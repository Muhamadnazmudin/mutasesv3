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
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown no-arrow">
                    <span class="nav-link text-gray-800">
                        <?= $this->session->userdata('siswa_nama'); ?> | <strong>Siswa</strong>
                    </span>
                </li>
            </ul>
        </nav>
