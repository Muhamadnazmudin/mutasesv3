<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Cell\DataType;


class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();

        // Ambil tahun ajaran dari session
        $session_tahun = $this->session->userdata('tahun_id');

        if ($session_tahun) {
            $this->tahun_id = $session_tahun;
        } else {
            // Untuk publik (tanpa login) ambil tahun aktif
            $t = $this->db->get_where('tahun_ajaran', ['aktif' => 1])->row();
            $this->tahun_id = $t ? $t->id : null;
        }
    }


    // ==========================================================
    //  DASHBOARD
    // ==========================================================
    public function index() {
        $data['title'] = 'Dashboard';

        // Jumlah kelas per tingkat
        $data['rombel']  = $this->get_kelas_by_tingkat();

        // siswa_tahun → status = aktif
        $data['aktif']   = $this->get_siswa_aktif_by_tingkat();
        // mutasi siswa masuk
        $data['masuk']   = $this->get_siswa_masuk_by_tingkat();
        // mutasi → jenis: keluar
        $data['keluar']  = $this->get_siswa_keluar_by_tingkat();

        // Lulus
        $q = $this->db
            ->select('tahun_ajaran.tahun, COUNT(siswa.id) AS jumlah')
            ->join('tahun_ajaran', 'tahun_ajaran.id = siswa.tahun_id', 'left')
            ->where('siswa.status', 'lulus')
            ->where('siswa.tahun_id', $this->tahun_id)
            ->group_by('tahun_ajaran.tahun')
            ->get('siswa');

        $data['lulus'] = $q ? $q->result() : [];

        // siswa_tahun → tabel publik
        $data['per_rombel'] = $this->get_siswa_per_rombel();

        // Jika login, tampilkan versi admin
        if ($this->session->userdata('logged_in')) {
            $data['active'] = 'dashboard';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('dashboard/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('dashboard/public', $data);
        }
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
    private function get_siswa_per_rombel() {
        $tahun = $this->tahun_id;

        $q = $this->db
            ->select("
                k.nama AS nama_kelas,
                SUM(CASE WHEN s.jk = 'L' THEN 1 ELSE 0 END) AS laki,
                SUM(CASE WHEN s.jk = 'P' THEN 1 ELSE 0 END) AS perempuan,
                COUNT(st.id) AS total
            ")
            ->from("siswa_tahun st")
            ->join("siswa s", "s.id = st.siswa_id", "left")
            ->join("kelas k", "k.id = st.kelas_id", "left")
            ->where("st.tahun_id", $tahun)
            ->where("st.status", "aktif")
            ->group_by("k.nama")
            ->order_by("k.nama", "ASC")
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

    // gunakan PhpSpreadsheet
    // pastikan di bagian atas file controller ada:
    // use PhpOffice\PhpSpreadsheet\Spreadsheet;
    // use PhpOffice\PhpSpreadsheet\Writer\Xls;
    // use PhpOffice\PhpSpreadsheet\Cell\DataType;

    @ob_end_clean();
    ob_start();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Siswa_Kelas_' . preg_replace('/[^A-Za-z0-9_]/', '_', $kelas->nama));

    // Header
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'NIS');
    $sheet->setCellValue('C1', 'NISN');
    $sheet->setCellValue('D1', 'Nama');
    $sheet->setCellValue('E1', 'JK');
    $sheet->setCellValue('F1', 'No HP Ortu');
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
        $sheet->setCellValueExplicit("C{$row}", (string)$s->nisn, DataType::TYPE_STRING);

        $sheet->setCellValue("D{$row}", $s->nama);
        $sheet->setCellValue("E{$row}", $s->jk ?: '-');

        // Nomor HP orang tua juga sebagai teks
        $sheet->setCellValueExplicit("F{$row}", (string)$s->no_hp_ortu, DataType::TYPE_STRING);

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
    // 🔹 HALAMAN PUBLIK: MUTASI
    // ==========================================================
    public function mutasi() {
        $this->load->model('Laporan_model');
        $this->load->library('pagination');

        $tahun  = date('Y');
        $kelas  = $this->input->get('kelas');
        $jenis  = $this->input->get('jenis');
        $search = $this->input->get('search');

        $config['base_url'] = site_url('dashboard/mutasi');
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;

        $page   = ($this->input->get('page')) ? (int)$this->input->get('page') : 0;
        $offset = $page;

        $all_mutasi = $this->Laporan_model->get_laporan($tahun, $kelas, $jenis, $search);
        $config['total_rows'] = count($all_mutasi);

        // paginasi
        $config['full_tag_open']   = '<ul class="pagination justify-content-center">';
$config['full_tag_close']  = '</ul>';

$config['first_link']      = '&laquo;';
$config['first_tag_open']  = '<li class="page-item">';
$config['first_tag_close'] = '</li>';

$config['last_link']       = '&raquo;';
$config['last_tag_open']   = '<li class="page-item">';
$config['last_tag_close']  = '</li>';

$config['next_link']       = '&rsaquo;';
$config['next_tag_open']   = '<li class="page-item">';
$config['next_tag_close']  = '</li>';

$config['prev_link']       = '&lsaquo;';
$config['prev_tag_open']   = '<li class="page-item">';
$config['prev_tag_close']  = '</li>';

$config['cur_tag_open']    = '<li class="page-item active"><span class="page-link">';
$config['cur_tag_close']   = '</span></li>';

$config['num_tag_open']    = '<li class="page-item">';
$config['num_tag_close']   = '</li>';

$config['attributes']      = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $data['mutasi'] = array_slice($all_mutasi, $offset, $config['per_page']);

        $data['judul']    = 'Data Siswa Mutasi';
        $data['tahun']    = $tahun;
        $data['kelas_list'] = $this->Laporan_model->get_kelas();
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('dashboard/mutasi_public', $data);
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
