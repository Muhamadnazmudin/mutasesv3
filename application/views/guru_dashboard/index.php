<style>
/* ===============================
   JADWAL HARI INI – BASE
================================ */
.jadwal-hari-ini {
    background: transparent;
    color: #212529;
}

/* CARD ITEM */
.jadwal-hari-ini .list-group-item {
    background: rgba(248, 251, 255, 0.95); /* biru semi putih */
    color: #212529;
    border: 1px solid #e4ecf5;
    border-radius: 18px;
    margin-bottom: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,.12);
}

/* TEXT MUTED */
.jadwal-hari-ini .text-muted {
    color: #6c757d;
}

/* ===============================
   DARK MODE
================================ */
.dark-mode .jadwal-hari-ini .list-group-item {
    background: rgba(32, 35, 52, 0.95); /* hitam lembut */
    color: #ffffff;
    border-color: #3a3f55;
    box-shadow: 0 12px 30px rgba(0,0,0,.45);
}

.dark-mode .jadwal-hari-ini .text-muted {
    color: #b0b3c6;
}

/* ===============================
   LIBUR SETENGAH HARI (VISUAL)
================================ */
.jadwal-libur {
    filter: grayscale(100%) brightness(0.9);
}


/* tombol masuk kelas dimatikan */
.jadwal-libur .btn-masuk {
    display: none;
}

/* ===============================
   JAM INFO
================================ */
.jam-info { line-height: 1.35; }
.jam-range { font-weight: 600; }
.jam-clock { font-size: .85rem; }

/* ===============================
   MOBILE
================================ */
@media (max-width: 576px) {
    .jadwal-hari-ini .list-group {
        gap: 14px;
    }

    .jadwal-hari-ini .list-group-item {
        padding: 16px;
        flex-direction: column;
    }

    .jadwal-hari-ini .list-group-item > div:last-child {
        margin-top: 12px;
        text-align: center;
    }
}

/* ===============================
   MODAL FIX (MOBILE SAFE)
================================ */
/* FINAL FIX MODAL MOBILE */
.modal {
    position: fixed !important;
    inset: 0;
    z-index: 1055;
}

.modal-backdrop {
    position: fixed !important;
    inset: 0;
    z-index: 1050;
}

/* penting untuk touch */
.modal-content {
    touch-action: auto;
}

</style>
<?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle"></i>
    <?= $this->session->flashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
<?php endif; ?>

<div class="card shadow mb-4 jadwal-hari-ini">

  <!-- HEADER CARD -->
  <div class="card-header bg-success text-white">
      <i class="fas fa-calendar-day text-warning"></i>
      <strong>Jadwal Mengajar Anda Hari Ini</strong><br>
      <small class="text-light">
          <?= $hari_ini ?>,
          <?= tgl_indo_teks(date('Y-m-d')) ?>
      </small>
  </div>

  <!-- BODY CARD -->
  <div class="card-body p-3">

    <?php if (empty($jadwal_hari_ini)): ?>

        <!-- TIDAK ADA JADWAL -->
        <div class="text-center text-muted py-4">
            <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
            <strong>Tidak ada jadwal mengajar hari ini</strong>
        </div>

    <?php else: ?>

        <ul class="list-group list-group-flush">

        <?php foreach ($jadwal_hari_ini as $j): ?>
        <?php
            $is_libur_jadwal = !empty($j->is_libur);

            date_default_timezone_set('Asia/Jakarta');
            $now = time();
            $jam_masuk = strtotime(date('Y-m-d').' '.$j->jam_mulai);
            $is_waktu_aktif = $now >= $jam_masuk;
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
                    <i class="fas fa-home"></i> Siswa Pulang
                </span>

            <?php elseif (empty($j->log)): ?>

                <?php if ($selisih_menit <= 5 && $selisih_menit >= 1): ?>
                    <div class="alert alert-warning p-2 mb-2 small">
                        <i class="fas fa-exclamation-triangle"></i>
                        Segera masuk, sisa <b><?= $selisih_menit ?> menit</b>
                    </div>
                <?php elseif ($selisih_menit <= 0 && $telat_menit >= 0): ?>
                    <div class="alert alert-danger p-2 mb-2 small">
                        <i class="fas fa-clock"></i>
                        Telat <b><?= $telat_menit ?> menit</b>
                    </div>
                <?php endif; ?>

                <button type="button"
                    class="btn btn-sm btn-danger mb-1"
                    data-toggle="modal"
                    data-target="#modalTidakMasuk<?= $j->jadwal_id ?>">
                    <i class="fas fa-user-times"></i> Tidak Masuk
                </button>

                <?php if ($is_waktu_aktif): ?>

    <a href="<?= site_url('mengajar/mulai/'.$j->jadwal_id) ?>"
       class="btn btn-sm btn-success btn-masuk">
       <i class="fas fa-door-open"></i> Masuk Kelas
    </a>

<?php else: ?>

    <button class="btn btn-sm btn-secondary" disabled>
        <i class="fas fa-lock"></i> Belum Waktunya
    </button>

