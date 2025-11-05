document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const allCards = [...document.querySelectorAll('.job-card')];
    const noResults = document.getElementById('noResults');
    let timer;

    searchInput.addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(applyFilters, 300);
    });

    form.addEventListener('submit', e => {
        e.preventDefault();
        applyFilters();
    });

    searchInput.addEventListener('keydown', e => e.key === 'Enter' && e.preventDefault());

    function applyFilters() {
        const search = searchInput.value.toLowerCase().trim();
        const industry = form.querySelector('[name="industry"]').value.toLowerCase().trim();
        const jobType = form.querySelector('[name="job_type"]').value.toLowerCase().trim();
        let visible = 0;

        allCards.forEach(card => {
            const { title, company, location, skills, industry: ind, type } = card.dataset;
            const matchSearch = !search || [title, company, location, skills].some(v => v.includes(search));
            const matchIndustry = !industry || ind.includes(industry);
            const matchType = !jobType || type === jobType;
            const show = matchSearch && matchIndustry && matchType;

            card.style.display = show ? 'block' : 'none';
            if (show) visible++;
        });

        if (visible === 0) {
            noResults.classList.remove('hidden');
            noResults.classList.add('flex');
        } else {
            noResults.classList.remove('flex');
            noResults.classList.add('hidden');
        }
    }
});