<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Kehadiran MBG</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fa;
        }
        .card-header {
            font-weight: bold;
            font-size: 18px;
        }
        .table th {
            background: #343a40;
            color: white;
        }
        .table tbody tr:hover {
            background: #f1f1f1;
        }
    </style>
</head>

<body>

<div class="container py-4">

    <div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        Dashboard Kehadiran — MBG
    </div>

    <div class="card-body">

        <!-- 🔙 Tombol Kembali -->
        <a href="<?= base_url('index.php/dashboard') ?>" 
           class="btn btn-secondary btn-sm mb-3">
           ← Kembali
        </a>

        <!-- Filter tanggal -->
        <form class="row g-3 mb-3">
            <div class="col-auto">
                <input type="date" name="tanggal" class="form-control" value="<?= $tanggal ?>">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary">Filter</button>
            </div>
        </form>


            <div class="d-flex justify-content-end mb-3">
    <a href="<?= base_url('index.php/dashboardmbg/export_pdf?tanggal='.$tanggal) ?>" 
       class="btn btn-danger btn-sm me-2">Export PDF</a>

    <a href="<?= base_url('index.php/dashboardmbg/export_excel?tanggal='.$tanggal) ?>" 
       class="btn btn-success btn-sm">Export Excel</a>
</div>

<div class="table-responsive">
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>Kelas</th>
                <th>Total</th>
                <th class="text-success">Hadir</th>
                <th class="text-danger">Tidak Hadir</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php $no=1; foreach ($rekap as $r): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td class="fw-bold"><?= $r['kelas_nama'] ?></td>
                <td><?= $r['total'] ?></td>
                <td class="text-success fw-bold"><?= $r['hadir'] ?></td>
                <td class="text-danger fw-bold"><?= $r['tidak_hadir'] ?></td>
                <td>
                    <a href="<?= base_url('index.php/dashboardmbg/detail/'.$r['kelas_id'].'?tanggal='.$tanggal) ?>" 
                       class="btn btn-info btn-sm">Detail</a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>


        </div>
    </div>

</div>

</body>
</html>
