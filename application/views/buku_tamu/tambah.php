<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Buku Tamu</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
body { background:#f4f6f9; }
.card { max-width:860px; margin:auto; }

.video-wrap {
  position: relative;
  width: 100%;
  height: 260px;
}

.video-wrap video,
.video-wrap canvas {
  position:absolute;
  top:0; left:0;
  width:100%;
  height:100%;
  border-radius:6px;
}

video { background:#000; object-fit:cover; }

.status-text {
  font-size: 13px;
  font-weight: 600;
}
</style>
</head>

<body>

<div class="container py-5">
<div class="card shadow">

<div class="card-header bg-primary text-white">
  <h5 class="mb-0"><i class="fas fa-book"></i> Buku Tamu</h5>
  <small>Silakan isi data kunjungan Anda</small>
</div>

<?= form_open_multipart('buku_tamu/tambah', ['id'=>'formBukuTamu']) ?>

<div class="card-body row g-3">

<!-- ================= FORM ================= -->
<div class="col-md-6">
  <label class="form-label">Nama Tamu</label>
  <input type="text" name="nama_tamu" class="form-control" required>
</div>

<div class="col-md-6">
  <label class="form-label">Instansi</label>
  <input type="text" name="instansi" class="form-control">
</div>

<div class="col-md-4">
  <label class="form-label">Jumlah Orang</label>
  <input type="number" name="jumlah_orang" class="form-control" min="1" value="1" required>
</div>

<div class="col-md-4">
  <label class="form-label">No HP</label>
  <input type="text" name="no_hp" class="form-control">
</div>

<div class="col-md-4">
  <label class="form-label">Bertemu Dengan</label>
  <input type="text" name="bertemu_dengan" class="form-control">
</div>

<div class="col-md-12">
  <label class="form-label">Tujuan</label>
  <input type="text" name="tujuan" class="form-control">
</div>

<div class="col-md-12">
  <label class="form-label">Keperluan</label>
  <textarea name="keperluan" class="form-control" rows="3"></textarea>
</div>

<hr>

<!-- ================= SELFIE ================= -->
<div class="col-md-6">
  <label class="form-label">Foto Selfie (Wajib)</label>

  <div class="video-wrap border">
    <video id="cameraSelfie" autoplay playsinline muted></video>
    <canvas id="overlaySelfie"></canvas>
  </div>

  <canvas id="canvasSelfie" class="d-none"></canvas>

  <img id="previewSelfie" class="img-thumbnail mt-2" style="display:none;width:140px">

  <input type="hidden" name="selfie_base64" id="selfieBase64">

  <div class="mt-2">
    <button type="button" class="btn btn-info btn-sm" id="btnCapture" disabled>
      <i class="fas fa-camera"></i> Ambil Foto
    </button>
    <button type="button" class="btn btn-secondary btn-sm d-none" id="btnUlangi">
      <i class="fas fa-undo"></i> Ulangi
    </button>
  </div>

  <div id="statusWajah" class="status-text text-danger mt-1">
    Arahkan wajah ke kamera
  </div>
</div>

<div class="col-md-6">
  <label class="form-label">Foto Identitas / KTA</label>
  <input type="file" name="foto_identitas" class="form-control">
</div>

</div>

<div class="card-footer text-end">
  <button class="btn btn-success">
    <i class="fas fa-save"></i> Simpan Buku Tamu
  </button>
</div>

<?= form_close() ?>
</div>
</div>

<!-- ================= FACE API ================= -->
<script src="<?= base_url('assets/face-api/face-api.min.js') ?>"></script>

<script>
const video = document.getElementById('cameraSelfie');
const overlay = document.getElementById('overlaySelfie');
const octx = overlay.getContext('2d');

const canvas = document.getElementById('canvasSelfie');
const img = document.getElementById('previewSelfie');
const btnCap = document.getElementById('btnCapture');
const btnUlg = document.getElementById('btnUlangi');
const input64 = document.getElementById('selfieBase64');
const statusWajah = document.getElementById('statusWajah');

let faceReady = false;
let faceValid = false;

/* LOAD MODEL */
(async () => {
  await faceapi.nets.tinyFaceDetector.loadFromUri('<?= base_url('assets/face-api/models') ?>');
  await faceapi.nets.faceLandmark68TinyNet.loadFromUri('<?= base_url('assets/face-api/models') ?>');
  faceReady = true;
})();

/* CAMERA */
navigator.mediaDevices.getUserMedia({ video:{facingMode:'user'}, audio:false })
.then(s => video.srcObject = s);

/* REALTIME CHECK */
async function loop() {
  if (!faceReady || video.readyState < 2) {
    requestAnimationFrame(loop);
    return;
  }

  // ⬅️ INI FIX UTAMA
  overlay.width  = overlay.clientWidth;
  overlay.height = overlay.clientHeight;
  octx.clearRect(0, 0, overlay.width, overlay.height);

  faceValid = false;

  const r = await faceapi
    .detectSingleFace(
      video,
      new faceapi.TinyFaceDetectorOptions({ scoreThreshold: 0.5 })
    )
    .withFaceLandmarks(true);

  if (r) {
    console.log('DETECTED', {
  box: r.detection.box,
  videoW: video.videoWidth,
  videoH: video.videoHeight
});
if (!r) {
  console.log('NO FACE');
}

    const b = r.detection.box;

    // ⬅️ SCALE KOORDINAT (WAJIB)
    const scaleX = overlay.width / video.videoWidth;
    const scaleY = overlay.height / video.videoHeight;

    const x = b.x * scaleX;
    const y = b.y * scaleY;
    const w = b.width * scaleX;
    const h = b.height * scaleY;

    const areaRatio =
      (b.width * b.height) /
      (video.videoWidth * video.videoHeight);

    const lm = r.landmarks;
    const eyeY =
  (lm.getLeftEye()[0].y + lm.getRightEye()[0].y) / 2;
const noseY = lm.getNose()[0].y;
const diff = noseY - eyeY;

    // ⬅️ THRESHOLD DIPERMUDAH (INI PENTING)
    const sizeOK  = areaRatio > 0.07;
    const angleOK = diff > 4 && diff < 43;

    faceValid = sizeOK && angleOK;

    // DRAW BOX
    octx.lineWidth = 3;
    octx.strokeStyle = faceValid ? '#00ff00' : '#ff0000';
    octx.strokeRect(x, y, w, h);

    statusWajah.textContent = faceValid
      ? 'Posisi wajah OK'
      : 'Sesuaikan wajah';
    statusWajah.className =
      'status-text ' + (faceValid ? 'text-success' : 'text-danger');
  } else {
    statusWajah.textContent = 'Wajah tidak terdeteksi';
    statusWajah.className = 'status-text text-danger';
  }

  btnCap.disabled = !faceValid;
  requestAnimationFrame(loop);
}

video.onloadedmetadata = () => loop();

/* CAPTURE */
btnCap.onclick = () => {
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  canvas.getContext('2d').drawImage(video,0,0);
  input64.value = canvas.toDataURL('image/jpeg',0.9);

  img.src = input64.value;
  img.style.display='block';

  btnCap.classList.add('d-none');
  btnUlg.classList.remove('d-none');
};

/* ULANGI */
btnUlg.onclick = () => {
  input64.value='';
  img.style.display='none';
  btnCap.classList.remove('d-none');
  btnUlg.classList.add('d-none');
};

/* SUBMIT VALIDASI */
document.getElementById('formBukuTamu').addEventListener('submit',e=>{
  if(!input64.value){ alert('Foto selfie wajib'); e.preventDefault(); }
});
</script>

</body>
</html>
