<style>
  body.light-mode .card {
	border: none !important;
	border-radius: 0.35rem !important;
	box-shadow: 0 0.15rem 1.75rem rgba(58, 59, 69, 0.15) !important;
	background-color: #ffffff !important;
}

body.light-mode .shadow,
body.light-mode .shadow-sm,
body.light-mode .shadow-lg {
	box-shadow: 0 0.15rem 1.75rem rgba(58, 59, 69, 0.15) !important;
}

body.light-mode .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
body.light-mode .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
body.light-mode .border-left-info    { border-left: 0.25rem solid #36b9cc !important; }
body.light-mode .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
body.light-mode .border-left-danger  { border-left: 0.25rem solid #e74a3b !important; }

body.light-mode .row > [class^="col-"] {
	border: none !important;
}
</style>
<style>
/* ================= DASHBOARD TOP CARDS ================= */
.dashboard-card {
  border-radius: 14px;
  color: #fff;
  position: relative;
  overflow: hidden;
  transition: all .25s ease;
}

.dashboard-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 25px rgba(0,0,0,.18);
}

.dashboard-card .card-body {
  padding: 1.6rem;
}

.dashboard-card .card-title {
  font-size: .85rem;
  text-transform: uppercase;
  letter-spacing: .8px;
  opacity: .9;
  margin-bottom: .25rem;
}

.dashboard-card .card-value {
  font-size: 2.2rem;
  font-weight: 700;
  line-height: 1.2;
}

.dashboard-card .card-icon {
  position: absolute;
  right: 18px;
  bottom: 18px;
  font-size: 3.8rem;
  opacity: .18;
}

/* Gradients */
.bg-guru {
  background: linear-gradient(135deg,#1cc88a,#13855c);
}
.bg-siswa {
  background: linear-gradient(135deg,#36b9cc,#258391);
}
.bg-rombel {
  background: linear-gradient(135deg,#f6c23e,#c69500);
}
</style>

<?php if ($this->session->userdata('logged_in')): ?>
<div class="text-center mt-4 mb-5">
  <h3>Selamat Datang, <?= $this->session->userdata('nama'); ?> 👋</h3>
  <p class="text-muted">
    Anda login sebagai <strong><?= ucfirst($this->session->userdata('role_name')); ?></strong><br>
    Tahun Ajaran Aktif: <strong>
      <?php
        $tahun_id = $this->session->userdata('tahun_id');
        $tahun = $this->db->get_where('tahun_ajaran', ['id' => $tahun_id])->row();
        echo $tahun ? $tahun->tahun : '-';
      ?>
    </strong>
  </p>
</div>
<?php endif; ?>

<div class="row mb-4">

  <!-- JUMLAH GURU -->
  <div class="col-xl-4 col-md-6 mb-3">
    <div class="card dashboard-card bg-guru h-100">
      <div class="card-body">
        <div class="card-title">Jumlah Guru</div>
        <div class="card-value"><?= $jumlah_guru ?></div>
        <i class="fas fa-chalkboard-teacher card-icon"></i>
      </div>
    </div>
  </div>

  <!-- SISWA AKTIF -->
  <div class="col-xl-4 col-md-6 mb-3">
    <div class="card dashboard-card bg-siswa h-100">
      <div class="card-body">
        <div class="card-title">Peserta Didik Aktif</div>
        <div class="card-value"><?= number_format($jumlah_siswa_aktif,0,',','.') ?></div>
        <i class="fas fa-user-graduate card-icon"></i>
      </div>
    </div>
  </div>

  <!-- JUMLAH ROMBEL -->
  <div class="col-xl-4 col-md-6 mb-3">
    <div class="card dashboard-card bg-rombel h-100">
      <div class="card-body">
        <div class="card-title">Jumlah Rombel</div>
        <div class="card-value"><?= $jumlah_rombel ?></div>
        <i class="fas fa-school card-icon"></i>
      </div>
    </div>
  </div>

</div>


<div class="row g-4 mb-4">

  <!-- JUMLAH ROMBEL -->
  <div class="col-md-6">
    <div class="card border-left-primary shadow-sm h-100">
      <div class="card-body">
        <h5 class="fw-bold text-primary mb-3"><i class="fas fa-school"></i> Jumlah Rombel / Kelas</h5>
        <table class="table table-bordered table-sm mb-0">
          <thead class="table-light"><tr><th>Tingkat</th><th>Jumlah</th></tr></thead>
          <tbody>
            <tr><td>Kelas X</td><td><?= $rombel['x'] ?></td></tr>
            <tr><td>Kelas XI</td><td><?= $rombel['xi'] ?></td></tr>
            <tr><td>Kelas XII</td><td><?= $rombel['xii'] ?></td></tr>
            <tr class="table-secondary fw-bold"><td>Total</td><td><?= $rombel['total'] ?></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- SISWA AKTIF -->
  <div class="col-md-6">
    <div class="card border-left-success shadow-sm h-100">
      <div class="card-body">
        <h5 class="fw-bold text-success mb-3"><i class="fas fa-user-graduate"></i> Siswa Aktif</h5>
        <table class="table table-bordered table-sm mb-0">
          <thead class="table-light"><tr><th>Tingkat</th><th>Jumlah</th></tr></thead>
          <tbody>
            <tr><td>Kelas X</td><td><?= $aktif['x'] ?></td></tr>
            <tr><td>Kelas XI</td><td><?= $aktif['xi'] ?></td></tr>
            <tr><td>Kelas XII</td><td><?= $aktif['xii'] ?></td></tr>
            <tr class="table-secondary fw-bold"><td>Total</td><td><?= $aktif['total'] ?></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>


 <div class="row g-4 mb-4">

  <!-- SISWA KELUAR -->
  <div class="col-md-6">
    <div class="card border-left-danger shadow-sm h-100">
      <div class="card-body">
        <h5 class="fw-bold text-danger mb-3"><i class="fas fa-door-open"></i> Siswa Keluar</h5>
        <table class="table table-bordered table-sm mb-0">
          <thead class="table-light"><tr><th>Tingkat</th><th>Jumlah</th></tr></thead>
          <tbody>
            <tr><td>Kelas X</td><td><?= $keluar['x'] ?></td></tr>
            <tr><td>Kelas XI</td><td><?= $keluar['xi'] ?></td></tr>
            <tr><td>Kelas XII</td><td><?= $keluar['xii'] ?></td></tr>
            <tr class="table-secondary fw-bold"><td>Total</td><td><?= $keluar['total'] ?></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- SISWA MASUK -->
  <div class="col-md-6">
    <div class="card border-left-info shadow-sm h-100">
      <div class="card-body">
        <h5 class="fw-bold text-info mb-3"><i class="fas fa-door-closed"></i> Siswa Masuk</h5>
        <table class="table table-bordered table-sm mb-0">
          <thead class="table-light"><tr><th>Tingkat</th><th>Jumlah</th></tr></thead>
          <tbody>
            <tr><td>Kelas X</td><td><?= $masuk['x'] ?></td></tr>
            <tr><td>Kelas XI</td><td><?= $masuk['xi'] ?></td></tr>
            <tr><td>Kelas XII</td><td><?= $masuk['xii'] ?></td></tr>
            <tr class="table-secondary fw-bold"><td>Total</td><td><?= $masuk['total'] ?></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<!-- SISWA LULUS -->
<div class="card shadow-sm border-left-warning mb-4">
  <div class="card-body">
    <h5 class="fw-bold text-warning mb-3"><i class="fas fa-graduation-cap"></i> Siswa Lulus per Tahun Ajaran</h5>
    <table class="table table-bordered table-sm mb-0">
      <thead class="table-light"><tr><th>Tahun Ajaran</th><th>Jumlah Siswa Lulus</th></tr></thead>
      <tbody>
        <?php if ($lulus): foreach ($lulus as $r): ?>
          <tr><td><?= $r->tahun ?></td><td><?= $r->jumlah ?></td></tr>
        <?php endforeach; else: ?>
          <tr><td colspan="2" class="text-center text-muted">Belum ada data siswa lulus.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<!-- CHARTS SECTION -->
<div class="row mt-4">
  <div class="col-md-8">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="fw-bold text-primary mb-3"><i class="fas fa-chart-bar"></i> Grafik Siswa per Tingkat</h5>
        <canvas id="chartAktifKeluar" height="100"></canvas>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="fw-bold text-info mb-3"><i class="fas fa-chart-pie"></i> Rasio Aktif vs Keluar</h5>
        <canvas id="chartRasio" height="200"></canvas>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script>
var ctx1 = document.getElementById('chartAktifKeluar').getContext('2d');
new Chart(ctx1, {
  type: 'bar',
  data: {
    labels: ['Kelas X', 'Kelas XI', 'Kelas XII'],
    datasets: [
      {
        label: 'Siswa Aktif',
        data: [<?= $aktif['x'] ?>, <?= $aktif['xi'] ?>, <?= $aktif['xii'] ?>],
        backgroundColor: 'rgba(40, 167, 69, 0.7)'
      },
      {
        label: 'Siswa Keluar',
        data: [<?= $keluar['x'] ?>, <?= $keluar['xi'] ?>, <?= $keluar['xii'] ?>],
        backgroundColor: 'rgba(220, 53, 69, 0.7)'
      }
    ]
  },
  options: {
    responsive: true,
    legend: { position: 'top' },
    scales: {
      yAxes: [{ ticks: { beginAtZero:true } }]
    }
  }
});

var ctx2 = document.getElementById('chartRasio').getContext('2d');
new Chart(ctx2, {
  type: 'doughnut',
  data: {
    labels: ['Siswa Aktif', 'Siswa Keluar'],
    datasets: [{
      data: [<?= $aktif['total'] ?>, <?= $keluar['total'] ?>],
      backgroundColor: ['rgba(40, 167, 69, 0.8)', 'rgba(220, 53, 69, 0.8)']
    }]
  },
  options: { responsive: true, legend: { position: 'bottom' } }
});
</script>

