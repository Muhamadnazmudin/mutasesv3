<div class="container-fluid">
    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i>
        <?= $this->session->flashdata('success'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i>
        <?= $this->session->flashdata('error'); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>


    <!-- Judul Halaman -->
    <div class="text-center mb-4">
        <h3 class="font-weight-bold text-primary">Edit Biodata Siswa</h3>
        <p class="text-muted">Perbarui data diri anda dengan benar</p>
    </div>

    <style>
        .section-title {
            font-size: 16px;
            font-weight: bold;
            background: #e8f1ff;
            padding: 10px 12px;
            border-left: 4px solid #4e73df;
            margin-top: 25px;
            border-radius: 4px;
        }
        .bio-table td {
            padding: 8px;
            border: 1px solid #dce3f1;
            vertical-align: top;
        }
        .bio-label {
            font-weight: 600;
            width: 35%;
            background: #f8f9fc;
        }
        .bio-table input, .bio-table textarea {
            width: 100%;
            padding: 7px 10px;
            border: 1px solid #cfd5e2;
            border-radius: 4px;
            font-size: 14px;
        }
    </style>

    <form method="post" action="<?= site_url('SiswaDashboard/update_biodata') ?>">
        <input type="hidden"
            name="<?= $this->security->get_csrf_token_name(); ?>"
            value="<?= $this->security->get_csrf_hash(); ?>">

        <div class="card shadow mb-4">
            <div class="card-body">

                <!-- =================== A. DATA PRIBADI =================== -->
                <div class="section-title">A. DATA PRIBADI</div>
                <table class="table bio-table">
                    <tr><td class="bio-label">Nama Lengkap</td><td><?= $siswa->nama ?></td></tr>
                    <tr><td class="bio-label">NIS</td><td><?= $siswa->nis ?></td></tr>
                    <tr><td class="bio-label">Jenis Kelamin</td><td><?= $siswa->jk ?></td></tr>
                    <tr><td class="bio-label">NISN</td><td><?= $siswa->nisn ?></td></tr>

                    <tr>
                        <td class="bio-label">Tempat Lahir</td>
                        <td><input type="text" name="tempat_lahir" value="<?= $siswa->tempat_lahir ?>"></td>
                    </tr>
                    <tr><td class="bio-label">Tanggal Lahir</td><td><?= $siswa->tgl_lahir ?></td></tr>
                    <!-- <tr>
                        <td class="bio-label">Tanggal Lahir</td></td><?= $siswa->tgl_lahir ?></td>
                    </tr> -->

                    <tr>
                        <td class="bio-label">Nomor KK</td>
                        <td><input type="text" name="nomor_kk" value="<?= $siswa->nomor_kk ?>"></td>
                    </tr>

                    <tr>
                        <td class="bio-label">NIK</td>
                        <td><input type="text" name="nik" value="<?= $siswa->nik ?>"></td>
                    </tr>

                    <tr>
                        <td class="bio-label">Anak Ke</td>
                        <td><input type="text" name="anak_keberapa" value="<?= $siswa->anak_keberapa ?>"></td>
                    </tr>

                    <!-- <tr>
                        <td class="bio-label">Agama</td>
                        <td><input type="text" name="agama" value="<?= $siswa->agama ?>"></td>
                    </tr> -->
                    <tr><td class="bio-label">Agama</td><td><?= $siswa->agama ?></td></tr>
                    <tr>
                        <td class="bio-label">Alamat</td>
                        <td><textarea name="alamat" rows="2"><?= $siswa->alamat ?></textarea></td>
                    </tr>

                    <tr>
                        <td class="bio-label">RT</td>
                        <td><input type="text" name="rt" value="<?= $siswa->rt ?>"></td>
                    </tr>

                    <tr>
                        <td class="bio-label">RW</td>
                        <td><input type="text" name="rw" value="<?= $siswa->rw ?>"></td>
                    </tr>

                    <tr>
                        <td class="bio-label">Dusun</td>
                        <td><input type="text" name="dusun" value="<?= $siswa->dusun ?>"></td>
                    </tr>

                    <tr>
                        <td class="bio-label">Kecamatan</td>
                        <td><input type="text" name="kecamatan" value="<?= $siswa->kecamatan ?>"></td>
                    </tr>

                    <tr>
                        <td class="bio-label">Kode POS</td>
                        <td><input type="text" name="kode_pos" value="<?= $siswa->kode_pos ?>"></td>
                    </tr>

                    <tr>
                        <td class="bio-label">Telp Rumah</td>
                        <td><input type="text" name="telp" value="<?= $siswa->telp ?>"></td>
                    </tr>

                    <tr>
                        <td class="bio-label">No HP</td>
                        <td><input type="text" name="hp" value="<?= $siswa->hp ?>"></td>
                    </tr>

                    <tr>
                        <td class="bio-label">Email</td>
                        <td><input type="email" name="email" value="<?= $siswa->email ?>"></td>
                    </tr>
                </table>


                <!-- =================== B. KESEJAHTERAAN =================== -->
                <div class="section-title">B. KESEJAHTERAAN PESERTA DIDIK</div>
                <table class="table bio-table">
                    <tr>
                        <td class="bio-label">Penerima KPS</td>
                        <td><input type="text" name="penerima_kps" value="<?= $siswa->penerima_kps ?>"></td>
                    </tr>
                    <tr>
                        <td class="bio-label">Nomor KPS</td>
                        <td><input type="text" name="no_kps" value="<?= $siswa->no_kps ?>"></td>
                    </tr>
                </table>


                <!-- =================== C. DATA PERIODIK =================== -->
                <div class="section-title">C. DATA PERIODIK</div>
                <table class="table bio-table">
                    <tr><td class="bio-label">Tinggi Badan</td><td><input type="text" name="tinggi_badan" value="<?= $siswa->tinggi_badan ?>"></td></tr>
                    <tr><td class="bio-label">Berat Badan</td><td><input type="text" name="berat_badan" value="<?= $siswa->berat_badan ?>"></td></tr>
                    <tr><td class="bio-label">Hobi</td><td><input type="text" name="hobi" value="<?= $siswa->hobi ?>"></td></tr>
                    <tr><td class="bio-label">Cita-cita</td><td><input type="text" name="cita_cita" value="<?= $siswa->cita_cita ?>"></td></tr>
                </table>


                <!-- =================== D. DATA PENDIDIKAN =================== -->
                <div class="section-title">D. DATA PENDIDIKAN</div>
                <table class="table bio-table">
                    <tr><td class="bio-label">Sekolah Asal</td><td><input type="text" name="sekolah_asal" value="<?= $siswa->sekolah_asal ?>"></td></tr>
                    <tr><td class="bio-label">Nomor SKHUN</td><td><input type="text" name="skhun" value="<?= $siswa->skhun ?>"></td></tr>
                </table>


                <!-- =================== E. DATA AYAH =================== -->
                <div class="section-title">E. DATA AYAH KANDUNG</div>
                <table class="table bio-table">
                    <tr><td class="bio-label">Nama Ayah</td><td><input type="text" name="nama_ayah" value="<?= $siswa->nama_ayah ?>"></td></tr>
                    <tr><td class="bio-label">NIK Ayah</td><td><input type="text" name="nik_ayah" value="<?= $siswa->nik_ayah ?>"></td></tr>
                    <tr><td class="bio-label">Tahun Lahir Ayah</td><td><input type="text" name="tahun_lahir_ayah" value="<?= $siswa->tahun_lahir_ayah ?>"></td></tr>
                    <tr><td class="bio-label">Pendidikan Ayah</td><td><input type="text" name="pendidikan_ayah" value="<?= $siswa->pendidikan_ayah ?>"></td></tr>
                    <tr><td class="bio-label">Pekerjaan Ayah</td><td><input type="text" name="pekerjaan_ayah" value="<?= $siswa->pekerjaan_ayah ?>"></td></tr>
                    <tr><td class="bio-label">Penghasilan Ayah</td><td><input type="text" name="penghasilan_ayah" value="<?= $siswa->penghasilan_ayah ?>"></td></tr>
                </table>


                <!-- =================== F. DATA IBU =================== -->
                <div class="section-title">F. DATA IBU KANDUNG</div>
                <table class="table bio-table">
                    <tr><td class="bio-label">Nama Ibu</td><td><input type="text" name="nama_ibu" value="<?= $siswa->nama_ibu ?>"></td></tr>
                    <tr><td class="bio-label">NIK Ibu</td><td><input type="text" name="nik_ibu" value="<?= $siswa->nik_ibu ?>"></td></tr>
                    <tr><td class="bio-label">Tahun Lahir Ibu</td><td><input type="text" name="tahun_lahir_ibu" value="<?= $siswa->tahun_lahir_ibu ?>"></td></tr>
                    <tr><td class="bio-label">Pendidikan Ibu</td><td><input type="text" name="pendidikan_ibu" value="<?= $siswa->pendidikan_ibu ?>"></td></tr>
                    <tr><td class="bio-label">Pekerjaan Ibu</td><td><input type="text" name="pekerjaan_ibu" value="<?= $siswa->pekerjaan_ibu ?>"></td></tr>
                    <tr><td class="bio-label">Penghasilan Ibu</td><td><input type="text" name="penghasilan_ibu" value="<?= $siswa->penghasilan_ibu ?>"></td></tr>
                </table>


                <!-- =================== G. DATA WALI =================== -->
                <div class="section-title">G. DATA WALI</div>
                <table class="table bio-table">
                    <tr><td class="bio-label">Nama Wali</td><td><input type="text" name="nama_wali" value="<?= $siswa->nama_wali ?>"></td></tr>
                    <tr><td class="bio-label">NIK Wali</td><td><input type="text" name="nik_wali" value="<?= $siswa->nik_wali ?>"></td></tr>
                    <tr><td class="bio-label">Tahun Lahir Wali</td><td><input type="text" name="tahun_lahir_wali" value="<?= $siswa->tahun_lahir_wali ?>"></td></tr>
                    <tr><td class="bio-label">Pendidikan Wali</td><td><input type="text" name="pendidikan_wali" value="<?= $siswa->pendidikan_wali ?>"></td></tr>
                    <tr><td class="bio-label">Pekerjaan Wali</td><td><input type="text" name="pekerjaan_wali" value="<?= $siswa->pekerjaan_wali ?>"></td></tr>
                    <tr><td class="bio-label">Penghasilan Wali</td><td><input type="text" name="penghasilan_wali" value="<?= $siswa->penghasilan_wali ?>"></td></tr>
                </table>


                <!-- =================== BUTTON =================== -->
                <div class="mt-4">
                    <button class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>

                    <a href="<?= site_url('SiswaDashboard/biodata') ?>" class="btn btn-secondary ms-2">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                </div>

            </div>
        </div>

    </form>

</div>
<script>
    setTimeout(function() {
        let alert = document.querySelector('.alert');
        if (alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 3000);
</script>
