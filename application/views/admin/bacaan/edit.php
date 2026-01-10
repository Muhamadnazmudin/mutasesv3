<div class="container-fluid">

    <h1 class="h4 mb-4 text-gray-800">
        <i class="fas fa-edit"></i> Edit Buku
    </h1>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            

            <form method="post"
      action="<?= site_url('AdminBacaan/update/'.$buku->id) ?>"
      enctype="multipart/form-data">
                 <input type="hidden"
           name="<?= $this->security->get_csrf_token_name(); ?>"
           value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul"
                           class="form-control"
                           value="<?= htmlspecialchars($buku->judul) ?>" required>
                </div>

                <div class="form-group">
                    <label>Kelas</label>
                    <select name="kelas" class="form-control">
                        <?php foreach (['Umum','X','XI','XII'] as $k): ?>
                            <option value="<?= $k ?>" <?= $buku->kelas==$k?'selected':'' ?>>
                                <?= $k ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Mapel</label>
                    <input type="text" name="mapel"
                           class="form-control"
                           value="<?= $buku->mapel ?>">
                </div>
                    <div class="form-group">
                        <label>Cover Buku</label>
                        <input type="file" name="cover"
                            class="form-control-file"
                            accept="image/*">
                        <small class="text-muted">
                            JPG / PNG, max 2MB
                        </small>
                    </div>

                    <?php if (!empty($buku->cover)) : ?>
                        <div class="mb-3">
                            <img src="<?= base_url('assets/uploads/cover_buku/'.$buku->cover) ?>"
                                alt="Cover Buku"
                                style="max-height:150px;border-radius:6px;">
                        </div>
                    <?php endif; ?>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="aktif" <?= $buku->status=='aktif'?'selected':'' ?>>Aktif</option>
                        <option value="nonaktif" <?= $buku->status=='nonaktif'?'selected':'' ?>>Nonaktif</option>
                    </select>
                </div>

                <button class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>

                <a href="<?= site_url('AdminBacaan') ?>"
                   class="btn btn-secondary">
                   Kembali
                </a>

            </form>

        </div>
    </div>
</div>
