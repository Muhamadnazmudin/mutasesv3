<style>
/* ===============================
   DARK MODE - FORM LABEL FIX
   =============================== */

body.dark-mode label,
body.dark-mode .form-label,
body.dark-mode .modal-body label {
    color: #000000ff !important; /* terang & aman */
    font-weight: 500;
}

/* Placeholder agar tetap terbaca */
body.dark-mode .form-control::placeholder,
body.dark-mode textarea::placeholder {
    color: #9aa0a6;
}

/* Judul modal */
body.dark-mode .modal-title {
    color: #ffffff !important;
}
body.dark-mode .modal-body small,
body.dark-mode .modal-body span,
body.dark-mode .modal-body .text-muted {
    color: #e4e6eb !important;
}

</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Data Buku Tamu</h4>

    <div>
        <a href="<?= site_url('buku_tamu/export_pdf') ?>"
           class="btn btn-danger btn-sm">
            <i class="fas fa-file-pdf"></i> PDF
        </a>

        <a href="<?= site_url('buku_tamu/export_excel') ?>"
           class="btn btn-success btn-sm">
            <i class="fas fa-file-excel"></i> Excel
        </a>

        <button class="btn btn-primary btn-sm"
                data-toggle="modal"
                data-target="#modalTambahBukuTamu">
            <i class="fas fa-plus"></i> Tambah
        </button>
    </div>
</div>


<div class="table-responsive">
<table class="table table-bordered table-striped table-hover">
<thead class="thead-dark">
<tr>
    <th width="5%">No</th>
    <th width="15%">Tanggal</th>
    <th>Nama</th>
    <th>Instansi</th>
    <th width="8%">Jumlah</th>
    <th>Tujuan</th>
    <th>Keperluan</th>
    <th width="10%">Selfie</th>
    <th width="10%">KTA/Identitas</th>
    <th width="15%">Aksi</th>
</tr>
</thead>

<tbody>
<?php if (!empty($list)): ?>
<?php $no = 1; foreach ($list as $r): ?>
<tr>
    <td class="text-center"><?= $no++ ?></td>

    <td>
        <?= date('d-m-Y', strtotime($r->tanggal)) ?><br>
        <small class="text-muted"><?= date('H:i', strtotime($r->tanggal)) ?></small>
    </td>

    <td><?= htmlspecialchars($r->nama_tamu) ?></td>
    <td><?= htmlspecialchars($r->instansi) ?></td>
    <td class="text-center"><?= (int) $r->jumlah_orang ?> org</td>
    <td><?= htmlspecialchars($r->tujuan) ?></td>
    <td><?= htmlspecialchars($r->keperluan) ?></td>
    <!-- FOTO SELFIE -->
    <td class="text-center">
        <?php if (!empty($r->foto_selfie)): ?>
            <img src="<?= base_url('uploads/buku_tamu/selfie/'.$r->foto_selfie) ?>"
                 class="img-thumbnail"
                 width="60"
                 style="cursor:pointer"
                 onclick="window.open(this.src)">
        <?php else: ?>
            <span class="text-muted">-</span>
        <?php endif; ?>
    </td>

    <!-- FOTO IDENTITAS -->
    <td class="text-center">
        <?php if (!empty($r->foto_identitas)): ?>
            <a href="<?= base_url('uploads/buku_tamu/identitas/'.$r->foto_identitas) ?>"
               target="_blank"
               class="btn btn-sm btn-outline-primary">
               Lihat
            </a>
        <?php else: ?>
            <span class="text-muted">-</span>
        <?php endif; ?>
    </td>

    <!-- AKSI -->
    <td class="text-center">
        <button class="btn btn-warning btn-sm btn-edit"
        data-id="<?= $r->id ?>">
    <i class="fas fa-edit"></i>
</button>

        <a href="<?= site_url('buku_tamu/hapus/'.$r->id) ?>"
           onclick="return confirm('Yakin ingin menghapus data ini?')"
           class="btn btn-danger btn-sm mb-1">
           <i class="fas fa-trash"></i>
        </a>
    </td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="8" class="text-center text-muted">
        Belum ada data buku tamu
    </td>
</tr>
<?php endif; ?>
</tbody>
</table>
<!-- ===========================
     MODAL TAMBAH BUKU TAMU
