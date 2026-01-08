<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">
        <h1 class="h5 text-gray-800">
            <i class="fas fa-edit"></i> Edit Jam Sekolah
        </h1>
        <a href="<?= site_url('jam_sekolah') ?>" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow">
                <div class="card-body">

                    <form method="post" action="<?= site_url('jam_sekolah/update') ?>">

                        <!-- CSRF -->
                        <input type="hidden"
                               name="<?= $this->security->get_csrf_token_name(); ?>"
                               value="<?= $this->security->get_csrf_hash(); ?>">

                        <input type="hidden" name="id_jam" value="<?= $jam->id_jam ?>">

                        <div class="form-group">
                            <label>Hari</label>
                            <select name="hari" class="form-control" required>
                                <?php
                                $hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                                foreach ($hari as $h):
                                ?>
                                <option value="<?= $h ?>" <?= $jam->hari==$h?'selected':'' ?>>
                                    <?= $h ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Nama Jam</label>
                            <input type="text" name="nama_jam" class="form-control"
                                   value="<?= $jam->nama_jam ?>" required>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label>Jam Mulai</label>
                                <input type="time" name="jam_mulai"
                                       class="form-control"
                                       value="<?= $jam->jam_mulai ?>" required>
                            </div>
                            <div class="col">
                                <label>Jam Selesai</label>
                                <input type="time" name="jam_selesai"
                                       class="form-control"
                                       value="<?= $jam->jam_selesai ?>" required>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Jenis</label>
                            <select name="jenis" class="form-control">
                                <?php
                                $jenis = ['Mengajar','Istirahat','Masuk','Pulang','Upacara'];
                                foreach ($jenis as $j):
                                ?>
                                <option value="<?= $j ?>" <?= $jam->jenis==$j?'selected':'' ?>>
                                    <?= $j ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Target</label>
                            <select name="target" class="form-control">
                                <?php
                                $target = ['Semua','X','XI','XII'];
                                foreach ($target as $t):
                                ?>
                                <option value="<?= $t ?>" <?= $jam->target==$t?'selected':'' ?>>
                                    <?= $t ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Urutan</label>
                            <input type="number" name="urutan"
                                   class="form-control"
                                   value="<?= $jam->urutan ?>" required>
                        </div>

                        <hr>

                        <div class="text-right">
                            <button class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
