<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Cell\DataType;


class Dashboard extends CI_Controller {

    public function __construct()
{
    parent::__construct();
    $this->load->library('session');
    $this->load->database();

    // Ambil tahun ajaran dari session (kalau ada)
    $session_tahun = $this->session->userdata('tahun_id');

    if ($session_tahun) {
        $this->tahun_id = $session_tahun;
    } else {
        // Publik / belum login → ambil tahun aktif
        $t = $this->db->get_where('tahun_ajaran', ['aktif' => 1])->row();
        $this->tahun_id = $t ? $t->id : null;
    }
}
    // ==========================================================
    //  DASHBOARD
    // ==========================================================
    public function index()
{
    $data['title'] = 'Dashboard';

    // ===============================
    //  JIKA SUDAH LOGIN
    // ===============================
    if ($this->session->userdata('logged_in')) {

        $role = $this->session->userdata('role_name');

        // 🔒 GURU TIDAK BOLEH KE DASHBOARD ADMIN
        if ($role === 'guru') {
            redirect('guru_dashboard');
        }

        // 🔒 ROLE LAIN SELAIN ADMIN
        if ($role !== 'admin') {
            redirect('auth/logout');
        }

        // ===============================
        //  DASHBOARD ADMIN
        // ===============================
        $data['active'] = 'dashboard';

        $data['rombel'] = $this->get_kelas_by_tingkat();
        $data['aktif']  = $this->get_siswa_aktif_by_tingkat();
        $data['masuk']  = $this->get_siswa_masuk_by_tingkat();
        $data['keluar'] = $this->get_siswa_keluar_by_tingkat();

        $q = $this->db
            ->select('tahun_ajaran.tahun, COUNT(siswa.id) AS jumlah')
            ->join('tahun_ajaran', 'tahun_ajaran.id = siswa.tahun_id', 'left')
            ->where('siswa.status', 'lulus')
            ->where('siswa.tahun_id', $this->tahun_id)
            ->group_by('tahun_ajaran.tahun')
            ->get('siswa');

        $data['lulus'] = $q ? $q->result() : [];
        $data['per_rombel'] = $this->get_siswa_per_rombel();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');

        return;
    }

    // ===============================
    //  JIKA BELUM LOGIN → PUBLIK
    // ===============================
   $data['rombel']     = $this->get_kelas_by_tingkat();
$data['aktif']      = $this->get_siswa_aktif_by_tingkat();
$data['masuk']      = $this->get_siswa_masuk_by_tingkat();
$data['keluar']     = $this->get_siswa_keluar_by_tingkat();
$data['per_rombel'] = $this->get_siswa_per_rombel();

/* TAMBAHKAN INI */
$q = $this->db
    ->select('tahun_ajaran.tahun, COUNT(siswa.id) AS jumlah')
    ->join('tahun_ajaran', 'tahun_ajaran.id = siswa.tahun_id', 'left')
    ->where('siswa.status', 'lulus')
    ->where('siswa.tahun_id', $this->tahun_id)
    ->group_by('tahun_ajaran.tahun')
    ->get('siswa');

$data['lulus'] = $q ? $q->result() : [];

/* BARU LOAD VIEW */
$this->load->view('dashboard/public', $data);
}



    // ==========================================================
    // 🔹 HITUNG KELAS PER TINGKAT
    // ==========================================================
    private function get_kelas_by_tingkat() {
        $out = ['x'=>0,'xi'=>0,'xii'=>0,'total'=>0];

        $regex = [
            'x'   => "^X( |$|[^I])",
            'xi'  => "^XI( |$)",
            'xii' => "^XII"
        ];

        foreach ($regex as $k => $r) {
            $this->db->where("nama REGEXP '$r'");
            $out[$k] = $this->db->count_all_results('kelas');
        }

        $out['total'] = $out['x'] + $out['xi'] + $out['xii'];
        return $out;
    }



