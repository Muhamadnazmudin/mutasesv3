<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= isset($title) ? $title : 'Dashboard Siswa'; ?></title>

    <!-- FONT AWESOME -->
    <link href="<?= base_url('assets/sbadmin2/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet">

    <!-- SB ADMIN 2 CSS -->
    <link href="<?= base_url('assets/sbadmin2/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

    <style>
        body {
            font-size: 0.9rem;
        }

        /* ===== MOBILE SIDEBAR TOGGLE ===== */
        #btnToggleSidebar {
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1050;
            border-radius: 10px;
            box-shadow: 0 6px 18px rgba(0,0,0,.25);
        }

        /* ===== OVERLAY ===== */
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
        /* ================= DARK MODE SISWA ================= */
.dark-mode {
    background-color: #1e1f2b;
}

.dark-mode .topbar {
    background: #24263a !important;
    border-bottom: 1px solid #2f314a;
}

.dark-mode .topbar .nav-link,
.dark-mode .topbar strong {
    color: #f1f1f1 !important;
}

/* CONTENT */
.dark-mode #content-wrapper {
    background-color: #1e1f2b;
    color: #e6e6e6;
}

/* CARD */
.dark-mode .card {
    background-color: #2a2d3e;
    color: #f1f1f1;
    border-color: #34384f;
}

.dark-mode .card-header {
    background-color: #2f3248 !important;
    border-bottom: 1px solid #3a3f55;
}

/* TABLE */
.dark-mode table {
    color: #eaeaea;
}

/* BUTTON */
.dark-mode .btn-outline-secondary {
    color: #ddd;
    border-color: #555;
}

.dark-mode .btn-outline-secondary:hover {
    background: #444;
}

/* LIST GROUP */
.dark-mode .list-group-item {
    background-color: #2a2d3e;
    color: #f1f1f1;
    border-color: #3a3f55;
}
/* ===== FIX CONTENT KETUTUP TOPBAR ===== */
#content {
    padding-top: 70px;
}
/* ================= DARK MODE SIDEBAR SISWA ================= */
.dark-mode #accordionSidebar {
    background: linear-gradient(180deg, #1c1f2e, #151827);
}

.dark-mode #accordionSidebar .sidebar-brand {
    background: transparent;
}

.dark-mode #accordionSidebar .sidebar-brand-text,
.dark-mode #accordionSidebar .nav-link {
    color: #e8eaf6;
}

.dark-mode #accordionSidebar .nav-link i {
    color: #b0b7ff;
}

.dark-mode #accordionSidebar .nav-link:hover {
    background: rgba(255,255,255,.08);
}

.dark-mode #accordionSidebar .nav-item.active .nav-link {
    background: rgba(255,255,255,.12);
    box-shadow: inset 3px 0 0 #7aa2ff;
}

.dark-mode #accordionSidebar .sidebar-divider {
    border-top: 1px solid rgba(255,255,255,.1);
}

/* Logout */
.dark-mode #accordionSidebar .btn-danger {
    background: #c0392b;
    border: none;
}
/* ================= DARK MODE TOPBAR ================= */
.dark-mode .topbar {
    background: linear-gradient(90deg, #1c1f2e, #151827) !important;
    border-bottom: 1px solid #2f334d;
}

.dark-mode .topbar .nav-link,
.dark-mode .topbar strong {
    color: #e8eaf6 !important;
}

.dark-mode #toggleDarkMode {
    border-color: #4b4f75;
    color: #e8eaf6;
}
/* ================= DARK MODE CONTENT ================= */
.dark-mode body {
    background: #12141f;
}

.dark-mode #content-wrapper {
    background: #12141f;
}

.dark-mode #content {
    background: #12141f;
    color: #e0e0e0;
}
/* CARD */
.dark-mode .card {
    background: #1f2233;
    border-color: #2f334d;
    color: #f1f1f1;
}

