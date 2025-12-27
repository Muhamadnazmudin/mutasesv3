<div class="container-fluid">

  <!-- HEADER (SAMA DENGAN DATA GURU) -->
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Riwayat Sertifikasi Guru</h4>
    <div>
      <?php if ($mode === 'admin'): ?>
  <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalTambah">
    <i class="fas fa-plus"></i> Tambah
  </button>
<?php endif; ?>

    </div>
  </div>

  <!-- ALERT -->
  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle"></i>
      <?= $this->session->flashdata('success'); ?>
      <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
      </button>
    </div>
  <?php endif; ?>

  <!-- TABLE -->
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="thead-light">
        <tr>
          <th width="50">No</th>
          <th>Nama Guru</th>
          <th>Bidang Studi</th>
          <th>Jenis Sertifikasi</th>
          <th>Lembaga</th>
          <th>Masa Berlaku</th>
          <th>No Sertifikat</th>
          <th>Kualifikasi</th>
          <th width="120">Aksi</th>
        </tr>
      </thead>
      <tbody>

      <?php if (!empty($sertifikasi)): ?>
        <?php $no = 1; foreach ($sertifikasi as $s): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($s->nama_guru) ?></td>
            <td><?= htmlspecialchars($s->bidang_studi) ?></td>
            <td><?= htmlspecialchars($s->jenis_sertifikasi) ?></td>
            <td><?= htmlspecialchars($s->kode_lembaga_sertifikasi) ?></td>
            <td>
              <?= date('d-m-Y', strtotime($s->tgl_mulai_berlaku)); ?>
              <br>
              <!-- <small class="text-muted">
                s/d <?= date('d-m-Y', strtotime($s->tgl_habis_berlaku)); ?>
              </small> -->
            </td>
            <td><?= htmlspecialchars($s->nomor_sertifikat) ?></td>
            <td><?= $s->kualifikasi ?: '-' ?></td>
            <td class="text-center">
              <button class="btn btn-warning btn-sm"
                      data-toggle="modal"
                      data-target="#edit<?= $s->id ?>">
                <i class="fas fa-edit"></i>
              </button>
              <a href="<?= site_url('guru_sertifikasi/delete/'.$s->id) ?>"
                 onclick="return confirm('Hapus data sertifikasi ini?')"
                 class="btn btn-danger btn-sm">
                <i class="fas fa-trash"></i>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="9" class="text-center text-muted">
            Data sertifikasi belum tersedia
          </td>
        </tr>
      <?php endif; ?>

      </tbody>
    </table>
  </div>

</div>
<?php foreach ($sertifikasi as $s): ?>
<div class="modal fade" id="edit<?= $s->id ?>" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form method="post"
            action="<?= site_url(
              ($mode === 'admin')
              ? 'guru_sertifikasi/update/'.$s->id
              : 'guru_sertifikasi_guru/update/'.$s->id
            ) ?>">

        <!-- CSRF -->
        <input type="hidden"
               name="<?= $this->security->get_csrf_token_name(); ?>"
               value="<?= $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
          <h5 class="modal-title">Edit Sertifikasi Guru</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

          <?php if ($mode === 'admin'): ?>
          <div class="form-group">
            <label>Nama Guru</label>
            <select name="guru_id" class="form-control" required>
              <?php foreach ($guru as $g): ?>
                <option value="<?= $g->id ?>"
                  <?= $g->id == $s->guru_id ? 'selected' : '' ?>>
                  <?= $g->nama ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <?php endif; ?>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Bidang Studi</label>
                <input name="bidang_studi"
                       class="form-control"
                       value="<?= $s->bidang_studi ?>"
                       required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Jenis Sertifikasi</label>
                <input name="jenis_sertifikasi"
                       class="form-control"
                       value="<?= $s->jenis_sertifikasi ?>"
                       required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Lembaga Sertifikasi</label>
                <input name="kode_lembaga_sertifikasi"
                       class="form-control"
                       value="<?= $s->kode_lembaga_sertifikasi ?>"
                       required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Tgl Mulai</label>
                <input type="date"
                       name="tgl_mulai_berlaku"
                       class="form-control"
                       value="<?= $s->tgl_mulai_berlaku ?>"
                       required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Tgl Habis</label>
                <input type="date"
                       name="tgl_habis_berlaku"
                       class="form-control"
                       value="<?= $s->tgl_habis_berlaku ?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>No Sertifikat</label>
                <input name="nomor_sertifikat"
                       class="form-control"
                       value="<?= $s->nomor_sertifikat ?>"
                       required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Kualifikasi</label>
                <input name="kualifikasi"
                       class="form-control"
                       value="<?= $s->kualifikasi ?>">
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa-save"></i> Simpan Perubahan
          </button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
            Batal
          </button>
        </div>

      </form>

    </div>
  </div>
</div>
<?php endforeach; ?>

<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form method="post" action="<?= site_url('guru_sertifikasi/store') ?>">
        <input type="hidden"
       name="<?= $this->security->get_csrf_token_name(); ?>"
       value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Sertifikasi Guru</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

          <div class="form-group">
            <label>Nama Guru</label>
            <select name="guru_id" class="form-control" required>
              <option value="">- Pilih Guru -</option>
              <?php foreach ($guru as $g): ?>
                <option value="<?= $g->id ?>"><?= $g->nama ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Bidang Studi</label>
                <input type="text" name="bidang_studi" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Jenis Sertifikasi</label>
                <input type="text" name="jenis_sertifikasi" class="form-control" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Lembaga Sertifikasi</label>
                <input type="text" name="kode_lembaga_sertifikasi" class="form-control" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Tgl Mulai</label>
                <input type="date" name="tgl_mulai_berlaku" class="form-control" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Tgl Habis</label>
                <input type="date" name="tgl_habis_berlaku" class="form-control">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>No Sertifikat</label>
                <input type="text" name="nomor_sertifikat" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Kualifikasi</label>
                <input type="text" name="kualifikasi" class="form-control">
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa-save"></i> Simpan
          </button>
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
            Batal
          </button>
        </div>

      </form>
    </div>
  </div>
</div>
