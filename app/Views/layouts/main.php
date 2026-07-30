<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle ?? 'LMS Dashboard') ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* 2. DEFINISI VARIABEL WARNA */
        :root {
            --sidebar-width: 260px;
            --header-height: 70px;
            --footer-height: 60px; /* Tinggi Footer Tetap */

            /* Light Mode */
            --primary-navy: #0d2141; 
            --active-blue: #e3f2fd;
            --bg-body: #f4f6f9;
            --bg-card: #ffffff;
            --bg-sidebar: #ffffff;
            --text-main: #343a40;
            --text-muted: #6c757d;
            --border-color: #e9ecef;
            --input-bg: #ffffff;
            --input-border: #dee2e6;
            --table-hover: #f8f9fa;
            --shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        /* Dark Mode */
        [data-theme="dark"] {
            --primary-navy: #4e89e8;
            --bg-body: #121212;
            --bg-card: #1e1e1e;
            --bg-sidebar: #1e1e1e;
            --text-main: #e0e0e0;
            --text-muted: #a0a0a0;
            --border-color: #333333;
            --input-bg: #2c2c2c;
            --input-border: #444444;
            --table-hover: #2c2c2c;
            --shadow: 0 4px 6px rgba(0,0,0,0.3);
        }

        /* 3. GLOBAL RESET */
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg-body); 
            color: var(--text-main);
            font-size: 0.9rem;
            transition: background-color 0.3s, color 0.3s;
            overflow-x: hidden;
        }
        a { text-decoration: none; }

        /* 4. LAYOUT SIDEBAR (FIXED LEFT - LAYER TERTINGGI) */
        .sidebar { 
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0; 
            left: 0;
            background-color: var(--bg-sidebar); 
            border-right: 1px solid var(--border-color); 
            z-index: 1040; /* Paling Atas */
            padding: 20px 15px;
            display: flex; flex-direction: column;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-brand { font-weight: 800; font-size: 1.25rem; color: var(--primary-navy); margin-bottom: 30px; padding-left: 10px; display: flex; align-items: center; gap: 10px; }
        .nav-link { color: var(--text-muted); font-weight: 500; padding: 12px 15px; margin-bottom: 5px; border-radius: 8px; transition: all 0.2s; display: flex; align-items: center; }
        .nav-link i { margin-right: 10px; width: 20px; text-align: center; }
        .nav-link:hover { background-color: var(--table-hover); color: var(--primary-navy); }
        .nav-link.active { background-color: #0d2141; color: white !important; box-shadow: 0 4px 6px rgba(13, 33, 65, 0.2); }

        /* 5. LAYOUT HEADER (FIXED TOP - SEBELAH KANAN SIDEBAR) */
        .top-header { 
            position: fixed;
            top: 0;
            left: var(--sidebar-width); 
            width: calc(100% - var(--sidebar-width)); 
            height: var(--header-height);
            background-color: var(--bg-card); 
            border-bottom: 1px solid var(--border-color); 
            display: flex; align-items: center; justify-content: space-between; padding: 0 30px;
            z-index: 1030; /* Di bawah Sidebar */
            transition: left 0.3s, width 0.3s;
        }

        /* 6. LAYOUT FOOTER (FIXED BOTTOM - SEBELAH KANAN SIDEBAR) */
        .app-footer {
            position: fixed;
            bottom: 0;
            left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            height: var(--footer-height);
            background-color: var(--bg-card);
            border-top: 1px solid var(--border-color);
            display: flex; align-items: center; justify-content: center;
            z-index: 1030; /* Setara Header */
            color: var(--text-muted);
            font-size: 0.85rem;
            transition: left 0.3s, width 0.3s;
        }

        /* 7. MAIN CONTENT (WRAPPER) */
        .main-content {
            margin-top: var(--header-height); 
            margin-left: var(--sidebar-width); 
            padding: 30px; 
            min-height: calc(100vh - var(--header-height));
            padding-bottom: calc(var(--footer-height) + 30px); /* Ruang agar tidak tertutup footer */
            transition: margin-left 0.3s;
        }

        /* 8. KOMPONEN UI */
        .card { background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 10px; box-shadow: var(--shadow); }
        .card-header { background-color: var(--bg-card); border-bottom: 1px solid var(--border-color); color: var(--text-main); }
        .card-footer { background-color: var(--bg-card); border-top: 1px solid var(--border-color); }
        
        .form-control, .form-select { background-color: var(--input-bg); border-color: var(--input-border); color: var(--text-main); }
        .form-control:focus, .form-select:focus { background-color: var(--input-bg); color: var(--text-main); border-color: var(--primary-navy); }
        
        .table { color: var(--text-main); }
        .table thead th { background-color: var(--table-hover); color: var(--text-main); border-bottom: 2px solid var(--border-color); }
        .table td { border-bottom: 1px solid var(--border-color); }
        .table-hover tbody tr:hover { background-color: var(--table-hover); color: var(--text-main); }

        .btn-navy { background-color: #0d2141; color: white; }
        .btn-navy:hover { background-color: #1a3a6c; color: white; }
        
        .btn-quick { background-color: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-main); padding: 15px; border-radius: 8px; text-align: left; transition: all 0.2s ease; display: block; font-weight: 500; }
        .btn-quick:hover { border-color: var(--primary-navy); background-color: var(--table-hover); color: var(--primary-navy); transform: translateX(5px); }

        .card-stat { background-color: var(--bg-card); border: none; border-radius: 10px; box-shadow: var(--shadow); height: 100%; transition: transform 0.2s; }
        .card-stat:hover { transform: translateY(-3px); }
        .icon-box { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }

        /* Helpers */
        .text-dark { color: var(--text-main) !important; }
        .bg-white { background-color: var(--bg-card) !important; }
        .bg-light { background-color: var(--table-hover) !important; }
        .text-muted { color: var(--text-muted) !important; }

        /* 9. MOBILE RESPONSIVE */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            
            /* Header & Footer & Content jadi Full Width */
            .top-header { left: 0; width: 100%; }
            .app-footer { left: 0; width: 100%; }
            .main-content { margin-left: 0; }
            
            /* Sidebar Muncul */
            .sidebar.show { transform: translateX(0); box-shadow: 0 0 15px rgba(0,0,0,0.5); }
        }
        
        <?= $this->renderSection('styles') ?>
    </style>


</head>
<body>

<div class="sidebar d-flex flex-column">
    <a href="/" class="text-decoration-none">
        <div class="sidebar-brand">
            <i class="fa-solid fa-graduation-cap me-2 text-primary"></i>
            <span>LMS Admin</span>
        </div>
    </a>
    
    <ul class="nav flex-column mb-auto">
        <?php 
            $uri = current_url(true); 
            $role = session()->get('role');
            $tenantPrefix = esc(session()->get('tenant_string_id') ?? service('uri')->getSegment(1));
            
            $activeSegment = '';
            if ($role === 'super_admin') {
                $activeSegment = $uri->getSegment(2);
            } elseif ($role === 'tenant_admin') {
                $activeSegment = $uri->getSegment(3);
            }
        ?>

        <?php if($role === 'super_admin'): ?>
            <li class="px-4 mt-2 mb-2 text-uppercase small text-muted fw-bold" style="font-size: 0.7rem;">MAIN MENU</li>
            <li class="nav-item">
                <a class="nav-link <?= ($activeSegment == 'dashboard' || $activeSegment == '') ? 'active' : '' ?>" href="/superadmin/dashboard">
                    <i class="fa-solid fa-gauge-high"></i> Dashboard
                </a>
            </li>
            <li class="px-4 mt-4 mb-2 text-uppercase small text-muted fw-bold" style="font-size: 0.7rem;">MANAGEMENT</li>
            <li class="nav-item">
                <a class="nav-link <?= ($activeSegment == 'tenants') ? 'active' : '' ?>" href="/superadmin/tenants">
                    <i class="fa-solid fa-building"></i> Manajemen Tenant
                </a>
            </li>
        <?php elseif($role === 'tenant_admin'): ?>
            <li class="px-4 mt-2 mb-2 text-uppercase small text-muted fw-bold" style="font-size: 0.7rem;">MAIN MENU</li>
            <li class="nav-item">
                <a class="nav-link <?= ($activeSegment == 'dashboard' || $activeSegment == '') ? 'active' : '' ?>" href="/<?= $tenantPrefix ?>/admin_tenant/dashboard">
                    <i class="fa-solid fa-gauge-high"></i> Dashboard
                </a>
            </li>
            <li class="px-4 mt-4 mb-2 text-uppercase small text-muted fw-bold" style="font-size: 0.7rem;">AKADEMIK</li>
            <li class="nav-item">
                <a class="nav-link <?= ($activeSegment == 'courses') ? 'active' : '' ?>" href="/<?= $tenantPrefix ?>/admin_tenant/courses">
                    <i class="fa-solid fa-book"></i> Kelola Course
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($activeSegment == 'instructors') ? 'active' : '' ?>" href="/<?= $tenantPrefix ?>/admin_tenant/instructors">
                    <i class="fa-solid fa-chalkboard-teacher"></i> Kelola Instruktur
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($activeSegment == 'students') ? 'active' : '' ?>" href="/<?= $tenantPrefix ?>/admin_tenant/students">
                    <i class="fa-solid fa-user-graduate"></i> Kelola Siswa
                </a>
            </li>
            <li class="px-4 mt-4 mb-2 text-uppercase small text-muted fw-bold" style="font-size: 0.7rem;">SISTEM</li>
            <li class="nav-item">
                <a class="nav-link <?= ($activeSegment == 'announcements') ? 'active' : '' ?>" href="/<?= $tenantPrefix ?>/admin_tenant/announcements">
                    <i class="fa-solid fa-bullhorn"></i> Pusat Informasi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($activeSegment == 'admins') ? 'active' : '' ?>" href="/<?= $tenantPrefix ?>/admin_tenant/admins">
                    <i class="fa-solid fa-user-shield"></i> Kelola Admin
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($activeSegment == 'settings') ? 'active' : '' ?>" href="/<?= $tenantPrefix ?>/admin_tenant/settings">
                    <i class="fa-solid fa-gear"></i> Pengaturan Web
                </a>
            </li>
        <?php endif; ?>
    </ul>

    <div class="px-3 pb-4 mt-4">
        <?php $logoutUrl = ($role === 'super_admin') ? '/superadmin/logout' : "/{$tenantPrefix}/logout"; ?>
        <a href="<?= $logoutUrl ?>" class="nav-link text-danger fw-bold border border-danger rounded-3 justify-content-center">
            <i class="fa-solid fa-right-from-bracket"></i> Keluar
        </a>
    </div>
</div>

<div class="top-header">
    <div class="d-flex align-items-center">
        <button type="button" class="btn btn-link d-lg-none me-3 p-0 text-decoration-none" 
                onclick="toggleSidebar()" 
                style="z-index: 1050; color: var(--text-main);">
            <i class="fa-solid fa-bars fs-4"></i>
        </button>

        <div>
            <h5 class="fw-bold mb-0" style="color: var(--text-main);">
                <?= esc($pageTitle ?? 'Dashboard') ?>
            </h5>
            <small class="text-muted">Learning Management System</small>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <div class="d-none d-md-block text-end">
            <div class="fw-bold small" style="color: var(--text-main);"><?= date('l, d F Y') ?></div>
            <div id="live-clock" class="badge border rounded-pill px-3" style="color: var(--text-main); border-color: var(--border-color) !important;">
                --:--:-- WIB
            </div>
        </div>

        <script>
            function startNavbarClock() {
                var serverTime = new Date("<?= date('Y/m/d H:i:s') ?>").getTime();

                setInterval(function() {
                    serverTime += 1000;
                    var date = new Date(serverTime);
                    
                    var h = date.getHours().toString().padStart(2, '0');
                    var m = date.getMinutes().toString().padStart(2, '0');
                    var s = date.getSeconds().toString().padStart(2, '0');
                    
                    var clockElement = document.getElementById('live-clock');
                    if(clockElement) {
                        clockElement.innerHTML = h + ":" + m + ":" + s + " WIB";
                    }
                }, 1000);
            }
            document.addEventListener('DOMContentLoaded', startNavbarClock);
        </script>

        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <div class="bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                    <?= strtoupper(substr(session()->get('full_name') ?? session()->get('name') ?? 'U', 0, 1)) ?>
                </div>
                <div class="d-none d-lg-block text-start lh-sm">
                    <div class="fw-bold small" style="color: var(--text-main);"><?= esc(session()->get('full_name') ?? session()->get('name') ?? 'User') ?></div>
                    <small class="text-muted" style="font-size: 11px;">
                        <?= session()->get('role') === 'super_admin' ? 'Super Admin' : 'Tenant Admin' ?>
                    </small>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow mt-2" style="background-color: var(--bg-card); border-color: var(--border-color);">
                <?php if($role === 'tenant_admin'): ?>
                    <li><a class="dropdown-item" style="color: var(--text-main);" href="/<?= $tenantPrefix ?>/admin_tenant/settings"><i class="fa-solid fa-gear me-2"></i> Pengaturan</a></li>
                    <li><hr class="dropdown-divider" style="border-color: var(--border-color);"></li>
                <?php endif; ?>
                <li><a class="dropdown-item text-danger" href="<?= $logoutUrl ?>"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="main-content">
    
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success') || session()->getFlashdata('message')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> <?= esc(session()->getFlashdata('success') ?? session()->getFlashdata('message')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i> <?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i>
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

<footer class="app-footer">
    <div>
        &copy; <?= date('Y') ?> <strong>Learning Management System</strong>. 
        <span class="d-none d-sm-inline"> - All Rights Reserved</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ============================================================
    // 1. DEFINISI FUNGSI GLOBAL
    // ============================================================

    window.toggleSidebar = function() {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) sidebar.classList.toggle('show');
    };

    // ============================================================
    // 2. INISIALISASI SAAT LOAD
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
        // Tutup sidebar jika klik di luar (Mobile Only)
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.querySelector('.d-lg-none'); 

            if (sidebar && sidebar.classList.contains('show') &&
                !sidebar.contains(event.target) &&
                (!toggleBtn || !toggleBtn.contains(event.target))) {
                sidebar.classList.remove('show');
            }
        });
    });
