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
    <title>Login — LMS</title>
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
        .login-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 450px;
            margin: 20px;
        }
        .card-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
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

    <div class="login-card">
        <div class="card-header">
            <i class="fa-solid fa-right-to-bracket fa-3x mb-3"></i>
            <h4 class="mb-0 fw-bold">Selamat Datang Kembali!</h4>
            <p class="mb-0 opacity-75 small mt-1">Silakan masuk ke akun Anda</p>
        </div>
        <div class="card-body">
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> <?= esc(session('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->has('message')): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> <?= esc(session('message')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="/<?= esc($tenant_string_id) ?>/login" method="POST">
                <?= csrf_field() ?>
                
                <?php
                $errors = session()->getFlashdata('errors') ?? [];
                $err = fn($key) => isset($errors[$key]) ? '<div class="invalid-feedback">' . esc($errors[$key]) . '</div>' : '';
                $cls = fn($key) => 'form-control ' . (isset($errors[$key]) ? 'is-invalid' : '');
                ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-envelope text-muted"></i></span>
                        <input type="email" name="email" class="<?= $cls('email') ?>" value="<?= esc(old('email')) ?>" placeholder="Masukkan email Anda" required>
                        <?= $err('email') ?>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-lock text-muted"></i></span>
                        <input type="password" name="password" class="<?= $cls('password') ?>" placeholder="Masukkan password Anda" required>
                        <?= $err('password') ?>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary fw-bold py-2">
                        <i class="fa-solid fa-arrow-right-to-bracket me-2"></i> Masuk
                    </button>
                </div>
                
                <div class="text-center text-muted small">
                    Belum punya akun? <a href="/<?= esc($tenant_string_id) ?>/register" class="text-decoration-none fw-semibold">Daftar sekarang</a>
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
