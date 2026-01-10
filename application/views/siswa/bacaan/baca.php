<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h5 text-gray-800 mb-0">
            <i class="fas fa-book-open"></i>
            <?= htmlspecialchars($buku->judul); ?>
        </h1>

        <a href="<?= site_url('SiswaBacaan'); ?>"
           class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">

            <iframe
                src="https://drive.google.com/file/d/<?= $buku->drive_file_id; ?>/preview"
                width="100%"
                height="650"
                style="border:none;">
            </iframe>

        </div>
    </div>

</div>
