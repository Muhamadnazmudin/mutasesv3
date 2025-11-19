<div class="container mt-4">
    <h3>Pengaturan Jam Masuk & Pulang Siswa</h3>
    <hr>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('index.php/jadwalabsensi/update') ?>">
        <input type="hidden" 
           name="<?= $this->security->get_csrf_token_name(); ?>"
           value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 180px;">Hari</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jadwal as $j): ?>
                        <tr>
                            <td>
                                <strong><?= $j->hari ?></strong>
                                <input type="hidden" name="id[]" value="<?= $j->id ?>">
                            </td>
                            <td>
                                <input type="text" 
       name="jam_masuk[]" 
       value="<?= substr($j->jam_masuk, 0, 5) ?>" 
       class="form-control jam24"
       placeholder="06:30"
       required>

                            <td>
                                <input type="text" 
       name="jam_pulang[]" 
       value="<?= substr($j->jam_pulang, 0, 5) ?>" 
       class="form-control jam24"
       placeholder="14:30"
       required>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <script>
document.querySelectorAll('.jam24').forEach(function(input) {
    input.addEventListener('input', function() {
        this.value = this.value
            .replace(/[^0-9:]/g, '')  // hanya angka & :
            .replace(/(\..*)\./g, '$1');

        // auto tambah ":" setelah 2 digit
        if (this.value.length === 2 && !this.value.includes(":")) {
            this.value = this.value + ":";
        }

        // validasi format HH:MM
        const pattern = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;

        if (!pattern.test(this.value)) {
            this.style.borderColor = "red";
        } else {
            this.style.borderColor = "#ced4da"; // default bootstrap
        }
    });
});
</script>

        </div>

        <button class="btn btn-primary mt-3">
            <i class="fas fa-save"></i> Simpan Perubahan
        </button>
    </form>
</div>
