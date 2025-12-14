// ===== FEEDBACK UTILITIES =====
const toastStyles = {
    success: { bar: 'bg-emerald-500', text: 'text-emerald-700', icon: '✔️' },
    info: { bar: 'bg-sky-500', text: 'text-sky-700', icon: 'ℹ️' },
    warning: { bar: 'bg-amber-500', text: 'text-amber-700', icon: '⚠️' },
    danger: { bar: 'bg-red-500', text: 'text-red-700', icon: '⚠️' },
};

function ensureToastContainer() {
    let container = document.getElementById('appToastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'appToastContainer';
        container.className = 'fixed top-5 right-5 z-[2100] flex flex-col gap-3 items-end';
        document.body.appendChild(container);
    }
    return container;
}

function showToast(message, type = 'success', duration = 3500) {
    const container = ensureToastContainer();
    const style = toastStyles[type] || toastStyles.info;
    const toast = document.createElement('div');

    toast.className = 'pointer-events-auto w-80 overflow-hidden rounded-xl bg-white shadow-xl ring-1 ring-black/5 transition duration-200 ease-out opacity-0 translate-y-2';
    toast.innerHTML = `
        <div class="flex">
            <div class="${style.bar} w-1"></div>
            <div class="flex-1 p-4 flex gap-3">
                <div class="mt-0.5 text-lg">${style.icon}</div>
                <div class="space-y-1">
                    <p class="font-semibold text-slate-900">Notifikasi</p>
                    <p class="text-sm ${style.text} leading-relaxed">${message}</p>
                </div>
            </div>
            <button class="px-3 text-slate-400 hover:text-slate-600" aria-label="Tutup">×</button>
        </div>
    `;

    const closeToast = () => {
        toast.classList.add('opacity-0', 'translate-y-2');
        setTimeout(() => toast.remove(), 180);
    };

    toast.querySelector('button')?.addEventListener('click', closeToast, { once: true });

    container.appendChild(toast);
    requestAnimationFrame(() => toast.classList.remove('opacity-0', 'translate-y-2'));

    if (duration > 0) {
        setTimeout(closeToast, duration);
    }
}

