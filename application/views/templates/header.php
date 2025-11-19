<!-- ================= HEADER.PHP ================= -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($title) ? $title.' - Mutases' : 'Mutases' ?></title>

  <!-- FontAwesome -->
  <link href="<?= base_url('assets/sbadmin2/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
  <!-- Bootstrap -->
  <link href="<?= base_url('assets/sbadmin2/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
  <!-- SB Admin 2 -->
  <link href="<?= base_url('assets/sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="<?= base_url('assets/css/custom-style.css') ?>" rel="stylesheet">
  <style>

/* ===============================
   LIGHT MODE — SOFT BLUE THEME
   =============================== */

/* Warna dasar agak kebiruan lembut */
body.light-mode {
    background-color: #f0f4ff !important; /* soft blue-white */
    color: #1a1a1a !important;
}

/* Wrapper & Content lebih redup (soft white-blue) */
body.light-mode #wrapper,
body.light-mode #content-wrapper,
body.light-mode #content,
body.light-mode .container-fluid {
    background-color: #f7f9ff !important; /* very soft blue white */
    color: #000 !important;
}

/* Card tema terang lembut */
body.light-mode .card,
body.light-mode .card-body,
body.light-mode .card-header {
    background-color: #ffffff !important;
    border: 1px solid #e3e7ff !important; /* border sedikit biru */
    box-shadow: 0 2px 6px rgba(0, 50, 150, 0.05) !important;
    color: #000 !important;
}

/* Tabel header biru muda */
body.light-mode .table thead th {
    background-color: #e4ebff !important;
    color: #000 !important;
}

/* Baris tabel tetap putih */
body.light-mode .table tbody tr {
    background-color: #ffffff !important;
}

/* Hover tabel sedikit kebiruan */
body.light-mode .table tbody tr:hover {
    background-color: #eef3ff !important;
}

/* Topbar putih kebiruan */
body.light-mode .topbar {
    background-color: #f9fbff !important;
    border-bottom: 1px solid #dce4ff !important;
}

/* Sidebar tetap gradient biru */
body.light-mode .sidebar {
    background: linear-gradient(180deg, #4e73df 10%, #224abe 100%) !important;
}

/* Warna teks umum */
body.light-mode h1,
body.light-mode h2,
body.light-mode h3,
body.light-mode h4,
body.light-mode p,
body.light-mode span,
body.light-mode label,
body.light-mode td,
body.light-mode th {
    color: #1a1a1a !important;
}
/* ==== FIX SIDEBAR SCROLL BARENG CONTENT ==== */
html, body {
    height: 100%;
    overflow: hidden; /* kunci body agar tidak scroll */
}

/* Sidebar SB Admin 2 */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh !important;   /* full tinggi layar */
    overflow-y: auto;           /* sidebar scroll sendiri */
    z-index: 1000;
}

/* Geser content-wrapper agar tidak ketutup sidebar */
#content-wrapper {
    margin-left: 224px; /* lebar default sidebar SB Admin 2 */
    height: 100vh;
    overflow-y: auto;   /* hanya konten yang scroll */
}

/* Ketika sidebar collapsed */
.sidebar.toggled {
    width: 80px !important;
}

.sidebar.toggled + #content-wrapper {
    margin-left: 80px !important;
}
/* ==== KUNCI BODY ==== */
html, body {
    height: 100%;
    overflow: hidden; /* jangan scroll body */
}

/* ==== SIDEBAR FIX ==== */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    overflow-y: auto;
    z-index: 1030;
}

/* ==== TOPBAR FIX ==== */
.topbar {
    position: fixed;
    top: 0;
    left: 224px; /* lebar default sidebar */
    right: 0;
    z-index: 1031;
}

/* ==== KONTEN YANG SCROLL ==== */
#content-wrapper {
    margin-left: 224px; /* ikut lebar sidebar */
    padding-top: 72px;  /* beri ruang untuk topbar */
    height: 100vh;
    overflow-y: auto;   /* hanya konten yang scroll */
}

/* ==== MODE SIDEBAR TOGGLE ==== */
.sidebar.toggled {
    width: 80px !important;
}

.sidebar.toggled + #content-wrapper,
.sidebar.toggled ~ #content-wrapper {
    margin-left: 80px !important;
}

.topbar.sidebar-toggled {
    left: 80px !important;
}
/* ==== SIDEBAR FIX ==== */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 224px;
    height: 100vh;
    display: flex;
    flex-direction: column;
}

/* Bagian brand SIDEBAR (MUTASES) dibikin fix di atas */
.sidebar .sidebar-brand {
    position: sticky;
    top: 0;
    z-index: 1040;
    background: inherit;   /* ikuti warna sidebar */
    padding-top: 1rem;
    padding-bottom: 1rem;
}

/* Isi sidebar yang scroll */
.sidebar .nav-item,
.sidebar .sidebar-heading,
.sidebar hr {
    flex-shrink: 0;
}

#accordionSidebar {
    overflow-y: auto;
    overflow-x: hidden;
    flex-grow: 1; /* area menu yang bisa scroll */
}

</style>

</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
