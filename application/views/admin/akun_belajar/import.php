<div class="container-fluid">

<h4 class="mb-4">
    <i class="fas fa-file-excel"></i> Import Akun BelajarID
</h4>

<div class="card">
<div class="card-body">

<form method="post"
      action="<?= site_url('akun_belajar/import_process') ?>"
      enctype="multipart/form-data">

<input type="hidden"
       name="<?= $this->security->get_csrf_token_name(); ?>"
       value="<?= $this->security->get_csrf_hash(); ?>">

<div class="form-group">
    <label>File Excel</label>
    <input type="file"
           name="file"
           class="form-control"
           accept=".xls,.xlsx"
           required>
</div>

<div class="alert alert-info">
<b>Format Excel:</b><br>
Kolom B = NISN<br>
Kolom D = BelajarID<br>
Kolom E = Password default
</div>

<button class="btn btn-success">
    <i class="fas fa-upload"></i> Import
</button>

<a href="<?= site_url('akun_belajar') ?>"
   class="btn btn-secondary">
   Kembali
</a>

</form>

</div>
</div>

</div>
