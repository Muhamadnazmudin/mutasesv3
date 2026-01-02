<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- ===== TITLE ===== -->
  <title>SimSGTK – Sistem Informasi Siswa & GTK</title>

  <!-- ===== BASIC META ===== -->
  <meta name="description" content="SimSGTK adalah aplikasi manajemen sekolah modern untuk pengelolaan data siswa, guru, absensi, mutasi, dan administrasi pendidikan secara terintegrasi.">
  <meta name="theme-color" content="#007bff">

  <!-- ===== OPEN GRAPH (WHATSAPP, FB, TELEGRAM) ===== -->
  <meta property="og:title" content="SimSGTK – Sistem Informasi Siswa & GTK">
  <meta property="og:description" content="Aplikasi manajemen sekolah terpadu untuk pengelolaan siswa, guru, absensi, mutasi, dan administrasi pendidikan secara cepat, rapi, dan modern.">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= base_url() ?>">
  <meta property="og:image" content="<?= base_url('assets/pwa/icon-512.png') ?>">
  <meta property="og:image:width" content="512">
  <meta property="og:image:height" content="512">

  <!-- ===== TWITTER CARD (OPSIONAL) ===== -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="SimSGTK – Sistem Informasi Siswa & GTK">
  <meta name="twitter:description" content="Solusi digital sekolah untuk pengelolaan data siswa dan tenaga kependidikan secara efisien.">
  <meta name="twitter:image" content="<?= base_url('assets/pwa/icon-512.png') ?>">

  <!-- ===== ICON ===== -->
  <link rel="icon" href="<?= base_url('assets/pwa/favicon.ico') ?>" sizes="any">
  <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('assets/pwa/icon-192.png') ?>">
  <link rel="icon" type="image/png" sizes="512x512" href="<?= base_url('assets/pwa/icon-512.png') ?>">
  <link rel="apple-touch-icon" href="<?= base_url('assets/pwa/icon-192.png') ?>">

  <!-- ===== PWA ===== -->
  <link rel="manifest" href="<?= base_url('assets/pwa/manifest.json') ?>">

  <!-- ===== CSS ===== -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
  :root {
  /* ===== COLOR SYSTEM ===== */
  --primary: #0d6efd;
  --primary-dark: #0b5ed7;

  /* Light */
  --bg-light: #f5f7fb;
  --card-light: #ffffff;
  --text-light: #212529;
  --muted-light: #6c757d;
  --border-light: #dee2e6;

  /* Dark */
  --bg-dark: #12141c;
  --card-dark: #1c1f2b;
  --text-dark: #f1f3f5;
  --muted-dark: #adb5bd;
  --border-dark: #343a55;

  --radius: 12px;
  --shadow: 0 4px 14px rgba(0,0,0,.08);
}

* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
  background: var(--bg-light);
  color: var(--text-light);
  transition: background .25s, color .25s;
}

body.dark-mode {
  background: var(--bg-dark);
  color: var(--text-dark);
}

/* ================= HEADER ================= */
header {
  background: linear-gradient(135deg, var(--primary), var(--primary-dark));
  box-shadow: 0 4px 15px rgba(13,110,253,.35);
}

.navbar {
  padding: .8rem 0;
}

.navbar-brand {
  font-weight: 700;
  font-size: 1.3rem;
}

.nav-link {
  color: rgba(255,255,255,.9) !important;
  border-radius: 8px;
  padding: .5rem .9rem !important;
}

.nav-link:hover {
  background: rgba(255,255,255,.15);
}

/* Toggle */
.btn-theme-toggle {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  border: 1px solid rgba(255,255,255,.4);
  background: rgba(255,255,255,.2);
  color: #fff;
}

/* ================= CONTENT ================= */
main {
  padding: 2rem 0;
}

.welcome-section h3 {
  font-weight: 700;
  color: var(--primary);
}

body.dark-mode .welcome-section h3 {
  color: #8bb4ff;
}

#currentTime {
  color: var(--muted-light);
}

body.dark-mode #currentTime {
  color: var(--muted-dark);
}

/* ================= CARD ================= */
.card {
  border-radius: var(--radius);
  background: var(--card-light);
  border: 1px solid var(--border-light);
  box-shadow: var(--shadow);
}

body.dark-mode .card {
  background: var(--card-dark);
  border-color: var(--border-dark);
}

.card h5 {
  font-weight: 600;
  color: var(--primary);
}

body.dark-mode .card h5 {
  color: #9bbcff;
}

