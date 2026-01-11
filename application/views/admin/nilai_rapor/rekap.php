<div class="container-fluid">

    <h4 class="mb-3">
        <i class="fas fa-list"></i> Daftar / Rekap Nilai Rapor
    </h4>

    <!-- Filter -->
    <form method="get" class="row mb-4">
        <div class="col-md-3">
            <select name="kelas" class="form-control">
                <option value="">-- Semua Kelas --</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k->id ?>"
                        <?= ($this->input->get('kelas') == $k->id) ? 'selected' : '' ?>>
                        <?= $k->nama ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="col-md-3">
            <select name="mapel" class="form-control">
                <option value="">-- Semua Mapel --</option>
                <?php foreach ($mapel as $m): ?>
                    <option value="<?= $m->id_mapel ?>"
                        <?= ($this->input->get('mapel') == $m->id_mapel) ? 'selected' : '' ?>>
                        <?= $m->nama_mapel ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </form>

    <!-- Tabel Rekap -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm">
            <thead class="thead-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Mata Pelajaran</th>
                    <th>Smt 1</th>
                    <th>Smt 2</th>
                    <th>Smt 3</th>
                    <th>Smt 4</th>
                    <th>Smt 5</th>
                    <th>Smt 6</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($rekap)): ?>
                    <?php $no = 1; foreach ($rekap as $r): 
                        $smt1 = (int) $r->smt1;
                        $smt2 = (int) $r->smt2;
                        $smt3 = (int) $r->smt3;
                        $smt4 = (int) $r->smt4;
                        $smt5 = (int) $r->smt5;
                        $smt6 = (int) $r->smt6;
                        $total = $smt1 + $smt2 + $smt3 + $smt4 + $smt5 + $smt6;
                    ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $r->nama_siswa ?></td>
                        <td><?= $r->nama_kelas ?></td>
                        <td><?= $r->nama_mapel ?: '-' ?></td>
                        <td class="text-center"><?= $smt1 ?></td>
                        <td class="text-center"><?= $smt2 ?></td>
                        <td class="text-center"><?= $smt3 ?></td>
                        <td class="text-center"><?= $smt4 ?></td>
                        <td class="text-center"><?= $smt5 ?></td>
                        <td class="text-center"><?= $smt6 ?></td>
                        <td class="text-center font-weight-bold"><?= $total ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="11" class="text-center text-muted">
                            Data nilai belum tersedia.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="<?= site_url('Nilairapor_admin') ?>" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Kembali ke Input Nilai
    </a>

</div>
