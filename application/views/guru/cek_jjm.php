<div class="container-fluid">

    <h1 class="h4 mb-4 text-gray-800">
        <i class="fas fa-file-pdf"></i> Cek JJM
    </h1>

    <?php if ($jjm): ?>

<div class="card shadow-sm mb-3">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-start flex-wrap">

            <!-- NAMA GURU -->
            <div>
                <p class="mb-1">
                    <strong>Nama Guru:</strong><br>
                    <?= $jjm->nama ?>
                </p>

                <p class="mb-0">
                    <strong>Status JJM:</strong><br>
                    <span class="badge badge-success">Sudah tersedia</span>
                </p>
            </div>

           
            <div class="mt-2 mt-md-0">

                <a href="https://ptk.datadik.kemendikdasmen.go.id/"
                   target="_blank"
                   class="btn btn-sm btn-outline-primary mb-1">
                    <i class="fas fa-external-link-alt"></i> PTK Datadik
                </a>

                <a href="https://info.gtk.kemendikdasmen.go.id/"
                   target="_blank"
                   class="btn btn-sm btn-outline-success mb-1">
                    <i class="fas fa-external-link-alt"></i> Info GTK
                </a>

                <a href="<?= base_url('uploads/linieritas_guru.pdf') ?>"
                   target="_blank"
                   class="btn btn-sm btn-outline-danger mb-1">
                    <i class="fas fa-file-pdf"></i> Cek Linieritas
                </a>

            </div>

        </div>

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
