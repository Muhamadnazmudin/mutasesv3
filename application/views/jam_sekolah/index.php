<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">
        <h1 class="h5 text-gray-800">
            <i class="fas fa-clock"></i> Jam Sekolah
        </h1>
        <a href="<?= site_url('jam_sekolah/tambah') ?>" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Jam
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered table-sm">
                <thead class="bg-light">
                    <tr>
                        <th>Hari</th>
                        <th>Nama Jam</th>
                        <th>Waktu</th>
                        <th>Jenis</th>
                        <th>Target</th>
                        <th>Urutan</th>
                        <th width="8%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jam as $j): ?>
                    <tr>
                        <td><?= $j->hari ?></td>
                        <td><?= $j->nama_jam ?></td>
                        <td><?= $j->jam_mulai ?> - <?= $j->jam_selesai ?></td>
                        <td><?= $j->jenis ?></td>
                        <td><?= $j->target ?></td>
                        <td><?= $j->urutan ?></td>
                        <td class="text-center">
    <a href="<?= site_url('jam_sekolah/edit/'.$j->id_jam) ?>"
       class="btn btn-sm btn-warning mb-1">
       <i class="fas fa-edit"></i>
    </a>

    <a href="<?= site_url('jam_sekolah/delete/'.$j->id_jam) ?>"
       onclick="return confirm('Hapus data?')"
       class="btn btn-sm btn-danger">
       <i class="fas fa-trash"></i>
    </a>
</td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
