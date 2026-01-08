<style>
 /* ===== JADWAL HARI INI – LIGHT MODE ===== */
.jadwal-hari-ini {
    background-color: #ffffff;
    color: #212529;
}

.jadwal-hari-ini .list-group-item {
    background-color: #ffffff;
    color: #212529;
    border-color: #e9ecef;
}

.jadwal-hari-ini .text-muted {
    color: #6c757d;
}

/* ===== JADWAL HARI INI – DARK MODE ===== */
.dark-mode .jadwal-hari-ini {
    background-color: #2a2d3e;   /* dark soft */
    color: #f1f1f1;
}

.dark-mode .jadwal-hari-ini .list-group-item {
    background-color: #2a2d3e;
    color: #f1f1f1;
    border-color: #3a3f55;
}

.dark-mode .jadwal-hari-ini .text-muted {
    color: #b0b3c6;
}

/* Ikon tetap jelas */
.jadwal-hari-ini i {
    opacity: 0.9;
}

  </style>
<div class="card shadow mb-4 jadwal-hari-ini">
    <div class="card-header bg-success text-white">
        <i class="fas fa-calendar-day"></i>
        Jadwal Mengajar Hari Ini (<?= $hari_ini ?>)
    </div>
    <div class="card-body">

        <?php if (empty($jadwal_hari_ini)): ?>
            <div class="alert alert-secondary mb-0">
                <i class="fas fa-coffee"></i>
                Tidak ada jadwal mengajar hari ini.
            </div>
        <?php else: ?>

            <ul class="list-group list-group-flush">
                <?php foreach ($jadwal_hari_ini as $j): ?>
                <li class="list-group-item">
                    <strong><?= $j->nama_jam ?></strong>
                    <span class="text-muted">
                        (<?= $j->jam_mulai ?> – <?= $j->jam_selesai ?>)
                    </span>
                    <br>
                    <i class="fas fa-book text-primary"></i>
                    <?= $j->nama_mapel ?>
                    <br>
                    <i class="fas fa-school text-success"></i>
                    <?= $j->nama_kelas ?>
                </li>
                <?php endforeach; ?>
            </ul>

        <?php endif; ?>

    </div>
</div>
