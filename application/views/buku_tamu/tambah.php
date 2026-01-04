<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Buku Tamu</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
body {
  background: #f4f6f9;
}
.card {
  max-width: 860px;
  margin: auto;
}
video {
  background: #000;
  object-fit: cover;
}
</style>
</head>

<body>

<div class="container py-5">

  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">
        <i class="fas fa-book"></i> Buku Tamu
      </h5>
      <small>Silakan isi data kunjungan Anda</small>
    </div>

    <?= form_open_multipart('buku_tamu/tambah', ['id'=>'formBukuTamu']) ?>

    <div class="card-body row g-3">

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

      <!-- SELFIE -->
      <div class="col-md-6">
        <label class="form-label">Foto Selfie (Wajib)</label>

        <video id="cameraSelfie"
               autoplay
               playsinline
               muted
               class="w-100 rounded border"
               style="height:260px;"></video>

        <canvas id="canvasSelfie" class="d-none"></canvas>

        <img id="previewSelfie"
             class="img-thumbnail mt-2"
             style="display:none; width:140px;">

        <input type="hidden" name="selfie_base64" id="selfieBase64">

        <div class="mt-2">
          <button type="button" class="btn btn-info btn-sm" id="btnCapture">
            <i class="fas fa-camera"></i> Ambil Foto
          </button>
          <button type="button" class="btn btn-secondary btn-sm d-none" id="btnUlangi">
            <i class="fas fa-undo"></i> Ulangi
          </button>
        </div>

        <small class="text-muted">
          Foto diambil langsung dari kamera
        </small>
      </div>

      <!-- IDENTITAS -->
      <div class="col-md-6">
        <label class="form-label">Foto Identitas / KTA</label>
        <input type="file" name="foto_identitas" class="form-control">
        <small class="text-muted">
          KTP / Kartu Instansi / KTA
        </small>
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

<script>
let stream = null;

// START CAMERA
navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' }, audio:false })
.then(s => {
  stream = s;
  document.getElementById('cameraSelfie').srcObject = stream;
});

// CAPTURE
document.getElementById('btnCapture').onclick = () => {
  const video  = document.getElementById('cameraSelfie');
  const canvas = document.getElementById('canvasSelfie');
  const img    = document.getElementById('previewSelfie');

  canvas.width  = video.videoWidth;
  canvas.height = video.videoHeight;
  canvas.getContext('2d').drawImage(video,0,0);

  const dataURL = canvas.toDataURL('image/jpeg',0.9);
  document.getElementById('selfieBase64').value = dataURL;

  img.src = dataURL;
  img.style.display = 'block';

  document.getElementById('btnCapture').classList.add('d-none');
  document.getElementById('btnUlangi').classList.remove('d-none');
};

// ULANGI
document.getElementById('btnUlangi').onclick = () => {
  document.getElementById('selfieBase64').value = '';
  document.getElementById('previewSelfie').style.display = 'none';
  document.getElementById('btnCapture').classList.remove('d-none');
  document.getElementById('btnUlangi').classList.add('d-none');
};

// VALIDASI
document.getElementById('formBukuTamu').addEventListener('submit', e => {
  if (!document.getElementById('selfieBase64').value) {
    alert('Foto selfie wajib diambil');
    e.preventDefault();
  }
});
</script>

</body>
</html>
