<style>
/* ================= JADWAL SISWA RESPONSIVE ================= */

/* DESKTOP */
.jadwal-mobile {
    display: none;
}

/* FILTER */
.jadwal-filter {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.jadwal-filter .btn.active {
    background: #0d6efd;
    color: #fff;
}

/* ================= MOBILE MODE ================= */
@media (max-width: 768px) {

    .jadwal-table {
        display: none;
    }

    .jadwal-mobile {
        display: block;
    }

    .jadwal-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 14px;
        margin-bottom: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,.08);
    }

    .jadwal-header {
        display: flex;
        justify-content: space-between;
        font-size: .8rem;
        margin-bottom: 6px;
    }

    .jadwal-header .hari {
        font-weight: 600;
        color: #0d6efd;
    }

    .jadwal-header .jam {
        color: #6c757d;
    }

    .jadwal-body .mapel {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 2px;
        color: #212529;
    }

    .jadwal-body .guru {
        font-size: .85rem;
        color: #495057;
    }

    /* ===== DARK MODE MOBILE ===== */
    .dark-mode .jadwal-card {
        background: #2a2d3e;
        color: #f1f1f1;
    }

    .dark-mode .jadwal-header .hari {
        color: #7aa2ff;
    }

    .dark-mode .jadwal-header .jam {
        color: #aab0ff;
    }

    .dark-mode .jadwal-body .mapel {
        color: #ffffff;
    }

    .dark-mode .jadwal-body .guru {
        color: #cfd3ff;
    }
}

/* ===== DARK MODE FILTER ===== */
.dark-mode .jadwal-filter .btn {
    border-color: #4b4f75;
    color: #cfd3ff;
}

.dark-mode .jadwal-filter .btn.active {
    background: #7aa2ff;
    color: #12141f;
}
</style>
<div class="container-fluid">

    <h4 class="mb-3">
        <i class="fas fa-calendar-alt"></i> Jadwal Pelajaran
    </h4>

    <div class="card shadow">
        <div class="card-body">

            <!-- FILTER HARI -->
            <div class="jadwal-filter mb-3">
                <button class="btn btn-sm btn-outline-primary active" data-hari="all">Semua</button>
                <button class="btn btn-sm btn-outline-primary" data-hari="Senin">Senin</button>
                <button class="btn btn-sm btn-outline-primary" data-hari="Selasa">Selasa</button>
                <button class="btn btn-sm btn-outline-primary" data-hari="Rabu">Rabu</button>
                <button class="btn btn-sm btn-outline-primary" data-hari="Kamis">Kamis</button>
                <button class="btn btn-sm btn-outline-primary" data-hari="Jumat">Jumat</button>
            </div>

            <?php if (empty($jadwal)): ?>
                <div class="alert alert-info">
                    Jadwal pelajaran belum tersedia.
                </div>
            <?php else: ?>

            <!-- DESKTOP TABLE -->
            <div class="table-responsive jadwal-table">
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($jadwal as $j): ?>
                        <tr data-hari="<?= $j->hari ?>">
                            <td><?= $no++ ?></td>
                            <td><?= $j->hari ?></td>
                            <td>
                                <?= $j->nama_jam_awal ?> – <?= $j->nama_jam_akhir ?><br>
                                <small class="text-muted">
                                    <?= substr($j->jam_mulai,0,5) ?> – <?= substr($j->jam_selesai,0,5) ?>
                                </small>
                            </td>
                            <td><?= $j->nama_mapel ?></td>
                            <td><?= $j->nama_guru ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- MOBILE CARD -->
            <div class="jadwal-mobile">
                <?php foreach ($jadwal as $j): ?>
                <div class="jadwal-card" data-hari="<?= $j->hari ?>">
                    <div class="jadwal-header">
                        <span class="hari"><?= $j->hari ?></span>
                        <span class="jam">
                            <?= $j->nama_jam_awal ?> – <?= $j->nama_jam_akhir ?>
                            (<?= substr($j->jam_mulai,0,5) ?>–<?= substr($j->jam_selesai,0,5) ?>)
                        </span>
                    </div>

                    <div class="jadwal-body">
                        <div class="mapel"><?= $j->nama_mapel ?></div>
                        <div class="guru"><?= $j->nama_guru ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php endif; ?>

        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.jadwal-filter button');
    const rows = document.querySelectorAll('.jadwal-table tbody tr');
    const cards = document.querySelectorAll('.jadwal-card');

    buttons.forEach(btn => {
        btn.addEventListener('click', function () {
            buttons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const hari = this.dataset.hari;

            rows.forEach(row => {
                row.style.display =
                    (hari === 'all' || row.dataset.hari === hari) ? '' : 'none';
            });

            cards.forEach(card => {
                card.style.display =
                    (hari === 'all' || card.dataset.hari === hari) ? '' : 'none';
            });
        });
    });
});
</script>
