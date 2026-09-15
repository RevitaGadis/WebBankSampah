import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const toggle = (element, from, to) => element?.classList.replace(from, to);
    const bindModal = (open, modal, close, display = 'flex') => {
        document.querySelectorAll(open).forEach((button) => button.addEventListener('click', () => toggle(document.querySelector(modal), 'hidden', display)));
        document.querySelectorAll(close).forEach((button) => button.addEventListener('click', () => toggle(document.querySelector(modal), display, 'hidden')));
    };
    bindModal('[data-logout-open]', '[data-logout-modal]', '[data-logout-close]');
    bindModal('[data-petugas-logout-open]', '[data-petugas-logout-modal]', '[data-petugas-logout-close]');
    document.querySelector('[data-sidebar-open]')?.addEventListener('click', () => document.querySelector('#nasabah-sidebar')?.classList.toggle('-translate-x-full'));
    document.querySelector('[data-petugas-sidebar-open]')?.addEventListener('click', () => document.querySelector('#petugas-sidebar')?.classList.toggle('-translate-x-full'));
    bindModal('[data-setoran-open]', '[data-setoran-modal]', '[data-setoran-close]', 'block');
    bindModal('[data-petugas-detail-open]', '[data-petugas-detail-modal]', '[data-petugas-detail-close]');
    bindModal('[data-receipt-open]', '[data-receipt-modal]', '[data-receipt-close]', 'block');
    const nasabahModal = document.querySelector('[data-nasabah-detail-modal]');
    document.querySelectorAll('[data-nasabah-detail-open]').forEach((button) => button.addEventListener('click', () => {
        Object.entries(button.dataset).filter(([key]) => key.startsWith('nd')).forEach(([key, value]) => {
            const field = key.slice(2).replace(/^[A-Z]/, (letter) => letter.toLowerCase());
            nasabahModal?.querySelectorAll(`[data-nd-${field}]`).forEach((element) => element.textContent = value);
        });
        toggle(nasabahModal, 'hidden', 'block');
    }));
    document.querySelectorAll('[data-nasabah-detail-close]').forEach((button) => button.addEventListener('click', () => toggle(nasabahModal, 'block', 'hidden')));

    const adminTransactionModal = document.querySelector('[data-admin-transaction-modal]');
    const closeAdminTransactionModal = () => toggle(adminTransactionModal, 'flex', 'hidden');
    document.querySelectorAll('[data-admin-transaction-open]').forEach((button) => button.addEventListener('click', () => {
        ['id', 'date', 'time', 'name', 'number', 'class', 'jenis', 'weight', 'price', 'total', 'officer', 'phone', 'balance-before', 'balance-after'].forEach((field) => {
            const camel = field.replace(/-([a-z])/g, (_, l) => l.toUpperCase());
            adminTransactionModal?.querySelectorAll(`[data-at-${field}], [data-at-${field}-copy]`)
                .forEach((element) => element.textContent = button.dataset[camel] || '—');
        });
        const initial = button.dataset.name ? button.dataset.name.substring(0, 2).toUpperCase() : 'XX';
        adminTransactionModal?.querySelectorAll('[data-at-initial]').forEach((el) => el.textContent = initial);
        toggle(adminTransactionModal, 'hidden', 'flex');
    }));
    document.querySelectorAll('[data-admin-transaction-close]').forEach((button) => button.addEventListener('click', closeAdminTransactionModal));
    adminTransactionModal?.addEventListener('click', (event) => {
        if (event.target === adminTransactionModal) closeAdminTransactionModal();
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && adminTransactionModal?.classList.contains('flex')) closeAdminTransactionModal();
    });

    const adminNasabahModals = [...document.querySelectorAll('[data-admin-nasabah-modal]')];
    let activeAdminNasabah = {};
    const closeAdminNasabahModals = () => adminNasabahModals.forEach((modal) => toggle(modal, 'flex', 'hidden'));
    document.querySelectorAll('[data-admin-nasabah-open]').forEach((button) => button.addEventListener('click', () => {
        const modal = document.querySelector(`[data-admin-nasabah-modal="${button.dataset.adminNasabahOpen}"]`);
        const rowData = Object.fromEntries(Object.entries(button.dataset).filter(([key]) => !['adminNasabahOpen'].includes(key)));
        if (Object.keys(rowData).length) activeAdminNasabah = rowData;
        const values = Object.keys(activeAdminNasabah).length ? activeAdminNasabah : rowData;
        Object.entries(values).forEach(([field, value]) => {
            modal?.querySelectorAll(`[data-an-${field}]`).forEach((element) => element.textContent = value);
            modal?.querySelectorAll(`[data-an-input-${field}]`).forEach((element) => { element.value = value; });
        });
        const rekapLink = modal?.querySelector('[data-an-rekap]');
        if (rekapLink) {
            const num = values.number || '';
            rekapLink.href = num ? `/admin/nasabah/rekap/${num}` : '#';
        }
        if (modal) {
            closeAdminNasabahModals();
            toggle(modal, 'hidden', 'flex');
        }
    }));
    document.querySelectorAll('[data-admin-nasabah-close]').forEach((button) => button.addEventListener('click', closeAdminNasabahModals));
    adminNasabahModals.forEach((modal) => modal.addEventListener('click', (event) => {
        if (event.target === modal) closeAdminNasabahModals();
    }));
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && adminNasabahModals.some((modal) => modal.classList.contains('flex'))) closeAdminNasabahModals();
    });

    const adminNasabahSearch = document.querySelector('[data-admin-nasabah-search]');
    const adminNasabahClass = document.querySelector('[data-admin-nasabah-class]');
    const adminNasabahRows = [...document.querySelectorAll('[data-admin-nasabah-rows] tr')];
    const adminNasabahEmpty = document.querySelector('[data-admin-nasabah-empty]');
    const filterAdminNasabah = () => {
        const query = (adminNasabahSearch?.value || '').toLowerCase().trim();
        const selectedClass = adminNasabahClass?.value || '';
        let count = 0;
        adminNasabahRows.forEach((row) => {
            const visible = row.dataset.search.includes(query) && (!selectedClass || row.dataset.class === selectedClass);
            row.classList.toggle('hidden', !visible);
            if (visible) count += 1;
        });
        adminNasabahEmpty?.classList.toggle('hidden', count !== 0);
    };
    adminNasabahSearch?.addEventListener('input', filterAdminNasabah);
    adminNasabahClass?.addEventListener('change', filterAdminNasabah);

    const adminNasabahTypeInput = document.querySelector('[data-admin-nasabah-type-input]');
    const adminNasabahTypeButtons = [...document.querySelectorAll('[data-admin-nasabah-type]')];
    adminNasabahTypeButtons.forEach((button) => button.addEventListener('click', () => {
        adminNasabahTypeInput.value = button.dataset.adminNasabahType;
        adminNasabahTypeButtons.forEach((option) => {
            const isActive = option === button;
            option.setAttribute('aria-pressed', String(isActive));
            option.classList.toggle('bg-[#92591f]', isActive);
            option.classList.toggle('text-white', isActive);
            option.classList.toggle('text-[#3d2417]', !isActive);
        });
    }));

    const adminWasteModals = [...document.querySelectorAll('[data-admin-waste-modal]')];
    let activeAdminWaste = {};
    const closeAdminWasteModals = () => adminWasteModals.forEach((modal) => toggle(modal, 'flex', 'hidden'));
    document.querySelectorAll('[data-admin-waste-open]').forEach((button) => button.addEventListener('click', () => {
        const modal = document.querySelector(`[data-admin-waste-modal="${button.dataset.adminWasteOpen}"]`);
        const rowData = Object.fromEntries(Object.entries(button.dataset).filter(([key]) => key !== 'adminWasteOpen'));
        if (Object.keys(rowData).length) activeAdminWaste = rowData;
        const values = Object.keys(activeAdminWaste).length ? activeAdminWaste : rowData;
        Object.entries(values).forEach(([field, value]) => {
            modal?.querySelectorAll(`[data-aw-${field}]`).forEach((element) => element.textContent = value);
            modal?.querySelectorAll(`[data-aw-input-${field}]`).forEach((element) => { element.value = value; });
        });
        if (modal) {
            closeAdminWasteModals();
            toggle(modal, 'hidden', 'flex');
        }
    }));
    document.querySelectorAll('[data-admin-waste-close]').forEach((button) => button.addEventListener('click', closeAdminWasteModals));
    adminWasteModals.forEach((modal) => modal.addEventListener('click', (event) => {
        if (event.target === modal) closeAdminWasteModals();
    }));
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && adminWasteModals.some((modal) => modal.classList.contains('flex'))) closeAdminWasteModals();
    });

    const adminWasteSearch = document.querySelector('[data-admin-waste-search]');
    const adminWasteRows = [...document.querySelectorAll('[data-admin-waste-rows] tr')];
    const adminWasteEmpty = document.querySelector('[data-admin-waste-empty]');
    adminWasteSearch?.addEventListener('input', () => {
        const query = adminWasteSearch.value.toLowerCase().trim();
        let count = 0;
        adminWasteRows.forEach((row) => {
            const visible = row.dataset.search.includes(query);
            row.classList.toggle('hidden', !visible);
            if (visible) count += 1;
        });
        adminWasteEmpty?.classList.toggle('hidden', count !== 0);
    });

    const adminAccountModals = [...document.querySelectorAll('[data-admin-account-modal]')];
    let activeAdminAccount = {};
    const closeAdminAccountModals = () => adminAccountModals.forEach((modal) => toggle(modal, 'flex', 'hidden'));
    document.querySelectorAll('[data-admin-account-open]').forEach((button) => button.addEventListener('click', () => {
        const modal = document.querySelector(`[data-admin-account-modal="${button.dataset.adminAccountOpen}"]`);
        const rowData = Object.fromEntries(Object.entries(button.dataset).filter(([key]) => key !== 'adminAccountOpen'));
        if (Object.keys(rowData).length) activeAdminAccount = rowData;
        const values = Object.keys(activeAdminAccount).length ? activeAdminAccount : rowData;
        Object.entries(values).forEach(([field, value]) => {
            modal?.querySelectorAll(`[data-aa-${field}]`).forEach((element) => element.textContent = value);
            modal?.querySelectorAll(`[data-aa-input-${field}]`).forEach((element) => { element.value = value; });
        });
        if (modal) {
            closeAdminAccountModals();
            toggle(modal, 'hidden', 'flex');
        }
    }));
    document.querySelectorAll('[data-admin-account-close]').forEach((button) => button.addEventListener('click', closeAdminAccountModals));
    adminAccountModals.forEach((modal) => modal.addEventListener('click', (event) => {
        if (event.target === modal) closeAdminAccountModals();
    }));
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && adminAccountModals.some((modal) => modal.classList.contains('flex'))) closeAdminAccountModals();
    });

    const accountRoleInput = document.querySelector('[data-admin-account-role-input]');
    const accountRoleButtons = [...document.querySelectorAll('[data-account-role]')];
    accountRoleButtons.forEach((button) => button.addEventListener('click', () => {
        if (accountRoleInput) accountRoleInput.value = button.dataset.accountRole;
        accountRoleButtons.forEach((option) => {
            const isActive = option === button;
            option.setAttribute('aria-pressed', String(isActive));
            option.classList.toggle('bg-[#92591f]', isActive);
            option.classList.toggle('text-white', isActive);
            option.classList.toggle('text-[#3d2417]', !isActive);
            option.classList.toggle('font-bold', isActive);
            option.classList.toggle('font-medium', !isActive);
        });
    }));

    const accountStatusButtons = [...document.querySelectorAll('[data-account-status]')];
    accountStatusButtons.forEach((button) => button.addEventListener('click', () => {
        accountStatusButtons.forEach((option) => {
            const isActive = option === button;
            option.setAttribute('aria-pressed', String(isActive));
            option.classList.toggle('bg-[#92591f]', isActive);
            option.classList.toggle('text-white', isActive);
            option.classList.toggle('border-[#decfb8]', !isActive);
            option.classList.toggle('bg-white', !isActive);
            option.classList.toggle('text-[#3d2417]', !isActive);
            option.classList.toggle('font-bold', isActive);
            option.classList.toggle('font-medium', !isActive);
        });
    }));

    const bindTextSearch = (inputSelector, rowSelector, emptySelector) => {
        const input = document.querySelector(inputSelector);
        const rows = [...document.querySelectorAll(rowSelector)];
        const empty = document.querySelector(emptySelector);
        input?.addEventListener('input', () => {
            const query = input.value.toLowerCase().trim();
            let count = 0;
            rows.forEach((row) => {
                const visible = row.textContent.toLowerCase().includes(query);
                row.classList.toggle('hidden', !visible);
                if (visible) count += 1;
            });
            empty?.classList.toggle('hidden', count !== 0);
        });
    };
    bindTextSearch('[data-admin-account-search]', '[data-admin-account-rows] tr', '[data-admin-account-empty]');
    bindTextSearch('[data-admin-history-search]', '.ns-card table tbody tr', '[data-admin-history-empty]');

    document.querySelectorAll('[data-admin-global-search]').forEach((input) => {
        const rows = [...document.querySelectorAll(input.dataset.searchTarget)];
        const empty = document.querySelector(input.dataset.searchEmpty);
        input.addEventListener('input', () => {
            const query = input.value.toLowerCase().trim();
            let count = 0;
            rows.forEach((row) => {
                const searchable = (row.dataset.search || row.textContent).toLowerCase();
                const visible = searchable.includes(query);
                row.classList.toggle('hidden', !visible);
                if (visible) count += 1;
            });
            empty?.classList.toggle('hidden', count !== 0);
        });
    });
});
