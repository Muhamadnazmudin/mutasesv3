<style>

.akun-item label {
    font-size: 0.9rem;
}

.akun-field {
    display: flex;
    gap: 8px;
}

.akun-field input {
    flex: 1;
    font-size: 0.95rem;
}

.btn-copy {
    white-space: nowrap;
    padding: 8px 14px;
    font-size: 0.85rem;
    border-radius: 8px;
}

/* ===== MOBILE MODE ===== */
@media (max-width: 576px) {

    .akun-field {
        flex-direction: column;
    }

    .btn-copy {
        width: 100%;
        font-size: 0.9rem;
        padding: 10px;
    }

    .akun-field input {
        font-size: 0.95rem;
    }
}
</style>

<div class="container-fluid">

<h4 class="mb-4">
    <i class="fas fa-envelope-open-text"></i> Akun BelajarID
</h4>

<?php if (!$akun): ?>

<div class="alert alert-warning">
    Akun BelajarID Anda belum didaftarkan oleh sekolah.
</div>

<?php else: ?>

<div class="card shadow-sm">
<div class="card-body">

<!-- EMAIL -->
<div class="akun-item mb-3">
    <label class="font-weight-bold mb-1">Email BelajarID</label>

    <div class="akun-field">
        <input type="text"
               id="emailBelajar"
               class="form-control"
               value="<?= $akun->email_belajar ?>"
               readonly>

        <button class="btn btn-primary btn-copy"
                onclick="copyText('emailBelajar')">
            <i class="fas fa-copy"></i>
            <span>Salin</span>
        </button>
    </div>
</div>

<!-- PASSWORD -->
<div class="akun-item mb-3">
    <label class="font-weight-bold mb-1">Password Default</label>

    <div class="akun-field">
        <input type="text"
               id="passwordBelajar"
               class="form-control"
               value="<?= $akun->password_default ?>"
               readonly>

        <button class="btn btn-primary btn-copy"
                onclick="copyText('passwordBelajar')">
            <i class="fas fa-copy"></i>
            <span>Salin</span>
        </button>
    </div>
</div>

<!-- STATUS -->
<div class="mb-3">
    <span class="badge badge-success px-3 py-2">Tersimpan</span>
</div>

<div class="alert alert-info mb-0">
    <strong>Catatan:</strong><br>
    Password ini hanya digunakan saat login pertama.<br>
    Silakan ganti password setelah berhasil login.
</div>

</div>
</div>

<?php endif; ?>

</div>
<script>
function copyText(elementId) {
    const input = document.getElementById(elementId);
    input.select();
    input.setSelectionRange(0, 99999);

    navigator.clipboard.writeText(input.value)
        .then(() => showToast('Berhasil disalin'))
        .catch(() => alert('Gagal menyalin'));
}

function showToast(message) {
    let toast = document.createElement('div');
    toast.innerText = message;

    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.left = '50%';
    toast.style.transform = 'translateX(-50%)';
    toast.style.background = '#4caf50';
    toast.style.color = '#fff';
    toast.style.padding = '10px 18px';
    toast.style.borderRadius = '20px';
    toast.style.fontSize = '14px';
    toast.style.zIndex = '9999';

    document.body.appendChild(toast);

    setTimeout(() => toast.remove(), 2000);
}
</script>
