<!-- <!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Daftar Kunjungan Tamu</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
body {
  background: #f4f6f9;
}
.card {
  border-radius: 14px;
}
.card-header {
  font-weight: 600;
}
.table thead th {
  font-size: .85rem;
  text-transform: uppercase;
}
.pagination {
  justify-content: center;
}
.pagination a,
.pagination span {
  margin: 0 4px;
  padding: 6px 12px;
  border-radius: 6px;
  border: 1px solid #dee2e6;
  text-decoration: none;
}
.pagination .active span {
  background: #0d6efd;
  color: #fff;
  border-color: #0d6efd;
}
</style>
</head>

<body>

<div class="container py-4">

  
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">
      <i class="fas fa-clipboard-list text-primary"></i>
      Daftar Kunjungan Tamu
    </h3>

    <a href="<?= site_url('buku_tamu/tambah') ?>" class="btn btn-primary">
      <i class="fas fa-plus"></i> Isi Buku Tamu
    </a>
  </div>

  
  <div class="card shadow-sm mb-5">
    <div class="card-header bg-primary text-white">
      <i class="fas fa-calendar-day"></i> Data Tamu Hari Ini
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover table-sm mb-0">
        <thead class="table-light">
          <tr>
            <th width="5%">No</th>
            <th>Nama</th>
            <th>Instansi</th>
            <th width="8%">Jumlah</th>
            <th>Bertemu</th>
            <th width="15%">Status</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!empty($hari_ini)): ?>
          <?php $no = 1; foreach ($hari_ini as $r): ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= htmlspecialchars($r->nama_tamu) ?></td>
            <td><?= htmlspecialchars($r->instansi) ?></td>
            <td class="text-center"><?= (int)$r->jumlah_orang ?> org</td>
            <td><?= htmlspecialchars($r->bertemu_dengan) ?></td>
            <td class="text-center">
              <?php if ($r->status == 1): ?>
                <span class="badge bg-success">
                  <i class="fas fa-check-circle"></i> Selesai
                </span>
              <?php else: ?>
                <span class="badge bg-warning text-dark">
                  <i class="fas fa-clock"></i> Belum Selesai
                </span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center text-muted py-3">
              Belum ada kunjungan hari ini
            </td>
          </tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>

    <?php if (!empty($pagination_hari)): ?>
    <div class="card-footer bg-white">
      <?= $pagination_hari ?>
    </div>
    <?php endif; ?>
  </div>

</body>
</html> -->
