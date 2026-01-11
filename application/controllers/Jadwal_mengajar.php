<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\IOFactory;


class Jadwal_mengajar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Jadwal_mengajar_model');
         if (!$this->session->userdata('logged_in')) {
            redirect('dashboard');
            exit;
        }
    }
    

    public function index()
{
    $data['title']  = 'Jadwal Mengajar Guru';
    $data['active'] = 'jadwal_mengajar';

    // ambil filter dari GET
    $filter = [
        'hari'    => $this->input->get('hari'),
        'guru_id' => $this->input->get('guru_id'),
        'kelas_id'=> $this->input->get('kelas_id'),
    ];

    $data['jadwal'] = $this->Jadwal_mengajar_model->get_all($filter);

    // data dropdown filter
    $data['guru']  = $this->db->order_by('nama','ASC')->get('guru')->result();
    $data['kelas'] = $this->db->order_by('nama','ASC')->get('kelas')->result();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('jadwal_mengajar/index', $data);
    $this->load->view('templates/footer');
}


    public function tambah()
    {
        $data['title']   = 'Tambah Jadwal Mengajar';
        $data['active']  = 'jadwal_mengajar';
        $data['guru']    = $this->db->get('guru')->result();
        $data['kelas']   = $this->db->get('kelas')->result();
        $data['mapel']   = $this->db->get('mapel')->result();
        $data['jam']     = $this->Jadwal_mengajar_model->jam_mengajar();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('jadwal_mengajar/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function store()
{
    $jamAwal  = (int)$this->input->post('jam_mulai_id');
    $jamAkhir = (int)$this->input->post('jam_selesai_id');

    if (!$jamAwal || !$jamAkhir || $jamAkhir < $jamAwal) {
        $this->session->set_flashdata('error', 'Jam awal & akhir tidak valid');
        redirect('jadwal_mengajar/tambah');
        return;
    }

    $hari      = $this->input->post('hari');
    $guru_id   = $this->input->post('guru_id');
    $rombel_id = $this->input->post('rombel_id');

    $bentrok = $this->Jadwal_mengajar_model
    ->get_bentrok_detail($hari, $jamAwal, $jamAkhir, $guru_id, $rombel_id);

if ($bentrok) {

    $this->session->set_flashdata('error',
        "❌ <b>Jadwal Bentrok!</b><br>
        Hari: <b>{$bentrok->hari}</b><br>
        Guru: <b>{$bentrok->nama_guru}</b><br>
        Kelas: <b>{$bentrok->nama_kelas}</b>"
    );

    redirect('jadwal_mengajar/tambah');
    return;
}


    $this->db->insert('jadwal_mengajar', [
        'hari'           => $hari,
        'jam_mulai_id'   => $jamAwal,
        'jam_selesai_id' => $jamAkhir,
        'guru_id'        => $guru_id,
        'rombel_id'      => $rombel_id,
        'mapel_id'       => $this->input->post('mapel_id'),
    ]);

    redirect('jadwal_mengajar');
}


    public function get_jam_by_hari()
{
    $hari = $this->input->get('hari', TRUE);

    if (!$hari) {
        echo json_encode([]);
        return;
    }

    $jam = $this->db
        ->where('hari', $hari)
        ->where('is_active', 1)
        ->order_by('urutan', 'ASC')
        ->get('jam_sekolah')
        ->result();

    echo json_encode($jam);
}
public function import()
{
    $data = [
        'title' => 'Import Jadwal Mengajar'
    ];

    $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('jadwal_mengajar/import', $data);
        $this->load->view('templates/footer');
}
public function download_template()
{
    // ===============================
    // BERSIHKAN OUTPUT (WAJIB)
    // ===============================
    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    require FCPATH . 'vendor/autoload.php';


    $excel = new Spreadsheet();

    /* =====================================================
     * SHEET 1 : JADWAL (DIISI USER)
     * ===================================================== */
    $sheet = $excel->getActiveSheet();
    $sheet->setTitle('Jadwal');

    $headers = [
        'A' => 'Hari',
        'B' => 'Jam_Mulai',
        'C' => 'Jam_Selesai',
        'D' => 'Guru',
        'E' => 'Kelas',
        'F' => 'Mapel',
    ];

    foreach ($headers as $col => $text) {
        $sheet->setCellValue($col.'1', $text);
        $sheet->getStyle($col.'1')->getFont()->setBold(true);
        $sheet->getColumnDimension($col)->setWidth(25);
    }

    $sheet->freezePane('A2');

    /* =====================================================
     * SHEET 2 : LISTS (REFERENSI DROPDOWN)
     * ===================================================== */
    $lists = $excel->createSheet();
    $lists->setTitle('Lists');

    /* ================= HARI ================= */
    $lists->setCellValue('A1', 'Hari');

    $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $r = 2;
    foreach ($hariList as $h) {
        $lists->setCellValue("A$r", $h);
        $r++;
    }
    $excel->addNamedRange(
        new NamedRange('LIST_HARI', $lists, 'A2:A7')
    );

    /* ================= JAM PER HARI ================= */
    $jam = $this->db
        ->where('is_active', 1)
        ->where('jenis', 'Mengajar')
        ->order_by('hari', 'ASC')
        ->order_by('urutan', 'ASC')
        ->get('jam_sekolah')
        ->result();

    $hariCol = [
        'Senin'  => 'B',
        'Selasa' => 'C',
        'Rabu'   => 'D',
        'Kamis'  => 'E',
        'Jumat'  => 'F',
        'Sabtu'  => 'G',
    ];

    foreach ($hariCol as $hariNama => $col) {

        $lists->setCellValue($col.'1', "Jam_$hariNama");
        $r = 2;

        foreach ($jam as $j) {
            if ($j->hari === $hariNama) {
                $label =
                    $j->nama_jam .
                    ' (' . substr($j->jam_mulai,0,5) .
                    '-' . substr($j->jam_selesai,0,5) . ')';

                $lists->setCellValue($col.$r, $label);
                $r++;
            }
        }

        if ($r > 2) {
            $excel->addNamedRange(
                new NamedRange(
                    'LIST_JAM_'.$hariNama,
                    $lists,
                    $col.'2:'.$col.($r-1)
                )
            );
        }
    }

    /* ================= GURU ================= */
    $lists->setCellValue('H1', 'Guru');
    $r = 2;
    foreach ($this->db->order_by('nama','ASC')->get('guru')->result() as $g) {
        $lists->setCellValue("H$r", $g->nama);
        $r++;
    }
    $excel->addNamedRange(
        new NamedRange('LIST_GURU', $lists, "H2:H".($r-1))
    );

    /* ================= KELAS (KOLOM I) ================= */
    $lists->setCellValue('I1', 'Kelas');
    $r = 2;
    foreach ($this->db->order_by('nama','ASC')->get('kelas')->result() as $k) {
        $lists->setCellValue("I$r", $k->nama);
        $r++;
    }
    $excel->addNamedRange(
        new NamedRange('LIST_KELAS', $lists, "I2:I".($r-1))
    );

    /* ================= MAPEL ================= */
    $lists->setCellValue('J1', 'Mapel');
    $r = 2;
    foreach ($this->db->order_by('nama_mapel','ASC')->get('mapel')->result() as $m) {
        $lists->setCellValue("J$r", $m->nama_mapel);
        $r++;
    }
    $excel->addNamedRange(
        new NamedRange('LIST_MAPEL', $lists, "J2:J".($r-1))
    );

    /* =====================================================
     * DATA VALIDATION (DROPDOWN)
     * ===================================================== */
    $maxRow = 300;

    for ($i = 2; $i <= $maxRow; $i++) {

        // Hari
        $dv = new DataValidation();
        $dv->setType(DataValidation::TYPE_LIST);
        $dv->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $dv->setAllowBlank(true);
        $dv->setShowDropDown(true);
        $dv->setShowInputMessage(true);
        $dv->setShowErrorMessage(true);
        $dv->setFormula1('=LIST_HARI');
        $sheet->getCell("A$i")->setDataValidation($dv);

        // Jam Mulai
        $dv = new DataValidation();
        $dv->setType(DataValidation::TYPE_LIST);
        $dv->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $dv->setAllowBlank(true);
        $dv->setShowDropDown(true);
        $dv->setShowInputMessage(true);
        $dv->setShowErrorMessage(true);
        $dv->setFormula1('=INDIRECT("LIST_JAM_"&A'.$i.')');
        $sheet->getCell("B$i")->setDataValidation($dv);

        // Jam Selesai
        $dv = new DataValidation();
        $dv->setType(DataValidation::TYPE_LIST);
        $dv->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $dv->setAllowBlank(true);
        $dv->setShowDropDown(true);
        $dv->setShowInputMessage(true);
        $dv->setShowErrorMessage(true);
        $dv->setFormula1('=INDIRECT("LIST_JAM_"&A'.$i.')');
        $sheet->getCell("C$i")->setDataValidation($dv);

        // Guru
        $dv = new DataValidation();
        $dv->setType(DataValidation::TYPE_LIST);
        $dv->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $dv->setAllowBlank(true);
        $dv->setShowDropDown(true);
        $dv->setShowInputMessage(true);
        $dv->setShowErrorMessage(true);
        $dv->setFormula1('=LIST_GURU');
        $sheet->getCell("D$i")->setDataValidation($dv);

        // Kelas
        $dv = new DataValidation();
        $dv->setType(DataValidation::TYPE_LIST);
        $dv->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $dv->setAllowBlank(true);
        $dv->setShowDropDown(true);
        $dv->setShowInputMessage(true);
        $dv->setShowErrorMessage(true);
        $dv->setFormula1('=LIST_KELAS');
        $sheet->getCell("E$i")->setDataValidation($dv);

        // Mapel
        $dv = new DataValidation();
        $dv->setType(DataValidation::TYPE_LIST);
        $dv->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $dv->setAllowBlank(true);
        $dv->setShowDropDown(true);
        $dv->setShowInputMessage(true);
        $dv->setShowErrorMessage(true);
        $dv->setFormula1('=LIST_MAPEL');
        $sheet->getCell("F$i")->setDataValidation($dv);
    }

    /* =====================================================
     * OUTPUT FILE
     * ===================================================== */
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Template_Jadwal_Mengajar.xlsx"');
    header('Cache-Control: max-age=0');

    IOFactory::createWriter($excel, 'Xlsx')->save('php://output');
    exit;
}

public function import_proses()
{
    require FCPATH . 'vendor/autoload.php';

    if (empty($_FILES['file_excel']['name'])) {
        $this->session->set_flashdata('error', 'File Excel belum dipilih');
        redirect('jadwal_mengajar/import');
        return;
    }

    $spreadsheet = IOFactory::load($_FILES['file_excel']['tmp_name']);
    $rows = $spreadsheet->getActiveSheet()->toArray();

    $berhasil = 0;
    $bentrok  = [];

    foreach ($rows as $i => $row) {

        if ($i === 0) continue; // skip header

        $hari        = trim($row[0]);
        $jam_mulai   = trim($row[1]);
        $jam_selesai = trim($row[2]);
        $nama_guru   = trim($row[3]);
        $nama_kelas  = trim($row[4]);
        $nama_mapel  = trim($row[5]);

        if (!$hari || !$jam_mulai || !$nama_guru) continue;

        // === CARI DATA MASTER ===
        $guru  = $this->db->get_where('guru', ['nama' => $nama_guru])->row();
        $kelas = $this->db->get_where('kelas', ['nama' => $nama_kelas])->row();
        $mapel = $this->db->get_where('mapel', ['nama_mapel' => $nama_mapel])->row();

        preg_match('/\((\d{2}:\d{2})-/', $jam_mulai, $m1);
        preg_match('/\((\d{2}:\d{2})-/', $jam_selesai, $m2);

        if (!$m1 || !$m2) continue;

        $jamMulai = $this->db->get_where('jam_sekolah', [
            'hari' => $hari,
            'jam_mulai' => $m1[1].':00'
        ])->row();

        $jamSelesai = $this->db->get_where('jam_sekolah', [
            'hari' => $hari,
            'jam_mulai' => $m2[1].':00'
        ])->row();

        if (!$guru || !$kelas || !$mapel || !$jamMulai || !$jamSelesai) continue;

        // === CEK BENTROK (SAMA PERSIS DENGAN MANUAL) ===
        $cek = $this->Jadwal_mengajar_model->cek_bentrok(
            $hari,
            $jamMulai->id_jam,
            $jamSelesai->id_jam,
            $guru->id,
            $kelas->id
        );

        if ($cek) {
            $bentrok[] = "Baris ".($i+1)." → $hari | $nama_guru | $nama_kelas";
            continue;
        }

        // === INSERT ===
        $this->db->insert('jadwal_mengajar', [
            'hari'           => $hari,
            'jam_mulai_id'   => $jamMulai->id_jam,
            'jam_selesai_id' => $jamSelesai->id_jam,
            'guru_id'        => $guru->id,
            'rombel_id'      => $kelas->id,
            'mapel_id'       => $mapel->id_mapel,
        ]);

        $berhasil++;
    }

    // === NOTIFIKASI ===
    if (!empty($bentrok)) {
        $this->session->set_flashdata(
            'error',
            "<strong>Import selesai dengan bentrok!</strong><br>"
            ."Berhasil: <b>$berhasil</b><br>"
            ."Bentrok:<br>- ".implode('<br>- ', $bentrok)
        );
    } else {
        $this->session->set_flashdata(
            'success',
            "Import berhasil. Total data masuk: <b>$berhasil</b>"
        );
    }

    redirect('jadwal_mengajar');
}
public function edit($id)
{
    $jadwal = $this->Jadwal_mengajar_model->get_by_id($id);
    if (!$jadwal) {
        show_404();
    }

    $data['title']  = 'Edit Jadwal Mengajar';
    $data['active'] = 'jadwal_mengajar';
    $data['jadwal'] = $jadwal;

    $data['guru']  = $this->db->get('guru')->result();
    $data['kelas'] = $this->db->get('kelas')->result();
    $data['mapel'] = $this->db->get('mapel')->result();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('jadwal_mengajar/edit', $data);
    $this->load->view('templates/footer');
}
public function update($id)
{
    $jadwal = $this->Jadwal_mengajar_model->get_by_id($id);
    if (!$jadwal) {
        show_404();
    }

    $hari           = $this->input->post('hari');
    $guru_id        = $this->input->post('guru_id');
    $rombel_id      = $this->input->post('rombel_id');
    $mapel_id       = $this->input->post('mapel_id');
    $jam_mulai_id   = (int) $this->input->post('jam_mulai_id');
    $jam_selesai_id = (int) $this->input->post('jam_selesai_id');

    if (!$jam_mulai_id || !$jam_selesai_id || $jam_selesai_id < $jam_mulai_id) {
        $this->session->set_flashdata('error', 'Jam awal & akhir tidak valid');
        redirect('jadwal_mengajar/edit/'.$id);
        return;
    }

    // === CEK BENTROK (KECUALI DIRI SENDIRI) ===
    $bentrok = $this->Jadwal_mengajar_model
        ->cek_bentrok_edit(
            $hari,
            $jam_mulai_id,
            $jam_selesai_id,
            $guru_id,
            $rombel_id,
            $id
        );

    if ($bentrok) {
        $this->session->set_flashdata(
            'error',
            '<strong>Jadwal Bentrok!</strong><br>'
            .'Hari: '.$hari.'<br>'
            .'Guru: '.$bentrok->nama_guru.'<br>'
            .'Kelas: '.$bentrok->nama_kelas
        );
        redirect('jadwal_mengajar/edit/'.$id);
        return;
    }

    // === UPDATE ===
    $this->db->where('id', $id)->update('jadwal_mengajar', [
        'hari'           => $hari,
        'guru_id'        => $guru_id,
        'rombel_id'      => $rombel_id,
        'mapel_id'       => $mapel_id,
        'jam_mulai_id'   => $jam_mulai_id,
        'jam_selesai_id' => $jam_selesai_id,
    ]);

    $this->session->set_flashdata('success', 'Jadwal berhasil diperbarui');
    redirect('jadwal_mengajar');
}
public function delete($id)
{
    $this->Jadwal_mengajar_model->delete($id);
    $this->session->set_flashdata('success', 'Jadwal berhasil dihapus');
    redirect('jadwal_mengajar');
}



}
