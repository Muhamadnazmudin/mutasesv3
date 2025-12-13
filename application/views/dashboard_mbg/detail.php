<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Kehadiran</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fa;
        }

        .card-header {
            font-size: 18px;
            font-weight: bold;
        }

        /* Card list style */
        .student-card {
            border-radius: 10px;
            padding: 12px 18px;
            margin-bottom: 10px;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .student-status {
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
        }

        .hadir {
            background: #d4edda;
            color: #155724;
        }

        .tidak-hadir {
            background: #f8d7da;
            color: #721c24;
        }

        /* Responsive list columns */
        @media (min-width: 768px) {
            .list-container {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }
        }
    </style>
</head>

<body>

<div class="container py-4">

    <a href="<?= base_url('index.php/dashboardmbg?tanggal='.$tanggal) ?>" 
       class="btn btn-secondary btn-sm mb-3">← Kembali</a>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            Detail Kehadiran — <?= $kelas->nama ?> (<?= $tanggal ?>)
        </div>

        <div class="card-body">

            <!-- ============================= -->
            <!-- LIST HADIR -->
            <!-- ============================= -->
            <h5 class="text-success fw-bold mb-3">
                ✔ Siswa Hadir (<?= count($hadir) ?>)
            </h5>

            <div class="list-container">
                <?php foreach ($hadir as $s): ?>
                    <div class="student-card">
                        <div><?= $s->nama ?></div>
                        <span class="student-status hadir">Hadir</span>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($hadir)): ?>
                    <p class="text-muted fst-italic">Tidak ada yang hadir.</p>
                <?php endif; ?>
            </div>


            <hr class="my-4">


            <!-- ============================= -->
            <!-- LIST TIDAK HADIR -->
            <!-- ============================= -->
            <h5 class="text-danger fw-bold mb-3">
                ✖ Siswa Tidak Hadir (<?= count($tidak_hadir) ?>)
            </h5>

            <div class="list-container">
                <?php foreach ($tidak_hadir as $s): ?>
                    <div class="student-card">
                        <div><?= $s->nama ?></div>
                        <span class="student-status tidak-hadir">Tidak Hadir</span>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($tidak_hadir)): ?>
                    <p class="text-muted fst-italic">Semua hadir hari ini.</p>
                <?php endif; ?>
            </div>

        </div>
    </div>

</div>

</body>
</html>
