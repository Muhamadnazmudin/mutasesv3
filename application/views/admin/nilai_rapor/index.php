<div class="container-fluid">

    <h4 class="mb-4">
        <i class="fas fa-clipboard-check"></i> Input Nilai Rapor
    </h4>

    <!-- Flash Message -->
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('Nilairapor_admin/simpan') ?>">
        <input type="hidden"
           name="<?= $this->security->get_csrf_token_name(); ?>"
           value="<?= $this->security->get_csrf_hash(); ?>">

        <div class="row">
            <!-- Siswa -->
            <div class="col-md-4">
                <div class="form-group">
                    <label>Siswa</label>
                    <select name="siswa_id" class="form-control" required>
                        <option value="">-- Pilih Siswa --</option>
                        <?php foreach ($siswa as $s): ?>
                            <option value="<?= $s->id_siswa ?>">
                                <?= $s->nama_siswa ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <!-- Mapel -->
            <div class="col-md-4">
                <div class="form-group">
                    <label>Mata Pelajaran</label>
                    <select name="mapel_id" class="form-control" required>
                        <option value="">-- Pilih Mapel --</option>
                        <?php foreach ($mapel as $m): ?>
                            <option value="<?= $m->id_mapel ?>">
                                <?= $m->nama_mapel ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <!-- Semester -->
            <div class="col-md-2">
                <div class="form-group">
                    <label>Semester</label>
                    <select name="semester" class="form-control" required>
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                            <option value="<?= $i ?>">Semester <?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <!-- Nilai -->
            <div class="col-md-2">
                <div class="form-group">
                    <label>Nilai</label>
                    <input type="number"
                           name="nilai_angka"
                           class="form-control"
                           min="0"
                           max="100"
                           required>
                </div>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Deskripsi / Catatan</label>
                    <textarea name="deskripsi"
                              class="form-control"
                              rows="3"
                              placeholder="Opsional"></textarea>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Simpan Nilai
        </button>

        <a href="<?= site_url('Nilairapor_admin/rekap') ?>"
           class="btn btn-secondary ml-2">
            <i class="fas fa-list"></i> Daftar Nilai
        </a>

    </form>

</div>