    // ==========================================================
    // 🔹 SISWA AKTIF PER TINGKAT (siswa_tahun)
    // ==========================================================
    private function get_siswa_aktif_by_tingkat()
{
    $out = ['x'=>0,'xi'=>0,'xii'=>0,'total'=>0];

    $regex = [
        'x'   => "^X( |$)",
        'xi'  => "^XI( |$)",
        'xii' => "^XII( |$)"
    ];

    foreach ($regex as $k => $r) {

        $this->db->select('COUNT(siswa.id) AS jumlah');
        $this->db->from('siswa');
        $this->db->join('kelas', 'kelas.id = siswa.id_kelas', 'left');
        $this->db->where('siswa.status', 'aktif');
        $this->db->where("kelas.nama REGEXP '$r'");

        $q = $this->db->get()->row();
        $out[$k] = $q ? (int)$q->jumlah : 0;
    }

    $out['total'] = $out['x'] + $out['xi'] + $out['xii'];
    return $out;
}


    // ==========================================================
    // 🔹 SISWA KELUAR PER TINGKAT (mutasi)
    // ==========================================================
    private function get_siswa_keluar_by_tingkat()
{
    $out = ['x'=>0,'xi'=>0,'xii'=>0,'total'=>0];

    $regex = [
        'x'   => "^X( |$)",
        'xi'  => "^XI( |$)",
        'xii' => "^XII( |$)"
    ];

    foreach ($regex as $k => $r) {

        $this->db->select('COUNT(siswa.id) AS jumlah');
        $this->db->from('siswa');
        $this->db->join('kelas', 'kelas.id = siswa.id_kelas', 'left');

        // STATUS KELUAR
        $this->db->where_in('siswa.status', [
            'keluar',
            'mutasi_keluar',
            'meninggal'
        ]);

        $this->db->where("kelas.nama REGEXP '$r'");

        $row = $this->db->get()->row();
        $out[$k] = $row ? (int)$row->jumlah : 0;
    }

    $out['total'] = $out['x'] + $out['xi'] + $out['xii'];
    return $out;
}


