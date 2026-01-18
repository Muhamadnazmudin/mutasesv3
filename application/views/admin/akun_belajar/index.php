<form method="get" class="form-inline mb-3">

<input type="text"
       name="nama"
       value="<?= html_escape($nama) ?>"
       class="form-control mr-2"
       placeholder="Cari Nama Siswa">

<select name="kelas" class="form-control mr-2">
    <option value="">Semua Kelas</option>
    <?php foreach ($list_kelas as $k): ?>
        <option value="<?= $k->id ?>"
            <?= ($kelas_id == $k->id) ? 'selected' : '' ?>>
            <?= $k->nama ?>
        </option>
    <?php endforeach ?>
</select>

<button class="btn btn-primary mr-2">
    <i class="fas fa-search"></i> Filter
</button>

<a href="<?= site_url('akun_belajar/import') ?>" class="btn btn-success">
    <i class="fas fa-file-excel"></i> Import Excel
</a>

</form>
<table class="table table-bordered table-hover">
<thead class="thead-light">
<tr>
    <th>NISN</th>
    <th>Nama</th>
    <th>Kelas</th>
    <th>BelajarID</th>
    <th>Password Default</th>
    <th>Status</th>
    <th>Subscribe</th>
    <th width="320">Aksi</th>
</tr>
</thead>
<tbody>

<?php foreach ($siswa as $s): ?>
<tr>

<td><?= $s->nisn ?></td>
<td><?= $s->nama ?></td>
<td><?= $s->nama_kelas ?: '-' ?></td>

<td><?= $s->email_belajar ?: '-' ?></td>
<td><?= $s->password_default ?: '-' ?></td>

<!-- STATUS AKUN -->
<td>
<?php if ($s->email_belajar): ?>
    <span class="badge badge-success">Tersimpan</span>
<?php else: ?>
    <span class="badge badge-secondary">Belum</span>
<?php endif ?>
</td>

<!-- STATUS SUBSCRIBE -->
<td>
<?php if (!empty($s->sudah_subscribe)): ?>
    <span class="badge badge-success">Sudah</span>
<?php else: ?>
    <span class="badge badge-warning">Belum</span>
<?php endif ?>
</td>

<!-- AKSI -->
<td>

<!-- FORM SIMPAN / UPDATE -->
<form method="post"
      action="<?= site_url('akun_belajar/simpan') ?>"
      class="form-inline mb-1">

<input type="hidden"
       name="<?= $this->security->get_csrf_token_name(); ?>"
       value="<?= $this->security->get_csrf_hash(); ?>">

<input type="hidden" name="nisn" value="<?= $s->nisn ?>">

<input type="email"
       name="email_belajar"
       value="<?= $s->email_belajar ?>"
       class="form-control form-control-sm mr-1 mb-1"
       placeholder="email@belajar.id"
       required>

<input type="text"
       name="password_default"
       value="<?= $s->password_default ?>"
       class="form-control form-control-sm mr-1 mb-1"
       placeholder="Password default"
       required>

<button class="btn btn-sm btn-primary mr-1 mb-1">
    <?= $s->email_belajar ? 'Update' : 'Simpan' ?>
</button>

<?php if ($s->email_belajar): ?>
<a href="<?= site_url('akun_belajar/hapus/'.$s->nisn) ?>"
   onclick="return confirm('Hapus data BelajarID ini?')"
   class="btn btn-sm btn-danger mb-1">
   Hapus
</a>
<?php endif ?>

</form>

<!-- FORM RESET SUBSCRIBE (TERPISAH) -->
<?php if (!empty($s->sudah_subscribe)): ?>
<form method="post"
      action="<?= site_url('akun_belajar/reset_subscribe') ?>"
      style="display:inline">

    <input type="hidden"
           name="<?= $this->security->get_csrf_token_name(); ?>"
           value="<?= $this->security->get_csrf_hash(); ?>">

    <input type="hidden" name="nisn" value="<?= $s->nisn ?>">

    <button type="submit"
            class="btn btn-sm btn-warning"
            onclick="return confirm('Reset status subscribe siswa ini?')">
        <i class="fas fa-undo"></i> Reset Subscribe
    </button>
</form>
<?php endif ?>

</td>
</tr>
<?php endforeach ?>

</tbody>
</table>

<?php $total_page = ceil($total / $limit); ?>

<nav>
<ul class="pagination justify-content-center">

<?php for ($i = 0; $i < $total_page; $i++): ?>
<li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
    <a class="page-link"
       href="?page=<?= $i ?>&nama=<?= urlencode($nama) ?>&kelas=<?= urlencode($kelas_id) ?>">
       <?= $i + 1 ?>
    </a>
</li>
<?php endfor ?>

</ul>
</nav>
