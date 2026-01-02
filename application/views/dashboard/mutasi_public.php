<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Siswa Mutasi — Sistem Mutasi Siswa</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<style>
:root {
  --bg:#f8f9fa; --text:#212529; --card:#fff;
  --table-header:#007bff; --table-header-text:#fff;
}
body.dark {
  --bg:#1e1e1e; --text:#eaeaea; --card:#2b2b2b;
  --table-header:#333;
}
body {
  background:var(--bg); color:var(--text);
  font-family:'Segoe UI',sans-serif;
  transition:.3s;
}

/* Header */
header {
  background:linear-gradient(90deg,#007bff,#00bcd4);
  color:#fff; padding:1rem 0;
}
header .brand {font-weight:700;font-size:1.3rem}

/* Card */
.card {
  background:var(--card);
  border:none;
  border-radius:12px;
  box-shadow:0 2px 6px rgba(0,0,0,.08);
}

/* Table modern */
.table-modern {
  border-collapse:separate;
  border-spacing:0;
  border-radius:10px;
  overflow:hidden;
}
.table-modern thead th {
  position:sticky; top:0; z-index:2;
  background:var(--table-header);
  color:var(--table-header-text);
  font-size:.75rem;
  text-transform:uppercase;
}
.table-modern tbody tr:hover {
  background:rgba(0,123,255,.08);
}
body.dark .table-modern tbody tr:hover {
  background:rgba(255,255,255,.08);
}
.table-modern td {
  font-size:.9rem;
  vertical-align:middle;
}

/* Badge */
.badge-masuk {background:#198754}
.badge-keluar {background:#dc3545}

/* Pagination */
.pagination .page-link {border-radius:6px;margin:0 3px}
.pagination .active .page-link {
  background:#007bff;border-color:#007bff;
}
</style>
</head>

<body>

<header>
<div class="container d-flex justify-content-between align-items-center">
  <div class="brand">
    <i class="fas fa-exchange-alt"></i> Data Siswa Mutasi
  </div>
  <div>
    <button id="toggleDark" class="btn btn-light btn-sm">
      <i class="fas fa-moon"></i>
    </button>
    <a href="<?= base_url('index.php/dashboard') ?>" class="btn btn-light btn-sm ms-2">
      <i class="fas fa-home"></i> Dashboard
    </a>
  </div>
</div>
</header>

<main class="container my-5">

<h3 class="text-center mb-4">Laporan Mutasi Siswa Tahun <?= $tahun ?></h3>

<!-- FILTER -->
<form method="get" class="row g-3 mb-4">
  <div class="col-md-3">
    <label class="fw-bold">Kelas</label>
    <select name="kelas" class="form-select form-select-sm">
      <option value="">Semua</option>
      <?php foreach($kelas_list as $k): ?>
        <option value="<?= $k->id ?>" <?= ($this->input->get('kelas')==$k->id?'selected':'') ?>>
          <?= $k->nama ?>
        </option>
      <?php endforeach ?>
    </select>
  </div>

  <div class="col-md-3">
    <label class="fw-bold">Jenis Mutasi</label>
    <select name="jenis" class="form-select form-select-sm">
      <option value="">Semua</option>
      <option value="masuk" <?= $this->input->get('jenis')=='masuk'?'selected':'' ?>>Masuk</option>
      <option value="keluar" <?= $this->input->get('jenis')=='keluar'?'selected':'' ?>>Keluar</option>
    </select>
  </div>

  <div class="col-md-4">
    <label class="fw-bold">Cari Nama</label>
    <input type="text" name="search" class="form-control form-control-sm"
      value="<?= $this->input->get('search') ?>" placeholder="Nama siswa...">
  </div>

  <div class="col-md-2 d-flex align-items-end gap-2">
    <button class="btn btn-primary btn-sm w-100">
      <i class="fas fa-filter"></i> Filter
    </button>
    <a href="<?= site_url('mutasi') ?>" class="btn btn-secondary btn-sm w-100">
      Reset
    </a>
  </div>
</form>

<!-- EXPORT -->
<div class="mb-3">
  <a href="<?= site_url('public_mutasi/export_excel?'.http_build_query($_GET)) ?>"
     class="btn btn-success btn-sm">
    <i class="fas fa-file-excel"></i> Excel
  </a>
  <a href="<?= site_url('public_mutasi/export_pdf?'.http_build_query($_GET)) ?>"
   target="_blank"
   rel="noopener"
   class="btn btn-danger btn-sm">
  <i class="fas fa-file-pdf"></i> PDF
</a>


<!-- TABLE -->
<div class="card p-3">
<div class="table-responsive">
<table class="table table-modern align-middle">
<thead>
<tr>
  <th>No</th>
  <th>Nama</th>
  <th>NIS</th>
  <th>NISN</th>
  <th>Kelas Asal</th>
  <th>Jenis</th>
  <th>Tanggal</th>
  <th>Tujuan</th>
  <th>Tahun</th>
</tr>
</thead>
<tbody>
<?php if($mutasi): $no=1+(int)$this->input->get('page'); foreach($mutasi as $m): ?>
<tr>
  <td><?= $no++ ?></td>
  <td class="fw-semibold"><?= $m->nama_siswa ?></td>
  <td><?= $m->nis ?: '-' ?></td>
  <td><?= $m->nisn ?: '-' ?></td>
  <td><?= $m->kelas_asal ?: '-' ?></td>
  <td>
    <span class="badge <?= $m->jenis=='masuk'?'badge-masuk':'badge-keluar' ?>">
      <?= ucfirst($m->jenis) ?>
    </span>
  </td>
  <td><?= $m->tanggal?date('d-m-Y',strtotime($m->tanggal)):'-' ?></td>
  <td><?= $m->jenis=='keluar' ? ($m->tujuan_sekolah?:'-') : '-' ?></td>
  <td><?= $m->tahun_ajaran ?></td>
</tr>
<?php endforeach; else: ?>
<tr>
  <td colspan="9" class="text-center text-muted py-4">
    Tidak ada data mutasi
  </td>
</tr>
<?php endif ?>
</tbody>
</table>
</div>

<nav class="mt-3 d-flex justify-content-center">
<?= $pagination ?>
</nav>

</div>
</main>

<footer class="text-center text-muted my-4">
<small>&copy; <?= date('Y') ?> Sistem Mutasi Siswa</small>
</footer>

<script>
document.getElementById('toggleDark').onclick = ()=>{
 document.body.classList.toggle('dark');
 localStorage.setItem('darkMode',document.body.classList.contains('dark'));
}
if(localStorage.getItem('darkMode')==='true'){
 document.body.classList.add('dark');
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
