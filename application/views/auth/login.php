<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Mutases</title>
  <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap.min.css') ?>">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
          <h4 class="m-0">Login Mutases</h4>
        </div>
        <div class="card-body">
          <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
          <?php endif; ?>

          <?= form_open('auth/login') ?>
  <input type="hidden" 
         name="<?= $this->security->get_csrf_token_name(); ?>" 
         value="<?= $this->security->get_csrf_hash(); ?>">
  
  <div class="form-group mb-3">
    <label>Username</label>
    <input type="text" name="username" class="form-control" required>
  </div>
  <div class="form-group mb-3">
    <label>Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <div class="form-group mb-3">
    <label>Tahun Ajaran</label>
    <select name="tahun_id" class="form-control" required>
      <option value="">-- Pilih Tahun Ajaran --</option>
      <?php foreach($tahun as $t): ?>
        <option value="<?= $t->id ?>"><?= $t->tahun ?><?= $t->aktif ? ' (Aktif)' : '' ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary w-100">Login</button>
<?= form_close() ?>

        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
