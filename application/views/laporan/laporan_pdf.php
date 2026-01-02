<h3>Laporan Mutasi Siswa Tahun <?= $tahun ?></h3>
<table border="1" width="100%" cellspacing="0" cellpadding="5">
<tr>
  <th>No</th><th>Nama</th><th>NIS</th><th>Jenis</th>
  <th>Tanggal</th><th>Tujuan</th>
</tr>
<?php $no=1; foreach($mutasi as $m): ?>
<tr>
  <td><?= $no++ ?></td>
  <td><?= $m->nama_siswa ?></td>
  <td><?= $m->nis ?></td>
  <td><?= $m->jenis ?></td>
  <td><?= $m->tanggal ?></td>
  <td><?= $m->tujuan_sekolah ?></td>
</tr>
<?php endforeach ?>
</table>
