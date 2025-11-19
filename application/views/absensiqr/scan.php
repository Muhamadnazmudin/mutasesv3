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
</style>
</head>
<body>

<h2>SCAN QR ABSENSI</h2>

<!-- ====================== -->
<!--    HEADER JAM HARI INI -->
<!-- ====================== -->
<div class="info-wrapper">

    <!-- Hari -->
    <div class="hari-label">
        Hari: <span style="color:#00eaff;"><?= isset($hari_nama) ? $hari_nama : '-' ?></span>
    </div>

    <!-- Kolom Jam -->
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
</div>


<!-- QR Scanner -->
<div id="reader"></div>

<!-- Suara (tetap ada meski tidak dipakai) -->
<audio id="beep-success" src="<?= base_url('assets/sound/success.mp3') ?>"></audio>
<audio id="beep-error" src="<?= base_url('assets/sound/error.mp3') ?>"></audio>

<script>
let lastScan = "";
let lastTime = 0;

function onScanSuccess(decodedText) {
    let now = Date.now();

    // cegah double scan
    if (decodedText === lastScan && (now - lastTime) < 2500) return;

    lastScan = decodedText;
    lastTime = now;

    // jika mau pakai suara, tinggal aktifkan
    // document.getElementById("beep-success").play();

    window.location.href =
        "<?= base_url('index.php/AbsensiQR/scan/') ?>" + decodedText;
}

new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: 250 }
).render(onScanSuccess);
</script>

</body>
</html>
