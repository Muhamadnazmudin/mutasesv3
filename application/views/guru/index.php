<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Data Guru</h4>
  <div>
    <a href="<?= site_url('guru/export_excel') ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Export</a>
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importModal"><i class="fas fa-upload"></i> Import</button>
    <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus"></i> Tambah</button>
  </div>
</div>
<?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i>
    <?= $this->session->flashdata('success'); ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<table class="table table-bordered table-striped table-responsive-sm">
  <thead class="thead-light">
    <tr>
      <th>No</th>
      <th>NIP</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Telepon</th>
      <th width="120">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = $start + 1; foreach ($guru as $g): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $g->nip ?></td>
        <td><?= $g->nama ?></td>
        <td><?= $g->email ?></td>
        <td><?= $g->telp ?></td>
        <td>
          <a href="<?= site_url('guru/edit/'.$g->id) ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
          <a href="<?= site_url('guru/delete/'.$g->id) ?>" onclick="return confirm('Hapus data ini?')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?= $pagination ?>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="<?= site_url('guru/add') ?>">
        <div class="modal-header"><h5>Tambah Guru</h5></div>
        <div class="modal-body">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
          <div class="form-group"><label>NIP</label><input type="text" name="nip" class="form-control"></div>
          <div class="form-group"><label>Nama</label><input type="text" name="nama" class="form-control" required></div>
          <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control"></div>
          <div class="form-group"><label>No. Telepon</label><input type="text" name="telp" class="form-control"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="<?= site_url('guru/import_excel') ?>" enctype="multipart/form-data">
        <div class="modal-header"><h5>Import Data Guru</h5></div>
        <div class="modal-body">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
          <div class="form-group">
            <label>Pilih File Excel</label>
            <input type="file" name="file" accept=".xls,.xlsx" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Import</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
