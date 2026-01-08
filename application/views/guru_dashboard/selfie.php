<div class="container-fluid">

    <h4 class="mb-3">
        <i class="fas fa-camera"></i> Selfie Mengajar
    </h4>

    <div class="card shadow">
        <div class="card-body text-center">

            <!-- CSRF -->
            <input type="hidden" id="csrf_name"
                   value="<?= $this->security->get_csrf_token_name(); ?>">
            <input type="hidden" id="csrf_hash"
                   value="<?= $this->security->get_csrf_hash(); ?>">

            <input type="hidden" id="log_id" value="<?= $log->id ?>">

            <!-- VIDEO CAMERA -->
            <video id="video" autoplay playsinline
                   style="width:100%; max-width:360px; border-radius:10px; background:#000;">
            </video>

            <!-- CANVAS (HIDDEN) -->
            <canvas id="canvas" style="display:none;"></canvas>

            <div class="mt-3">
                <button class="btn btn-primary" id="btnCapture">
                    <i class="fas fa-camera"></i> Ambil Foto
                </button>

                <button class="btn btn-success d-none" id="btnSave">
                    <i class="fas fa-save"></i> Simpan Selfie
                </button>
            </div>

            <div class="mt-3">
                <img id="preview" class="img-fluid d-none"
                     style="max-width:360px; border-radius:10px;">
            </div>

        </div>
    </div>

</div>

<script>
let video   = document.getElementById('video');
let canvas  = document.getElementById('canvas');
let preview = document.getElementById('preview');

let btnCapture = document.getElementById('btnCapture');
let btnSave    = document.getElementById('btnSave');

let stream = null;
let blob   = null;

// ==========================
// AKTIFKAN KAMERA
// ==========================
navigator.mediaDevices.getUserMedia({
    video: { facingMode: "user" },
    audio: false
}).then(s => {
    stream = s;
    video.srcObject = stream;
}).catch(err => {
    alert('Kamera tidak bisa diakses!\nIzinkan kamera & gunakan HTTPS / localhost');
});

// ==========================
// AMBIL FOTO
// ==========================
btnCapture.addEventListener('click', function () {
    canvas.width  = video.videoWidth;
    canvas.height = video.videoHeight;

    let ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0);

    canvas.toBlob(function (b) {
        blob = b;
        preview.src = URL.createObjectURL(blob);
        preview.classList.remove('d-none');
        btnSave.classList.remove('d-none');
    }, 'image/jpeg', 0.9);
});

// ==========================
// SIMPAN SELFIE
// ==========================
btnSave.addEventListener('click', function () {

    if (!blob) {
        alert('Foto belum diambil!');
        return;
    }

    let formData = new FormData();
    formData.append('selfie', blob, 'selfie.jpg');
    formData.append('log_id', document.getElementById('log_id').value);

    // CSRF
    formData.append(
        document.getElementById('csrf_name').value,
        document.getElementById('csrf_hash').value
    );

    fetch('<?= site_url("mengajar/simpan_selfie") ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        if (res.status === 'ok') {
            alert('Selfie berhasil disimpan');
            window.location.href = '<?= site_url("guru_dashboard") ?>';
        } else {
            alert(res.message || 'Gagal menyimpan selfie');
        }
    })
    .catch(() => {
        alert('Gagal mengirim data');
    });
});
</script>
