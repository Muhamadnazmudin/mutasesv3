<div class="container-fluid">

  <h4 class="mb-4">Data Guru</h4>

  <!-- ================= IDENTITAS UTAMA ================= -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">

      <div class="row align-items-center">

        <!-- FOTO PROFIL -->
        <div class="col-md-3 text-center mb-3 mb-md-0">
          <?php
$fotoUrl  = base_url('assets/img/default-avatar.png');
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

</div>
