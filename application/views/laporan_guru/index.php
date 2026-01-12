<div class="card shadow-sm">
    <div class="card-header bg-danger text-white">
        <i class="fas fa-file-pdf"></i>
        <strong>Export Jurnal Mengajar (PDF)</strong>
    </div>

    <div class="card-body">
        <form method="get"
              action="<?= site_url('laporan_guru/export_pdf') ?>"
              target="_blank">

            <div class="form-row">

                <!-- BULAN -->
                <div class="form-group col-md-6">
                    <label for="bulan">Bulan</label>
                    <select name="bulan" id="bulan" class="form-control" required>
                        <?php
                        $bulanIndo = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                            4 => 'April', 5 => 'Mei', 6 => 'Juni',
                            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];

                        $bulanNow = date('n');
                        foreach ($bulanIndo as $num => $nama):
                        ?>
                            <option value="<?= $num ?>"
                                <?= $num == $bulanNow ? 'selected' : '' ?>>
                                <?= $nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- TAHUN -->
                <div class="form-group col-md-6">
                    <label for="tahun">Tahun</label>
                    <select name="tahun" id="tahun" class="form-control" required>
                        <?php
                        $tahunNow = date('Y');
                        for ($y = $tahunNow; $y >= 2020; $y--):
                        ?>
                            <option value="<?= $y ?>"
                                <?= $y == $tahunNow ? 'selected' : '' ?>>
                                <?= $y ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>

            </div>

            <!-- BUTTON -->
            <div class="text-right mt-3">
                <button type="submit" class="btn btn-danger btn-block btn-md">
                    <i class="fas fa-file-pdf"></i>
                    Generate Jurnal PDF
                </button>
            </div>

        </form>
    </div>
</div>
