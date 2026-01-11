<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">
                Import Jadwal Mengajar (Excel)
            </h6>
        </div>
        <div class="card-body">
                <a href="<?= site_url('jadwal_mengajar/download_template') ?>"
   class="btn btn-info btn-sm mb-3">
    <i class="fas fa-download"></i> Download Template
</a>

            <form action="<?= site_url('jadwal_mengajar/import_proses') ?>" 
                  method="post" enctype="multipart/form-data">
                  <input type="hidden"
                               name="<?= $this->security->get_csrf_token_name(); ?>"
                               value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="form-group">
                    <label>File Excel</label>
                    <input type="file" name="file_excel" class="form-control" required>
                </div>

                <button class="btn btn-success btn-sm">
                    <i class="fas fa-upload"></i> Import
                </button>

                <a href="<?= site_url('jadwal_mengajar') ?>" class="btn btn-secondary btn-sm">
                    Kembali
                </a>
            </form>

        </div>
    </div>
</div>
