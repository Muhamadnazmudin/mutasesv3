<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }
        .maintenance-box {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 40px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,.25);
        }
        .maintenance-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="maintenance-box text-center">
    <div class="maintenance-icon">
        <i class="fas fa-tools"></i>
    </div>

    <h2 class="fw-bold mb-3">Website Dalam Perbaikan</h2>

    <p class="mb-4">
        Sistem <strong>SimSGTK</strong> sedang dalam proses maintenance untuk peningkatan layanan.
        <br>
        Silakan kembali beberapa saat lagi.
    </p>

    <hr class="border-light">

    <small>
        © <?= date('Y') ?> SimSGTK<br>
        Terima kasih atas pengertiannya 🙏
    </small>
</div>

</body>
</html>
