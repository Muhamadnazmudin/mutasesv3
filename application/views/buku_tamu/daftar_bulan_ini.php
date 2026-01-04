<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Daftar Tamu Bulan Ini</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
body {
  background: #f5f7fb;
  font-size: 14px;
}

.page-title {
  font-weight: 700;
}

.card {
  border-radius: 14px;
  border: none;
  box-shadow: 0 8px 22px rgba(0,0,0,.08);
}

.table th {
  background: #f1f3ff;
  text-transform: uppercase;
  font-size: 12px;
}

.table td {
  vertical-align: top;
}

.text-truncate-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.badge {
  font-size: 12px;
}

.pagination {
  justify-content: center;
}
</style>
</head>
<body>

<div class="container my-4">

  <!-- HEADER -->
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
      <h4 class="page-title mb-1">
        <i class="fas fa-calendar-alt text-primary"></i>
        Daftar Tamu Bulan Ini
      </h4>
      <small class="text-muted">
        Rekap kunjungan bulan <?= date('F Y') ?>
      </small>
    </div>

    <div class="mt-2 mt-md-0">
      <a href="<?= site_url('buku_tamu/daftar_hari_ini') ?>" class="btn btn-outline-primary btn-sm">
        <i class="fas fa-calendar-day"></i> Hari Ini
      </a>
      <a href="<?= site_url('buku_tamu/tambah') ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Isi Buku Tamu
      </a>
    </div>
  </div>

  <!-- CARD TABLE -->
  <div class="card">
    <div class="card-body p-0">

      <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
          <thead>
            <tr>
              <th width="50">No</th>
              <th width="130">Tanggal</th>
              <th>Nama</th>
              <th>Instansi</th>
              <th class="text-center">Jumlah</th>
              <th>Bertemu</th>
              <th>Keperluan</th>
            </tr>
          </thead>
          <tbody>

          <?php if (!empty($list)): ?>
            <?php foreach ($list as $r): ?>
            <tr>
              <td><?= ++$start ?></td>

              <td>
                <?= date('d/m/Y', strtotime($r->tanggal)) ?><br>
                <small class="text-muted"><?= date('H:i', strtotime($r->tanggal)) ?></small>
              </td>

              <td class="fw-semibold">
                <?= htmlspecialchars($r->nama_tamu) ?>
              </td>

              <td><?= htmlspecialchars($r->instansi) ?></td>

              <td class="text-center">
                <span class="badge bg-primary">
                  <?= (int)$r->jumlah_orang ?> org
                </span>
              </td>

              <td><?= htmlspecialchars($r->bertemu_dengan) ?></td>

              <td>
                <div class="text-truncate-2"
                     title="<?= htmlspecialchars($r->keperluan) ?>">
                  <?= htmlspecialchars($r->keperluan) ?>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>

          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center text-muted py-4">
                <i class="fas fa-info-circle"></i>
                Belum ada kunjungan bulan ini
              </td>
            </tr>
          <?php endif; ?>

          </tbody>
        </table>
      </div>

    </div>

    <?php if (!empty($pagination)): ?>
    <div class="card-footer bg-white">
      <?= $pagination ?>
    </div>
    <?php endif; ?>
  </div>

</div>

</body>
</html>
