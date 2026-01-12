<!-- ================= SIDEBAR GURU ================= -->
<style> 
html, body {
    height: 100%;
    margin: 0;
}

/* ================= SIDEBAR ================= */
#accordionSidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 224px;
    overflow-y: auto;
    z-index: 1032;
    transition: all .3s ease;
}

/* ================= CONTENT ================= */
#content-wrapper {
    margin-left: 224px;
    min-height: 100vh;
    padding-top: 70px;
    background-color: #e7f9e7;
    transition: all .3s ease;
}

/* ================= TOPBAR ================= */
.topbar {
    position: fixed;
    top: 0;
    left: 224px;
    right: 0;
    z-index: 1031;
    background-color: #28a745 !important;
    transition: all .3s ease;
}

/* ===== DESKTOP TOGGLE ===== */
.sidebar-toggled #accordionSidebar {
    width: 80px;
}

.sidebar-toggled #content-wrapper {
    margin-left: 80px;
}

.sidebar-toggled .topbar {
    left: 80px;
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {

    #accordionSidebar {
        transform: translateX(-100%);
        transition: transform .3s ease;
    }

    #accordionSidebar.show {
        transform: translateX(0);
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.5);
        z-index: 1030;
    }

    .sidebar-overlay.show {
        display: block;
    }
    /* ===== FORCE SIDEBAR ABOVE OVERLAY (FIX FINAL) ===== */
#accordionSidebar {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 180px !important;
    height: 100vh !important;
    z-index: 9999 !important;
    background: linear-gradient(180deg, #28a745, #1e7e34);
}

/* MOBILE */
@media (max-width: 768px) {

    #accordionSidebar {
        transform: translateX(-100%);
        transition: transform .3s ease;
    }

    #accordionSidebar.show {
        transform: translateX(0);
    }

    .sidebar-overlay {
        z-index: 9000 !important;
    }
}
/* ===== PREVENT TEXT WRAP SIDEBAR MENU ===== */
#accordionSidebar .nav-link span {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: inline-block;
    max-width: 130px;
}

/* Rapatkan tinggi menu */
#accordionSidebar .nav-link {
    line-height: 1.2;
}
/* ================= MENU LIST FIX ================= */

/* Heading menu */
#accordionSidebar .sidebar-heading {
    margin-top: 12px;
    margin-bottom: 8px;
    padding-left: 18px;
    font-size: .75rem;
    font-weight: 600;
    letter-spacing: .08em;
    color: rgba(255,255,255,.85);
}

/* Item wrapper */
#accordionSidebar .nav-item {
    margin: 4px 12px;
}

/* Link menu */
#accordionSidebar .nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 10px;
    font-size: .9rem;
    font-weight: 500;
    color: #f1fff1;
    line-height: 1.4;
    transition: all .2s ease;
}

/* Icon menu */
#accordionSidebar .nav-link i {
    width: 20px;
    min-width: 20px;
    text-align: center;
    font-size: .95rem;
    opacity: .95;
}

/* Hover */
#accordionSidebar .nav-link:hover {
    background: rgba(255,255,255,.15);
}

/* Active */
#accordionSidebar .nav-item.active .nav-link {
    background: rgba(255,255,255,.22);
    font-weight: 600;
}

/* Divider dirapikan */
#accordionSidebar .sidebar-divider {
    margin: 10px 16px;
    border-top: 1px solid rgba(255,255,255,.15);
}

/* Logout biar konsisten */
#accordionSidebar .btn-danger {
    margin-top: 8px;
    border-radius: 12px;
    font-size: .85rem;
}
/* ================= FIX TEKS MENU ================= */
#accordionSidebar .nav-link span {
    white-space: normal;        /* BOLEH TURUN BARIS */
    overflow: visible;
    text-overflow: unset;
    max-width: none;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;      /* maksimal 2 baris */
    -webkit-box-orient: vertical;
}

    }
/* ================= FIX TOPBAR MOBILE ================= */
@media (max-width: 768px) {

    .topbar {
        left: 0 !important;   /* ⬅️ INI KUNCI UTAMA */
        padding-left: 12px;
        padding-right: 12px;
    }

}
/* =========================================================
   OVERRIDE WARNA SIDEBAR GURU (LEBIH ADEM, MIRIP SISWA)
   ========================================================= */

/* Background sidebar */
#accordionSidebar {
    background: linear-gradient(180deg, #1f2d27, #16201c) !important;
}

/* Brand */
#accordionSidebar .sidebar-brand {
    background: transparent !important;
}

#accordionSidebar .sidebar-brand-text,
#accordionSidebar .sidebar-brand-icon i {
    color: #e6f4ec !important;
}

/* Menu text */
#accordionSidebar .nav-link {
    color: #d9efe4 !important;
}

/* Icon menu */
#accordionSidebar .nav-link i {
    color: #9fd5bb !important;
}

/* Hover */
#accordionSidebar .nav-link:hover {
    background: rgba(255,255,255,.08) !important;
}

/* Active menu */
#accordionSidebar .nav-item.active .nav-link {
    background: rgba(255,255,255,.12) !important;
    box-shadow: inset 3px 0 0 #5fd19f;
    font-weight: 600;
}

