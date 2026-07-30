<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftarkan Institusi Anda — Cloud LMS</title>
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6.4.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }
        
        .register-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
            background: white;
            max-width: 800px;
            width: 100%;
        }

        .card-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            text-align: center;
            padding: 3rem 2rem;
            border-bottom: none;
        }
        
        .card-body {
            padding: 3rem;
        }
        
        .section-title {
            color: #1e293b;
            font-weight: 700;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 10px;
            margin-bottom: 25px;
            margin-top: 20px;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="register-card mx-auto">
                    <div class="card-header">
                        <i class="fa-solid fa-rocket fa-3x mb-3"></i>
                        <h2 class="fw-bold mb-1">Daftarkan Institusi Anda</h2>
                        <p class="mb-0 opacity-75">Buat ekosistem e-learning mandiri untuk kampus atau sekolah Anda</p>
                    </div>
                    
                    <div class="card-body">
                        <?php if (session()->has('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                                <i class="fa-solid fa-circle-exclamation me-2"></i> <?= esc(session('error')) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form action="/register-institution" method="POST" novalidate>
                            <?= csrf_field() ?>
                            
                            <?php
                            $errors = session()->getFlashdata('errors') ?? [];
                            $err = fn($key) => isset($errors[$key]) ? '<div class="invalid-feedback d-block">' . esc($errors[$key]) . '</div>' : '';
                            $cls = fn($key) => 'form-control form-control-lg ' . (isset($errors[$key]) ? 'is-invalid' : '');
                            ?>

                            <h5 class="section-title"><i class="fa-solid fa-building me-2"></i> Data Institusi</h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Institusi <span class="text-danger">*</span></label>
                                <input type="text" name="tenant_name" id="tenantName" class="<?= $cls('tenant_name') ?>" value="<?= esc(old('tenant_name')) ?>" placeholder="Contoh: Universitas Al-Ma'ata" required>
                                <?= $err('tenant_name') ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">URL Identifier <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light text-muted">lms.domain.com/</span>
                                    <input type="text" name="url_string" id="urlString" class="<?= $cls('url_string') ?>" value="<?= esc(old('url_string')) ?>" placeholder="universitas_almaata" required>
                                </div>
                                <?= $err('url_string') ?>
                                <div class="form-text mt-2">Hanya huruf, angka, strip (-), dan underscore (_). Tidak bisa diubah setelah disimpan.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Domain Custom <span class="text-muted fw-normal">(Opsional)</span></label>
                                <input type="url" name="domain" class="<?= $cls('domain') ?>" value="<?= esc(old('domain')) ?>" placeholder="https://lms.institusi-anda.ac.id">
                                <?= $err('domain') ?>
                            </div>

                            <h5 class="section-title mt-5"><i class="fa-solid fa-user-tie me-2"></i> Akun Administrator Utama</h5>
                            
                            <div class="row g-4 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Admin <span class="text-danger">*</span></label>
                                    <input type="text" name="admin_name" class="<?= $cls('admin_name') ?>" value="<?= esc(old('admin_name')) ?>" placeholder="Nama lengkap admin" required>
                                    <?= $err('admin_name') ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Email Admin <span class="text-danger">*</span></label>
                                    <input type="email" name="admin_email" class="<?= $cls('admin_email') ?>" value="<?= esc(old('admin_email')) ?>" placeholder="admin@institusi.com" required>
                                    <?= $err('admin_email') ?>
                                </div>
                            </div>

                            <div class="row g-4 mb-5">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="admin_password" class="<?= $cls('admin_password') ?>" placeholder="Min. 8 karakter" required>
                                    <div class="form-text">Wajib kombinasi huruf besar, kecil, dan angka.</div>
                                    <?= $err('admin_password') ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" name="admin_password_confirm" class="<?= $cls('admin_password_confirm') ?>" placeholder="Ulangi password" required>
                                    <?= $err('admin_password_confirm') ?>
                                </div>
                            </div>

                            <div class="d-grid gap-3">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold py-3">
                                    <i class="fa-solid fa-cloud-arrow-up me-2"></i> Buat Institusi Sekarang
                                </button>
                                <a href="/" class="btn btn-light btn-lg fw-semibold text-secondary">
                                    <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Beranda
                                </a>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('tenantName');
            const urlInput = document.getElementById('urlString');
            
            if(nameInput && urlInput) {
                let urlTouched = urlInput.value.length > 0;
                
                urlInput.addEventListener('input', function() { 
                    urlTouched = true; 
                });

                nameInput.addEventListener('input', function () {
                    if (urlTouched) return;
                    
                    urlInput.value = this.value
                        .toLowerCase()
                        .trim()
                        .replace(/[^a-z0-9\s_-]/g, '')
                        .replace(/\s+/g, '_')
                        .replace(/_+/g, '_')
                        .substring(0, 100);
                });
            }
        });
    </script>
</body>
</html>
