<style>
    /* ================= ROOT SISWA ================= */
:root {
    --siswa-bg-1: #1e88e5;
    --siswa-bg-2: #1565c0;
    --siswa-hover: rgba(255,255,255,.14);
    --siswa-active: rgba(255,255,255,.22);
    --siswa-text: #f1f6ff;
    --siswa-muted: rgba(255,255,255,.7);
}

/* ================= SIDEBAR SISWA ================= */
#accordionSidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 224px;
    height: 100vh;
    background: linear-gradient(180deg, var(--siswa-bg-1), var(--siswa-bg-2));
    overflow-y: auto;
    z-index: 1032;
    transition: all .3s ease;
    box-shadow: 4px 0 18px rgba(0,0,0,.12);
}

/* ================= BRAND ================= */
.sidebar-brand {
    height: 64px;
    font-size: 1.05rem;
    font-weight: 700;
    letter-spacing: .5px;
}

.sidebar-brand-icon {
    font-size: 1.6rem;
}

.sidebar-brand-text {
    color: #fff;
}

/* ================= MENU ================= */
#accordionSidebar .nav-item {
    margin: 4px 12px;
}

#accordionSidebar .nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 12px;
    font-size: .9rem;
    font-weight: 500;
    color: var(--siswa-text);
    line-height: 1.35;
    transition: all .25s ease;
}

/* ICON */
#accordionSidebar .nav-link i {
    width: 20px;
    min-width: 20px;
    text-align: center;
    font-size: .95rem;
    opacity: .95;
}

/* HOVER */
#accordionSidebar .nav-link:hover {
    background: var(--siswa-hover);
    transform: translateX(3px);
}

/* ACTIVE */
#accordionSidebar .nav-item.active .nav-link {
    background: var(--siswa-active);
    font-weight: 600;
    box-shadow: inset 3px 0 0 #90caf9;
}

/* ================= TEKS MENU (FULL, 2 BARIS) ================= */
#accordionSidebar .nav-link span {
    white-space: normal;
    overflow: visible;
    text-overflow: unset;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

/* ================= DIVIDER ================= */
.sidebar-divider {
    margin: 10px 16px;
    border-top: 1px solid rgba(255,255,255,.15);
}

/* ================= LOGOUT ================= */
#accordionSidebar .btn-danger {
    border-radius: 12px;
    font-size: .85rem;
}

/* ================= CONTENT ================= */
#content-wrapper {
    margin-left: 224px;
    min-height: 100vh;
    transition: all .3s ease;
}

.sidebar-toggled #content-wrapper {
    margin-left: 80px;
}

/* ================= SIDEBAR COLLAPSE ================= */
.sidebar-toggled #accordionSidebar {
    width: 80px;
}

.sidebar-toggled #accordionSidebar span,
.sidebar-toggled #accordionSidebar .sidebar-brand-text {
    display: none;
}

.sidebar-toggled #accordionSidebar .nav-link {
    justify-content: center;
}

.sidebar-toggled #accordionSidebar .nav-link i {
    font-size: 1.1rem;
}

/* ================= TOPBAR SISWA ================= */
.topbar {
    position: fixed;
    top: 0;
    left: 224px;
    right: 0;
    z-index: 1031;
    background: #ffffff;
    transition: all .3s ease;
}

.sidebar-toggled .topbar {
    left: 80px;
}

/* ================= MOBILE ================= */
@media (max-width: 768px) {

    #accordionSidebar {
        transform: translateX(-100%);
        width: 200px;
    }

    #accordionSidebar.show {
        transform: translateX(0);
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.55);
        z-index: 1030;
    }

    .sidebar-overlay.show {
        display: block;
    }

    #content-wrapper,
    .topbar {
        margin-left: 0 !important;
        left: 0 !important;
    }
}

    </style>

<?php $active = isset($active) ? $active : ''; ?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" 
       href="<?= site_url('SiswaDashboard'); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SISWA</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item <?= ($active=='dashboard'?'active':''); ?>">
        <a class="nav-link" href="<?= site_url('SiswaDashboard'); ?>">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">
<li class="nav-item <?= ($active=='jadwal'?'active':''); ?>">
    <a class="nav-link" href="<?= site_url('SiswaJadwal'); ?>">
        <i class="fas fa-calendar-alt"></i>
        <span>Jadwal Pelajaran</span>
    </a>
</li>
<hr class="sidebar-divider">

<li class="nav-item <?= ($active=='bacaan'?'active':''); ?>">
    <a class="nav-link" href="<?= site_url('SiswaBacaan'); ?>">
        <i class="fas fa-book-reader"></i>
        <span>Bacaan / E-Book</span>
    </a>
</li>

<hr class="sidebar-divider">
    <!-- Biodata -->
    <li class="nav-item <?= ($active=='biodata'?'active':''); ?>">
        <a class="nav-link" href="<?= site_url('SiswaDashboard/biodata'); ?>">
            <i class="fas fa-id-card"></i>
            <span>Biodata Lengkap</span>
        </a>
    </li>

    <li class="nav-item <?= ($active=='edit_biodata'?'active':''); ?>">
        <a class="nav-link" href="<?= site_url('SiswaDashboard/edit_biodata'); ?>">
            <i class="fas fa-edit"></i>
            <span>Edit Biodata</span>
        </a>
    </li>

    <!-- <li class="nav-item <?= ($active=='cetak'?'active':''); ?>">
        <a class="nav-link" href="<?= site_url('SiswaDashboard/cetak'); ?>">
            <i class="fas fa-file-pdf"></i>
            <span>Cetak Biodata PDF</span>
        </a>
    </li> -->

    <!-- Kartu -->
    <li class="nav-item <?= ($active=='kartu'?'active':''); ?>">
        <a class="nav-link" href="<?= site_url('SiswaDashboard/kartu'); ?>">
            <i class="fas fa-id-badge"></i>
            <span>Kartu Siswa</span>
        </a>
    </li>

    <li class="nav-item <?= ($active=='idcard'?'active':''); ?>">
        <a class="nav-link" href="<?= site_url('SiswaDashboard/idcard'); ?>">
            <i class="fas fa-address-card"></i>
            <span>ID Card Siswa</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Logout -->
    <div class="text-center mb-2">
        <a href="<?= site_url('SiswaAuth/logout'); ?>" 
           class="btn btn-danger btn-sm w-75 shadow-sm">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <!-- Sidebar Toggle -->
    <div class="text-center d-none d-md-inline mb-3">
        <button class="rounded-circle border-0 bg-white shadow-sm" id="sidebarToggle">
            <i class="fas fa-angle-double-left text-primary"></i>
        </button>
    </div>

</ul>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <ul class="navbar-nav ml-auto align-items-center">

        <!-- DARK MODE TOGGLE -->
        <li class="nav-item mr-3">
            <button id="toggleDarkMode" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-moon"></i>
            </button>
        </li>

        <li class="nav-item dropdown no-arrow">
            <span class="nav-link text-gray-800">
                <?= $this->session->userdata('siswa_nama'); ?> |
                <strong>Siswa</strong>
            </span>
        </li>

    </ul>
</nav>
