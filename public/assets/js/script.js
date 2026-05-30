function showForm(formId) {
    document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
    document.getElementById(formId).classList.add("active");
}

function switchTab(tab) {
    const loginForm    = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const tabLogin     = document.getElementById('tabLogin');
    const tabRegister  = document.getElementById('tabRegister');

    const isLogin = tab === 'login';

    loginForm.style.display    = isLogin ? 'block' : 'none';
    registerForm.style.display = isLogin ? 'none' : 'block';

    tabLogin.classList.toggle('active', isLogin);
    tabRegister.classList.toggle('active', !isLogin);
}

// ===== INLINE STATUS COLOR UPDATE =====
document.querySelectorAll('.inline-status').forEach(sel => {
    sel.addEventListener('change', () => {
        sel.className = 'inline-status badge-' + sel.value.replace(' ', '-');
    });
});

// ===== TICKET FILTER / SEARCH / SORT =====

function filterTickets() {
    const search         = document.getElementById('ticketSearch')?.value.toLowerCase() || '';
    const activeStatus   = document.querySelector('.filter-btn.active[data-filter-type="status"]')?.dataset.value   || 'all';
    const activePriority = document.querySelector('.filter-btn.active[data-filter-type="priority"]')?.dataset.value || 'all';

    let visible = 0;
    document.querySelectorAll('.ticket-row').forEach(row => {
        const match =
            row.dataset.title.includes(search) &&
            (activeStatus   === 'all' || row.dataset.status   === activeStatus) &&
            (activePriority === 'all' || row.dataset.priority === activePriority);
        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });

    const noResults = document.getElementById('noResults');
    if (noResults) noResults.style.display = visible === 0 ? 'block' : 'none';
}

document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll(`.filter-btn[data-filter-type="${btn.dataset.filterType}"]`)
            .forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        filterTickets();
    });
});

document.getElementById('ticketSearch')?.addEventListener('input', filterTickets);

// ===== COLUMN SORT =====

let sortState = { col: null, asc: true };

document.querySelectorAll('th[data-sort]').forEach(th => {
    th.addEventListener('click', () => {
        const col = th.dataset.sort;
        sortState.asc = sortState.col === col ? !sortState.asc : true;
        sortState.col = col;

        document.querySelectorAll('th[data-sort] .sort-icon').forEach(ic => ic.textContent = '↕');
        th.querySelector('.sort-icon').textContent = sortState.asc ? '↑' : '↓';

        const tbody = document.getElementById('ticketsBody');
        if (!tbody) return;

        const rows = Array.from(tbody.querySelectorAll('tr.ticket-row'));
        const priorityOrder = { critical: 0, high: 1, medium: 2, low: 3 };

        rows.sort((a, b) => {
            let av, bv;
            if (col === 'id') {
                av = parseInt(a.cells[0].textContent);
                bv = parseInt(b.cells[0].textContent);
            } else if (col === 'title') {
                av = a.dataset.title;
                bv = b.dataset.title;
            } else if (col === 'status') {
                av = a.dataset.status;
                bv = b.dataset.status;
            } else if (col === 'priority') {
                av = priorityOrder[a.dataset.priority] ?? 99;
                bv = priorityOrder[b.dataset.priority] ?? 99;
            } else if (col === 'date') {
                av = a.cells[4].textContent.trim();
                bv = b.cells[4].textContent.trim();
            }
            if (av < bv) return sortState.asc ? -1 : 1;
            if (av > bv) return sortState.asc ?  1 : -1;
            return 0;
        });

        rows.forEach(r => tbody.appendChild(r));
    });
});
