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

                        <div class="row">
    <div class="col">
        <div class="form-group">
            <label>Jam Ke Awal</label>
            <select name="jam_mulai_id" id="jamMulai" class="form-control" required>
                <option value="">-- Pilih Jam Awal --</option>
            </select>
        </div>
    </div>

    <div class="col">
        <div class="form-group">
            <label>Jam Ke Akhir</label>
            <select name="jam_selesai_id" id="jamSelesai" class="form-control" required>
                <option value="">-- Pilih Jam Akhir --</option>
            </select>
        </div>
    </div>
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
<script>
const hariSelect = document.querySelector('select[name="hari"]');
const jamMulai   = document.getElementById('jamMulai');
const jamSelesai = document.getElementById('jamSelesai');

let jamData = [];

hariSelect.addEventListener('change', function () {

    const hari = this.value;

    jamMulai.innerHTML   = '<option value="">-- Pilih Jam Awal --</option>';
    jamSelesai.innerHTML = '<option value="">-- Pilih Jam Akhir --</option>';

    if (!hari) return;

    fetch(`<?= site_url('jadwal_mengajar/get_jam_by_hari') ?>?hari=${hari}`)
        .then(res => res.json())
        .then(data => {

            jamData = data;

            data.forEach(jam => {
                const opt = document.createElement('option');
                opt.value = jam.id_jam;
                opt.textContent =
                    `${jam.nama_jam} (${jam.jam_mulai}–${jam.jam_selesai})`;
                jamMulai.appendChild(opt);
            });

        });
});

// jam akhir hanya boleh >= jam awal
jamMulai.addEventListener('change', function () {

    const mulaiId = parseInt(this.value);
    jamSelesai.innerHTML = '<option value="">-- Pilih Jam Akhir --</option>';

    if (!mulaiId) return;

    jamData
        .filter(j => j.id_jam >= mulaiId)
        .forEach(jam => {
            const opt = document.createElement('option');
            opt.value = jam.id_jam;
            opt.textContent =
                `${jam.nama_jam} (${jam.jam_mulai}–${jam.jam_selesai})`;
            jamSelesai.appendChild(opt);
        });
});
</script>

