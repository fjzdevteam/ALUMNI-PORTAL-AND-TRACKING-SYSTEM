import os
import sys
import json
import pandas as pd
import sqlalchemy
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

if len(sys.argv) < 2:
    print(json.dumps({"error": "No user ID provided"}))
    sys.exit()
user_id = sys.argv[1]

# ✅ Get DB credentials from environment (.env)
db_host = os.getenv("DB_HOST", "127.0.0.1")
db_port = os.getenv("DB_PORT", "3306")
db_name = os.getenv("DB_DATABASE", "alumnidb")
db_user = os.getenv("DB_USERNAME", "root")
db_pass = os.getenv("DB_PASSWORD", "")

try:
    engine = sqlalchemy.create_engine(
        f"mysql+mysqlconnector://{db_user}:{db_pass}@{db_host}:{db_port}/{db_name}"
    )
except Exception as e:
    print(json.dumps({"error": f"Database connection failed: {e}"}))
    sys.exit()


alumni_query = """
SELECT s.name AS skill
FROM alumni_skill a
JOIN skills s ON s.id = a.skill_id
WHERE a.user_id = %s
"""

jobs_query = """
SELECT
    j.job_id,
    j.job_title,
    j.company,
    j.location,
    j.job_type,
    i.industry_name,
    GROUP_CONCAT(s.name SEPARATOR ', ') AS job_skills
FROM job_details j
LEFT JOIN job_skill js ON js.job_id = j.job_id
LEFT JOIN skills s ON s.id = js.skill_id
LEFT JOIN industries i ON i.industry_id = j.industry_id
WHERE j.status = 'active'
GROUP BY j.job_id, j.job_title, j.company, j.location, j.job_type, i.industry_name
"""

try:
    alumni_df = pd.read_sql(alumni_query, engine, params=(user_id,))
    jobs_df = pd.read_sql(jobs_query, engine)
except Exception as e:
    print(json.dumps({"error": f"Error fetching data: {e}"}))
    sys.exit()

if alumni_df.empty:
    print(json.dumps({"error": "No skills found for this alumni."}))
    sys.exit()
if jobs_df.empty:
    print(json.dumps({"error": "No job listings found."}))
    sys.exit()

def normalize(text):
    return " ".join(text.lower().replace("/", " ").replace("-", " ").split())

alumni_text = " ".join([normalize(s) for s in alumni_df["skill"].tolist() if str(s).strip()])
jobs_df["job_skills"] = jobs_df["job_skills"].fillna("")
job_texts = [normalize(text) for text in jobs_df["job_skills"]]

tfidf = TfidfVectorizer(stop_words="english", ngram_range=(1, 2))
tfidf_matrix = tfidf.fit_transform([alumni_text] + job_texts)
jobs_df["cosine_similarity"] = cosine_similarity(tfidf_matrix[0:1], tfidf_matrix[1:]).flatten()

alumni_set = set([s.lower() for s in alumni_df["skill"].tolist()])
def clean_skill_set(text):
    return set([s.strip().lower() for s in text.split(",") if s.strip()])

jobs_df["overlap_ratio"] = jobs_df["job_skills"].apply(
    lambda x: len(alumni_set.intersection(clean_skill_set(x))) / len(clean_skill_set(x)) if clean_skill_set(x) else 0
)

OVERLAP_WEIGHT = 0.6
COSINE_WEIGHT = 0.4
jobs_df["final_score"] = (OVERLAP_WEIGHT * jobs_df["overlap_ratio"]) + (COSINE_WEIGHT * jobs_df["cosine_similarity"])
jobs_df["final_score"] = jobs_df["final_score"].clip(upper=1.0)
jobs_df["final_score_pct"] = (jobs_df["final_score"] * 100).round(2)

jobs_df = jobs_df[jobs_df["final_score"] > 0.1].sort_values(by="final_score", ascending=False)

recommendations = jobs_df[[
    "job_id", "job_title", "company", "location", "job_type",
    "industry_name", "job_skills", "cosine_similarity",
    "overlap_ratio", "final_score", "final_score_pct"
]].to_dict(orient="records")

print(json.dumps(recommendations, indent=4))
