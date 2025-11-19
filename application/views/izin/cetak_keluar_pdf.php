<style>
body { font-size: 8px; font-family: helvetica; }
.center { text-align:center; }
.table td { padding:1px 0; font-size:8px; }
.ttd td { font-size:8px; vertical-align:top; }
.line { border-top:1px solid #000; margin-top:10px; }
.garis-center {
    text-align: center;    /* container center */
    width: 100%;
    margin-top: 5px;
}

.garis-50 {
    display: inline-block; /* supaya bisa di-center */
    width: 10px;           /* panjang garis */
    border-bottom: 1px solid #000;
    height: 1px;
}

</style>

<div nobr="true">

<div class="center">
    <!-- <img src="<?= $logo ?>" width="30"><br> -->
    <b>PEMERINTAH DAERAH PROVINSI JAWA BARAT</b><br>
    DINAS PENDIDIKAN<br>
    CABANG DINAS PENDIDIKAN X<br>
    <b>SMK NEGERI 1 CILIMUS</b><br>
    <small>Jalan Baru Lingkar Caracas Cilimus</small><br>
    <small>Telp. (0232) 8910145 • Email: smkn_1cilimus@yahoo.com</small><br>
    <small>Kabupaten Kuningan 45556</small>
</div>

<hr>

<div class="center"><b>SURAT IZIN KELUAR</b></div>

<table width="100%" class="table">
    <tr><td width="28%">Nama Siswa</td><td>: <?= $izin->nama ?></td></tr>
    <tr><td>Kelas</td><td>: <?= $izin->kelas_nama ?></td></tr>
    <tr><td>Jam Keluar</td><td>: <?= $izin->jam_keluar ?></td></tr>
    <tr><td>Alasan</td><td>: <?= $izin->keperluan ?></td></tr>
    <tr><td>Guru Mapel</td><td>: <?= $guru_mapel->nama ?></td></tr>
</table>

<div class="center" style="margin:5px 0;">
    <img src="<?= $qr_image ?>" width="80">

    <br>
    <small>Scan untuk menandai siswa sudah kembali</small>
</div>

<table width="100%" class="ttd">
<tr>
    <td align="left"><br><br>
        Guru Mata Pelajaran,<br><br><br><br>
        <b><?= $guru_mapel->nama ?></b><br>
        NIP. <?= $guru_mapel->nip ?>
    </td>

    <td align="right">
        Kuningan, <?= date('d-m-Y') ?><br>
        Petugas Piket,<br><br><br><br>
        <b><?= $piket->nama ?></b><br>
        NIP. <?= $piket->nip ?>
    </td>
</tr>
</table>
<div class="center"><br>
    Yang dituju:<br>
    <b><?= $izin->ditujukan ?></b><br>
<br><br><br>
    <!-- garis 50px center menggunakan tabel -->
    <table align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td width="70"></td> <!-- spacer kiri -->
            <td width="75" style="border-bottom:1px solid #000;">&nbsp;</td>
            <td width="70"></td> <!-- spacer kanan -->
        </tr>
    </table>

</div>



