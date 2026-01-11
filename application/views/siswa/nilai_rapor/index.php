<div class="container-fluid">

    <h4 class="mb-3">
        <i class="fas fa-clipboard-list"></i>
        Rekap Nilai Rapor
    </h4>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm">
            <thead class="thead-light text-center">
                <tr>
                    <th style="width:50px">No</th>
                    <th>Mata Pelajaran</th>
                    <th>Smt 1</th>
                    <th>Smt 2</th>
                    <th>Smt 3</th>
                    <th>Smt 4</th>
                    <th>Smt 5</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($nilai)): ?>
                    <?php $no = 1; foreach ($nilai as $n): ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $n->nama_mapel ?></td>
                            <td class="text-center"><?= $n->smt1 ?: '-' ?></td>
                            <td class="text-center"><?= $n->smt2 ?: '-' ?></td>
                            <td class="text-center"><?= $n->smt3 ?: '-' ?></td>
                            <td class="text-center"><?= $n->smt4 ?: '-' ?></td>
                            <td class="text-center"><?= $n->smt5 ?: '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Belum ada data nilai rapor.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
