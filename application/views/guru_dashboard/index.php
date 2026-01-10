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
    background-color: #2a2d3e;
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

/* ===== LIBUR SETENGAH HARI ===== */
.jadwal-libur {
    opacity: .6;
    pointer-events: none;
}

/* ===== JAM INFO ===== */
.jam-info { line-height: 1.3; }
.jam-range { font-weight: 600; }
.jam-clock { font-size: .85rem; }

/* ===== MOBILE ===== */
@media (max-width: 576px) {
    .jadwal-hari-ini .list-group {
        gap: 14px;
    }
    .jadwal-hari-ini .list-group-item {
        border-radius: 18px;
        padding: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,.12);
        flex-direction: column;
    }
    .jadwal-hari-ini .list-group-item > div:last-child {
        margin-top: 12px;
        text-align: center;
    }
}
</style>

<?php if (!empty($is_libur) && $is_libur): ?>
<div class="alert alert-success text-center mt-4">
    <h4 class="mb-1">🎉 Hari Ini Libur</h4>
    <small><?= $nama_libur ?></small>
</div>
<?php return; endif; ?>

<?php if (!empty($libur_half) && $libur_half): ?>
<div class="alert alert-warning text-center">
    <strong>⚠️ Libur Mulai Jam <?= substr($jam_libur, 0, 5) ?></strong>
</div>
<?php endif; ?>

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

            <?php
            $is_libur_jadwal = !empty($j->is_libur) && $j->is_libur === true;

            date_default_timezone_set('Asia/Jakarta');
            $now = time();
            $jam_masuk = strtotime(date('Y-m-d') . ' ' . $j->jam_mulai);
            $selisih_menit = floor(($jam_masuk - $now) / 60);
            $telat_menit   = floor(($now - $jam_masuk) / 60);
            ?>

            <li class="list-group-item d-flex justify-content-between align-items-start <?= $is_libur_jadwal ? 'jadwal-libur' : '' ?>">

                <!-- INFO -->
                <div>
                    <div class="jam-info">
                        <div class="jam-range">
                            <?= $j->jam_awal ?> – <?= $j->jam_akhir ?>
                        </div>
                        <div class="jam-clock text-muted">
                            (<?= substr($j->jam_mulai,0,5) ?> – <?= substr($j->jam_selesai,0,5) ?>)
                        </div>
                    </div>
                    <br>
                    <i class="fas fa-book text-primary"></i> <?= $j->nama_mapel ?><br>
                    <i class="fas fa-school text-success"></i> <?= $j->nama_kelas ?>
                </div>

                <!-- AKSI -->
                <div class="text-right">

                <?php if ($is_libur_jadwal): ?>

                    <span class="badge badge-secondary">
                        🎉 Libur (Setengah Hari)
                    </span>

                <?php else: ?>

                    <?php if (empty($j->log)): ?>

                        <?php if ($selisih_menit <= 5 && $selisih_menit >= 1): ?>
                            <div class="alert alert-warning p-2 mb-2 small">
                                <i class="fas fa-exclamation-triangle"></i>
                                Segera masuk, sisa <strong><?= $selisih_menit ?> menit</strong>
                            </div>
                        <?php elseif ($selisih_menit <= 0 && $telat_menit >= 0): ?>
                            <div class="alert alert-danger p-2 mb-2 small">
                                <i class="fas fa-clock"></i>
                                Telat <strong><?= $telat_menit ?> menit</strong>
                            </div>
                        <?php endif; ?>

                        <a href="<?= site_url('mengajar/mulai/'.$j->jadwal_id) ?>"
                           class="btn btn-sm btn-success">
                           <i class="fas fa-door-open"></i> Masuk Kelas
                        </a>

                    <?php elseif ($j->log->status === 'mulai'): ?>

                        <a href="<?= site_url('mengajar/selesai/'.$j->log->id) ?>"
                           class="btn btn-sm btn-danger">
                           <i class="fas fa-stop-circle"></i> Selesai
                        </a>

                    <?php elseif ($j->log->status === 'menunggu_selfie'): ?>

                        <a href="<?= site_url('mengajar/selfie/'.$j->log->id) ?>"
                           class="btn btn-sm btn-warning">
                           <i class="fas fa-camera"></i> Selfie
                        </a>

                    <?php else: ?>

                        <span class="badge badge-success">
                            <i class="fas fa-check"></i> Selesai
                        </span>

                    <?php endif; ?>

                <?php endif; ?>

                </div>
            </li>

        <?php endforeach; ?>
        </ul>

        <?php endif; ?>

    </div>
</div>
