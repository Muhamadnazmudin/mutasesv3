<div class="container-fluid">

  <h4 class="mb-3">Dashboard Guru</h4>

  <div class="alert alert-info">
    Selamat datang, <strong><?= $this->session->userdata('nama') ?></strong>
  </div>

  <?php if ($this->session->userdata('is_walikelas')): ?>
    <div class="card border-success mb-3">
      <div class="card-body bg-light">
        <h5 class="card-title text-success">
          <i class="fas fa-users"></i> Wali Kelas
        </h5>
        <p class="card-text">
          Anda adalah <strong>Wali Kelas <?= $this->session->userdata('kelas_nama') ?></strong>.
        </p>
        <a href="<?= site_url('walikelas') ?>" class="btn btn-success btn-sm">
          Masuk Menu Wali Kelas
        </a>
      </div>
    </div>
  <?php else: ?>
    <div class="alert alert-warning">
      Anda login sebagai <strong>Guru</strong>.
    </div>
  <?php endif; ?>

</div>
