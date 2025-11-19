<style>
    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 11px;
    }
    th, td {
        border: 1px solid #000;
        padding: 3px;
        text-align: center;
    }
    .libur {
        background: #ffb3b3;
    }
    .judul {
        text-align: center;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 10px;
    }
</style>

<div class="judul">
    <img src="<?= base_url('assets/logo.png') ?>" width="70"><br>
    <div style="font-size:18px; font-weight:bold;">SMKN 1 CILIMUS</div>
    Laporan Absensi Siswa<br>
    Bulan: <b><?= date('F Y', strtotime($tanggal[0])) ?></b>,  
    Tahun Ajaran: <b>2025/2026</b><br>
    Kelas: <b><?= $kelas->nama ?></b>
</div>

<table>
    <thead>
        <tr>
            <th style="width:180px;">Nama Siswa</th>

            <?php foreach ($tanggal as $tgl): ?>
                <?php
                    $hari = date('N', strtotime($tgl));
                    $is_libur = in_array($tgl, $libur);
                    $class = ($hari == 6 || $hari == 7 || $is_libur) ? 'libur' : '';
                ?>
                <th class="<?= $class ?>"><?= date('d', strtotime($tgl)) ?></th>
            <?php endforeach; ?>

            <th>H</th>
            <th>S</th>
            <th>I</th>
            <th>A</th>
            <th>L</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($siswa as $s): ?>
            <?php
                $H = $S = $I = $A = $L = 0;
            ?>
            <tr>
                <td style="text-align:left;"><?= strtoupper($s->nama) ?></td>

                <?php foreach ($tanggal as $tgl): ?>

                    <?php
                        // weekend / hari libur = L
                        $hari = date('N', strtotime($tgl));
                        $is_libur = in_array($tgl, $libur);
                        $isWeekend = ($hari == 6 || $hari == 7);
                        $class = ($isWeekend || $is_libur) ? 'libur' : '';

                        if ($isWeekend || $is_libur) {
                            $val = "L";
                            $L++;
                        }
                        // hadir / sakit / izin / alpa dari QR
                        else if (isset($absen[$s->nis][$tgl])) {
                            $val = $absen[$s->nis][$tgl];

                            if ($val == "H") $H++;
                            if ($val == "S") $S++;
                            if ($val == "I") $I++;
                            if ($val == "A") $A++;
                        }
                        // tidak scan & tidak libur = alpa
                        else {
                            $val = "A";
                            $A++;
                        }
                    ?>

                    <td class="<?= $class ?>"><?= $val ?></td>

                <?php endforeach; ?>

                <td><?= $H ?></td>
                <td><?= $S ?></td>
                <td><?= $I ?></td>
                <td><?= $A ?></td>
                <td><?= $L ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
