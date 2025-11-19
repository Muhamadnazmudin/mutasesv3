<div class="container mt-4">

<h3>Edit Data Izin</h3>
<hr>

<form method="POST" action="<?= base_url('index.php/izin/update') ?>">

    <input type="hidden" 
           name="<?= $this->security->get_csrf_token_name(); ?>" 
           value="<?= $this->security->get_csrf_hash(); ?>">

    <input type="hidden" name="id" value="<?= $izin->id ?>">


    <div class="mb-3">
        <label>Nama Siswa</label>
        <input class="form-control" value="<?= $izin->nama ?>" readonly>
    </div>

    <div class="mb-3">
        <label>Kelas</label>
        <input class="form-control" value="<?= $izin->kelas_nama ?>" readonly>
    </div>

    <div class="mb-3">
        <label>Keperluan</label>
        <input class="form-control" value="<?= $izin->keperluan ?>" readonly>
    </div>

    <div class="mb-3">
        <label>Jam Keluar</label>
        <input class="form-control" value="<?= $izin->jam_keluar ?>" readonly>
    </div>

    <!-- Field yang bisa diedit -->
    <div class="mb-3">
        <label>Jam Masuk (Kembali)</label>
        <input type="datetime-local" name="jam_masuk"
               class="form-control"
               value="<?= $izin->jam_masuk ? date('Y-m-d\TH:i', strtotime($izin->jam_masuk)) : '' ?>">
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="keluar"   <?= $izin->status == 'keluar' ? 'selected' : '' ?>>Belum Kembali</option>
            <option value="kembali"  <?= $izin->status == 'kembali' ? 'selected' : '' ?>>Sudah Kembali</option>
            <option value="pulang"   <?= $izin->status == 'pulang' ? 'selected' : '' ?>>Pulang</option>
        </select>
    </div>

    <button class="btn btn-success">Simpan Perubahan</button>
    <a href="<?= base_url('index.php/izin') ?>" class="btn btn-secondary">Kembali</a>

</form>

</div>
