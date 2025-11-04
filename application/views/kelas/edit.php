<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Edit Data Kelas</h4>
  <a href="<?= site_url('kelas') ?>" class="btn btn-secondary btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <form method="post" action="<?= site_url('kelas/edit/'.$kelas->id) ?>">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
             value="<?= $this->security->get_csrf_hash(); ?>">

      <div class="form-group">
        <label for="nama">Nama Kelas</label>
        <input type="text" id="nama" name="nama" class="form-control" 
               value="<?= $kelas->nama ?>" required>
      </div>

      <div class="form-group">
        <label for="wali_kelas_id">Wali Kelas</label>
        <select id="wali_kelas_id" name="wali_kelas_id" class="form-control">
          <option value="">-- Pilih Guru --</option>
          <?php foreach($guru as $g): ?>
            <option value="<?= $g->id ?>" <?= ($g->id == $kelas->wali_kelas_id ? 'selected' : '') ?>>
              <?= $g->nama ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label for="kapasitas">Kapasitas</label>
        <input type="number" id="kapasitas" name="kapasitas" class="form-control" 
               value="<?= $kelas->kapasitas ?>" required>
      </div>

      <div class="text-right">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