/* ================= TABLE ================= */
.table-responsive {
  border-radius: var(--radius);
  overflow: hidden;
}

.table {
  margin: 0;
}

.table thead th {
  background: #eef2ff;
  font-size: .8rem;
  text-transform: uppercase;
  color: #1e293b;
  border-bottom: 2px solid var(--border-light);
}

body.dark-mode .table thead th {
  background: #232844;
  color: #ffffff;
  border-bottom-color: var(--border-dark);
}

.table td {
  border-bottom: 1px solid var(--border-light);
}

body.dark-mode .table td {
  color: var(--text-dark);
  border-bottom-color: var(--border-dark);
}

.table tbody tr:hover {
  background: rgba(13,110,253,.06);
}

body.dark-mode .table tbody tr:hover {
  background: rgba(13,110,253,.2);
}

.table-secondary {
  background: rgba(13,110,253,.12);
  font-weight: 600;
}

body.dark-mode .table-secondary {
  background: rgba(13,110,253,.3);
}

/* ================= BUTTON ================= */
.btn-success {
  background: var(--primary);
  border: none;
}

.btn-success:hover {
  background: var(--primary-dark);
}

/* ================= FOOTER ================= */
footer {
  margin-top: 4rem;
  padding: 1.5rem 0;
  background: var(--card-light);
  border-top: 1px solid var(--border-light);
}

body.dark-mode footer {
  background: var(--card-dark);
  border-top-color: var(--border-dark);
}

/* ================= CHATBOT ================= */
#chatbot {
  background: var(--card-light);
  border-radius: var(--radius);
  border: 1px solid var(--border-light);
}

body.dark-mode #chatbot {
  background: var(--card-dark);
  border-color: var(--border-dark);
}

#chatbot-header {
  background: var(--primary);
  color: #fff;
}

.bot-msg {
  background: #e7f1ff;
  color: #084298;
}

body.dark-mode .bot-msg {
  background: #2a3158;
  color: #dbe4ff;
}

.user-msg {
  background: var(--primary);
}
/* ================= DARK MODE TABLE FIX ================= */
body.dark-mode table {
  background-color: transparent;
}

body.dark-mode .table {
  color: #f1f3f5;
}

body.dark-mode .table thead th {
  background-color: #1f253a !important;
  color: #ffffff !important;
  border-bottom: 2px solid #3d4566 !important;
}

body.dark-mode .table tbody td {
  background-color: #161b2e !important;
  color: #e9ecef !important;
  border-color: #2f3658 !important;
}

body.dark-mode .table tbody tr:hover td {
  background-color: rgba(13,110,253,0.25) !important;
}

/* Baris TOTAL */
body.dark-mode .table-secondary td {
  background-color: #24305e !important;
  color: #ffffff !important;
  font-weight: 700;
}

/* Jika tabel kosong */
body.dark-mode .table td.text-muted {
  color: #adb5bd !important;
}

/* ================= CHATBOT FIX TOTAL ================= */
#chatbot {
  position: fixed;
  bottom: 90px;
  right: 20px;
  width: 340px;
  max-height: 520px;
  background: var(--card-light);
  border-radius: 14px;
  display: none;
  flex-direction: column;
  overflow: hidden;
  z-index: 9999;
  border: 1px solid var(--border-light);
  box-shadow: 0 12px 30px rgba(0,0,0,.25);
}

body.dark-mode #chatbot {
  background: var(--card-dark);
  border-color: var(--border-dark);
}

/* HEADER */
#chatbot-header {
  background: linear-gradient(135deg, var(--primary), var(--primary-dark));
  color: #fff;
  padding: .7rem 1rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

/* BODY */
#chatbot-body {
  flex: 1;
  padding: .8rem;
  overflow-y: auto;
  background: transparent;
  font-size: .85rem;
}

/* FOOTER */
#chatbot-footer {
  display: flex;
  border-top: 1px solid var(--border-light);
  background: inherit;
}

body.dark-mode #chatbot-footer {
  border-top-color: var(--border-dark);
}

/* INPUT */
#chatbot-input {
  flex: 1;
  border: none;
  padding: .6rem .8rem;
  outline: none;
  background: transparent;
  color: inherit;
  font-size: .85rem;
}

/* SEND BUTTON */
#chatbot-send {
  border: none;
  padding: 0 .9rem;
  background: var(--primary);
  color: #fff;
  cursor: pointer;
}

