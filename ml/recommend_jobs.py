import sys
import json
import pandas as pd
import sqlalchemy
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity


# 1️⃣ Get user_id from Laravel command
if len(sys.argv) < 2:
    print(json.dumps({"error": "No user ID provided"}))
    sys.exit()


user_id = sys.argv[1]


# 2️⃣ Create database connection using SQLAlchemy
try:
    engine = sqlalchemy.create_engine("mysql+mysqlconnector://root:@localhost/alumnidb")
except Exception as e:
    print(json.dumps({"error": f"Database connection failed: {e}"}))
    sys.exit()


# 3️⃣ SQL Queries
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




# 4️⃣ Fetch data
try:
    alumni_df = pd.read_sql(alumni_query, engine, params=(user_id,))
    jobs_df = pd.read_sql(jobs_query, engine)
except Exception as e:
    print(json.dumps({"error": f"Error fetching data: {e}"}))
    sys.exit()


# 5️⃣ Check if data exists
if alumni_df.empty:
    print(json.dumps({"error": "No skills found for this alumni."}))
    sys.exit()


if jobs_df.empty:
    print(json.dumps({"error": "No job listings found."}))
    sys.exit()


# 6️⃣ Prepare text for comparison
alumni_skills = " ".join(alumni_df["skill"].tolist())
job_texts = jobs_df["job_skills"].fillna("")


# 7️⃣ TF-IDF vectorization
tfidf = TfidfVectorizer(stop_words="english")
tfidf_matrix = tfidf.fit_transform([alumni_skills] + job_texts.tolist())


# 8️⃣ Compute cosine similarity
cos_sim = cosine_similarity(tfidf_matrix[0:1], tfidf_matrix[1:]).flatten()


# 9️⃣ Attach similarity scores to job list
jobs_df["similarity"] = cos_sim


# 🔟 Sort by similarity (highest first)
jobs_df = jobs_df.sort_values(by="similarity", ascending=False)


# 🧾 11️⃣ Convert to list of dicts
recommendations = jobs_df.to_dict(orient="records")


# 🧹 12️⃣ Keep only jobs with similarity > 0
recommendations = [rec for rec in recommendations if rec['similarity'] > 0]


# 📤 13️⃣ Print JSON output
print(json.dumps(recommendations, indent=4))