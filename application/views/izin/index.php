<div class="container-fluid mt-4">


<h3 class="mb-3">Data Izin Siswa</h3>
<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<hr>

<div class="table-responsive shadow-sm rounded">
<table class="table table-striped table-bordered align-middle">
    <thead class="table-dark">
        <tr class="text-center">
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jenis Izin</th>
            <th>Keperluan</th>
            <th>Keluar</th>
            <th>Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
    <?php 
        $no = $start + 1;
        foreach($izin as $i): 
    ?>
        <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td><?= $i->nama ?></td>
            <td class="text-center"><?= $i->kelas_nama ?></td>

            <td class="text-center">
                <?php if ($i->jenis_izin == 'pulang'): ?>
                    <span class="badge bg-danger">Pulang</span>
                <?php else: ?>
                    <span class="badge bg-primary">Keluar</span>
                <?php endif; ?>
            </td>

            <td><?= $i->keperluan ?></td>
            <td class="text-center"><?= $i->jam_keluar ?></td>
            <td class="text-center"><?= $i->jam_masuk ?: '-' ?></td>

            <td class="text-center">
                <?php if ($i->jenis_izin == 'pulang'): ?>
                    <span class="badge bg-danger">Pulang</span>

                <?php elseif ($i->status == 'keluar'): ?>
                    <span class="badge bg-warning text-dark">Belum Kembali</span>

                <?php else: ?>
                    <span class="badge bg-success">Kembali</span>
                <?php endif; ?>
            </td>

            <td class="text-center">

                <!-- CETAK -->
                <a href="<?= base_url('index.php/izin/cetak/' . $i->id) ?>" 
                   target="_blank"
                   class="btn btn-sm btn-success mb-1">
                    Cetak
                </a>

                <!-- EDIT -->
                <a href="<?= base_url('index.php/izin/edit/' . $i->id) ?>" 
                   class="btn btn-sm btn-warning mb-1">
                    Edit
                </a>

                <!-- DELETE -->
                <a href="<?= base_url('index.php/izin/delete/' . $i->id) ?>" 
   class="btn btn-danger btn-sm"
   onclick="return confirm('Yakin ingin menghapus data ini?')">
   Hapus
</a>

                <a href="<?= base_url('index.php/izin/pdf/' . $i->id) ?>" 
   target="_blank"
   class="btn btn-sm btn-info mb-1">
   PDF
</a>

            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>

<div class="mt-3 d-flex justify-content-center">
    <?= $pagination ?>
</div>

</div>
<script>
    setTimeout(function() {
        let alertNode = document.querySelector('.alert');
        if (alertNode) {
            var alert = new bootstrap.Alert(alertNode);
            alert.close();
        }
    }, 3000);
</script>
