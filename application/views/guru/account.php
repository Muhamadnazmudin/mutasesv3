<div class="container-fluid">
  <h4 class="mb-3">Profile</h4>

  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
  <?php elseif ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
  <?php endif; ?>

  <!-- FOTO PROFIL -->
  <div class="card mb-4">
    <div class="card-header bg-success text-white">Foto Profil</div>
    <div class="card-body text-center">

      <img src="<?= $user->foto 
        ? base_url('uploads/profile/'.$user->foto) 
        : base_url('assets/img/default-user.png') ?>"
        class="rounded-circle mb-3"
        width="120" height="120">

      <form method="post" enctype="multipart/form-data"
      action="<?= site_url('guru_account/upload_foto') ?>">

    <input type="hidden"
           name="<?= $this->security->get_csrf_token_name(); ?>"
           value="<?= $this->security->get_csrf_hash(); ?>">

    <input type="file" name="foto" class="form-control mb-2" required>

    <button class="btn btn-success btn-sm">Upload Foto</button>
</form>

    </div>
  </div>

  <!-- GANTI PASSWORD -->
  <div class="card">
    <div class="card-header bg-success text-white">Ganti Password</div>
    <div class="card-body">

      <form method="post" action="<?= site_url('guru_account/update_password') ?>">

    <input type="hidden"
           name="<?= $this->security->get_csrf_token_name(); ?>"
           value="<?= $this->security->get_csrf_hash(); ?>">

    <div class="form-group">
      <label>Password Baru</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <div class="form-group">
      <label>Konfirmasi Password</label>
      <input type="password" name="password_confirm" class="form-control" required>
    </div>

    <button class="btn btn-warning btn-sm">
      <i class="fas fa-key"></i> Update Password
    </button>
</form>


    </div>
  </div>

</div>
