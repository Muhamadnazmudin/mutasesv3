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
/* ===== JAM INFO RESPONSIVE ===== */
.jam-info {
    line-height: 1.3;
}

/* Desktop / Tablet */
.jam-range {
    font-weight: 600;
    display: inline;
}

.jam-clock {
    display: inline;
    margin-left: 4px;
}

/* ===== MOBILE MODE ===== */
@media (max-width: 576px) {
    .jam-range {
        display: block;
        font-size: 0.95rem;
    }

    .jam-clock {
        display: block;
        font-size: 0.8rem;
        margin-left: 0;
    }
}
/* ================= MOBILE CARD BASE ================= */
@media (max-width: 576px) {

    .jadwal-hari-ini .list-group {
        gap: 14px;
    }

    .jadwal-hari-ini .list-group-item {
        border-radius: 18px;
        padding: 16px;
        border: none;
        box-shadow: 0 10px 25px rgba(0,0,0,.12);
        flex-direction: column;
        align-items: stretch;
    }

    .jadwal-hari-ini .list-group-item > div:last-child {
        margin-top: 12px;
        text-align: center;
    }

    .jadwal-hari-ini .jam-range {
        font-size: 1rem;
        font-weight: 600;
    }

    .jadwal-hari-ini .jam-clock {
        font-size: 0.8rem;
    }

    .jadwal-hari-ini .btn {
        border-radius: 12px;
        font-weight: 600;
        padding: 8px 12px;
    }

    .jadwal-hari-ini .badge {
        border-radius: 10px;
        padding: 6px 10px;
        font-size: 0.85rem;
    }
}
@media (max-width: 576px) {

    /* LIGHT MODE */
    .jadwal-hari-ini .list-group-item {
        background: #b7cfda;
        color: #212529;
    }

    .jadwal-hari-ini .jam-clock {
        color: #6c757d;
    }
}
@media (max-width: 576px) {

    .dark-mode .jadwal-hari-ini .list-group-item {
        background: linear-gradient(145deg, #2f3248, #25283b);
        color: #f1f1f1;
        box-shadow: 0 12px 30px rgba(0,0,0,.35);
    }

    .dark-mode .jadwal-hari-ini .jam-clock {
        color: #b9c0ff;
    }

    .dark-mode .jadwal-hari-ini .fa-book {
        color: #ffd66b;
    }

    .dark-mode .jadwal-hari-ini .fa-school {
        color: #7de2b8;
    }
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
            <li class="list-group-item d-flex justify-content-between align-items-start">

                <!-- INFO JADWAL -->
                <div>
    <div class="jam-info">
    <div class="jam-range">
        <?= $j->jam_awal ?> – <?= $j->jam_akhir ?>
    </div>
    <div class="jam-clock text-muted">
        (<?= substr($j->jam_mulai, 0, 5) ?> – <?= substr($j->jam_selesai, 0, 5) ?>)
    </div>
</div>

    <br>
    <i class="fas fa-book text-primary"></i>
    <?= $j->nama_mapel ?>
    <br>
    <i class="fas fa-school text-success"></i>
    <?= $j->nama_kelas ?>
</div>


                <!-- AKSI / STATUS -->
                <div class="text-right">
                    <?php if (empty($j->log)): ?>

    <a href="<?= site_url('mengajar/mulai/'.$j->jadwal_id) ?>"
       class="btn btn-sm btn-success">
        <i class="fas fa-door-open"></i> Masuk Kelas
    </a>

<?php elseif ($j->log->status === 'mulai'): ?>

    <a href="<?= site_url('mengajar/selesai/'.$j->log->id) ?>"
       class="btn btn-sm btn-danger">
        <i class="fas fa-stop-circle"></i> Selesai
    </a>

<?php elseif ($j->log && $j->log->status === 'menunggu_selfie'): ?>



    <a href="<?= site_url('mengajar/selfie/'.$j->log->id) ?>"
       class="btn btn-sm btn-warning">
        <i class="fas fa-camera"></i> Selfie
    </a>

<?php else: ?>

    <span class="badge badge-success">
        <i class="fas fa-check"></i> Selesai
    </span>

<?php endif; ?>

                </div>

            </li>
            <?php endforeach; ?>
        </ul>

        <?php endif; ?>

    </div>
</div>