<?php endif; ?>


            <?php else: ?>

                <?php
                    $status = strtolower($j->log->status);
                    $badgeClass = 'secondary';
                    if ($status === 'izin')    $badgeClass = 'info';
                    if ($status === 'sakit')   $badgeClass = 'warning';
                    if ($status === 'dinas')   $badgeClass = 'primary';
                    if ($status === 'selesai') $badgeClass = 'success';
                ?>

                <?php if ($status === 'mulai'): ?>
<?php
$jam_selesai_jadwal = strtotime(date('Y-m-d').' '.$j->jam_selesai);
$selisih_selesai = floor(($jam_selesai_jadwal - time()) / 60);
$perlu_catatan = $selisih_selesai >= 30;
?>

    <?php if ($perlu_catatan): ?>

    <!-- 🔴 KELUAR LEBIH AWAL → MODAL -->
    <button class="btn btn-sm btn-danger"
        data-toggle="modal"
        data-target="#modalSelesai<?= $j->log->id ?>">
        <i class="fas fa-stop-circle"></i> Selesai
    </button>

<?php else: ?>

    <!-- 🟢 WAKTU NORMAL → LANGSUNG SELESAI -->
    <form method="post"
          action="<?= site_url('mengajar/selesai') ?>"
          style="display:inline">

        <input type="hidden"
               name="<?= $this->security->get_csrf_token_name(); ?>"
               value="<?= $this->security->get_csrf_hash(); ?>">

        <input type="hidden" name="log_id" value="<?= $j->log->id ?>">

        <button type="submit" class="btn btn-sm btn-success">
            <i class="fas fa-check-circle"></i> Selesai
        </button>
    </form>

<?php endif; ?>


<?php elseif ($status === 'menunggu_selfie'): ?>

    <!-- TOMBOL INPUT MATERI -->
    <button class="btn btn-sm btn-info mb-1"
            data-toggle="modal"
            data-target="#modalMateri<?= $j->log->id ?>">
        <i class="fas fa-book"></i> Input Materi
    </button>

    <!-- TOMBOL SELFIE -->
    <a href="<?= site_url('mengajar/selfie/'.$j->log->id) ?>"
       class="btn btn-sm btn-warning">
       <i class="fas fa-camera"></i> Selfie
    </a>

<?php else: ?>

                    <span class="badge badge-<?= $badgeClass ?>">
                        <?= ucfirst($status) ?>
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

<?php foreach ($jadwal_hari_ini as $j): ?>
<div class="modal fade" id="modalTidakMasuk<?= $j->jadwal_id ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <form method="post" action="<?= site_url('mengajar/tidak_masuk') ?>">

<input type="hidden"
       name="<?= $this->security->get_csrf_token_name(); ?>"
       value="<?= $this->security->get_csrf_hash(); ?>">


        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Tidak Masuk Kelas</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="jadwal_id" value="<?= $j->jadwal_id ?>">

          <div class="form-group">
            <label>Alasan</label>
            <select name="status" class="form-control" required>
              <option value="izin">Izin</option>
              <option value="sakit">Sakit</option>
              <option value="dinas">Dinas</option>
            </select>
          </div>

          <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan"
              class="form-control"
              rows="3"
              placeholder="Keterangan (opsional)"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-block">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php if (!empty($j->log) && $j->log->status === 'mulai'): ?>
<div class="modal fade" id="modalSelesai<?= $j->log->id ?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form method="post" action="<?= site_url('mengajar/selesai') ?>">

        <input type="hidden"
               name="<?= $this->security->get_csrf_token_name(); ?>"
               value="<?= $this->security->get_csrf_hash(); ?>">

        <input type="hidden" name="log_id" value="<?= $j->log->id ?>">

        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Selesai Mengajar</h5>
          <button type="button" class="close text-white" data-dismiss="modal">
            &times;
          </button>
        </div>

        <div class="modal-body">
          <p class="text-muted mb-2">
            Jika keluar lebih awal (≥ 30 menit), wajib mengisi catatan.
          </p>

          <div class="form-group">
            <label>Catatan Keluar</label>
            <textarea name="catatan_keluar"
                      class="form-control"
                      rows="3"
                      placeholder="Contoh: ada panggilan dinas / keluarga"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-block">
            Simpan & Selesai
          </button>
        </div>

      </form>

    </div>
  </div>
</div>
<?php endif; ?>

<?php endforeach; ?>
<?php foreach ($jadwal_hari_ini as $j): ?>
<?php if (!empty($j->log) && $j->log->status === 'menunggu_selfie'): ?>
<div class="modal fade" id="modalMateri<?= $j->log->id ?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form method="post" action="<?= site_url('mengajar/simpan_materi') ?>">

        <input type="hidden"
               name="<?= $this->security->get_csrf_token_name(); ?>"
               value="<?= $this->security->get_csrf_hash(); ?>">

        <input type="hidden" name="log_id" value="<?= $j->log->id ?>">

        <div class="modal-header bg-info text-white">
          <h5 class="modal-title">
            <i class="fas fa-book"></i> Materi Mengajar
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal">
            &times;
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Materi yang diajarkan</label>
            <textarea name="materi"
                      class="form-control"
                      rows="3"
                      placeholder="Contoh: Persamaan Linear Dua Variabel"
                      required><?= $j->log->materi ?? '' ?></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-info btn-block">
            Simpan Materi
          </button>
        </div>

      </form>

    </div>
  </div>
</div>
<?php endif; ?>
<?php endforeach; ?>
