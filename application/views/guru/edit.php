<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Edit Guru</h4>
  <a href="<?= site_url('guru') ?>" class="btn btn-secondary btn-sm">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <form method="post" action="<?= site_url('guru/edit/'.$guru->id) ?>">

      <input type="hidden"
             name="<?= $this->security->get_csrf_token_name(); ?>"
             value="<?= $this->security->get_csrf_hash(); ?>">

      <!-- ================= BIODATA ================= -->
      <h6 class="text-primary border-bottom pb-2 mb-3">Biodata</h6>

      <div class="row">
        <div class="col-md-6 form-group">
          <label>NIP</label>
          <input type="text" name="nip" class="form-control" value="<?= $guru->nip ?>">
        </div>

        <div class="col-md-6 form-group">
          <label>Nama <span class="text-danger">*</span></label>
          <input type="text" name="nama" class="form-control" value="<?= $guru->nama ?>" required>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 form-group">
          <label>Jenis Kelamin</label>
          <select name="jenis_kelamin" class="form-control">
            <option value="">- Pilih -</option>
            <option value="L" <?= $guru->jenis_kelamin=='L'?'selected':'' ?>>Laki-laki</option>
            <option value="P" <?= $guru->jenis_kelamin=='P'?'selected':'' ?>>Perempuan</option>
          </select>
        </div>

        <div class="col-md-6 form-group">
          <label>Tempat Lahir</label>
          <input type="text" name="tempat_lahir" class="form-control" value="<?= $guru->tempat_lahir ?>">
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 form-group">
          <label>Tanggal Lahir</label>
          <input type="date" name="tanggal_lahir" class="form-control" value="<?= $guru->tanggal_lahir ?>">
        </div>

        <div class="col-md-6 form-group">
          <label>Nama Ibu Kandung</label>
          <input type="text" name="nama_ibu_kandung" class="form-control" value="<?= $guru->nama_ibu_kandung ?>">
        </div>
      </div>

      <!-- ================= KONTAK ================= -->
      <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">Kontak</h6>

      <div class="row">
        <div class="col-md-6 form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control" value="<?= $guru->email ?>">
        </div>

        <div class="col-md-6 form-group">
          <label>No. Telepon</label>
          <input type="text" name="telp" class="form-control" value="<?= $guru->telp ?>">
        </div>
      </div>

      <!-- ================= ALAMAT ================= -->
      <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">Alamat</h6>

      <div class="form-group">
        <label>Alamat Jalan</label>
        <textarea name="alamat_jalan" class="form-control"><?= $guru->alamat_jalan ?></textarea>
      </div>

      <div class="row">
        <div class="col-md-2 form-group">
          <label>RT</label>
          <input type="text" name="rt" class="form-control" value="<?= $guru->rt ?>">
        </div>

        <div class="col-md-2 form-group">
          <label>RW</label>
          <input type="text" name="rw" class="form-control" value="<?= $guru->rw ?>">
        </div>

        <div class="col-md-4 form-group">
          <label>Dusun</label>
          <input type="text" name="dusun" class="form-control" value="<?= $guru->dusun ?>">
        </div>

        <div class="col-md-4 form-group">
          <label>Desa / Kelurahan</label>
          <input type="text" name="desa_kelurahan" class="form-control" value="<?= $guru->desa_kelurahan ?>">
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 form-group">
          <label>Kecamatan</label>
          <input type="text" name="kecamatan" class="form-control" value="<?= $guru->kecamatan ?>">
        </div>

        <div class="col-md-4 form-group">
          <label>Kode Pos</label>
          <input type="text" name="kode_pos" class="form-control" value="<?= $guru->kode_pos ?>">
        </div>
      </div>

      <!-- ================= IDENTITAS ================= -->
      <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">Identitas</h6>

      <div class="row">
        <div class="col-md-4 form-group">
          <label>NIK</label>
          <input type="text" name="nik" class="form-control" value="<?= $guru->nik ?>">
        </div>

        <div class="col-md-4 form-group">
          <label>No KK</label>
          <input type="text" name="no_kk" class="form-control" value="<?= $guru->no_kk ?>">
        </div>

        <div class="col-md-4 form-group">
          <label>Agama</label>
          <input type="text" name="agama" class="form-control" value="<?= $guru->agama ?>">
        </div>
      </div>

      <!-- ================= PERKAWINAN ================= -->
      <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">Perkawinan</h6>

      <div class="row">
        <div class="col-md-4 form-group">
          <label>Status Perkawinan</label>
          <select name="status_perkawinan" class="form-control">
            <option value="">- Pilih -</option>
            <?php
              $status = ['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'];
              foreach ($status as $s):
            ?>
              <option value="<?= $s ?>" <?= $guru->status_perkawinan==$s?'selected':'' ?>>
                <?= $s ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-4 form-group">
          <label>Nama Suami / Istri</label>
          <input type="text" name="nama_pasangan" class="form-control" value="<?= $guru->nama_pasangan ?>">
        </div>

        <div class="col-md-4 form-group">
          <label>Pekerjaan Suami / Istri</label>
          <input type="text" name="pekerjaan_pasangan" class="form-control" value="<?= $guru->pekerjaan_pasangan ?>">
        </div>
      </div>

      <!-- ================= KEPEGAWAIAN ================= -->
      <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">Kepegawaian</h6>

      <div class="row">
        <div class="col-md-4 form-group">
          <label>Status Kepegawaian</label>
          <input type="text" name="status_kepegawaian" class="form-control" value="<?= $guru->status_kepegawaian ?>">
        </div>

        <div class="col-md-4 form-group">
          <label>NUPTK</label>
          <input type="text" name="nuptk" class="form-control" value="<?= $guru->nuptk ?>">
        </div>

        <div class="col-md-4 form-group">
          <label>NRG</label>
          <input type="text" name="nrg" class="form-control" value="<?= $guru->nrg ?>">
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 form-group">
          <label>SK Pengangkatan</label>
          <input type="text" name="sk_pengangkatan" class="form-control" value="<?= $guru->sk_pengangkatan ?>">
        </div>

        <div class="col-md-4 form-group">
          <label>TMT Pengangkatan</label>
          <input type="date" name="tmt_pengangkatan" class="form-control" value="<?= $guru->tmt_pengangkatan ?>">
        </div>

        <div class="col-md-4 form-group">
          <label>Lembaga Pengangkat</label>
          <input type="text" name="lembaga_pengangkat" class="form-control" value="<?= $guru->lembaga_pengangkat ?>">
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 form-group">
          <label>Pangkat / Golongan</label>
          <input type="text" name="pangkat_golongan" class="form-control" value="<?= $guru->pangkat_golongan ?>">
        </div>

        <div class="col-md-4 form-group">
          <label>Sumber Gaji</label>
          <input type="text" name="sumber_gaji" class="form-control" value="<?= $guru->sumber_gaji ?>">
        </div>
      </div>

      <!-- ================= FOOTER ================= -->
      <div class="text-right mt-4">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Simpan Perubahan
        </button>
      </div>

    </form>
  </div>
</div>