const confirmVariants = {
    primary: { icon: 'ℹ️', accent: 'bg-sky-100 text-sky-700', button: 'bg-sky-600 hover:bg-sky-700 focus:ring-sky-500' },
    info: { icon: 'ℹ️', accent: 'bg-indigo-100 text-indigo-700', button: 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500' },
    danger: { icon: '⚠️', accent: 'bg-red-100 text-red-700', button: 'bg-red-600 hover:bg-red-700 focus:ring-red-500' },
};

function ensureConfirmModal() {
    let modal = document.getElementById('appConfirmModal');
    if (!modal) {
        const template = `
            <div id="appConfirmModal" class="fixed inset-0 z-[2000] hidden items-center justify-center px-4">
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" data-confirm-overlay></div>
                <div class="relative w-full max-w-md rounded-2xl bg-white shadow-2xl ring-1 ring-black/5 p-6 space-y-4">
                    <div class="flex items-start gap-3">
                        <div id="appConfirmIcon" class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-700 text-xl">⚠️</div>
                        <div class="space-y-1">
                            <h3 id="appConfirmTitle" class="text-lg font-semibold text-slate-900">Konfirmasi</h3>
                            <p id="appConfirmMessage" class="text-sm text-slate-600 leading-relaxed"></p>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" data-confirm-cancel class="rounded-lg border border-slate-200 px-4 py-2 text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-200">Batal</button>
                        <button type="button" data-confirm-accept class="rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-offset-1">Ya</button>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', template);
        modal = document.getElementById('appConfirmModal');
    }
    return modal;
}

function showConfirmModal({ title = 'Konfirmasi', message = 'Lanjutkan aksi ini?', confirmLabel = 'Ya', cancelLabel = 'Batal', variant = 'primary' } = {}) {
    const modal = ensureConfirmModal();
    const acceptBtn = modal.querySelector('[data-confirm-accept]');
    const cancelBtn = modal.querySelector('[data-confirm-cancel]');
    const overlay = modal.querySelector('[data-confirm-overlay]');
    const style = confirmVariants[variant] || confirmVariants.primary;

    modal.querySelector('#appConfirmTitle').textContent = title;
    modal.querySelector('#appConfirmMessage').textContent = message;
    modal.querySelector('#appConfirmIcon').className = `flex h-12 w-12 items-center justify-center rounded-full ${style.accent} text-xl`;
    modal.querySelector('#appConfirmIcon').textContent = style.icon;
    acceptBtn.textContent = confirmLabel;
    cancelBtn.textContent = cancelLabel;
    acceptBtn.className = `rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-offset-1 ${style.button}`;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    return new Promise((resolve) => {
        const cleanup = (result) => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            resolve(result);
        };

        const handleAccept = () => cleanup(true);
        const handleCancel = () => cleanup(false);

        acceptBtn.addEventListener('click', handleAccept, { once: true });
        cancelBtn.addEventListener('click', handleCancel, { once: true });
        overlay?.addEventListener('click', handleCancel, { once: true });
    });
}

function handleConfirmEvent(evt, options) {
    if (!evt) {
        return confirm(options.message);
    }

    evt.preventDefault();
    const target = evt.target?.closest('a, button, form');
    const href = target?.getAttribute('href');
    const form = target?.closest('form');

    showConfirmModal(options).then((confirmed) => {
        if (!confirmed) return;
        if (href) {
            window.location.href = href;
        } else if (form) {
            form.submit();
        }
    });

    return false;
}

// ===== SIDEBAR TOGGLE =====
function initializeSidebar() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    const navLinks = document.querySelectorAll('.sidebar-link');

    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.remove('active');
        });
    }

    // Close sidebar when a nav link is clicked
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('active');
            }
        });
    });

    // Highlight current page in sidebar based on pathname
    const currentPath = window.location.pathname;
    
    // Determine which section should be active
    let activeNav = null;
    
    if (currentPath.includes('/pasien/')) {
        activeNav = 'pasien';
    } else if (currentPath.includes('/dokter/')) {
        activeNav = 'dokter';
    } else if (currentPath.includes('/pendaftaran/')) {
        activeNav = 'pendaftaran';
    } else if (currentPath.includes('/pemeriksaan/')) {
        activeNav = 'pemeriksaan';
    } else if (currentPath.includes('/histori/')) {
        activeNav = 'histori';
    } else if (currentPath.includes('/admin/')) {
        activeNav = 'admin';
    } else if (currentPath.includes('index.php') || currentPath.endsWith('/puskesmas-app/')) {
        activeNav = 'dashboard';
    }
    
    // Apply active class to matching nav link
    navLinks.forEach(link => {
        const navAttr = link.getAttribute('data-nav');
        const isLogout = link.classList.contains('logout-item');
        
        // Remove active from all non-logout items
        if (!isLogout) {
            link.classList.remove('active');
        }
        
        // Add active to matching item
        if (navAttr === activeNav && !isLogout) {
            link.classList.add('active');
        }
    });
}

// Wire logout form with confirmation
function initializeLogoutConfirm() {
    const logoutBtn = document.getElementById('logout');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(evt) {
            evt.preventDefault();
            showConfirmModal({
                title: 'Konfirmasi Logout',
                message: 'Apakah Anda yakin ingin keluar?',
                variant: 'danger',
                confirmLabel: 'Ya, Keluar',
                cancelLabel: 'Batal'
            }).then((confirmed) => {
                if (confirmed) {
                    this.closest('form').submit();
                }
            });
        });
    }
}

// Show flash message if present
function initializeFlashMessages() {
    if (window.appFlash && window.appFlash.message) {
        showToast(window.appFlash.message, window.appFlash.type, 4000);
    }
}

// Initialize all on page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initializeSidebar();
        initializeLogoutConfirm();
        initializeFlashMessages();
    });
} else {
    initializeSidebar();
    initializeLogoutConfirm();
    initializeFlashMessages();
}

// ===== CONFIRMATION DIALOG =====
function confirmDelete(message = 'Yakin ingin menghapus data ini?') {
    return false; // Prevent default, we'll handle via event
}

function confirmAction(message = 'Lanjutkan aksi ini?') {
    return false; // Prevent default, we'll handle via event
}

// Wire delete links with modern confirmation
document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('click', function(evt) {
        const deleteLink = evt.target.closest('a.delete');
        if (deleteLink) {
            evt.preventDefault();
            const message = deleteLink.getAttribute('data-confirm') || 'Yakin ingin menghapus data ini?';
            showConfirmModal({
                title: 'Konfirmasi Hapus',
                message: message,
                variant: 'danger',
                confirmLabel: 'Ya, Hapus',
                cancelLabel: 'Batal'
            }).then((confirmed) => {
                if (confirmed) {
                    window.location.href = deleteLink.href;
                }
            });
        }
    });
});

// ===== FORM VALIDATION =====
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;

    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
    let isValid = true;

    inputs.forEach(input => {
        if (input.value.trim() === '') {
            input.style.borderColor = '#dc3545';
            isValid = false;
        } else {
            input.style.borderColor = '#ddd';
        }
    });

    return isValid;
}

// ===== TABLE FILTERING =====
function filterTable(inputId, tableId) {
    const input = document.getElementById(inputId);
    const table = document.getElementById(tableId);

    if (!input || !table) return;

    const rows = table.getElementsByTagName('tr');
    const searchTerm = input.value.toLowerCase();

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let match = false;

        for (let j = 0; j < cells.length; j++) {
            if (cells[j].textContent.toLowerCase().includes(searchTerm)) {
                match = true;
                break;
            }
        }

        row.style.display = match ? '' : 'none';
    }
}

// ===== SEARCH ON KEYUP =====
document.addEventListener('DOMContentLoaded', function() {
    const searchInputs = document.querySelectorAll('[data-search-table]');
    
    searchInputs.forEach(input => {
        input.addEventListener('keyup', function() {
            const tableId = this.getAttribute('data-search-table');
            filterTable(this.id, tableId);
        });
    });
});

// ===== AUTO-SHOW ALERTS =====
function showAlert(message, type = 'info', duration = 5000) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.innerHTML = `
        <strong>${type.charAt(0).toUpperCase() + type.slice(1)}:</strong>
        ${message}
    `;
    
    const container = document.querySelector('.container') || document.body;
    container.insertBefore(alertDiv, container.firstChild);
    
    if (duration > 0) {
        setTimeout(() => {
            alertDiv.remove();
        }, duration);
    }
}

// ===== MODAL FUNCTIONS =====
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
        modal.classList.add('show');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
        modal.classList.remove('show');
    }
}

// ===== DATE FORMATTING =====
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

// ===== SORT TABLE =====
function sortTable(tableId, columnIndex) {
    const table = document.getElementById(tableId);
    if (!table) return;

    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    rows.sort((a, b) => {
        const aVal = a.cells[columnIndex].textContent.trim();
        const bVal = b.cells[columnIndex].textContent.trim();

        if (!isNaN(aVal) && !isNaN(bVal)) {
            return aVal - bVal;
        }

        return aVal.localeCompare(bVal);
    });

    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row));
}

// ===== EXPORT TO CSV =====
function exportTableToCSV(tableId, filename = 'export.csv') {
    const table = document.getElementById(tableId);
    if (!table) return;

    let csv = [];
    const rows = table.querySelectorAll('tr');

    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const csvCols = [];
        cols.forEach(col => csvCols.push(col.textContent.trim()));
        csv.push(csvCols.join(','));
    });

    const csvContent = csv.join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = filename;
    link.click();
}

// ===== TOGGLE SIDEBAR =====
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        sidebar.classList.toggle('active');
    }
}

// ===== PRINT PAGE =====
function printPage() {
    window.print();
}

// ===== SCROLL TO TOP =====
const scrollToTopBtn = document.getElementById('scrollToTopBtn');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        if (scrollToTopBtn) scrollToTopBtn.style.display = 'block';
    } else {
        if (scrollToTopBtn) scrollToTopBtn.style.display = 'none';
    }
});

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

if (scrollToTopBtn) {
    scrollToTopBtn.addEventListener('click', scrollToTop);
}

// ===== FORM AUTO-SAVE DRAFT =====
function enableAutoSaveDraft(formId, storageKey) {
    const form = document.getElementById(formId);
    if (!form) return;

    // Load draft on page load
    const draft = localStorage.getItem(storageKey);
    if (draft) {
        const data = JSON.parse(draft);
        Object.keys(data).forEach(key => {
            const input = form.querySelector(`[name="${key}"]`);
            if (input) input.value = data[key];
        });
    }

    // Save draft on input change
    form.addEventListener('input', () => {
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
        localStorage.setItem(storageKey, JSON.stringify(data));
    });

    // Clear draft on form submit
    form.addEventListener('submit', () => {
        localStorage.removeItem(storageKey);
    });
}

// ===== KEYBOARD SHORTCUTS =====
document.addEventListener('keydown', (e) => {
    // Ctrl+S to save form
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        const submitBtn = document.querySelector('input[type="submit"]');
        if (submitBtn) submitBtn.click();
    }

    // Ctrl+Shift+P to print
    if (e.ctrlKey && e.shiftKey && e.key === 'P') {
        e.preventDefault();
        printPage();
    }
});