</script>

<?= $this->renderSection('scripts') ?>

<!-- Global Confirmation Modal -->
<div class="modal fade" id="globalConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fa-solid fa-circle-exclamation text-warning fa-4x mb-3"></i>
                <h5 class="fw-bold mb-3">Konfirmasi</h5>
                <p class="mb-0 text-muted" id="confirmMessage">Apakah Anda yakin ingin melakukan aksi ini?</p>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary px-4 rounded-pill" id="confirmBtn">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let formToSubmit = null;
        
        const confirmForms = document.querySelectorAll('.form-confirm');
        let confirmModal;
        
        if (confirmForms.length > 0) {
            confirmModal = new bootstrap.Modal(document.getElementById('globalConfirmModal'));
            
            confirmForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    formToSubmit = this;
                    
                    const message = this.getAttribute('data-message') || 'Apakah Anda yakin ingin melakukan aksi ini?';
                    document.getElementById('confirmMessage').innerText = message;
                    
                    confirmModal.show();
                });
            });
            
            document.getElementById('confirmBtn').addEventListener('click', function() {
                if (formToSubmit) {
                    // Coba trigger native submit agar tidak bentrok dengan script lain
                    HTMLFormElement.prototype.submit.call(formToSubmit);
                }
            });
        }
    });
</script>

</body>
</html>
