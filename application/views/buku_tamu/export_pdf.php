<h3 align="center">LAPORAN BUKU TAMU</h3>
<hr>

<table border="1" cellpadding="4" width="100%">
<tr style="background-color:#f2f2f2;">
    <th>No</th>
    <th>Tanggal</th>
    <th>Nama</th>
    <th>Instansi</th>
    <th>Jumlah Orang</th>
    <th>Tujuan</th>
    <th>Keperluan</th>
</tr>

<?php $no=1; foreach ($list as $r): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= date('d-m-Y H:i', strtotime($r->tanggal)) ?></td>
    <td><?= $r->nama_tamu ?></td>
    <td><?= $r->instansi ?></td>
    <td><?= $r->jumlah_orang ?></td>
    <td><?= $r->tujuan ?></td>
    <td><?= $r->keperluan ?></td>
</tr>
<?php endforeach; ?>
</table>