=========================== -->
<div class="modal fade" id="modalTambahBukuTamu" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">
            <i class="fas fa-book"></i> Tambah Buku Tamu
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <?= form_open_multipart('buku_tamu/tambah', ['id' => 'formTambahBukuTamu']) ?>

      <div class="modal-body">
        <div class="row">

          <div class="col-md-6 mb-3">
            <label>Nama Tamu</label>
            <input type="text" name="nama_tamu" class="form-control" required>
          </div>

          <div class="col-md-6 mb-3">
            <label>Instansi</label>
            <input type="text" name="instansi" class="form-control">
          </div>
          <div class="col-md-6 mb-3">
    <label>Jumlah Orang</label>
    <input type="number"
           name="jumlah_orang"
           class="form-control"
           min="1"
           value="1"
           required>
    <small class="text-muted">
        Termasuk ketua rombongan
    </small>
</div>

          <div class="col-md-6 mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp" class="form-control">
          </div>

          <div class="col-md-6 mb-3">
            <label>Bertemu Dengan</label>
            <input type="text" name="bertemu_dengan" class="form-control">
          </div>

          <div class="col-md-12 mb-3">
            <label>Tujuan</label>
            <input type="text" name="tujuan" class="form-control">
          </div>

          <div class="col-md-12 mb-3">
            <label>Keperluan</label>
            <textarea name="keperluan" class="form-control" rows="2"></textarea>
          </div>

          <hr class="col-12">

          <div class="col-md-6 mb-3">
  <label>Foto Selfie (Wajib)</label>

  <video id="cameraSelfie"
       autoplay
       muted
       playsinline
       class="w-100 rounded border"
       style="height:240px; background:#000; object-fit:cover;">
</video>


  <canvas id="canvasSelfie" style="display:none;"></canvas>

  <img id="previewSelfie"
       class="img-thumbnail mt-2"
       style="display:none; width:120px;">

  <input type="hidden" name="selfie_base64" id="selfieBase64">

  <div class="mt-2">
    <button type="button"
            class="btn btn-sm btn-info"
            id="btnCaptureSelfie">
      <i class="fas fa-camera"></i> Ambil Foto
    </button>
  </div>

  <small class="text-muted">
    Foto diambil langsung dari kamera (tidak bisa upload)
  </small>
</div>

          <div class="col-md-6 mb-3">
            <label>Foto Identitas</label>
            <input type="file" name="foto_identitas" class="form-control">
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          Batal
        </button>
        <button type="submit" class="btn btn-success">
          <i class="fas fa-save"></i> Simpan
        </button>
      </div>

      <?= form_close() ?>

    </div>
  </div>
</div>
<!-- ===========================
     MODAL EDIT BUKU TAMU
=========================== -->
<div class="modal fade" id="modalEditBukuTamu" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-warning">
        <h5 class="modal-title">
            <i class="fas fa-edit"></i> Edit Buku Tamu
        </h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body" id="editBukuTamuContent">
        <div class="text-center text-muted py-5">
            <i class="fas fa-spinner fa-spin"></i> Memuat data...
        </div>
      </div>

    </div>
  </div>
</div>

</div>
<script>
let stream = null;

// === START CAMERA ===
async function startCamera() {
    const video = document.getElementById('cameraSelfie');
    if (!video) return;

    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'user' },
            audio: false
        });

        video.srcObject = stream;
        await video.play();

    } catch (err) {
        console.error(err);
        alert('Kamera tidak dapat diakses');
    }
}

// === STOP CAMERA ===
function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
}

// === MODAL EVENT (TANPA JQUERY) ===
document.addEventListener('DOMContentLoaded', function () {

    if (window.jQuery) {

        $('#modalTambahBukuTamu').on('shown.bs.modal', function () {
            setTimeout(startCamera, 300);
        });

        $('#modalTambahBukuTamu').on('hidden.bs.modal', function () {
            stopCamera();
        });

    } else {
        console.error('jQuery tidak tersedia, modal event gagal');
    }

});

// === CAPTURE FOTO ===
document.addEventListener('click', function (e) {
    if (e.target.id === 'btnCaptureSelfie') {

        const video  = document.getElementById('cameraSelfie');
        const canvas = document.getElementById('canvasSelfie');
        const img    = document.getElementById('previewSelfie');

        if (!video || video.videoWidth === 0) {
            alert('Kamera belum siap');
            return;
        }

        canvas.width  = video.videoWidth;
        canvas.height = video.videoHeight;

        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0);

        const dataURL = canvas.toDataURL('image/jpeg', 0.9);
        document.getElementById('selfieBase64').value = dataURL;

        img.src = dataURL;
        img.style.display = 'block';
    }
});

// === VALIDASI FORM TAMBAH ===
document.getElementById('formTambahBukuTamu')
    .addEventListener('submit', function (e) {
        if (!document.getElementById('selfieBase64').value) {
            alert('Foto selfie wajib diambil');
            e.preventDefault();
        }
    });
</script>

