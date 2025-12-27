<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Data Guru</h4>
  <div>
    <a href="<?= base_url('assets/templates/templateimporguru.xlsx') ?>"
   class="btn btn-outline-success btn-sm"
   download>
  <i class="fas fa-download"></i> Template Excel
</a>

    <a href="<?= site_url('guru/export_excel') ?>" class="btn btn-success btn-sm">
      <i class="fas fa-file-excel"></i> Export
    </a>
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importModal">
      <i class="fas fa-upload"></i> Import
    </button>
    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#addModal">
      <i class="fas fa-plus"></i> Tambah
    </button>
  </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i>
    <?= $this->session->flashdata('success'); ?>
    <button type="button" class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
  </div>
<?php endif; ?>

<div class="table-responsive">
<table class="table table-bordered table-striped">
  <thead class="thead-light">
    <tr>
      <th width="50">No</th>
      <th>NIP</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Telepon</th>
      <th width="120">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($guru)): ?>
      <?php $no = $start + 1; foreach ($guru as $g): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($g->nip) ?></td>
          <td><?= htmlspecialchars($g->nama) ?></td>
          <td><?= htmlspecialchars($g->email) ?></td>
          <td><?= htmlspecialchars($g->telp) ?></td>
          <td class="text-center">
            <a href="<?= site_url('guru/edit/'.$g->id) ?>" class="btn btn-warning btn-sm">
              <i class="fas fa-edit"></i>
            </a>
            <a href="<?= site_url('guru/delete/'.$g->id) ?>"
               onclick="return confirm('Hapus data guru ini?')"
               class="btn btn-danger btn-sm">
              <i class="fas fa-trash"></i>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="6" class="text-center text-muted">Data guru belum tersedia</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>
</div>

<?= $pagination ?>

<!-- ================= MODAL TAMBAH ================= -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" action="<?= site_url('guru/add') ?>">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Guru</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

          <input type="hidden"
                 name="<?= $this->security->get_csrf_token_name(); ?>"
                 value="<?= $this->security->get_csrf_hash(); ?>">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>NIP</label>
                <input type="text" name="nip" class="form-control">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Nama <span class="text-danger">*</span></label>
                <input type="text" name="nama" class="form-control" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="telp" class="form-control">
              </div>
            </div>
          </div>

          <!-- Field tambahan penting (sinkron controller) -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                  <option value="">- Pilih -</option>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>NIK</label>
                <input type="text" name="nik" class="form-control">
              </div>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan
          </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Batal
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ================= MODAL IMPORT ================= -->
<div class="modal fade" id="importModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post"
            action="<?= site_url('guru/import_excel') ?>"
            enctype="multipart/form-data">

        <div class="modal-header">
          <h5 class="modal-title">Import Data Guru</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <input type="hidden"
                 name="<?= $this->security->get_csrf_token_name(); ?>"
                 value="<?= $this->security->get_csrf_hash(); ?>">

          <div class="form-group">
            <label>Pilih File Excel (.xls / .xlsx)</label>
            <input type="file"
                   name="file"
                   class="form-control"
                   accept=".xls,.xlsx"
                   required>
            <small class="text-muted">
              Baris pertama harus berisi nama kolom database
            </small>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="fas fa-upload"></i> Import
          </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Batal
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
