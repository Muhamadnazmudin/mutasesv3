<style>
/* ===== FILTER JADWAL GURU ===== */
.jadwal-filter {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.jadwal-filter .btn.active {
    background: #198754;
    color: #fff;
}

/* DARK MODE SUPPORT */
.dark-mode .jadwal-filter .btn {
    border-color: #4b8f6a;
    color: #cfeedd;
}

.dark-mode .jadwal-filter .btn.active {
    background: #6fd19c;
    color: #0f2f1f;
}
</style>


<div class="container-fluid">

    <h1 class="h5 mb-4 text-success">
        <i class="fas fa-calendar-alt"></i> Jadwal Mengajar Saya
    </h1>

    <div class="card shadow">
        <div class="card-body">

            <!-- FILTER HARI -->
            <div class="jadwal-filter mb-3">
                <button class="btn btn-sm btn-outline-success active" data-hari="all">
                    Semua
                </button>
                <button class="btn btn-sm btn-outline-success" data-hari="Senin">Senin</button>
                <button class="btn btn-sm btn-outline-success" data-hari="Selasa">Selasa</button>
                <button class="btn btn-sm btn-outline-success" data-hari="Rabu">Rabu</button>
                <button class="btn btn-sm btn-outline-success" data-hari="Kamis">Kamis</button>
                <button class="btn btn-sm btn-outline-success" data-hari="Jumat">Jumat</button>
            </div>

            <?php if (empty($jadwal)): ?>
                <div class="alert alert-info">
                    Belum ada jadwal mengajar.
                </div>
            <?php else: ?>

            <div class="table-responsive">
                <table class="table table-bordered table-sm jadwal-table">
                    <thead class="bg-success text-white">
                        <tr>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jadwal as $j): ?>
                        <tr data-hari="<?= $j->hari ?>">
                            <td><?= $j->hari ?></td>
                            <td>
                                <?= $j->jam_awal ?> – <?= $j->jam_akhir ?><br>
                                <small class="text-muted">
                                    <?= substr($j->jam_mulai, 0, 5) ?> – <?= substr($j->jam_selesai, 0, 5) ?>
                                </small>
                            </td>
                            <td><?= $j->nama_kelas ?></td>
                            <td><?= $j->nama_mapel ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php endif; ?>

        </div>
    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.jadwal-filter button');
    const rows = document.querySelectorAll('.jadwal-table tbody tr');

    buttons.forEach(btn => {
        btn.addEventListener('click', function () {
            buttons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const hari = this.dataset.hari;

            rows.forEach(row => {
                row.style.display =
                    (hari === 'all' || row.dataset.hari === hari)
                    ? '' : 'none';
            });
        });
    });
});
</script>
