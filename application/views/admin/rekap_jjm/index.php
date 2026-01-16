<div class="container-fluid">

    <h1 class="h4 mb-3 text-gray-800">
        <i class="fas fa-file-pdf"></i> Rekap JJM Guru
    </h1>

    <!-- Upload ALL -->
    <button class="btn btn-sm btn-success mb-3" data-toggle="modal" data-target="#uploadAll">
        <i class="fas fa-file-archive"></i> Upload Semua (ZIP)
    </button>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Guru</th>
                    <th>Email</th>
                    <th>Status Kepegawaian</th>
                    <th>Status JJM</th>
                    <th width="20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach ($guru as $g): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $g->nama ?></td>
                    <td><?= $g->email ?></td>
                    <td><?= $g->status_kepegawaian ?></td>
                    <td class="text-center">
                        <?php if ($g->file_jjm): ?>
                            <span class="badge badge-success">Ada</span>
                        <?php else: ?>
                            <span class="badge badge-secondary">Belum</span>
                        <?php endif; ?>
                    </td>

                    <!-- AKSI -->
                    <td class="text-center">

                        <!-- Upload / Edit -->
                        <button class="btn btn-sm btn-warning"
                            data-toggle="modal"
                            data-target="#uploadModal<?= $g->id ?>">
                            <i class="fas fa-upload"></i>
                        </button>

                        <!-- Download -->
                        <?php if ($g->file_jjm): ?>
                            <a href="<?= base_url('uploads/jjm/guru/'.$g->file_jjm) ?>"
                               class="btn btn-sm btn-primary"
                               target="_blank">
                                <i class="fas fa-download"></i>
                            </a>

                            <!-- Delete -->
                            <a href="<?= site_url('rekap_jjm/delete/'.$g->id) ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Yakin hapus file JJM guru ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        <?php endif; ?>

                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- MODAL UPLOAD PER GURU -->
<?php foreach ($guru as $g): ?>
<div class="modal fade" id="uploadModal<?= $g->id ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="<?= site_url('rekap_jjm/upload_single') ?>"
                  method="post"
                  enctype="multipart/form-data">
                  <input type="hidden"
           name="<?= $this->security->get_csrf_token_name(); ?>"
           value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Upload JJM - <?= $g->nama ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="guru_id" value="<?= $g->id ?>">

                    <div class="form-group">
                        <label>File JJM (PDF)</label>
                        <input type="file"
                               name="file_jjm"
                               accept=".pdf"
                               required
                               class="form-control">
                    </div>

                    <?php if ($g->file_jjm): ?>
                        <small class="text-muted">
                            File lama: <?= $g->file_jjm ?>
                        </small>
                    <?php endif; ?>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- MODAL UPLOAD ALL -->
<div class="modal fade" id="uploadAll" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="<?= site_url('rekap_jjm/upload_all') ?>"
                  method="post"
                  enctype="multipart/form-data">
                        <input type="hidden"
           name="<?= $this->security->get_csrf_token_name(); ?>"
           value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Rekap JJM (ZIP)</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-info">
                        Nama file PDF harus sesuai <b>ID Guru</b><br>
                        Contoh: <code>5.pdf</code>
                    </div>
                    <input type="file" name="zip_file" accept=".zip" required class="form-control">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