/* CHAT BUBBLE */
.bot-msg {
  background: #e7f1ff;
  color: #084298;
  padding: .55rem .75rem;
  border-radius: 12px 12px 12px 4px;
  margin-bottom: .5rem;
  max-width: 85%;
}

body.dark-mode .bot-msg {
  background: #2a3158;
  color: #dbe4ff;
}

.user-msg {
  background: var(--primary);
  color: #fff;
  padding: .55rem .75rem;
  border-radius: 12px 12px 4px 12px;
  margin-left: auto;
  margin-bottom: .5rem;
  max-width: 85%;
}

/* FLOAT BUTTON */
#chatbot-toggle {
  width: 58px;
  height: 58px;
  border-radius: 50%;
  background: var(--primary);
  border: none;
  color: #fff;
  font-size: 1.3rem;
  box-shadow: 0 8px 20px rgba(13,110,253,.45);
}
/* ================= FLOAT CHAT WRAPPER ================= */
#chatbot-wrapper {
  position: fixed;
  right: 22px;
  bottom: 22px;
  z-index: 99999;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
}

/* Label */
.chatbot-label {
  background: var(--card-light);
  color: var(--text-light);
  padding: 4px 10px;
  border-radius: 20px;
  font-size: .75rem;
  box-shadow: 0 4px 12px rgba(0,0,0,.15);
}

body.dark-mode .chatbot-label {
  background: var(--card-dark);
  color: var(--text-dark);
}

.bot-anim {
  animation: botWave 2s infinite ease-in-out;
  transform-origin: center;
}

@keyframes botWave {
  0%   { transform: rotate(0deg) scale(1); }
  25%  { transform: rotate(5deg) scale(1.05); }
  50%  { transform: rotate(0deg) scale(1); }
  75%  { transform: rotate(-5deg) scale(1.05); }
  100% { transform: rotate(0deg) scale(1); }
}
.bot-anim {
  color: #0d6efd; /* biru Bootstrap */
  animation: botWave 2s infinite ease-in-out;
}
.bot-anu {
  color: #6f42c1; /* biru Bootstrap */
  animation: botWave 2s infinite ease-in-out;
}
body:not(.dark-mode) .bot-anim {
  color: #0d6efd; /* biru */
}
body.dark-mode .bot-anim {
  color: #66b2ff; /* biru terang */
}

  </style>
</head>

<body>

<!-- ==================== HEADER ==================== -->
<header>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">

      <!-- Brand -->
      <a class="navbar-brand" href="#">
        <i class="fas fa-chart-line"></i> Dashboard Mutasi Siswa
      </a>

      <!-- Toggle button -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menu -->
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('index.php/public_mutasi') ?>">
              <i class="fas fa-users"></i> Siswa Mutasi
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('index.php/izin/scan') ?>">
              <i class="fas fa-qrcode"></i> Izin Keluar
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('index.php/AbsensiQR/scan') ?>">
              <i class="fas fa-qrcode"></i> Absensi QR
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('index.php/DashboardMBG?tanggal='.date('Y-m-d')) ?>">
              <i class="fas fa-chart-bar"></i> Dashboard MBG
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('index.php/scrapijazah') ?>">
              <i class="fas fa-graduation-cap"></i> Scrap Ijazah PDF
            </a>
          </li>
        </ul>

        <!-- Right side actions -->
        <div class="d-flex align-items-center gap-2">

          <!-- Dark Mode Toggle -->
          <button class="btn-theme-toggle" id="toggleDark" title="Ganti Tema">
            <i class="fas fa-moon"></i>
          </button>

          <!-- Login dropdown -->
          <div class="dropdown">
            <button class="btn-login dropdown-toggle" type="button" data-bs-toggle="dropdown">
              <i class="fas fa-sign-in-alt"></i> Login
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="<?= base_url('index.php/auth/login') ?>">
                  <i class="fas fa-user-shield text-primary"></i> Login Admin
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="<?= base_url('index.php/SiswaAuth') ?>">
                  <i class="fas fa-user-graduate text-success"></i> Login Siswa
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="<?= base_url('index.php/auth/login') ?>">
                  <i class="fas fa-chalkboard-teacher text-warning"></i> Login Guru/Wali Kelas
                </a>
              </li>
            </ul>
          </div>

        </div>
      </div>

    </div>
  </nav>
</header>

