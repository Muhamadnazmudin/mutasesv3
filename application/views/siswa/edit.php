<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Edit Data Siswa</h4>
  <a href="<?= site_url('siswa') ?>" class="btn btn-secondary btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <form method="post" action="<?= site_url('siswa/edit/'.$siswa->id) ?>">
      <!-- CSRF -->
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
             value="<?= $this->security->get_csrf_hash(); ?>">

      <div class="form-row">
        <div class="form-group col-md-4">
          <label>NIS</label>
          <input type="text" name="nis" value="<?= $siswa->nis ?>" class="form-control" required>
        </div>
        <div class="form-group col-md-4">
          <label>NISN</label>
          <input type="text" name="nisn" value="<?= $siswa->nisn ?>" class="form-control" required>
        </div>
        <div class="form-group col-md-4">
          <label>Nama</label>
          <input type="text" name="nama" value="<?= $siswa->nama ?>" class="form-control" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Tempat Lahir</label>
          <input type="text" name="tempat_lahir" value="<?= $siswa->tempat_lahir ?>" class="form-control">
        </div>

        <div class="form-group col-md-6">
          <label>Tanggal Lahir</label>
          <input type="date" name="tgl_lahir" value="<?= $siswa->tgl_lahir ?>" class="form-control">
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label>Jenis Kelamin</label>
          <select name="jk" class="form-control">
            <option value="L" <?= $siswa->jk == 'L' ? 'selected' : '' ?>>Laki-laki</option>
            <option value="P" <?= $siswa->jk == 'P' ? 'selected' : '' ?>>Perempuan</option>
          </select>
        </div>

        <div class="form-group col-md-6">
          <label>Agama</label>
          <select name="agama" class="form-control">
            <?php
              $agama_list = ['Islam','Kristen','Katolik','Hindu','Budha','Konghucu'];
              foreach($agama_list as $a):
            ?>
              <option value="<?= $a ?>" <?= $a == $siswa->agama ? 'selected' : '' ?>><?= $a ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control" rows="2"><?= $siswa->alamat ?></textarea>
      </div>

      <div class="form-row">
        <div class="form-group col-md-4">
          <label>Kelas</label>
          <select name="id_kelas" class="form-control">
            <option value="">-- Pilih Kelas --</option>
            <?php foreach($kelas as $k): ?>
              <option value="<?= $k->id ?>" <?= ($k->id == $siswa->id_kelas ? 'selected' : '') ?>>
                <?= $k->nama ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group col-md-4">
          <label>Tahun Ajaran</label>
          <select name="tahun_id" class="form-control">
            <?php foreach($tahun as $t): ?>
              <option value="<?= $t->id ?>" <?= ($t->id == $siswa->tahun_id ? 'selected' : '') ?>>
                <?= $t->tahun ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group col-md-4">
          <label>Status</label>
          <select name="status" class="form-control">
            <?php 
              $status_list = [
                'aktif' => 'Aktif',
                'mutasi_keluar' => 'Mutasi Keluar',
                'mutasi_masuk' => 'Mutasi Masuk',
                'lulus' => 'Lulus',
                'keluar' => 'Keluar'
              ];
              foreach($status_list as $val => $label): 
            ?>
              <option value="<?= $val ?>" <?= ($val == $siswa->status ? 'selected' : '') ?>>
                <?= $label ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="text-right">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
