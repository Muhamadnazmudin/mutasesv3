<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Laporan Mutasi Siswa</h4>
  <div>
    <a href="<?= site_url('laporan/export_excel?' . http_build_query($_GET)) ?>" class="btn btn-success btn-sm">
      <i class="fas fa-file-excel"></i> Excel
    </a>
    <a href="<?= site_url('laporan/export_pdf?' . http_build_query($_GET)) ?>" class="btn btn-danger btn-sm">
      <i class="fas fa-file-pdf"></i> PDF
    </a>
  </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i>
    <?= $this->session->flashdata('success'); ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php endif; ?>

<!-- FILTER -->
<form method="get" class="row g-3 mb-3">
  <div class="col-md-3">
    <label><strong>Kelas</strong></label>
    <select name="kelas" class="form-control input-sm">
      <option value="">Semua Kelas</option>
      <?php foreach($kelas_list as $k): ?>
        <option value="<?= $k->id ?>" <?= ($this->input->get('kelas') == $k->id ? 'selected' : '') ?>>
          <?= $k->nama ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="col-md-3">
    <label><strong>Jenis Mutasi</strong></label>
    <select name="jenis" class="form-control input-sm">
      <option value="">Semua</option>
      <option value="masuk" <?= ($this->input->get('jenis') == 'masuk' ? 'selected' : '') ?>>Masuk</option>
      <option value="keluar" <?= ($this->input->get('jenis') == 'keluar' ? 'selected' : '') ?>>Keluar</option>
    </select>
  </div>

  <div class="col-md-3">
    <label><strong>Cari Nama</strong></label>
    <input type="text" name="search" class="form-control input-sm" placeholder="Cari nama siswa..." value="<?= $this->input->get('search') ?>">
  </div>

  <div class="col-md-3" style="margin-top:25px;">
    <button type="submit" class="btn btn-primary btn-sm">
      <i class="fas fa-filter"></i> Filter
    </button>
    <a href="<?= site_url('laporan') ?>" class="btn btn-secondary btn-sm">
      <i class="fas fa-sync-alt"></i> Reset
    </a>
  </div>
</form>

<!-- TABEL -->
<table class="table table-bordered table-striped table-responsive-sm">
  <thead class="thead-light">
    <tr>
      <th>No</th>
      <th>Nama Siswa</th>
      <th>NIS</th>
      <th>Kelas Asal</th>
      <th>Jenis</th>
      <th>Tanggal</th>
      <th>Alasan</th>
      <th>Kelas Tujuan</th>
      <th>Tahun Ajaran</th>
      <th>Dibuat Oleh</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($mutasi): $no=1; foreach($mutasi as $m): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $m->nama_siswa ?></td>
        <td><?= $m->nis ?></td>
        <td><?= isset($m->kelas_asal) ? $m->kelas_asal : '-' ?></td>
        <td><?= ucfirst($m->jenis) ?></td>
        <td><?= !empty($m->tanggal) ? date('d-m-Y', strtotime($m->tanggal)) : '-' ?></td>
        <td><?= $m->alasan ?></td>
        <td><?= isset($m->kelas_tujuan) ? $m->kelas_tujuan : '-' ?></td>
        <td><?= $m->tahun_ajaran ?></td>
        <td><?= $m->dibuat_oleh ?></td>
      </tr>
    <?php endforeach; else: ?>
      <tr><td colspan="10" class="text-center text-muted">Tidak ada data ditemukan.</td></tr>
    <?php endif; ?>
  </tbody>
</table>
