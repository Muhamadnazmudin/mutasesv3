<div class="text-center mt-4">
  <h3>Selamat Datang, <?= $this->session->userdata('nama'); ?> 👋</h3>
  <p class="text-muted">
    Anda login sebagai <strong><?= ucfirst($this->session->userdata('role_name')); ?></strong><br>
    Tahun Ajaran Aktif: <strong>
      <?php
        $tahun_id = $this->session->userdata('tahun_id');
        $tahun = $this->db->get_where('tahun_ajaran', ['id' => $tahun_id])->row();
        echo $tahun ? $tahun->tahun : '-';
      ?>
    </strong>
  </p>
</div>