<!-- ==================== MAIN CONTENT ==================== -->
<main class="container my-5">

  <div class="welcome-section">
    <h3>Selamat Datang di Sistem Mutasi Siswa 👋</h3>
    <p id="currentTime">Data per <strong>-</strong></p>
  </div>

  <h2 class="section-title">Statistik Mutasi Siswa Sekolah</h2>

  <?php $this->load->view('dashboard/index', [
      'rombel' => $rombel,
      'aktif' => $aktif,
      'keluar' => $keluar,
      'lulus' => $lulus
  ]); ?>

  <!-- Tabel Jumlah Siswa per Rombel -->
  <div class="card shadow-sm mt-5">
    <div class="card-body">
      <h5>
        <i class="fas fa-users"></i> Jumlah Siswa per Rombongan Belajar
      </h5>

      <div class="table-responsive">
        <table class="table table-sm mb-0 text-center align-middle">
          <thead>
            <tr>
              <th style="width:50px">No</th>
              <th>Nama Kelas</th>
              <th>L</th>
              <th>P</th>
              <th>Total</th>
              <th>Download</th>
              <th>Jumlah Download</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $no = 1; 
              $sumL = 0;
              $sumP = 0;
              $sumTotal = 0;
              
              if (!empty($per_rombel)):
                foreach($per_rombel as $r):
                  $sumL += $r->laki;
                  $sumP += $r->perempuan;
                  $sumTotal += $r->total;

                  $kelas = $this->db->get_where('kelas', ['nama' => $r->nama_kelas])->row();
                  $kelas_id = $kelas ? $kelas->id : 0;
                  $count = isset($kelas->download_count) ? (int)$kelas->download_count : 0;
            ?>
              <tr>
                <td><?= $no++; ?></td>
                <td class="text-start"><?= $r->nama_kelas; ?></td>
                <td><?= $r->laki; ?></td>
                <td><?= $r->perempuan; ?></td>
                <td class="fw-bold"><?= $r->total; ?></td>
                <td>
                  <?php if ($kelas_id): ?>
                    <a href="<?= base_url('index.php/dashboard/download_excel/'.$kelas_id) ?>" 
                       class="btn btn-sm btn-success">
                       <i class="fas fa-file-excel"></i> Download
                    </a>
                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </td>
                <td><?= $count > 0 ? $count . 'x download' : '-' ?></td>
              </tr>
            <?php 
                endforeach;
            ?>
              <!-- Baris Total -->
              <tr class="table-secondary">
                <td colspan="2" class="text-end">Jumlah Keseluruhan</td>
                <td><?= $sumL; ?></td>
                <td><?= $sumP; ?></td>
                <td><?= $sumTotal; ?></td>
                <td colspan="2"></td>
              </tr>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center text-muted">Belum ada data siswa aktif.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</main>

<!-- ==================== FOOTER ==================== -->
<footer class="text-center">
  <div class="container">
    &copy; <?= date('Y') ?> Sistem Mutasi Siswa — Dibuat dengan 💙 oleh <strong>Nazmudin</strong>
  </div>
</footer>

<!-- ==================== CHATBOT ==================== -->
<div id="chatbot">
  <span class="bot-title">
  <i class="fas fa-robot bot-anim"></i> SiMuMu <i class="fas fa-robot bot-anu"></i>
</span>


  <div id="chatbot-body">
    <div class="bot-msg">
      👋 Halo! Saya Asisten Mutasi Siswa.<br>
      Silakan Ketik 'cek' untuk memunculkan list pertanyaan.
    </div>
  </div>

  <div id="chatbot-footer">
    <input type="text" id="chatbot-input" placeholder="Ketik 'cek' untuk lihat menu..." />
    <button id="chatbot-send"><i class="fas fa-paper-plane"></i></button>
  </div>
</div>

<!-- Tombol Floating -->
<div id="chatbot-wrapper">
  <button id="chatbot-toggle">
    <i class="fas fa-comments"></i>
  </button>
  <div class="chatbot-label">Chat di sini</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// ==================== REALTIME CLOCK ====================
function updateTime() {
  const el = document.getElementById('currentTime');
  const now = new Date();
  const hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][now.getDay()];
  const bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][now.getMonth()];
  const jam = now.getHours().toString().padStart(2,'0');
  const menit = now.getMinutes().toString().padStart(2,'0');
  const detik = now.getSeconds().toString().padStart(2,'0');
  el.innerHTML = `Data per <strong>${hari}, ${now.getDate()} ${bulan} ${now.getFullYear()} — ${jam}:${menit}:${detik} WIB</strong>`;
}
setInterval(updateTime, 1000);
updateTime();

