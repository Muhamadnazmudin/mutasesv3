<style>
body { font-size: 8px; font-family: helvetica; }
.center { text-align:center; }
.table td { padding:2px 0; font-size:8px; }
.ttd3 td { text-align:center; font-size:8px; }
</style>

<div class="center">
    <img src="<?= $logo ?>" width="35"><br>
    <b>PEMERINTAH DAERAH PROVINSI JAWA BARAT</b><br>
    DINAS PENDIDIKAN<br>
    CABANG DINAS PENDIDIKAN X<br>
    <b>SMK NEGERI 1 CILIMUS</b><br>
    <small>Jalan Baru Lingkar Caracas Cilimus</small><br>
    <small>Telp. (0232) 8910145 • Email: smkn_1cilimus@yahoo.com</small><br>
    <small>Kabupaten Kuningan 45556</small>
</div>

<hr>

<div class="center"><b>SURAT IZIN PULANG</b></div>

<table width="100%" class="table">
    <tr><td width="30%">Nama Siswa</td><td>: <?= $izin->nama ?></td></tr>
    <tr><td>Kelas</td><td>: <?= $izin->kelas_nama ?></td></tr>
    <tr><td>Jam Pulang</td><td>: <?= $izin->jam_keluar ?></td></tr>
    <tr><td>Alasan</td><td>: <?= $izin->keperluan ?></td></tr>
</table>

<br>

<table width="100%" class="ttd3">
<tr>
    <td>
        Guru Mapel,<br><br><br>
        <b><?= $guru_mapel->nama ?></b><br>
        NIP. <?= $guru_mapel->nip ?>
    </td>

    <td>
        Petugas Piket,<br><br><br>
        <b><?= $piket->nama ?></b><br>
        NIP. <?= $piket->nip ?>
    </td>

    <td>
        Wali Kelas,<br><br><br>
        <b><?= $walikelas->nama ?></b><br>
        NIP. <?= $walikelas->nip ?>
    </td>
</tr>
</table>
