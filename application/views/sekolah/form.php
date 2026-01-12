<div class="container-fluid">
    <h1 class="h4 mb-4"><?= $title ?></h1>

    <form method="post" enctype="multipart/form-data"
          action="<?= isset($row) ? base_url('sekolah/update/'.$row->id) : base_url('sekolah/simpan') ?>">
 <input type="hidden"
                               name="<?= $this->security->get_csrf_token_name(); ?>"
                               value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="row">
            <div class="col-md-6">
                <label>Nama Sekolah</label>
                <input type="text" name="nama_sekolah" class="form-control" required
                       value="<?= isset($row) ? $row->nama_sekolah : '' ?>">
            </div>

            <div class="col-md-6">
                <label>NPSN</label>
                <input type="text" name="npsn" class="form-control"
                       value="<?= isset($row) ? $row->npsn : '' ?>">
            </div>
        </div>

        <div class="mt-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control"><?= isset($row) ? $row->alamat : '' ?></textarea>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <label>Desa</label>
                <input type="text" name="desa" class="form-control"
                       value="<?= isset($row) ? $row->desa : '' ?>">
            </div>
            <div class="col-md-4">
                <label>Kecamatan</label>
                <input type="text" name="kecamatan" class="form-control"
                       value="<?= isset($row) ? $row->kecamatan : '' ?>">
            </div>
            <div class="col-md-4">
                <label>Kabupaten</label>
                <input type="text" name="kabupaten" class="form-control"
                       value="<?= isset($row) ? $row->kabupaten : '' ?>">
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label>Latitude</label>
                <input type="text" name="latitude" class="form-control"
                       value="<?= isset($row) ? $row->latitude : '' ?>">
            </div>
            <div class="col-md-6">
                <label>Longitude</label>
                <input type="text" name="longitude" class="form-control"
                       value="<?= isset($row) ? $row->longitude : '' ?>">
            </div>
        </div>

        <div class="mt-3">
            <label>Logo Sekolah</label>
            <input type="file" name="logo" class="form-control">
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <label>Nama Kepala Sekolah</label>
                <input type="text" name="nama_kepala_sekolah" class="form-control"
                       value="<?= isset($row) ? $row->nama_kepala_sekolah : '' ?>">
            </div>
            <div class="col-md-6">
                <label>NIP Kepala Sekolah</label>
                <input type="text" name="nip_kepala_sekolah" class="form-control"
                       value="<?= isset($row) ? $row->nip_kepala_sekolah : '' ?>">
            </div>
        </div>

        <button class="btn btn-success mt-4">
            <i class="fas fa-save"></i> Simpan
        </button>
        <a href="<?= base_url('sekolah') ?>" class="btn btn-secondary mt-4">Kembali</a>
    </form>
</div>
