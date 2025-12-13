<h3>Rekap Kehadiran MBG — <?= $tanggal ?></h3>

<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr style="background:#eee">
            <th>No</th>
            <th>Kelas</th>
            <th>Total</th>
            <th>Hadir</th>
            <th>Tidak Hadir</th>
        </tr>
    </thead>

    <tbody>
        <?php $no=1; foreach ($rekap as $r): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $r['kelas'] ?></td>
            <td><?= $r['total'] ?></td>
            <td><?= $r['hadir'] ?></td>
            <td><?= $r['tidak_hadir'] ?></td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
