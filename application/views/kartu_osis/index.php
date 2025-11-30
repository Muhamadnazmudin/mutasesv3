<?php
// ==================================================================
// FIX: Default variable agar tidak undefined
// ==================================================================
if (!isset($kelas)) $kelas = array();
if (!isset($kelas_id)) $kelas_id = "";
if (!isset($limit)) $limit = 25;
if (!isset($start)) $start = 0;
if (!isset($pagination)) $pagination = "";

// ==================================================================
// BACA TEMPLATE OTOMATIS
// ==================================================================
$templates = array();
$base = FCPATH . "assets/kartu_templates/";

if (is_dir($base)) {
    $scan = scandir($base);
    foreach ($scan as $d) {
        if ($d != "." && $d != ".." && is_dir($base.$d)) {
            $templates[] = $d;
        }
    }
}
?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-dark">Kartu OSIS</h4>
    </div>

    <!-- ====================== FILTER ====================== -->
    <div class="card shadow-sm mb-3">
        <div class="card-body">

            <form method="get" action="<?= site_url('kartu_osis') ?>" class="row">

                <!-- Filter Kelas -->
                <div class="col-md-4">
                    <label><b>Kelas</b></label>
                    <select name="kelas" class="form-control">
                        <option value="">-- Semua Kelas --</option>
                        <?php foreach ($kelas as $k): ?>
                            <option value="<?= $k->id ?>" <?= ($kelas_id == $k->id ? "selected" : "") ?>>
                                <?= $k->nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Limit -->
                <div class="col-md-2">
                    <label><b>Tampilkan</b></label>
                    <select name="limit" class="form-control">
                        <?php
                        $limits = array(10,25,50,100,200);
                        foreach ($limits as $l):
                        ?>
                        <option value="<?= $l ?>" <?= ($limit==$l?"selected":"") ?>><?= $l ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Tombol -->
                <div class="col-md-3">
                    <label>&nbsp;</label>
                    <button class="btn btn-primary btn-block">Filter</button>
                </div>

            </form>

        </div>
    </div>
    <!-- ====================== END FILTER ====================== -->

    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th style="width:50px;">No</th>
                        <th>Nama</th>
                        <th style="width:130px;">Kelas</th>
                        <th style="width:260px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = $start+1; foreach($siswa as $s): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $s->nama ?></td>
                        <td class="text-center"><?= $s->nama_kelas ?></td>

                        <td class="text-center">

                            <!-- DROPDOWN TEMPLATE -->
                            <select class="form-control form-control-sm pilih-template"
                                    data-id="<?= $s->id ?>" style="margin-bottom:6px;">
                                <?php foreach ($templates as $t): ?>
                                    <option value="<?= $t ?>"><?= ucfirst($t) ?></option>
                                <?php endforeach; ?>
                            </select>

                            <!-- TOMBOL -->
                            <button class="btn btn-danger btn-sm btn-pdf" data-id="<?= $s->id ?>">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>

                            <button class="btn btn-primary btn-sm btn-front" data-id="<?= $s->id ?>">
                                <i class="fas fa-image"></i> JPG Depan
                            </button>

                            <button class="btn btn-info btn-sm btn-back" data-id="<?= $s->id ?>">
                                <i class="fas fa-image"></i> JPG Belakang
                            </button>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

            <!-- PAGINATION -->
            <div class="mt-3">
                <?= $pagination ?>
            </div>

        </div>
    </div>

</div>


<!-- ============================================================= -->
<!-- JAVASCRIPT HANDLER -->
<!-- ============================================================= -->

<script>
document.addEventListener("DOMContentLoaded", function() {

    // PDF
    var pdfBtns = document.querySelectorAll(".btn-pdf");
    for (var i = 0; i < pdfBtns.length; i++) {
        pdfBtns[i].addEventListener("click", function(){
            var id = this.getAttribute("data-id");
            var template = this.parentNode.querySelector(".pilih-template").value;
            window.open("<?= site_url('kartu_osis_template/pdf/') ?>" + template + "/" + id, "_blank");
        });
    }

    // JPG Depan
    var frontBtns = document.querySelectorAll(".btn-front");
    for (var i = 0; i < frontBtns.length; i++) {
        frontBtns[i].addEventListener("click", function(){
            var id = this.getAttribute("data-id");
            var template = this.parentNode.querySelector(".pilih-template").value;
            window.open("<?= site_url('kartu_osis_template/front/') ?>" + template + "/" + id, "_blank");
        });
    }

    // JPG Belakang
    var backBtns = document.querySelectorAll(".btn-back");
    for (var i = 0; i < backBtns.length; i++) {
        backBtns[i].addEventListener("click", function(){
            var id = this.getAttribute("data-id");
            var template = this.parentNode.querySelector(".pilih-template").value;
            window.open("<?= site_url('kartu_osis_template/back/') ?>" + template + "/" + id, "_blank");
        });
    }

});
</script>
