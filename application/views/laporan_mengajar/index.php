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

    <button class="btn btn-primary">
        <i class="fas fa-filter"></i> Filter
    </button>
</form>


    <a href="<?= site_url('laporan_mengajar/export_pdf?'.http_build_query($_GET)) ?>"
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
                        <th>Selfie</th>
                    </tr>
                </thead>
                <tbody>

                <?php if (empty($laporan)): ?>
                    <tr>
                        <td colspan="10" class="text-center text-muted">
                            Belum ada data
                        </td>
                    </tr>
                <?php else: ?>

                <?php $no=1; foreach ($laporan as $l): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $l->tanggal ?></td>
                        <td><?= $l->nama_guru ?></td>
                        <td><?= $l->nama_kelas ?></td>
                        <td><?= $l->nama_mapel ?></td>

                        <!-- JAM JADWAL -->
                        <td>
                            <strong><?= $l->jam_awal ?> – <?= $l->jam_akhir ?></strong><br>
                            <small class="text-muted">
                                <?= substr($l->jam_mulai_jadwal,0,5) ?> – <?= substr($l->jam_selesai_jadwal,0,5) ?>
                            </small>
                        </td>

                        <!-- STATUS -->
                        <td>
                            <?php if ($l->status_laporan === 'selesai'): ?>
                                <span class="badge badge-success">Selesai</span>
                            <?php elseif ($l->status_laporan === 'mulai'): ?>
                                <span class="badge badge-info">Sedang Mengajar</span>
                            <?php else: ?>
                                <span class="badge badge-warning"><?= $l->status_laporan ?></span>
                            <?php endif; ?>
                        </td>

                        <!-- MASUK -->
                        <td>
                                <?php if ($l->jam_mulai): ?>
                                    <?php
                                        $jadwalMasuk = strtotime($l->tanggal.' '.$l->jam_mulai_jadwal);
                                        $realMasuk   = strtotime($l->jam_mulai);
                                        $selisih     = floor(($realMasuk - $jadwalMasuk) / 60);
                                    ?>

                                    <div>
                                        <strong><?= date('H:i', strtotime($l->jam_mulai)) ?></strong>
                                    </div>

                                    <div>
                                        <?php if ($selisih > 0): ?>
                                            <small class="text-danger">
                                                Telat <?= $selisih ?> menit
                                            </small>
                                        <?php elseif ($selisih == 0): ?>
                                            <small class="text-success">
                                                Tepat waktu
                                            </small>
                                        <?php else: ?>
                                            <small class="text-success font-weight-bold">
                                                Sangat tepat (<?= abs($selisih) ?> menit lebih awal)
                                            </small>
                                        <?php endif; ?>
                                    </div>

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
                                    $selisih      = floor(($realKeluar - $jadwalKeluar) / 60);
                                ?>

                                <div>
                                    <strong><?= date('H:i', strtotime($l->jam_selesai)) ?></strong>
                                </div>

                                <div>
                                    <?php if ($selisih < 0): ?>
                                        <small class="text-danger">
                                            Kurang <?= abs($selisih) ?> menit
                                        </small>
                                    <?php elseif ($selisih == 0): ?>
                                        <small class="text-success">
                                            Tepat waktu
                                        </small>
                                    <?php else: ?>
                                        <small class="text-success font-weight-bold">
                                            Lebih <?= $selisih ?> menit (Good)
                                        </small>
                                    <?php endif; ?>
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

                    </tr>
                <?php endforeach; ?>

                <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
