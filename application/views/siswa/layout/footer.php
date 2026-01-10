        </div> <!-- container-fluid -->
    </div> <!-- content -->
</div> <!-- content-wrapper -->
</div> <!-- wrapper -->

<!-- Scroll to Top -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- SB ADMIN 2 JS -->
<script src="<?php echo base_url('assets/sbadmin2/vendor/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/sbadmin2/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/sbadmin2/js/sb-admin-2.min.js'); ?>"></script>

</body>
</html>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('toggleDarkMode');
    const body = document.body;

    // LOAD STATE
    if (localStorage.getItem('siswaDarkMode') === 'on') {
        body.classList.add('dark-mode');
        toggle.innerHTML = '<i class="fas fa-sun"></i>';
    }

    // TOGGLE
    toggle.addEventListener('click', function () {
        body.classList.toggle('dark-mode');

        if (body.classList.contains('dark-mode')) {
            localStorage.setItem('siswaDarkMode', 'on');
            toggle.innerHTML = '<i class="fas fa-sun"></i>';
        } else {
            localStorage.setItem('siswaDarkMode', 'off');
            toggle.innerHTML = '<i class="fas fa-moon"></i>';
        }
    });
});
</script>
