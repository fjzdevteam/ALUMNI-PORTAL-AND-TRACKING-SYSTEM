document.addEventListener("DOMContentLoaded", () => {
    new Chart(document.getElementById("employmentChart"), {
        type: "pie",
        data: {
            labels: ["Full-time", "Part-time", "Self-employed", "Freelance", "Unemployed"],
            datasets: [{
                data: window.employmentChartData || [],
                backgroundColor: ["#EF4444", "#FACC15", "#10B981", "#2BB8C8", "#9B5DE5"]
            }]
        },
        options: {
            plugins: {
                legend: { labels: { boxWidth: 12, font: { size: 12 }, padding: 12 } },
                datalabels: { color: "#767676ff", font: { size: 12 }, formatter: v => v > 0 ? v : "" }
            }
        }
    });


    new Chart(document.getElementById("studyChart"), {
        type: "doughnut",
        data: {
            labels: ["Masteral", "Doctoral", "None"],
            datasets: [{
                data: window.studyChartData || [],
                backgroundColor: ["#2BB8C8", "#10B981", "#FACC15"]
            }]
        },
        options: {
            plugins: {
                legend: { labels: { boxWidth: 12, font: { size: 12 }, padding: 20 } },
                datalabels: { color: "#767676ff", font: { size: 12 }, formatter: v => v > 0 ? v : "" }
            }
        }
    });


    new Chart(document.getElementById("jobChart"), {
        type: "pie",
        data: {
            labels: ["Highly Related", "Somewhat Related", "Not Related"],
            datasets: [{
                data: window.jobRelevanceChartData || [],
                backgroundColor: ["#FACC15", "#10B981", "#EF4444"]
            }]
        },
        options: {
            plugins: {
                legend: { labels: { boxWidth: 12, font: { size: 12 }, padding: 14 } },
                datalabels: { color: "#767676ff", font: { size: 12 }, formatter: v => v > 0 ? v : "" }
            }
        }
    });


    new Chart(document.getElementById("unemploymentChart"), {
        type: "bar",
        data: {
            labels: ["0-3 months", "4-6 months", "7-12 months", "over 1 year"],
            datasets: [{
                label: "Alumni Count",
                data: window.unemploymentChartData || [],
                backgroundColor: "#10B981"
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: { display: true, text: "Alumni by Unemployment Period" },
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ` ${ctx.parsed.y} alumni` } }
            },
            scales: {
                y: { beginAtZero: true, title: { display: true, text: "Number of Alumni" } }
            }
        }
    });


    new Chart(document.getElementById("locationChart"), {
        type: "bar",
        data: {
            labels: window.locationLabels || [],
            datasets: [{
                label: "Alumni Count",
                data: window.locationCounts || [],
                backgroundColor: "#FACC15"
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: "Alumni Distribution by Region" }
            },
            scales: {
                x: { ticks: { autoSkip: false, maxRotation: 90, minRotation: 45 } },
                y: { beginAtZero: true, title: { display: true, text: "Number of Alumni" } }
            }
        }
    });


    new Chart(document.getElementById("industryChart"), {
        type: "bar",
        data: {
            labels: window.industryLabels || [],
            datasets: [{
                label: "Alumni Count",
                data: window.industryCounts || [],
                backgroundColor: "#9B5DE5"
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: "Alumni by Industry Sector" }
            },
            scales: {
                x: { ticks: { autoSkip: false, maxRotation: 90, minRotation: 45 } },
                y: { beginAtZero: true, title: { display: true, text: "Number of Alumni" } }
            }
        }
    });


    new Chart(document.getElementById("engagementChart"), {
        type: "bar",
        data: {
            labels: window.engagementLabels || [],
            datasets: [{
                label: "Participants",
                data: window.engagementCounts || [],
                backgroundColor: "#2BB8C8"
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: "Alumni Engagement Activities" }
            },
            scales: {
                y: { beginAtZero: true, title: { display: true, text: "Number of Alumni" } }
            }
        }
    });
});





