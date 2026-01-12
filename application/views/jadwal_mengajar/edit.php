<div class="container-fluid">

    <h4 class="mb-4">
        <i class="fas fa-edit"></i> Edit Jadwal Mengajar
    </h4>

    <div class="card shadow">
        <div class="card-body">

            <form method="post" action="<?= site_url('jadwal_mengajar/update/'.$jadwal_raw->id_jadwal) ?>">


                <!-- CSRF -->
                <input type="hidden"
                       name="<?= $this->security->get_csrf_token_name(); ?>"
                       value="<?= $this->security->get_csrf_hash(); ?>">

                <!-- ID JADWAL -->
                <input type="hidden" name="id_jadwal" value="<?= $jadwal->id_jadwal ?>">

                <!-- GURU -->
                <div class="form-group">
                    <label>Guru</label>
                    <select name="guru_id" class="form-control" required>
                        <?php foreach ($guru as $g): ?>
                            <option value="<?= $g->id ?>"
                                <?= $g->id == $jadwal_raw->guru_id ? 'selected' : '' ?>>
                                <?= $g->nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- MAPEL -->
                <div class="form-group">
                    <label>Mata Pelajaran</label>
                    <select name="mapel_id" class="form-control" required>
                        <?php foreach ($mapel as $m): ?>
                            <option value="<?= $m->id_mapel ?>"
                                <?= $m->id_mapel == $jadwal_raw->mapel_id ? 'selected' : '' ?>>
                                <?= $m->nama_mapel ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- KELAS -->
                <div class="form-group">
                    <label>Kelas</label>
                    <select name="rombel_id" class="form-control" required>
                        <?php foreach ($kelas as $k): ?>
                            <option value="<?= $k->id ?>"
                                <?= $k->id == $jadwal_raw->rombel_id ? 'selected' : '' ?>>
                                <?= $k->nama ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- HARI -->
                <div class="form-group">
                    <label>Hari</label>
                    <select name="hari" class="form-control" required>
                        <?php
                        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                        foreach ($hariList as $h):
                        ?>
                            <option value="<?= $h ?>"
                                <?= $h == $jadwal->hari ? 'selected' : '' ?>>
                                <?= $h ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- JAM MULAI -->
                <div class="form-group">
                    <label>Jam Mulai</label>
                    <select name="jam_mulai_id" class="form-control" required>
                        <?php foreach ($jam as $j): ?>
                            <option value="<?= $j->id_jam ?>"
                                <?= $j->id_jam == $jadwal_raw->jam_mulai_id ? 'selected' : '' ?>>
                                <?= $j->nama_jam ?> (<?= substr($j->jam_mulai,0,5) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- JAM SELESAI -->
                <div class="form-group">
                    <label>Jam Selesai</label>
                    <select name="jam_selesai_id" class="form-control" required>
                        <?php foreach ($jam as $j): ?>
                            <option value="<?= $j->id_jam ?>"
                                <?= $j->id_jam == $jadwal_raw->jam_selesai_id ? 'selected' : '' ?>>
                                <?= $j->nama_jam ?> (<?= substr($j->jam_selesai,0,5) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="text-right">
                    <a href="<?= site_url('jadwal_mengajar') ?>"
                       class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