// ==================== DARK MODE TOGGLE ====================
const btnToggle = document.getElementById('toggleDark');
const icon = btnToggle.querySelector('i');

btnToggle.addEventListener('click', () => {
  document.body.classList.toggle('dark-mode');
  const isDark = document.body.classList.contains('dark-mode');
  localStorage.setItem('darkMode', isDark);
  
  icon.style.opacity = '0';
  setTimeout(() => {
    icon.classList.remove('fa-moon', 'fa-sun');
    icon.classList.add(isDark ? 'fa-sun' : 'fa-moon');
    icon.style.opacity = '1';
  }, 200);
});

// Apply saved theme on load
if (localStorage.getItem('darkMode') === 'true') {
  document.body.classList.add('dark-mode');
  icon.classList.replace('fa-moon', 'fa-sun');
}

// ==================== PWA SERVICE WORKER ====================
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker
      .register('/mutases/service-worker.js')
      .then(reg => console.log('PWA aktif:', reg.scope))
      .catch(err => console.error('PWA gagal:', err));
  });
}

// ==================== CHATBOT FUNCTIONALITY ====================
const CHATBOT_URL = "<?= site_url('chatbot/reply') ?>";
const CSRF_NAME = "<?= $this->security->get_csrf_token_name(); ?>";
const CSRF_HASH = "<?= $this->security->get_csrf_hash(); ?>";

const chatbot = document.getElementById('chatbot');
const toggleBtn = document.getElementById('chatbot-toggle');
const closeBtn = document.getElementById('chatbot-close');
const sendBtn = document.getElementById('chatbot-send');
const input = document.getElementById('chatbot-input');
const body = document.getElementById('chatbot-body');

// Toggle open/close
toggleBtn.onclick = () => {
  chatbot.style.display = 'flex';
  input.focus();
};

closeBtn.onclick = () => {
  chatbot.style.display = 'none';
};

// Send message
sendBtn.onclick = sendMessage;
input.addEventListener('keypress', e => {
  if (e.key === 'Enter') sendMessage();
});

function sendMessage() {
  const msg = input.value.trim();
  if (!msg) return;

  appendMessage(msg, 'user-msg');
  input.value = '';

  setTimeout(() => botReply(msg), 600);
}

function appendMessage(text, className) {
  const div = document.createElement('div');
  div.className = className;

  // Jika bot dan ada list (•)
  if (className === 'bot-msg' && text.includes('•')) {
    const lines = text.split('\n');
    let normalText = '';
    let buttons = [];

    lines.forEach(line => {
      if (line.trim().startsWith('•')) {
        buttons.push(line.replace('•', '').trim());
      } else {
        normalText += line + '<br>';
      }
    });

    div.innerHTML = normalText;

    if (buttons.length > 0) {
      const wrap = document.createElement('div');
      wrap.className = 'quick-list';

      buttons.forEach(q => {
        const btn = document.createElement('button');
        btn.className = 'quick-btn';
        btn.innerText = q;
        btn.onclick = () => {
          wrap.remove();
          appendMessage(q, 'user-msg');

          const lowerQ = q.toLowerCase();

          if (lowerQ === 'kelas') {
            appendMessage("🏫 Silakan ketik nama kelas.\nContoh: kelas XI KL1", 'bot-msg');
            input.value = 'kelas ';
            input.focus();
          } else if (lowerQ === 'cek nisn') {
            appendMessage("🆔 Silakan masukkan NISN siswa.\nContoh: cek nisn 1234567890", 'bot-msg');
            input.value = 'cek nisn ';
            input.focus();
          } else {
            botReply(q);
          }
        };

        wrap.appendChild(btn);
      });

      div.appendChild(wrap);
    }

  } else {
    div.innerText = text;
  }

  body.appendChild(div);
  body.scrollTop = body.scrollHeight;
}

// Bot reply via API
function botReply(text) {
  const params =
    "message=" + encodeURIComponent(text) +
    "&" + CSRF_NAME + "=" + CSRF_HASH;

  fetch(CHATBOT_URL, {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: params
  })
  .then(res => {
    if (!res.ok) throw new Error("HTTP error");
    return res.json();
  })
  .then(data => {
    appendMessage(data.reply, 'bot-msg');
  })
  .catch(err => {
    console.error(err);
    appendMessage("⚠️ Server sedang bermasalah.", 'bot-msg');
  });
}
</script>

</body>
</html>