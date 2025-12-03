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

// Initialize sidebar immediately
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeSidebar);
} else {
    initializeSidebar();
}

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

// ===== CONFIRMATION DIALOG =====
function confirmDelete(message = 'Yakin ingin menghapus data ini?') {
    return confirm(message);
}

function confirmAction(message = 'Lanjutkan aksi ini?') {
    return confirm(message);
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
        scrollToTopBtn?.style.display = 'block';
    } else {
        scrollToTopBtn?.style.display = 'none';
    }
});

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

scrollToTopBtn?.addEventListener('click', scrollToTop);

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
