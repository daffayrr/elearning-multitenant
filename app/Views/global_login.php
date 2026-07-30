<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Institusi — LMS</title>
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
            <i class="fa-solid fa-building-user fa-3x mb-3"></i>
            <h4 class="mb-0 fw-bold">Login Institusi</h4>
            <p class="mb-0 opacity-75 small mt-1">Masukkan Identifier Institusi Anda</p>
        </div>
        <div class="card-body">
            
            <form onsubmit="handleAkses(event)">
                <div class="mb-4">
                    <label class="form-label fw-semibold">URL Identifier Institusi</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-link text-muted"></i></span>
                        <input type="text" id="tenantIdentifier" class="form-control" placeholder="Contoh: ugm_pusat" required autofocus>
                        <div class="invalid-feedback" id="tenantError">
                            Harap masukkan URL Identifier.
                        </div>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary fw-bold py-2">
                        <i class="fa-solid fa-arrow-right me-2"></i> Lanjutkan
                    </button>
                </div>
                
                <div class="text-center text-muted small mt-3">
                    <a href="/" class="text-decoration-none text-secondary"><i class="fa-solid fa-house me-1"></i> Kembali ke beranda</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function handleAkses(e) {
            e.preventDefault();
            const identifier = document.getElementById('tenantIdentifier').value.trim();
            const tenantInput = document.getElementById('tenantIdentifier');
            
            if (!identifier) {
                tenantInput.classList.add('is-invalid');
                tenantInput.focus();
                return;
            }
            
            tenantInput.classList.remove('is-invalid');
            const safeIdentifier = encodeURIComponent(identifier);
            
            window.location.href = `/${safeIdentifier}/login`;
        }
    </script>
</body>
</html>
