<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct(){
        parent::__construct();

        // ============================================================
        // 1. CEK APAKAH DATABASE SUDAH TERINSTALL ?
        // ============================================================
        // Jika tabel users tidak ada → database belum terinstall
        if (!$this->db->table_exists('users')) {

            // Jika lock.install belum ada → installer belum selesai
            if (!file_exists(FCPATH . 'install/lock.install')) {

                // Jika bukan halaman installer → redirect
                if (strtolower($this->router->class) !== 'install') {
                    redirect('install');
                    exit;
                }
            }
        }

        // ============================================================
        // 2. CEGAH CEK LOGIN SELAMA DI INSTALLER
        // ============================================================
        if (strtolower($this->router->class) !== 'install') {
            is_logged_in();
        }

        // ============================================================
        // 3. ANTI CACHE (opsional)
        // ============================================================
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
    }
}


class Admin_Controller extends MY_Controller {
    public function __construct(){
        parent::__construct();
        only_admin();
    }
}