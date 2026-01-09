<div class="container-fluid">

    <h1 class="h5 mb-4 text-success">
        <i class="fas fa-calendar-alt"></i> Jadwal Mengajar Saya
    </h1>

    <div class="card shadow">
        <div class="card-body">

            <?php if (empty($jadwal)): ?>
                <div class="alert alert-info">
                    Belum ada jadwal mengajar.
                </div>
            <?php else: ?>

            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="bg-success text-white">
                        <tr>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jadwal as $j): ?>
                        <tr>
                            <td><?= $j->hari ?></td>
                            <td>
    <?= $j->jam_awal ?> – <?= $j->jam_akhir ?><br>
    <small class="text-muted">
        <?= substr($j->jam_mulai, 0, 5) ?> – <?= substr($j->jam_selesai, 0, 5) ?>
    </small>
</td>

                            <td><?= $j->nama_kelas ?></td>
                            <td><?= $j->nama_mapel ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php endif; ?>

        </div>
    </div>

</div>
