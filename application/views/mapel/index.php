<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">
        <h1 class="h5 text-gray-800">
            <i class="fas fa-book"></i> Mata Pelajaran
        </h1>
        <div>
    <a href="<?= site_url('mapel/export_excel') ?>" class="btn btn-sm btn-success">
        <i class="fas fa-file-excel"></i> Export Excel
    </a>
    <a href="<?= site_url('mapel/import') ?>" class="btn btn-sm btn-info">
        <i class="fas fa-upload"></i> Import Excel
    </a>
    <a href="<?= site_url('mapel/tambah') ?>" class="btn btn-sm btn-primary">
        <i class="fas fa-plus"></i> Tambah Mapel
    </a>
</div>

    </div>

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered table-sm">
                <thead class="bg-light">
                    <tr>
                        <th width="5%">ID</th>
                        <th>Nama Mata Pelajaran</th>
                        <th width="20%">Kelompok</th>
                        <th width="10%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($mapel)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Belum ada data
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($mapel as $m): ?>
                    <tr>
                        <td><?= $m->id_mapel ?></td>
                        <td><?= $m->nama_mapel ?></td>
                        <td><?= $m->kelompok ?: '-' ?></td>
                        <td>
                            <span class="badge badge-success">Aktif</span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
