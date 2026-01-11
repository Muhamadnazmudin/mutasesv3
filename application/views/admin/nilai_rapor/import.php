<div class="container-fluid">

<h4 class="mb-3">
    <i class="fas fa-file-excel"></i> Import Nilai Rapor (Excel)
</h4>

<?php if ($this->session->flashdata('error')): ?>
<div class="alert alert-danger">
    <?= $this->session->flashdata('error') ?>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
<div class="alert alert-success">
    <?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>
<a href="<?= site_url('Nilairapor_admin/download_template_lebar') ?>"
   class="btn btn-success mb-3">
   <i class="fas fa-download"></i> Download Template Excel
</a>
<form method="post"
      action="<?= site_url('Nilairapor_admin/import_proses_lebar') ?>"
      enctype="multipart/form-data">
      <input type="hidden"
           name="<?= $this->security->get_csrf_token_name(); ?>"
           value="<?= $this->security->get_csrf_hash(); ?>">

    <div class="form-group">
        <label>Semester</label>
        <select name="semester" class="form-control" required>
            <?php for ($i=1; $i<=6; $i++): ?>
                <option value="<?= $i ?>">Semester <?= $i ?></option>
            <?php endfor ?>
        </select>
    </div>

    <div class="form-group">
        <label>File Excel</label>
        <input type="file" name="file" class="form-control" accept=".xlsx" required>
        <small class="text-muted">
            Kolom A = NISN, kolom selanjutnya = mapel, isi dengan nilai.
        </small>
    </div>

    <button class="btn btn-success">
        <i class="fas fa-upload"></i> Import Nilai
    </button>
</form>


</div>
