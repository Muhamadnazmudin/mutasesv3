<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Daftar Tamu Hari Ini</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
/* ===============================
   GLOBAL
================================ */
body {
  background: #f4f6f9;
  font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
}

.container {
  max-width: 1100px;
}

/* ===============================
   HEADER
================================ */
.page-header {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.page-title h4 {
  font-weight: 700;
  margin: 0;
}

.page-title small {
  color: #6c757d;
}

/* ===============================
   CARD
================================ */
.card-modern {
  border: none;
  border-radius: 18px;
  background: #fff;
  box-shadow: 0 8px 28px rgba(0,0,0,.08);
  overflow: hidden;
}

/* ===============================
   TABLE DESKTOP
================================ */
.table-modern {
  font-size: .9rem;
}

.table-modern thead th {
  background: #f1f3f8;
  text-transform: uppercase;
  font-size: .7rem;
  letter-spacing: .05em;
  border-bottom: 1px solid #dee2e6;
}

.table-modern tbody tr:hover {
  background: rgba(13,110,253,.06);
}

/* ===============================
   BADGE
================================ */
.badge-pill {
  border-radius: 999px;
  padding: .45rem .8rem;
  font-size: .75rem;
  font-weight: 600;
}

.badge-jumlah {
  background: #e0e7ff;
  color: #1e3a8a;
}

.badge-selesai {
  background: #d1fae5;
  color: #065f46;
}

.badge-belum {
  background: #fef3c7;
  color: #92400e;
}

/* ===============================
   EMPTY
================================ */
.empty-state {
  padding: 60px 20px;
  text-align: center;
  color: #6c757d;
}

.empty-state i {
  font-size: 2.5rem;
  opacity: .4;
}

/* ===============================
   MOBILE CARD
================================ */
.mobile-list {
  display: none;
}

.mobile-item {
  border-bottom: 1px solid #eee;
  padding: 14px 16px;
}

.mobile-item:last-child {
  border-bottom: none;
}

.mobile-name {
  font-weight: 700;
}

.mobile-meta {
  font-size: .8rem;
  color: #6c757d;
}

/* ===============================
   RESPONSIVE
================================ */
@media (max-width: 768px) {
  .desktop-table {
    display: none;
  }
  .mobile-list {
    display: block;
  }
}
</style>
</head>

<body>

<div class="container my-4">

  <!-- HEADER -->
  <div class="page-header">
    <div class="page-title">
      <h4>
        <i class="fas fa-calendar-day text-primary me-1"></i>
        Daftar Tamu Hari Ini
      </h4>
      <small><?= date('l, d F Y') ?></small>
    </div>

    <div class="d-flex gap-2">
      <a href="<?= site_url('buku_tamu/tambah') ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Isi Buku Tamu
      </a>
      <a href="<?= site_url('buku_tamu/daftar_bulan_ini') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-calendar-alt"></i> Bulan Ini
      </a>
    </div>
  </div>

  <!-- CARD -->
  <div class="card-modern">

    <!-- DESKTOP TABLE -->
    <div class="table-responsive desktop-table">
      <table class="table table-modern align-middle mb-0">
        <thead>
          <tr>
            <th width="60">No</th>
            <th>Nama</th>
            <th>Instansi</th>
            <th class="text-center">Jumlah</th>
            <th>Bertemu</th>
            <th class="text-center">Status</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!empty($list)): ?>
          <?php foreach ($list as $r): ?>
          <tr>
            <td><?= ++$start ?></td>
            <td class="fw-semibold"><?= htmlspecialchars($r->nama_tamu) ?></td>
            <td><?= htmlspecialchars($r->instansi ?: '-') ?></td>
            <td class="text-center">
              <span class="badge-pill badge-jumlah"><?= $r->jumlah_orang ?> org</span>
            </td>
            <td><?= htmlspecialchars($r->bertemu_dengan ?: '-') ?></td>
            <td class="text-center">
              <?php if ($r->status): ?>
                <span class="badge-pill badge-selesai">Selesai</span>
              <?php else: ?>
                <span class="badge-pill badge-belum">Belum</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="empty-state">
              <i class="fas fa-info-circle"></i>
              <div>Belum ada kunjungan hari ini</div>
            </td>
          </tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- MOBILE LIST -->
    <div class="mobile-list">
      <?php if (!empty($list)): ?>
        <?php foreach ($list as $r): ?>
        <div class="mobile-item">
          <div class="mobile-name"><?= htmlspecialchars($r->nama_tamu) ?></div>
          <div class="mobile-meta">
            <?= htmlspecialchars($r->instansi ?: '-') ?> • <?= $r->jumlah_orang ?> org
          </div>
          <div class="mt-2">
            <small>Bertemu: <?= htmlspecialchars($r->bertemu_dengan ?: '-') ?></small><br>
            <?php if ($r->status): ?>
              <span class="badge-pill badge-selesai mt-1 d-inline-block">Selesai</span>
            <?php else: ?>
              <span class="badge-pill badge-belum mt-1 d-inline-block">Belum</span>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="empty-state">
          <i class="fas fa-info-circle"></i>
          <div>Belum ada kunjungan hari ini</div>
        </div>
      <?php endif; ?>
    </div>

    <!-- PAGINATION -->
    <?php if (!empty($pagination)): ?>
    <div class="p-3 border-top bg-white">
      <div class="d-flex justify-content-center">
        <?= $pagination ?>
      </div>
    </div>
    <?php endif; ?>

  </div>

</div>

</body>
</html>
