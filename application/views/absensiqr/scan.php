<!DOCTYPE html>
<html>
<head>
<title>Scan Absensi</title>
<script src="https://unpkg.com/html5-qrcode"></script>

<style>
    body {
        background:#000;
        color:white;
        text-align:center;
        font-family:Arial, sans-serif;
        padding-top:25px;
    }
    h2 {
        font-size:32px;
        font-weight:bold;
        margin-bottom:20px;
    }

    #reader {
        width:350px;
        margin:20px auto;
    }

    /* BOX HEADER JAM */
    .info-wrapper {
        width: 500px;
        max-width: 92%;
        background: #111;
        border: 1px solid #333;
        border-radius: 12px;
        margin: 0 auto 20px auto;
        padding: 16px;
    }

    .hari-label {
        font-size:20px;
        font-weight:bold;
        margin-bottom:10px;
    }

    .row-jam {
        display:flex;
        justify-content:space-between;
        align-items:center;
        padding:0 15px;
        margin-top:10px;
    }

    .col-jam {
        text-align:center;
        width:50%;
    }

    .col-jam .label {
        font-size:15px;
        color:#ddd;
    }

    .col-jam .time {
        font-size:26px;
        font-weight:bold;
        color:#00eaff;
        margin-top:4px;
    }

    /* --- ANIMASI LIBUR KEREN --- */
    .libur-box {
        margin-top:20px;
        padding:20px;
        background:#221100;
        border:2px solid #ffbb33;
        border-radius:12px;
        animation: fadeIn 1s ease-out;
    }

    .libur-title {
        font-size:28px;
        font-weight:bold;
        color:#ffdd55;
        animation: pulse 1.5s infinite;
    }

    .libur-desc {
        font-size:18px;
        color:#ffcc88;
        margin-top:8px;
    }

    @keyframes fadeIn {
        from { opacity:0; transform:translateY(-10px); }
        to { opacity:1; transform:translateY(0); }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.06); }
        100% { transform: scale(1); }
    }
</style>
</head>
<body>

<h2>SCAN QR ABSENSI</h2>

<!-- ====================== -->
<!-- HEADER INFORMASI HARI  -->
<!-- ====================== -->
<div class="info-wrapper">

    <div class="hari-label">
        Hari: <span style="color:#00eaff;"><?= isset($hari_nama) ? $hari_nama : '-' ?></span>
    </div>

    <?php if (isset($libur) && $libur == true): ?>

        <!-- === MODE LIBUR === -->
        <div class="libur-box">
            <div class="libur-title">✨ HARI INI LIBUR ✨</div>

            <?php if (!empty($keterangan_libur)): ?>
            <div class="libur-desc">
                <?= $keterangan_libur ?>
            </div>
            <?php endif; ?>
        </div>

    <?php else: ?>

        <!-- === MODE NORMAL (ADA JAM MASUK/PULANG) === -->
        <div class="row-jam">

            <div class="col-jam">
                <div class="label">Jam Masuk Hari Ini</div>
                <div class="time"><?= $jam_masuk ?></div>
            </div>

            <div class="col-jam">
                <div class="label">Jam Pulang Hari Ini</div>
                <div class="time"><?= $jam_pulang ?></div>
            </div>

        </div>

    <?php endif; ?>
</div>


<!-- =========================== -->
<!-- QR SCANNER (HANYA NON LIBUR) -->
<!-- =========================== -->
<?php if (!isset($libur) || $libur == false): ?>
    <div id="reader"></div>
<?php endif; ?>


<!-- Suara -->
<audio id="beep-success" src="<?= base_url('assets/sound/success.mp3') ?>"></audio>
<audio id="beep-error" src="<?= base_url('assets/sound/error.mp3') ?>"></audio>


<!-- =========================== -->
<!--   JAVASCRIPT SCANNER        -->
<!-- =========================== -->
<?php if (!isset($libur) || $libur == false): ?>

<script>
let lastScan = "";
let lastTime = 0;

function onScanSuccess(decodedText) {
    let now = Date.now();

    if (decodedText === lastScan && (now - lastTime) < 2500) return;

    lastScan = decodedText;
    lastTime = now;

    window.location.href =
        "<?= base_url('index.php/AbsensiQR/scan/') ?>" + decodedText;
}

new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: 250 }
).render(onScanSuccess);
</script>

<?php endif; ?>

</body>
</html>