.dark-mode .card-header {
    background: #23263a !important;
    border-bottom: 1px solid #2f334d;
}

/* LIST / ALERT */
.dark-mode .list-group-item,
.dark-mode .alert {
    background: #1f2233;
    border-color: #2f334d;
    color: #f1f1f1;
}

/* MUTED TEXT */
.dark-mode .text-muted {
    color: #aab0ff !important;
}
.dark-mode .btn-primary {
    background: #4c6ef5;
    border-color: #4c6ef5;
}

.dark-mode .badge {
    background: #343aeb;
}
/* ================= DARK MODE FORM ================= */
.dark-mode input,
.dark-mode textarea,
.dark-mode select {
    background-color: #1f2233;
    color: #e8eaf6;
    border: 1px solid #3a3f55;
}

.dark-mode input::placeholder,
.dark-mode textarea::placeholder {
    color: #9aa0c7;
}

/* focus */
.dark-mode input:focus,
.dark-mode textarea:focus,
.dark-mode select:focus {
    background-color: #1f2233;
    color: #ffffff;
    border-color: #7aa2ff;
    box-shadow: 0 0 0 .15rem rgba(122,162,255,.25);
}
/* LABEL */
.dark-mode label,
.dark-mode .form-label {
    color: #cfd3ff;
}

/* HELP TEXT */
.dark-mode .form-text {
    color: #aab0ff;
}
/* ================= DARK MODE TABLE ================= */
.dark-mode table {
    color: #e8eaf6;
}

.dark-mode table th {
    background-color: #23263a;
    color: #cfd3ff;
    border-color: #3a3f55;
}

.dark-mode table td {
    background-color: #1f2233;
    color: #e8eaf6;
    border-color: #3a3f55;
}
.dark-mode .bg-light,
.dark-mode .bg-white {
    background-color: #23263a !important;
    color: #e8eaf6 !important;
}
.dark-mode input[readonly],
.dark-mode input:disabled,
.dark-mode textarea:disabled {
    background-color: #1a1d2b;
    color: #9aa0c7;
}
/* ================= DARK MODE SECTION TITLE ================= */
.dark-mode .section-title {
    background: linear-gradient(90deg, #1f2233, #23263a);
    color: #e8eaf6;
    border-left: 4px solid #7aa2ff;
}

/* Jika ada span / small di dalamnya */
.dark-mode .section-title span,
.dark-mode .section-title small {
    color: #b0b7ff;
}
/* ================= DARK MODE PAGE TITLE ================= */
.dark-mode h1,
.dark-mode h2,
.dark-mode h3,
.dark-mode h4,
.dark-mode .page-title,
.dark-mode .welcome-title {
    color: #e8eaf6 !important;
}
/* ================= DARK MODE DASHBOARD CARD ================= */
.dark-mode .card .text-gray-800,
.dark-mode .card .text-dark,
.dark-mode .card .font-weight-bold {
    color: #e8eaf6 !important;
}

.dark-mode .card .text-xs,
.dark-mode .card .text-uppercase {
    color: #9aa0ff !important;
}
.dark-mode .card h5,
.dark-mode .card h4,
.dark-mode .card h3,
.dark-mode .card .h5,
.dark-mode .card .h4 {
    color: #ffffff !important;
}
.dark-mode .card .status,
.dark-mode .card .text-success,
.dark-mode .card .text-info,
.dark-mode .card .text-primary {
    color: #7df0c8 !important;
}
/* ================= FIX PUDAR ================= */
.dark-mode .card * {
    opacity: 1 !important;
}

    </style>
</head>

<body id="page-top">

    <!-- MOBILE TOGGLE BUTTON -->
    <button class="btn btn-sm btn-primary d-md-none"
            id="btnToggleSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- PAGE WRAPPER -->
    <div id="wrapper">
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('accordionSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const btn = document.getElementById('btnToggleSidebar');

    if (btn) {
        btn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });
    }

    if (overlay) {
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });
    }
});
</script>
