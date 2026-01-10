<div class="container-fluid">

    <h1 class="h4 mb-4 text-gray-800">
        <i class="fas fa-file-csv"></i> Import Bacaan (CSV)
    </h1>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <form action="<?= site_url('AdminBacaan/import_proses'); ?>"
      method="post" enctype="multipart/form-data">

    <!-- CSRF TOKEN (WAJIB) -->
    <input type="hidden"
           name="<?= $this->security->get_csrf_token_name(); ?>"
           value="<?= $this->security->get_csrf_hash(); ?>">

    <div class="form-group">
        <label>File CSV</label>
        <input type="file" name="file_csv"
               class="form-control" accept=".csv" required>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="fas fa-upload"></i> Import
    </button>
</form>


            <hr>

            <small class="text-muted">
                Format CSV: judul, kelas, mapel, drive_link, status
            </small>

        </div>
    </div>

</div>
