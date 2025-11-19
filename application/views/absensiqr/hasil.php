<!DOCTYPE html>
<html>
<head>
<title>Hasil Absensi</title>
<style>
    body {
        background:#000;
        color:white;
        text-align:center;
        padding-top:40px;
        font-family:Arial, sans-serif;
    }

    .box {
        width: 90%;
        max-width: 400px;
        margin:auto;
        padding:15px;
        border-radius:8px;
    }

    .success { background:#0a0; }
    .danger  { background:#c00; }
    .warning { background:#d68f00; }

    h1 { font-size:22px; margin-bottom:8px; }
    h2 { font-size:18px; margin-bottom:5px; }
    p  { font-size:16px; margin:4px 0; }

    .redirect {
        margin-top:20px;
        font-size:14px;
        opacity:0.7;
    }
</style>
</head>
<body>

<?php if ($type == 'masuk'): ?>
    <div class="box success">
        <h1>ABSEN MASUK OK</h1>
        <h2><?= $nama ?></h2>
        <p>Jam Masuk: <b><?= $jam_masuk ?></b></p>
        <p>Status: <b><?= $status ?></b></p>
    </div>

<?php elseif ($type == 'pulang'): ?>
    <div class="box success">
        <h1>ABSEN PULANG OK</h1>
        <h2><?= $nama ?></h2>
        <p>Jam Pulang: <b><?= $jam_pulang ?></b></p>
    </div>

<?php elseif ($type == 'belum_waktu'): ?>
    <div class="box warning">
        <h1>BELUM WAKTUNYA</h1>
        <h2><?= $nama ?></h2>
        <p>Sekarang: <b><?= $jam_now ?></b></p>
        <p>Pulang Resmi: <b><?= $jam_resmi_pulang ?></b></p>
    </div>

<?php elseif ($type == 'sudah_pulang'): ?>
    <div class="box danger">
        <h1>SUDAH PULANG</h1>
        <h2><?= $nama ?></h2>
    </div>
<?php endif; ?>

<div class="redirect">Kembali ke scan...</div>

<meta http-equiv="refresh" content="1.3; url=<?= base_url('index.php/AbsensiQR/scan') ?>">

</body>
</html>
