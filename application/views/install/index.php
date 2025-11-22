<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Instalasi Mutases</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <div class="card shadow p-4 mx-auto" style="max-width: 480px;">
        <h3 class="text-center mb-3">Instalasi Sistem Mutases</h3>

        <p class="text-center text-muted mb-4">
            Sistem mendeteksi bahwa aplikasi belum diinstall.<br>
            Klik tombol di bawah untuk memulai instalasi database secara otomatis.
        </p>

        <div class="text-center">
            <a href="<?= base_url('index.php/install/run'); ?>" class="btn btn-primary btn-lg px-5">
                Install Sekarang
            </a>
        </div>
    </div>

</div>

</body>
</html>