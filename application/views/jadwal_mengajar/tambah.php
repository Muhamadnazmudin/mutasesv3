<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">
        <h1 class="h5 text-gray-800">
            <i class="fas fa-calendar-plus"></i> Tambah Jadwal Mengajar
        </h1>
        <a href="<?= site_url('jadwal_mengajar') ?>" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow">
                <div class="card-body">
                    <?php if ($this->session->flashdata('error')): ?>
<div class="alert alert-danger alert-dismissible fade show">
    <i class="fas fa-exclamation-circle"></i>
    <?= $this->session->flashdata('error'); ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php endif; ?>


                    <form method="post" action="<?= site_url('jadwal_mengajar/store') ?>">

                        <input type="hidden"
                               name="<?= $this->security->get_csrf_token_name(); ?>"
                               value="<?= $this->security->get_csrf_hash(); ?>">

                        <div class="form-group">
                            <label>Guru</label>
                            <select name="guru_id" class="form-control" required>
    <option value="">-- Pilih Guru --</option>
    <?php foreach ($guru as $g): ?>
        <option value="<?= $g->id ?>">
            <?= $g->nama ?>
        </option>
    <?php endforeach; ?>
</select>

                        </div>

                        <div class="form-group">
                            <label>Hari</label>
                            <select name="hari" class="form-control" required>
                                <option>Senin</option>
                                <option>Selasa</option>
                                <option>Rabu</option>
                                <option>Kamis</option>
                                <option>Jumat</option>
                                <option>Sabtu</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Jam ke-</label>
                            <select name="jam_id" class="form-control" required>
                                <option value="">-- Pilih Jam --</option>
                                <?php foreach ($jam as $j): ?>
                                    <option value="<?= $j->id_jam ?>">
                                        <?= $j->nama_jam ?> (<?= $j->jam_mulai ?>–<?= $j->jam_selesai ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Kelas / Rombel</label>
                            <select name="rombel_id" class="form-control" required>
    <option value="">-- Pilih Kelas --</option>
    <?php foreach ($kelas as $k): ?>
        <option value="<?= $k->id ?>">
            <?= $k->nama ?>
        </option>
    <?php endforeach; ?>
</select>

                        </div>

                        <div class="form-group">
                            <label>Mapel</label>
                            <select name="mapel_id" class="form-control" required>
                                <?php foreach ($mapel as $m): ?>
                                    <option value="<?= $m->id_mapel ?>"><?= $m->nama_mapel ?></option>
                                <?php endforeach; ?>
                            </select>
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
