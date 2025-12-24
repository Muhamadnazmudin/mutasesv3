<?php
$headBg = "#e9ecef";
?>

<style>
table {
    border-collapse: collapse;
    font-size: 9px;
    table-layout: fixed;
    width: 100%;
}

th, td {
    border: 1px solid #000;
    padding: 2px;
    text-align: center;
    word-wrap: break-word;
}


.nisn, .status {
    white-space: nowrap;
}
.nama {
    text-align: left;
}

</style>

<div style="text-align:center; margin-top:-10px; margin-bottom:6px;">

    <!-- LOGO -->
    <img src="<?= FCPATH.'assets/img/logobonti.png' ?>" width="35" style="margin-bottom:2px;">

    <!-- JUDUL -->
    <div style="font-size:14px; font-weight:bold;">
        SMKN 1 CILIMUS
    </div>

    <div style="font-size:11px;">
        HASIL VERVAL DATA SISWA
    </div>

    <div style="font-size:10px; margin-top:2px;">
        Kelas : <b><?= $kelas_nama ?></b>
    </div>

</div>

<table>
    <!-- INI KUNCI UTAMA -->
    <colgroup>
        <col width="2%">
        <col width="8%">
        <col width="50%">
        <col width="10%">
        <col width="30%">
    </colgroup>

    <thead>
        <tr style="background:<?= $headBg ?>;">
            <th>No</th>
            <th>NISN</th>
            <th>Nama Siswa</th>
            <th>Status</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($siswa as $s): ?>
        <tr>
            <td><?= $no ?></td>
            <td><?= $s->nisn ?></td>
            <td class="nama"><?= strtoupper($s->nama) ?></td>
            <td>
                <?php
                    if ($s->status_verval == 1) echo 'VALID';
                    elseif ($s->status_verval == 2) echo 'PERBAIKAN';
                    else echo 'BELUM';
                ?>
            </td>
            <td class="nama"><?= $s->catatan_verval ?: '-' ?></td>
        </tr>
    <?php $no++; endforeach; ?>
    </tbody>
</table>

