<style>
.badge {
    font-size: 13px;
    padding: 6px 10px;
}
</style>

<div class="card">
    <div class="card-header bg-info text-white">
        <i class="fa fa-search"></i> Laporan Absensi QR Siswa
    </div>

    <div class="card-body">

        <form id="formLaporanQR">

            <!-- CSRF -->
            <input type="hidden" 
                name="<?= $this->security->get_csrf_token_name(); ?>" 
                value="<?= $this->security->get_csrf_hash(); ?>">

            <div class="row">

                <div class="col-md-3">
                    <label>Cari Siswa</label>
                    <input id="nama" type="text" name="nama" class="form-control" placeholder="Cari Siswa...">
                </div>

                <div class="col-md-3">
                    <label>Dari Tanggal</label>
                    <input id="dari" type="date" name="dari" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>

                <div class="col-md-3">
                    <label>Sampai Tanggal</label>
                    <input id="sampai" type="date" name="sampai" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>

                <div class="col-md-3">
                    <label>Kelas</label>
                    <select id="kelas" name="kelas" class="form-control">
                        <option value="">[ SEMUA KELAS ]</option>
                        <?php foreach($kelas as $k): ?>
                        <option value="<?= $k->id ?>"><?= $k->nama ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="row mt-3">

                <div class="col-md-3">
                    <label>Keterangan</label>
                    <select id="keterangan" name="keterangan" class="form-control">
                        <option value="">[ SEMUA STATUS ]</option>
                        <option value="H">Hadir</option>
                        <option value="Terlambat">Terlambat</option>
                        <option value="I">Izin</option>
                        <option value="S">Sakit</option>
                        <option value="A">Alpa</option>
                    </select>
                </div>

            </div>

            <div class="mt-4">

                <button id="btnTampil" type="button" class="btn btn-info">
                    <i class="fa fa-search"></i> Tampilkan Data
                </button>

                <button id="btnPdf" type="button" class="btn btn-success">
                    <i class="fa fa-file-pdf"></i> Rekap PDF
                </button>

                <button id="btnExcel" type="button" class="btn btn-primary">
                    <i class="fa fa-file-excel"></i> Rekap Excel
                </button>

            </div>

        </form>

    </div>
</div>


<!-- HASIL -->
<div id="hasilBox" style="display:none; margin-top:30px;">
    <h4>Hasil Pencarian</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Kehadiran</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="hasilBody"></tbody>
    </table>
</div>

<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<script>
/* ============================================
   KONVERSI KEHADIRAN (H/I/S/A) → BADGE
============================================ */
function badgeKehadiranJS(k) {
    k = (k ?? "").toUpperCase();

    switch(k) {
        case 'H': return "<span class='badge bg-success'>Hadir</span>";
        case 'I': return "<span class='badge bg-warning text-dark'>Izin</span>";
        case 'S': return "<span class='badge bg-primary'>Sakit</span>";
        case 'A': return "<span class='badge bg-danger'>Alpa</span>";
        default:  return "<span class='badge bg-secondary'>-</span>";
    }
}

$(document).ready(function() {

    // ==========================
    // 1. TAMPILKAN DATA
    // ==========================
    $("#btnTampil").click(function() {

        $.ajax({
            url: "<?= site_url('AbsensiQRAdmin/data') ?>",
            type: "POST",
            data: {
                nama: $("#nama").val(),
                kelas: $("#kelas").val(),
                dari: $("#dari").val(),
                sampai: $("#sampai").val(),
                status: $("#keterangan").val(),
                "<?= $this->security->get_csrf_token_name(); ?>":
                "<?= $this->security->get_csrf_hash(); ?>"
            },
            dataType: "json",
            success: function(res){

                let html = "";
                let no = 1;

                res.forEach(r => {

                    html += `
                        <tr>
                            <td>${no++}</td>
                            <td>${r.tanggal}</td>
                            <td>${r.nama_siswa}</td>
                            <td>${r.nama_kelas}</td>
                            <td>${ badgeKehadiranJS(r.kehadiran) }</td>
                            <td>${r.jam_masuk ?? '-'}</td>
                            <td>${r.jam_pulang ?? '-'}</td>
                            <td>${r.status}</td>
                        </tr>
                    `;
                });

                $("#hasilBody").html(html);
                $("#hasilBox").show();
            }
        });

    });

    // ==========================
    // 2. PDF EXPORT
    // ==========================
    $("#btnPdf").click(function(){

        let kelas  = $("#kelas").val();
        let dari   = $("#dari").val();
        let sampai = $("#sampai").val();
        let status = $("#keterangan").val();

        window.open(
            "<?= site_url('AbsensiQRAdmin/pdf') ?>?kelas="+kelas+
            "&dari="+dari+
            "&sampai="+sampai+
            "&status="+status,
            "_blank"
        );
    });

    // ==========================
    // 3. EXCEL EXPORT
    // ==========================
    $("#btnExcel").click(function(){

        let kelas  = $("#kelas").val();
        let dari   = $("#dari").val();
        let sampai = $("#sampai").val();
        let status = $("#keterangan").val();

        window.location.href =
            "<?= site_url('AbsensiQRAdmin/excel') ?>?kelas="+kelas+
            "&dari="+dari+
            "&sampai="+sampai+
            "&status="+status;
    });

});
</script>