    // ==========================================================
    // 🔹 SISWA PER ROMBEL (PUBLIK) — siswa_tahun
    // ==========================================================
    private function get_siswa_per_rombel()
{
    $q = $this->db
        ->select("
            kelas.nama AS nama_kelas,
            SUM(CASE WHEN siswa.jk = 'L' THEN 1 ELSE 0 END) AS laki,
            SUM(CASE WHEN siswa.jk = 'P' THEN 1 ELSE 0 END) AS perempuan,
            COUNT(siswa.id) AS total
        ")
        ->from('siswa')
        ->join('kelas', 'kelas.id = siswa.id_kelas', 'left')
        ->where('siswa.status', 'aktif')
        ->group_by('kelas.id')
        ->order_by('kelas.nama', 'ASC')
        ->get();

    return $q->result();
}

    // ==========================================================
    // 🔹 DOWNLOAD PER KELAS (pakai siswa, tetap aman)
    // ==========================================================
   public function download_excel($kelas_id = null) {
    if (!$kelas_id) show_error('Kelas tidak ditemukan.');

    // ambil kelas
    $kelas = $this->db->get_where('kelas', ['id' => $kelas_id])->row();
    if (!$kelas) show_error('Data kelas tidak valid.');

    // hit +1 counter download
    $this->db->set('download_count', 'download_count + 1', FALSE)
             ->where('id', $kelas_id)
             ->update('kelas');

    // ambil siswa aktif kelas ini (join tahun ajaran)
    $siswa = $this->db
        ->select('siswa.nis, siswa.nisn, siswa.nama, siswa.jk, siswa.no_hp_ortu, tahun_ajaran.tahun AS tahun_ajaran')
        ->from('siswa')
        ->join('tahun_ajaran', 'tahun_ajaran.id = siswa.tahun_id', 'left')
        ->where('siswa.id_kelas', $kelas_id)
        ->where('siswa.status', 'aktif')
        ->order_by('siswa.nama', 'ASC')
        ->get()
        ->result();

    if (empty($siswa)) {
        show_error('Tidak ada data siswa aktif di kelas ini.');
    }


    @ob_end_clean();
    ob_start();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Siswa_Kelas_' . preg_replace('/[^A-Za-z0-9_]/', '_', $kelas->nama));

    // Header
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'NIS');
    // $sheet->setCellValue('C1', 'NISN');
    $sheet->setCellValue('D1', 'Nama');
    $sheet->setCellValue('E1', 'JK');
    // $sheet->setCellValue('F1', 'No HP Ortu');
    $sheet->setCellValue('G1', 'Tahun Ajaran');
    $sheet->setCellValue('H1', 'Kelas');

    // Style header (simple)
    $sheet->getStyle('A1:H1')->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        'borders' => [
            'allBorders' => [
                'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
            ]
        ]
    ]);

    // Isi data
    $row = 2;
    $no = 1;
    foreach ($siswa as $s) {
        // No
        $sheet->setCellValue("A{$row}", $no++);

        // NIS & NISN sebagai teks (paksa agar tidak hilang/format)
        $sheet->setCellValueExplicit("B{$row}", (string)$s->nis, DataType::TYPE_STRING);
        // $sheet->setCellValueExplicit("C{$row}", (string)$s->nisn, DataType::TYPE_STRING);

        $sheet->setCellValue("D{$row}", $s->nama);
        $sheet->setCellValue("E{$row}", $s->jk ?: '-');

        // Nomor HP orang tua juga sebagai teks
        // $sheet->setCellValueExplicit("F{$row}", (string)$s->no_hp_ortu, DataType::TYPE_STRING);

        $sheet->setCellValue("G{$row}", $s->tahun_ajaran ?: '-');

        // Tulis nama kelas di kolom H
        $sheet->setCellValue("H{$row}", $kelas->nama);

        $row++;
    }

    // Autosize columns A..H
    foreach (range('A', 'H') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Output sebagai XLS (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    $fileName = 'Siswa_Kelas_' . preg_replace('/[^A-Za-z0-9_]/', '_', $kelas->nama) . '.xls';
    header('Content-Disposition: attachment;filename="'. $fileName .'"');
    header('Cache-Control: max-age=0');

    $writer = new Xls($spreadsheet);
    $writer->save('php://output');

    ob_end_flush();
    exit;
}

// ==========================================================
// 🔹 SISWA MASUK PER TINGKAT (mutasi masuk)
// ==========================================================
private function get_siswa_masuk_by_tingkat()
{
    $out = ['x'=>0,'xi'=>0,'xii'=>0,'total'=>0];

    // regex tingkat
    $regex = [
        'x'   => "^X( |$)",
        'xi'  => "^XI( |$)",
        'xii' => "^XII( |$)"
    ];

    foreach ($regex as $k => $r) {

        $this->db->select('COUNT(m.id) AS jumlah');
        $this->db->from('mutasi m');
        $this->db->join('siswa s', 's.id = m.siswa_id', 'left');
        $this->db->join('siswa_tahun st', 'st.siswa_id = s.id AND st.tahun_id = m.tahun_id', 'left');
        $this->db->join('kelas k', 'k.id = st.kelas_id', 'left');

        $this->db->where('m.jenis', 'masuk');          // HANYA MUTASI MASUK
        $this->db->where('m.tahun_id', $this->tahun_id); // TAHUN AKTIF
        $this->db->where("k.nama REGEXP '$r'");        // FILTER TINGKAT

        $row = $this->db->get()->row();
        $out[$k] = $row ? (int)$row->jumlah : 0;
    }

    $out['total'] = $out['x'] + $out['xi'] + $out['xii'];

    return $out;
}


}
