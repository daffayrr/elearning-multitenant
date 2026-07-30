<?php
/**
 * @var string $tenant_string_id
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — LMS</title>
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6.4.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .register-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 550px;
            margin: 20px;
        }
        .card-header {
            background: linear-gradient(135deg, #198754 0%, #157347 100%);
            color: white;
            text-align: center;
            padding: 2rem 1rem;
            border-bottom: none;
        }
        .card-body {
            padding: 2rem;
            background-color: white;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="card-header">
            <i class="fa-solid fa-user-plus fa-3x mb-3"></i>
            <h4 class="mb-0 fw-bold">Buat Akun Baru</h4>
            <p class="mb-0 opacity-75 small mt-1">Daftar sebagai siswa di platform ini</p>
        </div>
        <div class="card-body">
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> <?= esc(session('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="/<?= esc($tenant_string_id) ?>/register" method="POST">
                <?= csrf_field() ?>
                
                <?php
                $errors = session()->getFlashdata('errors') ?? [];
                $err = fn($key) => isset($errors[$key]) ? '<div class="invalid-feedback">' . esc($errors[$key]) . '</div>' : '';
                $cls = fn($key) => 'form-control ' . (isset($errors[$key]) ? 'is-invalid' : '');
                ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-user text-muted"></i></span>
                        <input type="text" name="name" class="<?= $cls('name') ?>" value="<?= esc(old('name')) ?>" placeholder="Masukkan nama lengkap Anda" required>
                        <?= $err('name') ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-envelope text-muted"></i></span>
                        <input type="email" name="email" class="<?= $cls('email') ?>" value="<?= esc(old('email')) ?>" placeholder="Masukkan email yang valid" required>
                        <?= $err('email') ?>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Password</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-lock text-muted"></i></span>
                            <input type="password" name="password" class="<?= $cls('password') ?>" placeholder="Min. 8 karakter" required>
                            <?= $err('password') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Konfirmasi Password</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-lock text-muted"></i></span>
                            <input type="password" name="password_confirm" class="<?= $cls('password_confirm') ?>" placeholder="Ulangi password" required>
                            <?= $err('password_confirm') ?>
                        </div>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-success fw-bold py-2">
                        <i class="fa-solid fa-user-check me-2"></i> Daftar Sekarang
                    </button>
                </div>
                
                <div class="text-center text-muted small">
                    Sudah punya akun? <a href="/<?= esc($tenant_string_id) ?>/login" class="text-decoration-none text-success fw-semibold">Masuk di sini</a>
                </div>
                <div class="text-center text-muted small mt-3">
                    <a href="/" class="text-decoration-none text-secondary"><i class="fa-solid fa-house me-1"></i> Kembali ke beranda</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
