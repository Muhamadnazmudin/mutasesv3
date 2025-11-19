<style>
table {
    border-collapse: collapse;
    width: 100%;
    font-size: 10px;
}
table, th, td {
    border: 1px solid #444;
}
th {
    background: #eee;
    font-weight: bold;
    text-align: center;
}
td {
    padding: 3px;
    text-align: center;
}
.header {
    text-align: center;
    margin-bottom: 10px;
}
</style>

<div class="header">
    <h3>LAPORAN ABSENSI QR SISWA</h3>
    <p>
        Periode: <?= $dari ?> s/d <?= $sampai ?><br>
        Kelas: <?= $kelas_name ?>
    </p>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Kehadiran</th>
            <th>Jam Masuk</th>
            <th>Jam Pulang</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($absen as $r): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $r->nis ?></td>
            <td><?= $r->nama_siswa ?></td>
            <td><?= $r->tanggal ?></td>
            <td>
                <?php
                    switch($r->kehadiran){
                        case 'H': echo "Hadir"; break;
                        case 'S': echo "Sakit"; break;
                        case 'I': echo "Izin"; break;
                        case 'A': echo "Alpa"; break;
                        default: echo "-"; break;
                    }
                ?>
            </td>
            <td><?= $r->jam_masuk ?: '-' ?></td>
            <td><?= $r->jam_pulang ?: '-' ?></td>
            <td><?= $r->status ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
