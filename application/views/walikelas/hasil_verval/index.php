<div class="container-fluid">
    <h1 class="h4 mb-4">Hasil Verval Siswa</h1>

    <!-- ================= REKAP ================= -->
    <div class="card shadow mb-4">
        <div class="card-body table-responsive">

            <?php if ($laporan):
                $persen = ($laporan->total_siswa > 0)
                    ? round(($laporan->sudah_verval / $laporan->total_siswa) * 100, 1)
                    : 0;
            ?>
            
            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>Kelas</th>
                        <th class="text-center">Total</th>
                        <th class="text-center text-success">Valid</th>
                        <th class="text-center text-warning">Perbaikan</th>
                        <th class="text-center text-primary">Sudah</th>
                        <th class="text-center text-danger">Belum</th>
                        <th width="20%" class="text-center">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= htmlspecialchars($laporan->nama_kelas) ?></td>
                        <td class="text-center font-weight-bold"><?= $laporan->total_siswa ?></td>
                        <td class="text-center text-success font-weight-bold"><?= $laporan->valid ?></td>
                        <td class="text-center text-warning font-weight-bold"><?= $laporan->perbaikan ?></td>
                        <td class="text-center text-primary font-weight-bold"><?= $laporan->sudah_verval ?></td>
                        <td class="text-center text-danger font-weight-bold"><?= $laporan->belum_verval ?></td>
                        <td>
                            <div class="progress" style="height:18px">
                                <div class="progress-bar bg-success"
                                     style="width:<?= $persen ?>%">
                                    <?= $persen ?>%
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php endif; ?>

        </div>
    </div>

    <!-- ================= DAFTAR SISWA ================= -->
    <div class="card shadow">
        <div class="card-body table-responsive">
                <div class="mb-3">
    <a href="<?= site_url('hasilverval/export_pdf') ?>"
       class="btn btn-sm btn-danger">
        <i class="fas fa-file-pdf"></i> Export PDF
    </a>

    <a href="<?= site_url('hasilverval/export_excel') ?>"
       class="btn btn-sm btn-success">
        <i class="fas fa-file-excel"></i> Export Excel
    </a>
</div>

            <table class="table table-bordered table-hover table-sm align-middle">
                <thead class="thead-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th width="15%" class="text-center">Status</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1; foreach ($siswa as $s): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($s->nisn) ?></td>
                        <td><?= htmlspecialchars($s->nama) ?></td>
                        <td class="text-center">
                            <?php if ($s->status_verval == 1): ?>
                                <span class="badge badge-success px-3">Valid</span>
                            <?php elseif ($s->status_verval == 2): ?>
                                <span class="badge badge-warning px-3">Perbaikan</span>
                            <?php else: ?>
                                <span class="badge badge-secondary px-3">Belum</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($s->status_verval == 2 && $s->catatan_verval): ?>
                                <span title="<?= htmlspecialchars($s->catatan_verval) ?>">
                                    <?= htmlspecialchars($s->catatan_verval) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
