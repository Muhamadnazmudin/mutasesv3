<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">
        <h1 class="h5 text-gray-800">
            <i class="fas fa-clock"></i> Tambah Jam Sekolah
        </h1>
        <a href="<?= site_url('jam_sekolah') ?>" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow">
                <div class="card-body">

                    <form method="post" action="<?= site_url('jam_sekolah/store') ?>">

                        <!-- CSRF -->
                        <input type="hidden"
                               name="<?= $this->security->get_csrf_token_name(); ?>"
                               value="<?= $this->security->get_csrf_hash(); ?>">

                        <div class="form-group">
                                <label>Hari</label>
                                <select name="hari" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="ALL">Semua Hari</option>
                                    <option>Senin</option>
                                    <option>Selasa</option>
                                    <option>Rabu</option>
                                    <option>Kamis</option>
                                    <option>Jumat</option>
                                    <option>Sabtu</option>
                                </select>
                            </div>

                        <div class="form-group">
                            <label>Nama Jam</label>
                            <input type="text" name="nama_jam" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label>Jam Mulai</label>
                                <input type="time" name="jam_mulai" class="form-control" required>
                            </div>
                            <div class="col">
                                <label>Jam Selesai</label>
                                <input type="time" name="jam_selesai" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Jenis</label>
                            <select name="jenis" class="form-control">
                                <option>Mengajar</option>
                                <option>Istirahat</option>
                                <option>Masuk</option>
                                <option>Pulang</option>
                                <option>Upacara</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Target</label>
                            <select name="target" class="form-control">
                                <option value="Semua">Semua</option>
                                <option>X</option>
                                <option>XI</option>
                                <option>XII</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Urutan</label>
                            <input type="number" name="urutan" class="form-control" required>
                        </div>

                        <hr>

                        <div class="text-right">
                            <button class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
