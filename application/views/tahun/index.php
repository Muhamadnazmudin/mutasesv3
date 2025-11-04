<div class="content-wrapper mt-4 px-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold">Data Tahun Ajaran</h4>
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
      <i class="fas fa-plus"></i> Tambah Tahun
    </button>
  </div>

  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success'); ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
  <?php endif; ?>

  <table class="table table-bordered table-striped">
    <thead class="thead-dark">
      <tr>
        <th width="5%">No</th>
        <th>Tahun Ajaran</th>
        <th width="15%">Status</th>
        <th width="15%">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($tahun_list)): $no=1; foreach($tahun_list as $t): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $t->tahun ?></td>
          <td>
            <?php if($t->aktif): ?>
              <span class="badge badge-success">Aktif</span>
            <?php else: ?>
              <span class="badge badge-secondary">Nonaktif</span>
            <?php endif; ?>
          </td>
          <td>
            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $t->id ?>">
              <i class="fas fa-edit"></i>
            </button>
            <a href="<?= site_url('tahun/delete/'.$t->id) ?>" onclick="return confirm('Hapus data ini?')" class="btn btn-danger btn-sm">
              <i class="fas fa-trash"></i>
            </a>
          </td>
        </tr>

        <!-- Modal Edit -->
        <div class="modal fade" id="editModal<?= $t->id ?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="post" action="<?= site_url('tahun/edit/'.$t->id) ?>">
                <div class="modal-header bg-warning text-white">
                  <h5>Edit Tahun Ajaran</h5>
                </div>
                <div class="modal-body">
                  <!-- CSRF -->
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                         value="<?= $this->security->get_csrf_hash(); ?>">

                  <div class="form-group">
                    <label>Tahun Ajaran</label>
                    <input type="text" name="tahun" value="<?= $t->tahun ?>" class="form-control" required>
                  </div>
                  <div class="form-group form-check">
                    <input type="checkbox" name="aktif" value="1" class="form-check-input" <?= $t->aktif ? 'checked' : '' ?>>
                    <label class="form-check-label">Tandai sebagai tahun aktif</label>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Simpan</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; else: ?>
        <tr><td colspan="4" class="text-center text-muted">Belum ada data tahun ajaran.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="<?= site_url('tahun/add') ?>">
        <div class="modal-header bg-primary text-white">
          <h5>Tambah Tahun Ajaran</h5>
        </div>
        <div class="modal-body">
          <!-- CSRF -->
          <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                 value="<?= $this->security->get_csrf_hash(); ?>">

          <div class="form-group">
            <label>Tahun Ajaran</label>
            <input type="text" name="tahun" class="form-control" placeholder="Contoh: 2025/2026" required>
          </div>
          <div class="form-group form-check">
            <input type="checkbox" name="aktif" value="1" class="form-check-input">
            <label class="form-check-label">Tandai sebagai tahun aktif</label>
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