/* Heading */
#accordionSidebar .sidebar-heading {
    color: rgba(217,239,228,.7) !important;
}

/* Divider */
#accordionSidebar .sidebar-divider {
    border-top: 1px solid rgba(255,255,255,.08) !important;
}

/* Logout button tetap merah tapi lebih soft */
#accordionSidebar .btn-danger {
    background: #c0392b;
    border: none;
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {
    #accordionSidebar {
        background: linear-gradient(180deg, #1f2d27, #121a17) !important;
    }
}

</style>

<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center"
     href="<?= site_url('guru_dashboard') ?>">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-chalkboard-teacher"></i>
    </div>
    <div class="sidebar-brand-text mx-3">GURU</div>
  </a>

  <hr class="sidebar-divider my-0">

  <!-- Dashboard -->
  <li class="nav-item <?= ($active=='guru_dashboard')?'active':'' ?>">
    <a class="nav-link" href="<?= site_url('guru_dashboard') ?>">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <hr class="sidebar-divider">
  <li class="nav-item <?= ($active=='guru_account')?'active':'' ?>">
  <a class="nav-link" href="<?= site_url('guru_account') ?>">
    <i class="fas fa-id-badge"></i>
    <span>Profile</span>
  </a>
</li>

  <hr class="sidebar-divider">

  <div class="sidebar-heading">
    Menu Guru
  </div>

  <li class="nav-item <?= ($active=='guru_profile')?'active':'' ?>">
  <a class="nav-link" href="<?= site_url('guru_profile') ?>">
    <i class="fas fa-user"></i>
    <span>Data Guru</span>
  </a>
</li>

<li class="nav-item <?= ($active=='guru_jadwal')?'active':'' ?>">
  <a class="nav-link" href="<?= site_url('guru_jadwal') ?>">
    <i class="fas fa-calendar-alt"></i>
    <span>Jadwal Mengajar</span>
  </a>
</li>

<li class="nav-item <?= ($active=='laporan_guru') ? 'active' : '' ?>">
    <a class="nav-link" href="<?= site_url('laporan_guru') ?>">
        <i class="fas fa-file-pdf"></i>
        <span>Laporan Mengajar</span>
    </a>
</li>

<li class="nav-item <?= ($active=='guru_sertifikasi')?'active':'' ?>">
  <a class="nav-link" href="<?= site_url('guru_sertifikasi_guru') ?>">
    <i class="fas fa-certificate"></i>
    <span>Riwayat Sertifikasi</span>
  </a>
</li>



  <li class="nav-item">
    <a class="nav-link" href="#">
      <i class="fas fa-graduation-cap"></i>
      <span>Riwayat Pendidikan Formal</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="#">
      <i class="fas fa-child"></i>
      <span>Anak</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="#">
      <i class="fas fa-tasks"></i>
      <span>Tugas Tambahan</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="#">
      <i class="fas fa-money-bill-wave"></i>
      <span>Riwayat Gaji Berkala</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="#">
      <i class="fas fa-level-up-alt"></i>
      <span>Riwayat Kepangkatan</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="#">
      <i class="fas fa-briefcase"></i>
      <span>Riwayat Karir Guru</span>
    </a>
  </li>

  <?php if ($this->session->userdata('is_walikelas')): ?>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
      Akses Tambahan
    </div>

    <li class="nav-item">
      <a class="nav-link text-warning" href="<?= site_url('walikelas') ?>">
        <i class="fas fa-users"></i>
        <span>Menu Wali Kelas</span>
      </a>
    </li>
  <?php endif; ?>

  <hr class="sidebar-divider d-none d-md-block">

  <!-- Logout -->
  <div class="text-center mb-2">
    <a href="<?= site_url('auth/logout') ?>" class="btn btn-danger btn-sm w-75 shadow-sm">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </div>

  <div class="text-center d-none d-md-inline mb-3">
    <button class="rounded-circle border-0 bg-white shadow-sm" id="sidebarToggle">
      <i class="fas fa-angle-double-left text-success"></i>
    </button>
  </div>

</ul>

<nav class="navbar navbar-expand navbar-dark topbar mb-4 static-top shadow">

    <!-- LEFT : HAMBURGER -->
    <ul class="navbar-nav mr-auto">
        <li class="nav-item d-md-none">
            <button class="btn btn-sm btn-outline-light"
                    id="btnToggleSidebar"
                    type="button">
                <i class="fas fa-bars"></i>
            </button>
        </li>
    </ul>

    <!-- RIGHT -->
    <ul class="navbar-nav ml-auto align-items-center">

        <li class="nav-item mr-3">
            <button id="toggleMode" class="btn btn-sm btn-outline-light">
                <i class="fas fa-moon"></i>
            </button>
        </li>

        <li class="nav-item dropdown no-arrow">
            <span class="nav-link text-white">
                <?= $this->session->userdata('nama'); ?> |
                <strong>Guru</strong>
                <?php if ($this->session->userdata('is_walikelas')): ?>
                    <span class="badge badge-warning ml-1">Wali Kelas</span>
                <?php endif; ?>
            </span>
        </li>

    </ul>
</nav>


<div class="sidebar-overlay" id="sidebarOverlay"></div>
<div id="content-wrapper" class="d-flex flex-column">



