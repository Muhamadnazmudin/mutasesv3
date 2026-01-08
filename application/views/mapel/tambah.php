<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">
        <h1 class="h5 text-gray-800">
            <i class="fas fa-book"></i> Tambah Mata Pelajaran
        </h1>
        <a href="<?= site_url('mapel') ?>" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow">
                <div class="card-body">

                    <form method="post" action="<?= site_url('mapel/store') ?>">

                        <!-- CSRF -->
                        <input type="hidden"
                               name="<?= $this->security->get_csrf_token_name(); ?>"
                               value="<?= $this->security->get_csrf_hash(); ?>">

                        <!-- ID MAPEL -->
                        <div class="form-group">
                            <label class="font-weight-bold">
                                ID Mapel <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   name="id_mapel"
                                   class="form-control"
                                   required
                                   placeholder="Contoh: 401230000">
                            <small class="text-muted">
                                Diisi manual, harus unik
                            </small>
                        </div>

                        <!-- NAMA MAPEL -->
                        <div class="form-group">
                            <label class="font-weight-bold">
                                Nama Mata Pelajaran <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="nama_mapel"
                                   class="form-control"
                                   required
                                   placeholder="Contoh: Matematika">
                        </div>

                        <!-- KELOMPOK -->
                        <div class="form-group">
                            <label class="font-weight-bold">Kelompok</label>
                            <select name="kelompok" class="form-control">
                                <option value="">-- Opsional --</option>
                                <option value="Umum">Umum</option>
                                <option value="Peminatan">Peminatan</option>
                                <option value="Muatan Lokal">Muatan Lokal</option>
                                <option value="Produktif">Produktif</option>
                            </select>
                        </div>

                        <hr>

                        <div class="text-right">
                            <button type="reset" class="btn btn-light">Reset</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
