<?= form_open_multipart('buku_tamu/edit/'.$row->id) ?>

<div class="row">

    <div class="col-md-6 mb-3">
        <label>Nama Tamu</label>
        <input type="text" name="nama_tamu"
               value="<?= htmlspecialchars($row->nama_tamu) ?>"
               class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Instansi</label>
        <input type="text" name="instansi"
               value="<?= htmlspecialchars($row->instansi) ?>"
               class="form-control">
    </div>
<div class="col-md-6 mb-3">
    <label>Jumlah Orang</label>
    <input type="number"
           name="jumlah_orang"
           class="form-control"
           min="1"
           value="<?= (int) $row->jumlah_orang ?>"
           required>
    <small class="text-muted">
        Termasuk ketua rombongan
    </small>
</div>

    <div class="col-md-6 mb-3">
        <label>No HP</label>
        <input type="text" name="no_hp"
               value="<?= htmlspecialchars($row->no_hp) ?>"
               class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label>Bertemu Dengan</label>
        <input type="text" name="bertemu_dengan"
               value="<?= htmlspecialchars($row->bertemu_dengan) ?>"
               class="form-control">
    </div>

    <div class="col-md-12 mb-3">
        <label>Tujuan</label>
        <input type="text" name="tujuan"
               value="<?= htmlspecialchars($row->tujuan) ?>"
               class="form-control">
    </div>

    <div class="col-md-12 mb-3">
        <label>Keperluan</label>
        <textarea name="keperluan"
                  class="form-control"
                  rows="3"><?= htmlspecialchars($row->keperluan) ?></textarea>
    </div>

    <hr class="col-12">

    <div class="col-md-6 mb-3">
        <label>Foto Selfie</label><br>
        <?php if ($row->foto_selfie): ?>
            <img src="<?= base_url('uploads/buku_tamu/selfie/'.$row->foto_selfie) ?>"
                 class="img-thumbnail mb-2" width="120">
        <?php endif ?>
        <input type="file" name="foto_selfie" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label>Foto Identitas</label><br>
        <?php if ($row->foto_identitas): ?>
            <a href="<?= base_url('uploads/buku_tamu/identitas/'.$row->foto_identitas) ?>"
               target="_blank"
               class="btn btn-sm btn-outline-primary mb-2">
               Lihat Foto
            </a>
        <?php endif ?>
        <input type="file" name="foto_identitas" class="form-control">
    </div>

</div>

<div class="text-right mt-3">
    <button class="btn btn-success">
        <i class="fas fa-save"></i> Update
    </button>
</div>

<?= form_close() ?>
