const PER_PAGE_OPTIONS = [5, 10, 20, 50];

export const initPagination = (root = document) => {
    const instances = [...root.querySelectorAll('[data-table-pagination]')].map((footer) => {
        const allRows = [...root.querySelectorAll(footer.dataset.rows)]
            .filter((row) => !row.hasAttribute('data-page-ignore'));
        const summary = footer.querySelector('[data-pagination-summary]');
        const nav = footer.querySelector('[data-pagination-nav]');
        const perPageSelect = footer.querySelector('[data-pagination-per-page]');
        const label = footer.dataset.label || 'data';
        let perPage = Math.max(1, parseInt(footer.dataset.perPage, 10) || 10);
        let page = 1;

        const scrollToTable = () => {
            allRows[0]?.closest('table')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        };

        const pageButton = (text, targetPage, { active = false, disabled = false } = {}) => {
            const element = document.createElement('button');
            element.type = 'button';
            element.textContent = text;
            element.setAttribute('aria-label', text === '‹' ? 'Halaman sebelumnya' : text === '›' ? 'Halaman berikutnya' : `Halaman ${text}`);
            element.className = active
                ? 'min-w-9 rounded-lg bg-[#92591f] px-2.5 py-1.5 text-xs font-bold text-white'
                : 'min-w-9 rounded-lg bg-[#f4ecd7] px-2.5 py-1.5 text-xs font-semibold text-[#3d2417]';
            if (active) element.setAttribute('aria-current', 'page');
            if (disabled) {
                element.disabled = true;
                element.classList.add('cursor-not-allowed', 'opacity-40');
            } else {
                element.addEventListener('click', () => {
                    page = targetPage;
                    render();
                    scrollToTable();
                });
            }
            return element;
        };

        const pageList = (totalPages) => {
            const wanted = [...new Set([1, totalPages, page - 1, page, page + 1])]
                .filter((number) => number >= 1 && number <= totalPages)
                .sort((a, b) => a - b);
            return wanted.flatMap((number, index) => {
                const gap = index > 0 && number - wanted[index - 1] > 1
                    ? Object.assign(document.createElement('span'), { className: 'px-1 text-xs', textContent: '…' })
                    : null;
                return [gap, pageButton(String(number), number, { active: number === page })].filter(Boolean);
            });
        };

        const renderNav = (totalPages) => {
            if (!nav) return;
            nav.replaceChildren();
            nav.append(pageButton('‹', page - 1, { disabled: page === 1 }));
            pageList(totalPages).forEach((node) => nav.append(node));
            nav.append(pageButton('›', page + 1, { disabled: page === totalPages }));
        };

        const render = () => {
            const visible = allRows.filter((row) => !row.classList.contains('hidden'));
            const totalPages = Math.max(1, Math.ceil(visible.length / perPage));
            page = Math.min(Math.max(page, 1), totalPages);
            const start = (page - 1) * perPage;
            const end = Math.min(start + perPage, visible.length);
            const onPage = new Set(visible.slice(start, end));
            allRows.forEach((row) => row.classList.toggle('ns-page-off', !onPage.has(row)));
            if (summary) {
                summary.textContent = visible.length
                    ? `Menampilkan ${start + 1}–${end} dari ${visible.length} ${label}`
                    : `Tidak ada ${label} yang bisa ditampilkan`;
            }
            renderNav(totalPages);
        };

        if (perPageSelect) {
            const options = [...new Set([...PER_PAGE_OPTIONS, perPage])].sort((a, b) => a - b);
            perPageSelect.replaceChildren(...options.map((value) => {
                const option = document.createElement('option');
                option.value = String(value);
                option.textContent = String(value);
                if (value === perPage) option.selected = true;
                return option;
            }));
            perPageSelect.addEventListener('change', () => {
                perPage = Math.max(1, parseInt(perPageSelect.value, 10) || 10);
                page = 1;
                render();
            });
        }

        render();
        return {
            render,
            rows: allRows,
            get page() { return page; },
            get perPage() { return perPage; },
            setPerPage(value) { perPage = Math.max(1, value); page = 1; render(); },
        };
    });

    const refresh = () => instances.forEach((instance) => instance.render());
    return refresh;
};
