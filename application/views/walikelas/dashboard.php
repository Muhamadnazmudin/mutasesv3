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

<?php
$tahun_id = $this->session->userdata('tahun_id');
$tahun = $this->db->get_where('tahun_ajaran', ['id' => $tahun_id])->row();
?>

<div class="container-fluid">

<?php if ($this->session->userdata('logged_in')): ?>
<div class="text-center mt-4 mb-5">
  <h3>Selamat Datang, <?= $this->session->userdata('nama'); ?> 👋</h3>
  <p class="text-muted">
    Anda login sebagai <strong>Wali Kelas</strong><br>
    Kelas yang Anda ampu: <strong><?= $kelas_nama ?></strong><br>
    Tahun Ajaran Aktif:
    <strong><?= $tahun ? $tahun->tahun : '-' ?></strong>
  </p>
</div>
<?php endif; ?>

<!-- ================= ROW 1 ================= -->
<div class="row g-4 mb-4">

  <!-- SISWA DI KELAS -->
  <div class="col-md-6">
    <div class="card border-left-primary shadow-sm h-100">
      <div class="card-body">
        <h5 class="fw-bold text-primary mb-3">
          <i class="fas fa-users"></i> Siswa di Kelas <?= $kelas_nama ?>
        </h5>

        <table class="table table-bordered table-sm mb-0">
          <thead class="table-light">
            <tr>
              <th>Keterangan</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <tr><td>Laki-laki</td><td><?= $laki ?></td></tr>
            <tr><td>Perempuan</td><td><?= $perempuan ?></td></tr>
            <tr class="table-secondary fw-bold">
              <td>Total</td>
              <td><?= $total_siswa ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- KEHADIRAN HARI INI -->
  <div class="col-md-6">
    <div class="card border-left-success shadow-sm h-100">
      <div class="card-body">
        <h5 class="fw-bold text-success mb-3">
          <i class="fas fa-calendar-check"></i> Kehadiran Hari Ini
        </h5>

        <table class="table table-bordered table-sm mb-0">
          <thead class="table-light">
            <tr>
              <th>Status</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <tr><td>Hadir</td><td><?= $hari_H ?></td></tr>
            <tr><td>Izin</td><td><?= $hari_I ?></td></tr>
            <tr><td>Sakit</td><td><?= $hari_S ?></td></tr>
            <tr><td>Alpa</td><td><?= $hari_A ?></td></tr>
            <tr class="table-secondary fw-bold">
              <td>Total</td>
              <td><?= $hari_H + $hari_I + $hari_S + $hari_A ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

<!-- ================= ROW 2 ================= -->
<div class="row g-4 mb-4">

  <!-- KEHADIRAN BULAN INI -->
  <div class="col-md-6">
    <div class="card border-left-warning shadow-sm h-100">
      <div class="card-body">
        <h5 class="fw-bold text-warning mb-3">
          <i class="fas fa-calendar-alt"></i> Kehadiran Bulan Ini
        </h5>

        <table class="table table-bordered table-sm mb-0">
          <thead class="table-light">
            <tr>
              <th>Status</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <tr><td>Hadir</td><td><?= $bulan_H ?></td></tr>
            <tr><td>Izin</td><td><?= $bulan_I ?></td></tr>
            <tr><td>Sakit</td><td><?= $bulan_S ?></td></tr>
            <tr><td>Alpa</td><td><?= $bulan_A ?></td></tr>
            <tr class="table-secondary fw-bold">
              <td>Total</td>
              <td><?= $bulan_H + $bulan_I + $bulan_S + $bulan_A ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- IZIN SISWA -->
  <div class="col-md-6">
    <div class="card border-left-danger shadow-sm h-100">
      <div class="card-body">
        <h5 class="fw-bold text-danger mb-3">
          <i class="fas fa-door-open"></i> Izin Siswa Hari Ini
        </h5>

        <table class="table table-bordered table-sm mb-0">
          <thead class="table-light">
            <tr>
              <th>Jenis Izin</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <tr><td>Izin Keluar</td><td><?= $izin_keluar_hari_ini ?></td></tr>
            <tr><td>Izin Pulang</td><td><?= $izin_pulang_hari_ini ?></td></tr>
            <tr class="table-secondary fw-bold">
              <td>Total</td>
              <td><?= $izin_keluar_hari_ini + $izin_pulang_hari_ini ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>

</div>
