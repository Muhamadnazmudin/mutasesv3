<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Edit Guru</h4>
  <a href="<?= site_url('guru') ?>" class="btn btn-secondary btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <form method="post" action="<?= site_url('guru/edit/'.$guru->id) ?>">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
             value="<?= $this->security->get_csrf_hash(); ?>">

      <div class="form-group">
        <label for="nip">NIP</label>
        <input type="text" id="nip" name="nip" value="<?= $guru->nip ?>" class="form-control">
      </div>

      <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" value="<?= $guru->nama ?>" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= $guru->email ?>" class="form-control">
      </div>

      <div class="form-group">
        <label for="telp">No. Telepon</label>
        <input type="text" id="telp" name="telp" value="<?= $guru->telp ?>" class="form-control">
      </div>

      <div class="text-right">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
