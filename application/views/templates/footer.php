<!-- ================= FOOTER.PHP ================= -->
    </div> <!-- container-fluid -->
  </div> <!-- End of Main Content -->

  <!-- Footer -->
<footer class="sticky-footer bg-white text-dark py-3 border-top">
  <div class="container my-auto">
    <div class="text-center my-auto small">
      <span>
        © <?= date('Y') ?> Created by 
        <a href="https://www.profilsaya.my.id" target="_blank" class="text-decoration-none text-primary fw-bold">
          M. Nazmudin
        </a> 
        — Sistem Informasi Siswa dan GTK
      </span>
    </div>
  </div>
</footer>

</div>
</div>

<a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>


<script src="<?= base_url('assets/sbadmin2/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/sbadmin2/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
<script src="<?= base_url('assets/sbadmin2/js/sb-admin-2.min.js') ?>"></script>

<script src="<?= base_url('assets/sbadmin2/vendor/chart.js/Chart.min.js') ?>"></script>
<script src="<?= base_url('assets/sbadmin2/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/sbadmin2/vendor/sweetalert/sweetalert.min.js') ?>"></script>
<script>
 
  const toggleBtn = document.getElementById('toggleMode');
  const currentMode = localStorage.getItem('mode') || 'dark';
  const body = document.body;

  // ubah mode didieu
  function setMode(mode) {
    if (mode === 'dark') {
        body.classList.add('dark-mode');
        body.classList.remove('light-mode');
        localStorage.setItem('mode', 'dark');
        toggleBtn.innerHTML = '<i class="fas fa-sun"></i>';
        document.documentElement.style.setProperty('--bg', '#1e1e2f');
    } else {
        body.classList.remove('dark-mode');
        body.classList.add('light-mode');
        localStorage.setItem('mode', 'light');
        toggleBtn.innerHTML = '<i class="fas fa-moon"></i>';
        document.documentElement.style.setProperty('--bg', '#f8f9fc');
    }
}

  // Set mode awal sesuai localStorage
  setMode(currentMode);

  // Saat tombol diklik
  toggleBtn.addEventListener('click', () => {
    const newMode = body.classList.contains('dark-mode') ? 'light' : 'dark';
    setMode(newMode);
  });
</script>
<script>
$(document).on('click', '.btn-edit', function () {
    const id = $(this).data('id');

    $('#modalEditBukuTamu').modal('show');
    $('#editBukuTamuContent').html(
        '<div class="text-center py-5 text-muted">' +
        '<i class="fas fa-spinner fa-spin"></i> Memuat data...' +
        '</div>'
    );

    $('#editBukuTamuContent').load(
        '<?= site_url("buku_tamu/edit/") ?>' + id
    );
});
</script>

</body>
</html>
