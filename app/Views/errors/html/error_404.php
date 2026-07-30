<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .error-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            background: white;
            max-width: 600px;
            width: 100%;
            padding: 4rem 2rem;
            text-align: center;
            margin: 20px;
        }

        .error-icon {
            font-size: 6rem;
            color: #0d6efd;
            opacity: 0.8;
            margin-bottom: 2rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        .error-title {
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 1rem;
        }

        .error-message {
            font-size: 1.15rem;
            color: #64748b;
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }
    </style>
</head>
<body>

    <div class="error-card">
        <i class="fa-solid fa-magnifying-glass-location error-icon"></i>
        
        <h1 class="error-title">404 - Halaman Tidak Ditemukan</h1>
        
        <p class="error-message">
            <?php if (! empty($message) && $message !== 'Not Found') : ?>
                <?= esc($message) ?>
            <?php else : ?>
                Maaf, halaman atau tenant institusi yang Anda cari tidak dapat ditemukan, mungkin URL salah atau telah dinonaktifkan.
            <?php endif; ?>
        </p>

        <a href="/" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold shadow-sm">
            <i class="fa-solid fa-house me-2"></i> Kembali ke Beranda
        </a>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
