<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Manajemen User</h4>
  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
    <i class="fas fa-plus"></i> Tambah User
  </button>
</div>

<?php if ($this->session->flashdata('error')): ?>
  <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php elseif ($this->session->flashdata('success')): ?>
  <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>

<table class="table table-bordered table-striped table-sm">
  <thead class="thead-light">
    <tr>
      <th width="5%">No</th>
      <th>Username</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Role</th>
      <th width="20%">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $no=1; foreach($users as $u): ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= $u->username ?></td>
      <td><?= $u->nama ?></td>
      <td><?= $u->email ?></td>
      <td><?= ucfirst($u->role_name) ?></td>
      <td class="text-center">
        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $u->id ?>">
          <i class="fas fa-edit"></i> Edit
        </button>
        <a href="<?= site_url('users/delete/'.$u->id) ?>" onclick="return confirm('Yakin hapus user ini?')" class="btn btn-danger btn-sm">
          <i class="fas fa-trash"></i> Hapus
        </a>
      </td>
    </tr>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal<?= $u->id ?>">
      <div class="modal-dialog">
        <div class="modal-content">
          <form method="post" action="<?= site_url('users/edit/'.$u->id) ?>">
            <div class="modal-header bg-warning">
              <h5 class="modal-title">Edit User</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                     value="<?= $this->security->get_csrf_hash(); ?>">

              <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?= $u->nama ?>" required>
              </div>

              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= $u->email ?>">
              </div>

              <div class="form-group">
                <label>Role</label>
                <select name="role_id" class="form-control" required>
                  <?php foreach($roles as $r): ?>
                    <option value="<?= $r->id ?>" <?= $r->id == $u->role_id ? 'selected' : '' ?>><?= ucfirst($r->name) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label>Password (opsional)</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-warning">Simpan</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="<?= site_url('users/add') ?>">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Tambah User</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                 value="<?= $this->security->get_csrf_hash(); ?>">

          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
          </div>

          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Role</label>
            <select name="role_id" class="form-control" required>
              <option value="">-- Pilih Role --</option>
              <?php foreach($roles as $r): ?>
                <option value="<?= $r->id ?>"><?= ucfirst($r->name) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>
