<div class="card">
    <div class="card-header bg-primary text-white">
        <h4><i class="fa fa-calendar"></i> Hari Libur Nasional & Sekolah</h4>
    </div>

    <div class="card-body">

        <!-- Notifikasi -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambah">
            <i class="fa fa-plus"></i> Tambah Hari Libur
        </button>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Tanggal</th>
                        <th>Nama Hari Libur</th>
                        <th>Jam Libur</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($libur)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada data hari libur
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php $no=1; foreach($libur as $l): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= date('d-m-Y', strtotime($l->start)) ?></td>
                        <td><?= $l->nama ?></td>
                        <td>
                            <?= $l->jam_mulai
                                ? substr($l->jam_mulai, 0, 5)
                                : '<span class="text-muted">Sehari penuh</span>' ?>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                data-toggle="modal"
                                data-target="#modalEdit<?= $l->id ?>">
                                <i class="fa fa-edit"></i>
                            </button>

                            <a href="<?= site_url('HariLibur/hapus/'.$l->id) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus hari libur ini?')">
                               <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- ========================= -->
<!-- MODAL TAMBAH HARI LIBUR -->
<!-- ========================= -->
<div class="modal fade" id="modalTambah">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?= site_url('HariLibur/tambah') ?>" method="post">

        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Tambah Hari Libur</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

            <!-- CSRF -->
            <input type="hidden"
                name="<?= $this->security->get_csrf_token_name(); ?>"
                value="<?= $this->security->get_csrf_hash(); ?>">

            <div class="form-group">
                <label>Nama Hari Libur</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="start" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Libur Mulai Jam <small class="text-muted">(opsional)</small></label>
                <input type="time" name="jam_mulai" class="form-control">
                <small class="text-muted">Kosongkan jika libur sehari penuh</small>
            </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- ========================= -->
<!-- MODAL EDIT HARI LIBUR -->
<!-- ========================= -->
<?php foreach($libur as $l): ?>
<div class="modal fade" id="modalEdit<?= $l->id ?>">
  <div class="modal-dialog">
    <div class="modal-content">

      <form action="<?= site_url('HariLibur/update/'.$l->id) ?>" method="post">

        <div class="modal-header bg-warning">
          <h5 class="modal-title">Edit Hari Libur</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

            <!-- CSRF -->
            <input type="hidden"
                name="<?= $this->security->get_csrf_token_name(); ?>"
                value="<?= $this->security->get_csrf_hash(); ?>">

            <div class="form-group">
                <label>Nama Hari Libur</label>
                <input type="text" name="nama" class="form-control"
                       value="<?= $l->nama ?>" required>
            </div>

            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="start" class="form-control"
                       value="<?= $l->start ?>" required>
            </div>

            <div class="form-group">
                <label>Libur Mulai Jam</label>
                <input type="time" name="jam_mulai" class="form-control"
                       value="<?= $l->jam_mulai ?>">
                <small class="text-muted">Kosongkan jika libur sehari penuh</small>
            </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>

      </form>

    </div>
  </div>
</div>
<?php endforeach; ?>
