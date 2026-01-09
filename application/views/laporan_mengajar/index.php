<div class="container-fluid">

    <h4 class="mb-4">
        <i class="fas fa-clipboard-list"></i> Laporan Mengajar Guru
    </h4>

    <!-- FILTER -->
    <form method="get" class="form-inline mb-3">
        <input type="date" name="tanggal"
               class="form-control mr-2"
               value="<?= $this->input->get('tanggal') ?>">

        <select name="guru_id" class="form-control mr-2">
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
                        <th>Selfie</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($laporan)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">
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
                        <td>
    <strong>
        <?= $l->jam_awal ?> – <?= $l->jam_akhir ?>
    </strong>
    <br>
    <small class="text-muted">
        <?= substr($l->jam_mulai_jadwal, 0, 5) ?> – <?= substr($l->jam_selesai_jadwal, 0, 5) ?>
    </small>
</td>

                        <td>
                            <?php if ($l->status == 'selesai'): ?>
                                <span class="badge badge-success">Selesai</span>
                            <?php else: ?>
                                <span class="badge badge-warning"><?= $l->status ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
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
