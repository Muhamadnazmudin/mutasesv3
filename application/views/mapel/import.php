<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">
        <h1 class="h5 text-gray-800">
            <i class="fas fa-file-excel"></i> Import Mata Pelajaran
        </h1>
        <a href="<?= site_url('mapel') ?>" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow">
                <div class="card-body">

                    <form action="<?= site_url('mapel/import_excel') ?>"
                          method="post"
                          enctype="multipart/form-data">

                        <!-- CSRF -->
                        <input type="hidden"
                               name="<?= $this->security->get_csrf_token_name(); ?>"
                               value="<?= $this->security->get_csrf_hash(); ?>">

                        <div class="form-group">
                            <label class="font-weight-bold">
                                File Excel (.xlsx) <span class="text-danger">*</span>
                            </label>
                            <input type="file"
                                   name="file_excel"
                                   class="form-control"
                                   accept=".xlsx"
                                   required>
                            <small class="text-muted">
                                Kolom: id_mapel | nama_mapel | kelompok
                            </small>
                        </div>

                        <hr>

                        <div class="text-right">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-upload"></i> Import
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
