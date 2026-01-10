<div class="container-fluid">

    <h1 class="h4 mb-4 text-gray-800">
        <i class="fas fa-book"></i> Daftar Buku
    </h1>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Cover</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($buku as $no => $b): ?>
                    <tr>
                        <td><?= $no+1 ?></td>
                        <td><?= htmlspecialchars($b->judul) ?></td>
                        <td><?= $b->kelas ?></td>
                        <td><?= $b->mapel ?: '-' ?></td>
                        <td>
                            <?php if ($b->cover): ?>
                                <img src="<?= base_url('assets/uploads/cover_buku/'.$b->cover) ?>"
                                    style="height:50px;border-radius:4px;">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                            </td>
                        <td>
                            <span class="badge badge-<?= $b->status=='aktif'?'success':'secondary' ?>">
                                <?= $b->status ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= site_url('AdminBacaan/edit/'.$b->id) ?>"
                               class="btn btn-warning btn-sm">
                               <i class="fas fa-edit"></i>
                            </a>

                            <a href="<?= site_url('AdminBacaan/delete/'.$b->id) ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus buku ini?')">
                               <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
