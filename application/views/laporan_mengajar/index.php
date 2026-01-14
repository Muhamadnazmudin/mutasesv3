<div class="container-fluid">

    <h4 class="mb-4">
        <i class="fas fa-clipboard-list"></i> Laporan Mengajar Guru
    </h4>

    <!-- FILTER -->
    <form method="get" class="form-inline mb-3">

        <label class="mr-2">Dari</label>
        <input type="date" name="tanggal_awal"
               class="form-control mr-3"
               value="<?= $this->input->get('tanggal_awal') ?>">

        <label class="mr-2">Sampai</label>
        <input type="date" name="tanggal_akhir"
               class="form-control mr-3"
               value="<?= $this->input->get('tanggal_akhir') ?>">

        <select name="guru_id" class="form-control mr-3">
            <option value="">-- Semua Guru --</option>
            <?php foreach ($guru as $g): ?>
                <option value="<?= $g->id ?>"
                    <?= $this->input->get('guru_id') == $g->id ? 'selected' : '' ?>>
                    <?= $g->nama ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn btn-primary mr-2">
            <i class="fas fa-filter"></i> Filter
        </button>

        <a href="<?= site_url('laporan_mengajar') ?>" class="btn btn-secondary">
            <i class="fas fa-undo"></i> Reset Filter
        </a>
    </form>

    <!-- EXPORT -->
    <a href="<?= site_url('laporan_mengajar/export_pdf?' . http_build_query($_GET)) ?>"
       class="btn btn-danger mb-3">
        <i class="fas fa-file-pdf"></i> Export PDF
    </a>

    <!-- TABLE -->
    <div class="card shadow">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Guru</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th>Masuk</th>
                        <th>Keluar</th>
                        <th>Catatan</th>
                        <th>Selfie</th>
                        <?php if (is_admin()): ?>
                            <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>

                <?php if (empty($laporan)): ?>
                    <tr>
                        <td colspan="<?= is_admin() ? 12 : 11 ?>"
                            class="text-center text-muted">
                            Belum ada data
                        </td>
                    </tr>
                <?php else: ?>
                        <?php
$toleransi_masuk  = 10; // menit
$toleransi_keluar = 5;  // menit
?>

                <?php $no = 1; foreach ($laporan as $l): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $l->tanggal ?></td>
                        <td><?= $l->nama_guru ?></td>
                        <td><?= $l->nama_kelas ?></td>
                        <td><?= $l->nama_mapel ?></td>

                        <!-- JAM -->
                        <td>
                            <strong><?= $l->jam_awal ?> – <?= $l->jam_akhir ?></strong><br>
                            <small class="text-muted">
                                <?= substr($l->jam_mulai_jadwal,0,5) ?> –
                                <?= substr($l->jam_selesai_jadwal,0,5) ?>
                            </small>
                        </td>

                        <!-- STATUS -->
                        <td>
                            <?php if ($l->status_laporan === 'Selesai'): ?>
                                <span class="badge badge-success">Selesai</span>
                            <?php elseif ($l->status_laporan === 'Sedang Mengajar'): ?>
                                <span class="badge badge-info">Sedang Mengajar</span>
                            <?php else: ?>
                                <span class="badge badge-warning">
                                    <?= $l->status_laporan ?>
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- MASUK -->
<td>
    <?php if ($l->jam_mulai): ?>
        <?php
            $jadwalMasuk = strtotime($l->tanggal.' '.$l->jam_mulai_jadwal);
            $realMasuk   = strtotime($l->jam_mulai);

            // selisih real menit
            $selisihReal = floor(($realMasuk - $jadwalMasuk) / 60);

            // hitung setelah toleransi
            $telat = $selisihReal - $toleransi_masuk;
        ?>
        <strong><?= date('H:i', strtotime($l->jam_mulai)) ?></strong><br>
        <?php if ($telat > 0): ?>
            <small class="text-danger">
                Telat <?= $telat ?> menit
            </small>
        <?php else: ?>
            <small class="text-success">
                Tepat waktu
            </small>
        <?php endif; ?>
    <?php else: ?>
        <span class="text-muted">-</span>
    <?php endif; ?>
</td>

<!-- KELUAR -->
<td>
    <?php if ($l->jam_selesai): ?>
        <?php
            $jadwalKeluar = strtotime($l->tanggal.' '.$l->jam_selesai_jadwal);
            $realKeluar   = strtotime($l->jam_selesai);

            // selisih real menit (jadwal - real)
            $selisihReal = floor(($jadwalKeluar - $realKeluar) / 60);

            // hitung setelah toleransi
            $kurang = $selisihReal - $toleransi_keluar;
        ?>
        <strong><?= date('H:i', strtotime($l->jam_selesai)) ?></strong><br>
        <?php if ($kurang > 0): ?>
            <small class="text-danger">
                Kurang <?= $kurang ?> menit
            </small>
        <?php else: ?>
            <small class="text-success">
                Tepat waktu
            </small>
        <?php endif; ?>
    <?php else: ?>
        <span class="text-muted">-</span>
    <?php endif; ?>
</td>
<!-- CATATAN KELUAR -->
<td>
    <?php if (!empty($l->catatan_keluar)): ?>
        <span class="badge badge-danger d-block mb-1">
            Keluar Lebih Awal
        </span>

        <div class="small text-muted">
            <strong>Alasan:</strong><br>
            <?= nl2br(htmlspecialchars($l->catatan_keluar)) ?>
        </div>
    <?php else: ?>
        <span class="text-muted">-</span>
    <?php endif; ?>
</td>


                        <!-- SELFIE -->
                        <td class="text-center">
                            <?php if ($l->selfie): ?>
                                <a href="<?= base_url('uploads/selfie/'.$l->selfie) ?>"
                                   target="_blank"
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-image"></i>
                                </a>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>

                        <!-- AKSI RESET (ADMIN) -->
                        <?php if (is_admin()): ?>
                        <td class="text-center">
                            <a href="<?= site_url('laporan_mengajar/reset?' . http_build_query([
                                'tanggal' => $l->tanggal,
                                'guru'    => $l->nama_guru,
                                'mulai'   => $l->jam_mulai_jadwal,
                                'selesai' => $l->jam_selesai_jadwal
                            ])) ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm(
                                   'Yakin reset laporan <?= $l->nama_guru ?> tanggal <?= $l->tanggal ?>?'
                               )">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                        <?php endif; ?>

                    </tr>
                <?php endforeach; ?>
                <?php endif; ?>

                </tbody>
            </table>

        </div>
    </div>

</div>
