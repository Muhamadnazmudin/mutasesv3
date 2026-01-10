<!-- ================= HEADER.PHP ================= -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($title) ? $title.' - SimSGTK' : 'SimSGTK' ?></title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/logobonti.png'); ?>">

  <!-- FontAwesome -->
  <link href="<?= base_url('assets/sbadmin2/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
  <!-- Bootstrap -->
  <link href="<?= base_url('assets/sbadmin2/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
  <!-- SB Admin 2 -->
  <link href="<?= base_url('assets/sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="<?= base_url('assets/css/custom-style.css') ?>" rel="stylesheet">
  <style>
/* =====================================================
   FINAL CSS HEADER — SAFE MOBILE & DESKTOP
   FIX MODAL, SIDEBAR, TOPBAR (SB ADMIN 2)
   ===================================================== */

/* ===============================
   BASE
   =============================== */
html, body {
	margin: 0;
	padding: 0;
	width: 100%;
	font-family: "Nunito", sans-serif;
}

/* ===============================
   LIGHT MODE
   =============================== */
body.light-mode {
	background-color: #f0f4ff;
	color: #1a1a1a;
}

body.light-mode #wrapper,
body.light-mode #content-wrapper,
body.light-mode #content,
body.light-mode .container-fluid {
	background-color: #fafcff;
	color: #000;
}

body.light-mode .card,
body.light-mode .card-body,
body.light-mode .card-header {
	background-color: #ffffff;
	border: 1px solid #e3e7ff;
	color: #000;
}

body.light-mode .table thead th {
	background-color: #e4ebff;
	color: #000;
}

body.light-mode .topbar {
	background-color: #f9fbff;
	border-bottom: 1px solid #dce4ff;
}

/* ===============================
   SIDEBAR & TOPBAR — DESKTOP
   =============================== */
@media (min-width: 768px) {

	html, body {
		height: 100%;
		overflow: hidden;
	}

	.sidebar {
		position: fixed;
		top: 0;
		left: 0;
		width: 224px;
		height: 100vh;
		overflow-y: auto;
		z-index: 1030;
	}

	.topbar {
		position: fixed;
		top: 0;
		left: 224px;
		right: 0;
		height: 72px;
		z-index: 1040;
	}

	#content-wrapper {
		margin-left: 224px;
		padding-top: 72px;
		height: 100vh;
		overflow-y: auto;
	}

	/* Sidebar collapse */
	.sidebar.toggled {
		width: 80px !important;
	}

	.sidebar.toggled ~ #content-wrapper {
		margin-left: 80px !important;
	}

	.sidebar.toggled ~ .topbar {
		left: 80px !important;
	}
}

/* ===============================
   MOBILE — SAFE MODE (PORTRAIT & LANDSCAPE)
   =============================== */
@media (max-width: 767px) {

	/* MOBILE HARUS BOLEH SCROLL */
	html, body {
		height: auto !important;
		overflow: auto !important;
	}

	/* Sidebar overlay */
	.sidebar {
		position: fixed !important;
		top: 0;
		left: -260px;
		width: 260px;
		height: 100vh;
		overflow-y: auto;
		transition: all 0.3s ease;
		z-index: 3000;
	}

	.sidebar.toggled {
		left: 0;
	}

	/* Topbar */
	.topbar {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		height: 70px;
		z-index: 3500;
	}

	/* Content */
	#content-wrapper {
		margin-left: 0 !important;
		padding-top: 70px;
		height: auto !important;
		overflow: visible !important;
	}

	/* Modal FIX TOTAL */
	.modal {
		position: fixed !important;
		z-index: 5000 !important;
	}

	.modal-backdrop {
		z-index: 4900 !important;
	}

	.modal,
	.modal * {
		pointer-events: auto !important;
		touch-action: manipulation !important;
	}

	/* Sidebar & topbar jangan blok modal */
	body.modal-open .sidebar,
	body.modal-open .topbar {
		pointer-events: none !important;
	}
}

/* ===============================
   SUBMENU FIX
   =============================== */
.sidebar .collapse-inner {
	background-color: #2c2f48;
}

.sidebar .collapse-inner .collapse-item {
	color: #d1d1d1;
}

.sidebar .collapse-inner .collapse-item:hover {
	background-color: #3a3d5c;
	color: #fff;
}

.sidebar .collapse-inner .collapse-item.active {
	background-color: #4c5177;
	color: #fff;
}

/* ===============================
   SAFETY — NO BODY LOCK
   =============================== */
body.modal-open {
	overflow: visible !important;
}

</style>

</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
