<div class="container-fluid">

    <h1 class="h4 mb-4 text-gray-800">
        <i class="fas fa-file-pdf"></i> Cek JJM
    </h1>

    <?php if ($jjm): ?>

        <div class="card shadow-sm mb-3">
            <div class="card-body">

                <p>
                    <strong>Nama Guru:</strong><br>
                    <?= $jjm->nama ?>
                </p>

                <p>
                    <strong>Status JJM:</strong><br>
                    <span class="badge badge-success">Sudah tersedia</span>
                </p>

            </div>
        </div>

        <!-- PREVIEW PDF -->
        <div class="card shadow-sm mb-3">
            <div class="card-header font-weight-bold">
                <i class="fas fa-eye"></i> Preview JJM
            </div>
            <div class="card-body p-0">

                <iframe
                    src="<?= base_url('uploads/jjm/guru/'.$jjm->file_jjm) ?>"
                    width="100%"
                    height="600px"
                    style="border:none;">
                </iframe>

            </div>
        </div>

        <!-- DOWNLOAD -->
        <div class="text-right">
            <a href="<?= base_url('uploads/jjm/guru/'.$jjm->file_jjm) ?>"
               class="btn btn-primary"
               download>
                <i class="fas fa-download"></i> Unduh JJM
            </a>
        </div>

    <?php else: ?>

        <div class="alert alert-warning">
            <i class="fas fa-info-circle"></i>
            File JJM belum tersedia. Silakan hubungi admin.
        </div>

    <?php endif; ?>

</div>
