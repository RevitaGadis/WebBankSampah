import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const toggle = (element, from, to) => element?.classList.replace(from, to);
    const bindModal = (open, modal, close, display = 'flex') => {
        document.querySelectorAll(open).forEach((button) => button.addEventListener('click', () => toggle(document.querySelector(modal), 'hidden', display)));
        document.querySelectorAll(close).forEach((button) => button.addEventListener('click', () => toggle(document.querySelector(modal), display, 'hidden')));
    };
    // Mengisi action form dari template URL (route() Blade), bukan dari string manual.
    const setFormAction = (selector, id) => {
        const form = document.querySelector(selector);
        if (form?.dataset.actionTemplate && id) {
            form.action = form.dataset.actionTemplate.replace('__ID__', encodeURIComponent(id));
        }
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
    const isiDariDataset = (button, modal, prefix, fields) => {
        fields.forEach((field) => {
            const camel = field.replace(/-([a-z])/g, (_, l) => l.toUpperCase());
            modal?.querySelectorAll(
                `[data-${prefix}-${field}], [data-${prefix}-${field}-copy], [data-${prefix}-${field}-third]`
            ).forEach((el) => { el.textContent = button.dataset[camel] || '—'; });
        });
    };

    document.querySelectorAll('[data-petugas-detail-open]').forEach((button) =>
        button.addEventListener('click', () =>
            isiDariDataset(button, document.querySelector('[data-petugas-detail-modal]'), 'pd',
                ['id', 'name', 'weight', 'officer', 'jenis', 'price', 'total', 'balance-before', 'balance-after'])));

    document.querySelectorAll('[data-receipt-open]').forEach((button) =>
        button.addEventListener('click', () =>
            isiDariDataset(button, document.querySelector('[data-receipt-modal]'), 'receipt',
                ['date', 'time', 'total', 'id', 'jenis', 'detail', 'weight', 'price',
                'balance-before', 'balance', 'officer'])));

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
            modal?.querySelectorAll(`[data-an-input-${field}]`).forEach((element) => { element.value = value === '-' ? '' : value; });
        });
        setFormAction('#form-edit-nasabah', values.id);
        setFormAction('#form-delete-nasabah', values.id);
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
        const priceInput = modal?.querySelector('[data-aw-input-price]');
        if (priceInput && values.priceRaw !== undefined) priceInput.value = values.priceRaw;
        setFormAction('#form-edit-waste', values.id);
        setFormAction('#form-delete-waste', values.id);
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
        setFormAction('#form-edit-akun', values.id);
        setFormAction('#form-delete-akun', values.id);
        if (button.dataset.adminAccountOpen === 'edit' && modal) {
            modal?.querySelector(`[data-account-role="${values.roleValue || 'petugas'}"]`)?.click();
        }
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

    // Setiap modal (tambah/edit) punya input peran dan tombol sendiri.
    adminAccountModals.forEach((modal) => {
        const roleInput = modal.querySelector('[data-admin-account-role-input]');
        const roleButtons = [...modal.querySelectorAll('[data-account-role]')];
        roleButtons.forEach((button) => button.addEventListener('click', () => {
            if (roleInput) roleInput.value = button.dataset.accountRole;
            roleButtons.forEach((option) => {
                const isActive = option === button;
                option.setAttribute('aria-pressed', String(isActive));
                option.classList.toggle('bg-[#92591f]', isActive);
                option.classList.toggle('text-white', isActive);
                option.classList.toggle('text-[#3d2417]', !isActive);
                option.classList.toggle('font-bold', isActive);
                option.classList.toggle('font-medium', !isActive);
            });
        }));
    });

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

    document.querySelectorAll('[data-flash]').forEach((el) => setTimeout(() => el.remove(), 4000));
});

const setoranCariInput = document.querySelector('#setoran-cari-nasabah');
const setoranHasilDiv = document.querySelector('#setoran-hasil-cari');
const setoranIdNasabahInput = document.querySelector('#setoran-id-nasabah');
const setoranTerpilihDiv = document.querySelector('#setoran-nasabah-terpilih');

let setoranDebounce;
setoranCariInput?.addEventListener('input', () => {
    clearTimeout(setoranDebounce);
    const q = setoranCariInput.value.trim();
    if (q.length < 2) {
        setoranHasilDiv.classList.add('hidden');
        return;
    }
    setoranDebounce = setTimeout(async () => {
        const base = setoranCariInput.dataset.url || '/petugas/setoran/cari-nasabah';
        const res = await fetch(`${base}?q=${encodeURIComponent(q)}`, { headers: { Accept: 'application/json' } });
        if (!res.ok) return;
        const data = await res.json();
        setoranHasilDiv.replaceChildren();
        if (!data.length) {
            const empty = document.createElement('div');
            empty.className = 'px-4 py-2 text-sm text-[#695b51]';
            empty.textContent = 'Tidak ketemu';
            setoranHasilDiv.append(empty);
        }
        data.forEach((n) => {
            const row = document.createElement('div');
            row.className = 'cursor-pointer px-4 py-2 text-sm hover:bg-[#fcf3dd]';
            const nama = document.createElement('b');
            nama.textContent = n.nama;
            const info = document.createElement('small');
            info.className = 'ml-1 text-[#695b51]';
            info.textContent = `${n.no_nasabah} • ${n.kelas}`;
            row.append(nama, info);
            row.addEventListener('click', () => {
                setoranIdNasabahInput.value = n.id_nasabah;
                setoranCariInput.value = `${n.nama} (${n.no_nasabah})`;
                document.querySelector('#snt-nama').textContent = n.nama;
                document.querySelector('#snt-kelas').textContent = n.kelas;
                document.querySelector('#snt-saldo').textContent = Number(n.saldo).toLocaleString('id-ID');
                setoranTerpilihDiv.classList.remove('hidden');
                setoranHasilDiv.classList.add('hidden');
            });
            setoranHasilDiv.append(row);
        });
        setoranHasilDiv.classList.remove('hidden');
    }, 300);
});

const setoranHargaTampil = document.querySelector('#setoran-harga-tampil');
const setoranTotalTampil = document.querySelector('#setoran-total-tampil');
const setoranIdJenisInput = document.querySelector('#setoran-id-jenis');
const setoranBeratInput = document.querySelector('#setoran-berat');
let hargaTerpilih = 0;

const hitungTotal = () => {
    const berat = parseFloat(setoranBeratInput?.value || '0');
    const total = berat * hargaTerpilih;
    if (setoranTotalTampil) setoranTotalTampil.textContent = Math.round(total).toLocaleString('id-ID');
};

document.querySelectorAll('[data-waste-choice]').forEach((button) => {
    button.addEventListener('click', () => {
        document.querySelectorAll('[data-waste-choice]').forEach((b) => b.classList.remove('!bg-[#54220f]', '!text-white'));
        button.classList.add('!bg-[#54220f]', '!text-white');

        setoranIdJenisInput.value = button.dataset.id;
        hargaTerpilih = parseFloat(button.dataset.price);
        setoranHargaTampil.textContent = Math.round(hargaTerpilih).toLocaleString('id-ID');
        hitungTotal();
    });
});

setoranBeratInput?.addEventListener('input', hitungTotal);

document.addEventListener('click', (event) => {
    if (setoranHasilDiv && !setoranHasilDiv.contains(event.target) && event.target !== setoranCariInput) {
        setoranHasilDiv.classList.add('hidden');
    }
});