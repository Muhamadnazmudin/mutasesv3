<div class="container-fluid">
    <h1 class="h4 mb-4">🏫 Pengaturan Sekolah</h1>

    <?php if ($total == 0): ?>
        <a href="<?= base_url('sekolah/tambah') ?>" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Tambah Data Sekolah
        </a>
    <?php endif; ?>

    <?php if ($sekolah): ?>
        <table class="table table-bordered">
            <tr>
                <th width="200">Nama Sekolah</th>
                <td><?= $sekolah->nama_sekolah ?></td>
            </tr>
            <tr>
                <th>NPSN</th>
                <td><?= $sekolah->npsn ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>
                    <?= $sekolah->alamat ?><br>
                    Desa <?= $sekolah->desa ?>,
                    Kec. <?= $sekolah->kecamatan ?>,
                    <?= $sekolah->kabupaten ?>
                </td>
            </tr>
            <tr>
                <th>Koordinat</th>
                <td><?= $sekolah->latitude ?> , <?= $sekolah->longitude ?></td>
            </tr>
            <tr>
                <th>Kepala Sekolah</th>
                <td><?= $sekolah->nama_kepala_sekolah ?> (<?= $sekolah->nip_kepala_sekolah ?>)</td>
            </tr>
            <tr>
                <th>Logo</th>
                <td>
                    <?php if ($sekolah->logo): ?>
                        <img src="<?= base_url('uploads/logo/'.$sekolah->logo) ?>" height="80">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Aksi</th>
                <td>
                    <a href="<?= base_url('sekolah/edit/'.$sekolah->id) ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?= base_url('sekolah/hapus/'.$sekolah->id) ?>"
                       onclick="return confirm('Hapus data sekolah?')"
                       class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Hapus
                    </a>
                </td>
            </tr>
        </table>
    <?php else: ?>
        <div class="alert alert-info">
            Data sekolah belum diinput.
        </div>
    <?php endif; ?>
</div>
