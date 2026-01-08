<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">
        <h1 class="h5 text-gray-800">
            <i class="fas fa-calendar-alt"></i> Jadwal Mengajar Guru
        </h1>
        <a href="<?= site_url('jadwal_mengajar/tambah') ?>" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Jadwal
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-sm">
                <thead class="bg-light">
                    <tr>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Guru</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jadwal as $j): ?>
                    <tr>
                        <td><?= $j->hari ?></td>
                        <td><?= $j->nama_jam ?> (<?= $j->jam_mulai ?>–<?= $j->jam_selesai ?>)</td>
                        <td><?= $j->nama_guru ?></td>
                        <td><?= $j->nama_kelas ?></td>
                        <td><?= $j->nama_mapel ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
