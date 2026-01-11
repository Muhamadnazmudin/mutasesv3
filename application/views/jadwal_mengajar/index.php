<div class="container-fluid">

    <!-- ================= HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h5 text-gray-800">
            <i class="fas fa-calendar-alt"></i> Jadwal Mengajar Guru
        </h1>

        <div>
            <a href="<?= site_url('jadwal_mengajar/import') ?>" class="btn btn-sm btn-success">
                <i class="fas fa-file-excel"></i> Import Excel
            </a>
            <a href="<?= site_url('jadwal_mengajar/tambah') ?>" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah Jadwal
            </a>
        </div>
    </div>

    <!-- ================= FLASH MESSAGE ================= -->
    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle"></i>
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i>
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>
<form method="get" class="mb-3">
    <div class="row">

        <!-- Filter Hari -->
        <div class="col-md-3">
            <select name="hari" class="form-control form-control-sm">
                <option value="">-- Semua Hari --</option>
                <?php foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $h): ?>
                    <option value="<?= $h ?>"
                        <?= ($this->input->get('hari') == $h) ? 'selected' : '' ?>>
                        <?= $h ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Filter Guru -->
        <div class="col-md-4">
            <select name="guru_id" class="form-control form-control-sm">
                <option value="">-- Semua Guru --</option>
                <?php foreach ($guru as $g): ?>
                    <option value="<?= $g->id ?>"
                        <?= ($this->input->get('guru_id') == $g->id) ? 'selected' : '' ?>>
                        <?= $g->nama ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Filter Kelas -->
        <div class="col-md-3">
            <select name="kelas_id" class="form-control form-control-sm">
                <option value="">-- Semua Kelas --</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k->id ?>"
                        <?= ($this->input->get('kelas_id') == $k->id) ? 'selected' : '' ?>>
                        <?= $k->nama ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Tombol -->
        <div class="col-md-2">
            <button class="btn btn-sm btn-primary btn-block">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>

    </div>
</form>

    <!-- ================= TABLE ================= -->
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="bg-light text-center">
                        <tr>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Guru</th>
                            <th>Kelas</th>
                            <th>Mapel</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($jadwal)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Belum ada data jadwal mengajar
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($jadwal as $j): ?>
                                <tr>
                                    <td><?= $j->hari ?></td>
                                    <td>
                                        <?= $j->jam_awal ?> – <?= $j->jam_akhir ?><br>
                                        <small class="text-muted">
                                            (<?= substr($j->jam_mulai,0,5) ?>–<?= substr($j->jam_selesai,0,5) ?>)
                                        </small>
                                    </td>
                                    <td><?= $j->nama_guru ?></td>
                                    <td><?= $j->nama_kelas ?></td>
                                    <td><?= $j->nama_mapel ?></td>
                                    <td class="text-center">
                                        <a href="<?= site_url('jadwal_mengajar/edit/'.$j->id_jadwal
) ?>"
                                           class="btn btn-sm btn-warning"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="<?= site_url('jadwal_mengajar/delete/'.$j->id_jadwal
) ?>"
                                           class="btn btn-sm btn-danger"
                                           title="Hapus"
                                           onclick="return confirm('Yakin ingin menghapus jadwal ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
