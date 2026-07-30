<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($pageTitle ?? 'Instructor Dashboard') ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --header-height: 70px;
            --footer-height: 60px;

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

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg-body); 
            color: var(--text-main);
            font-size: 0.9rem;
            transition: background-color 0.3s, color 0.3s;
            overflow-x: hidden;
        }
        a { text-decoration: none; }

        .sidebar { 
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            background-color: var(--bg-sidebar); 
            border-right: 1px solid var(--border-color); 
            z-index: 1040;
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

        .top-header { 
            position: fixed;
            top: 0; left: var(--sidebar-width); 
            width: calc(100% - var(--sidebar-width)); 
            height: var(--header-height);
            background-color: var(--bg-card); 
            border-bottom: 1px solid var(--border-color); 
            display: flex; align-items: center; justify-content: space-between; padding: 0 30px;
            z-index: 1030; 
            transition: left 0.3s, width 0.3s;
        }

        .app-footer {
            position: fixed;
            bottom: 0; left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            height: var(--footer-height);
            background-color: var(--bg-card);
            border-top: 1px solid var(--border-color);
            display: flex; align-items: center; justify-content: center;
            z-index: 1030;
            color: var(--text-muted);
            font-size: 0.85rem;
            transition: left 0.3s, width 0.3s;
        }

        .main-content {
            margin-top: var(--header-height); 
            margin-left: var(--sidebar-width); 
            padding: 30px; 
            min-height: calc(100vh - var(--header-height));
            padding-bottom: calc(var(--footer-height) + 30px);
            transition: margin-left 0.3s;
        }

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

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .top-header { left: 0; width: 100%; }
            .app-footer { left: 0; width: 100%; }
            .main-content { margin-left: 0; }
            .sidebar.show { transform: translateX(0); box-shadow: 0 0 15px rgba(0,0,0,0.5); }
        }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column">
    <a href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/instructor/dashboard" class="text-decoration-none">
        <div class="sidebar-brand">
        <i class="fa-solid fa-graduation-cap"></i>
        <span>eLearning</span>
    </div>
    </a>
    
    <ul class="nav flex-column mb-auto">
        <li class="px-4 mt-2 mb-2 text-uppercase small text-muted fw-bold" style="font-size: 0.7rem;">Main Menu</li>
        <li class="nav-item">
            <a class="nav-link <?= (url_is('*dashboard*')) ? 'active' : '' ?>" href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/student/dashboard">
                <i class="fa-solid fa-house"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (url_is('*courses*') && !url_is('*all-courses*') || url_is('*course/*')) ? 'active' : '' ?>" href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/student/courses">
                <i class="fa-solid fa-book"></i> Kelasku
            </a>
        </li>
        <li class="px-4 mt-3 mb-2 text-uppercase small text-muted fw-bold" style="font-size: 0.7rem;">Akademik</li>
        <li class="nav-item">
            <a class="nav-link <?= (url_is('*assignments*')) ? 'active' : '' ?>" href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/student/assignments">
                <i class="fa-solid fa-file-pen"></i> Tugas Saya
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (url_is('*exams*')) ? 'active' : '' ?>" href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/student/exams">
                <i class="fa-solid fa-laptop-code"></i> Ujian / CBT
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= (url_is('*scores*')) ? 'active' : '' ?>" href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/student/scores">
                <i class="fa-solid fa-chart-line"></i> Nilai Saya
            </a>
        </li>

        <li class="px-4 mt-3 mb-2 text-uppercase small text-muted fw-bold" style="font-size: 0.7rem;">Sistem</li>
        <li class="nav-item">
            <a class="nav-link <?= (url_is('*announcements*')) ? 'active' : '' ?>" href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/student/announcements">
                <i class="fa-solid fa-bullhorn"></i> Pusat Informasi
            </a>
        </li>
    </ul>

    <div class="px-3 pb-4 mt-4">
        <a href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/logout" class="nav-link text-danger fw-bold border border-danger rounded-3 justify-content-center">
            <i class="fa-solid fa-right-from-bracket"></i> Keluar
        </a>
    </div>
</div>

<div class="top-header">
    <div class="d-flex align-items-center">
        <button type="button" class="btn btn-link d-lg-none me-3 p-0 text-decoration-none" onclick="toggleSidebar()" style="z-index: 1050; color: var(--text-main);">
            <i class="fa-solid fa-bars fs-4"></i>
        </button>
        <div>
            <h5 class="fw-bold mb-0" style="color: var(--text-main);"><?= esc($pageTitle ?? 'Dashboard') ?></h5>
            <small class="text-muted">Instruktur Portal</small>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <div class="bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                    <?= strtoupper(substr(session('name') ?? 'I', 0, 1)) ?>
                </div>
                <div class="d-none d-lg-block text-start lh-sm">
                    <div class="fw-bold small" style="color: var(--text-main);"><?= esc(session('name') ?? 'Instructor') ?></div>
                    <small class="text-muted" style="font-size: 11px;">Instruktur</small>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow mt-2" style="background-color: var(--bg-card); border-color: var(--border-color);">
                <li><a class="dropdown-item text-danger" href="/<?= $tenantStringId ?? session('current_tenant_string') ?>/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="main-content">
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

<footer class="app-footer">
    <div>
        &copy; 2026 <strong>eLearning Multi-Tenant</strong>.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.toggleSidebar = function() {
        const sidebar = document.querySelector('.sidebar');
        if (sidebar) sidebar.classList.toggle('show');
    };
    
    document.addEventListener('click', function(event) {
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.querySelector('.d-lg-none'); 

        if (sidebar && sidebar.classList.contains('show') &&
            !sidebar.contains(event.target) &&
            (!toggleBtn || !toggleBtn.contains(event.target))) {
            sidebar.classList.remove('show');
        }
    });
</script>
</body>
</html>
