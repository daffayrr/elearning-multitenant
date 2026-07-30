<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
        /* Card Stat Styling */
        .card-stat {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
            transition: transform 0.2s;
            overflow: hidden;
            position: relative;
            background: #fff;
        }
        .card-stat:hover {
            transform: translateY(-3px);
        }
        .card-stat .icon-bg {
            position: absolute;
            right: -10px;
            bottom: -10px;
            font-size: 5rem;
            opacity: 0.1;
        }
        .border-left-primary { border-left: 4px solid #0d6efd !important; }
        .border-left-success { border-left: 4px solid #198754 !important; }

        .welcome-banner {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .welcome-banner::after {
            content: '\f19d';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 20px;
            bottom: -20px;
            font-size: 8rem;
            opacity: 0.1;
        }
<?= $this->endSection() ?>

<?= $this->section('content') ?>
            <div class="welcome-banner">
                <h3 class="fw-bold mb-1">Selamat Datang, <?= esc(session()->get('name') ?? 'Admin') ?>! 👋</h3>
                <p class="mb-0 opacity-75">Kelola instruktur, siswa, dan pengaturan platform Anda di panel ini.</p>
            </div>

            <!-- Stats Grid -->
            <div class="row g-4 mb-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card card-stat border-left-primary h-100 p-3">
                        <div class="card-body p-0">
                            <h6 class="text-muted text-uppercase mb-2">Total Instruktur</h6>
                            <h2 class="text-primary mb-0 fw-bold"><?= esc($totalInstructors ?? 0) ?></h2>
                            <i class="fa-solid fa-chalkboard-teacher icon-bg text-primary"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-stat border-left-success h-100 p-3">
                        <div class="card-body p-0">
                            <h6 class="text-muted text-uppercase mb-2">Total Siswa</h6>
                            <h2 class="text-success mb-0 fw-bold"><?= esc($totalStudents ?? 0) ?></h2>
                            <i class="fa-solid fa-user-graduate icon-bg text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
<?= $this->endSection() ?>
