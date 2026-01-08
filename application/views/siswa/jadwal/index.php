<style>
    /* ===== JADWAL SISWA RESPONSIVE ===== */

/* default: desktop */
.jadwal-mobile {
    display: none;
}

/* ===== MOBILE MODE ===== */
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

    /* DARK MODE SUPPORT */
    .dark-mode .jadwal-card {
        background: #2a2d3e;
        color: #f1f1f1;
    }

    .dark-mode .jadwal-header .jam {
        color: #b0b3c6;
    }

    .dark-mode .jadwal-body .guru {
        color: #d0d3e0;
    }
}

    </style>
<div class="container-fluid">

    <h4 class="mb-3">
        <i class="fas fa-calendar-alt"></i> Jadwal Pelajaran
    </h4>

    <div class="card shadow">
        <div class="card-body">

            <?php if (empty($jadwal)): ?>
                <div class="alert alert-info">
                    Jadwal pelajaran belum tersedia.
                </div>
            <?php else: ?>

            <div class="table-responsive jadwal-table">
    <table class="table table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Mata Pelajaran</th>
                <th>Guru Pengajar</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach ($jadwal as $j): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $j->hari; ?></td>
                <td>
                    <?= $j->nama_jam; ?><br>
                    <small class="text-muted">
                        <?= $j->jam_mulai; ?> – <?= $j->jam_selesai; ?>
                    </small>
                </td>
                <td><?= $j->nama_mapel; ?></td>
                <td><?= $j->nama_guru; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- MOBILE CARD VIEW -->
<div class="jadwal-mobile">
    <?php foreach ($jadwal as $j): ?>
        <div class="jadwal-card">
            <div class="jadwal-header">
                <span class="hari"><?= $j->hari ?></span>
                <span class="jam">
                    <?= $j->nama_jam ?> (<?= $j->jam_mulai ?>–<?= $j->jam_selesai ?>)
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
