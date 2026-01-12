<div class="container-fluid">

  <h4 class="mb-4">Data Guru</h4>

  <!-- ================= IDENTITAS UTAMA ================= -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">

      <div class="row align-items-center">

        <!-- FOTO PROFIL -->
        <div class="col-md-3 text-center mb-3 mb-md-0">
          <?php
$fotoUrl  = base_url('assets/img/default-user.jpg');
$fotoPath = FCPATH.'uploads/profile/'.($user->foto ?? '');

if (!empty($user->foto) && file_exists($fotoPath)) {
    $fotoUrl = base_url('uploads/profile/'.$user->foto);
}
?>

<img src="<?= $fotoUrl ?>"
     class="img-fluid rounded-circle shadow"
     style="width:160px;height:160px;object-fit:cover;"
     alt="Foto Guru">


        </div>

        <!-- IDENTITAS -->
        <div class="col-md-9">
          <h3 class="mb-1"><?= strtoupper($guru->nama) ?></h3>

          <p class="text-muted mb-3">
            NIP : <?= $guru->nip ?: '-' ?>
          </p>

          <table class="table table-sm table-borderless mb-0">
            <tr>
              <td width="220">Jenis Kelamin</td>
              <td>
                :
                <?php
                  if ($guru->jenis_kelamin == 'L') echo 'Laki-laki';
                  elseif ($guru->jenis_kelamin == 'P') echo 'Perempuan';
                  else echo '-';
                ?>
              </td>
            </tr>

            <tr>
              <td>Tempat, Tanggal Lahir</td>
              <td>
                :
                <?= $guru->tempat_lahir ?: '-' ?>,
                <?= $guru->tanggal_lahir
                    ? date('d-m-Y', strtotime($guru->tanggal_lahir))
                    : '-' ?>
              </td>
            </tr>

            <tr>
              <td>Email</td>
              <td>: <?= $guru->email ?: '-' ?></td>
            </tr>

            <tr>
              <td>No. Telp</td>
              <td>: <?= $guru->telp ?: '-' ?></td>
            </tr>
          </table>
        </div>

      </div>

    </div>
  </div>

  <!-- ================= ALAMAT ================= -->
  <div class="card shadow-sm">
    <div class="card-header bg-success text-white">
      <strong>Alamat</strong>
    </div>
    <div class="card-body">
      <p class="mb-0">
        <?= $guru->alamat_jalan ?: '-' ?><br>

        RT <?= $guru->rt ?: '-' ?> / RW <?= $guru->rw ?: '-' ?>,
        Dusun <?= $guru->dusun ?: '-' ?><br>

        <?= $guru->desa_kelurahan ?: '-' ?>,
        <?= $guru->kecamatan ?: '-' ?>
        <?= $guru->kode_pos ?: '' ?>
      </p>
    </div>
  </div>
<!-- ================= DATA KEPEGAWAIAN ================= -->
<div class="card shadow-sm mt-4">
  <div class="card-header bg-primary text-white">
    <strong>Data Kepegawaian</strong>
  </div>

  <div class="card-body">

    <table class="table table-sm table-borderless mb-0">
      <tr>
        <td width="260">Kewarganegaraan</td>
        <td>: <?= $guru->kewarganegaraan ?: '-' ?></td>
      </tr>

      <tr>
        <td>NPWP</td>
        <td>: <?= $guru->npwp ?: '-' ?></td>
      </tr>

      <tr>
        <td>Nama Wajib Pajak</td>
        <td>: <?= $guru->nama_wajib_pajak ?: '-' ?></td>
      </tr>

      <tr>
        <td>Status Kepegawaian</td>
        <td>: <?= $guru->status_kepegawaian ?: '-' ?></td>
      </tr>

      <tr>
        <td>SK Pengangkatan</td>
        <td>: <?= $guru->sk_pengangkatan ?: '-' ?></td>
      </tr>

      <tr>
        <td>TMT Pengangkatan</td>
        <td>
          :
          <?= $guru->tmt_pengangkatan
              ? date('d-m-Y', strtotime($guru->tmt_pengangkatan))
              : '-' ?>
        </td>
      </tr>

      <tr>
        <td>Lembaga Pengangkat</td>
        <td>: <?= $guru->lembaga_pengangkat ?: '-' ?></td>
      </tr>

      <tr>
        <td>SK CPNS</td>
        <td>: <?= $guru->sk_cpns ?: '-' ?></td>
      </tr>

      <tr>
  <td>TMT CPNS</td>
  <td>
    :
    <?php
      if (
          !empty($guru->tmt_cpns) &&
          $guru->tmt_cpns != '0000-00-00'
      ) {
          echo date('d-m-Y', strtotime($guru->tmt_cpns));
      } else {
          echo '-';
      }
    ?>
  </td>
</tr>

<tr>
  <td>TMT Pengangkatan CPNS</td>
  <td>
    :
    <?php
      if (
          !empty($guru->tmt_pengangkatan_cpns) &&
          $guru->tmt_pengangkatan_cpns != '0000-00-00'
      ) {
          echo date('d-m-Y', strtotime($guru->tmt_pengangkatan_cpns));
      } else {
          echo '-';
      }
    ?>
  </td>
</tr>


      <tr>
        <td>Pangkat / Golongan</td>
        <td>: <?= $guru->pangkat_golongan ?: '-' ?></td>
      </tr>
    </table>

  </div>
</div>

</div>
