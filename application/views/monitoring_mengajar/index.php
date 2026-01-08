<div class="container-fluid">
    <h4 class="mb-3">Monitoring Mengajar Guru (Hari Ini)</h4>

    <div class="table-responsive">
        <div class="row mb-3">
    <div class="col-md-3">
        <label>Filter Guru</label>
        <select id="filterGuru" class="form-control form-control-sm">
            <option value="">Semua Guru</option>
        </select>
    </div>

    <div class="col-md-3">
        <label>Filter Kelas</label>
        <select id="filterKelas" class="form-control form-control-sm">
            <option value="">Semua Kelas</option>
        </select>
    </div>
</div>

        <table class="table table-bordered table-sm" id="tblMonitoring">
            <thead class="table-light">
                <tr>
                    <th>Guru</th>
                    <th>Kelas</th>
                    <th>Mapel</th>
                    <th>Jam Ke</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script>
function loadMonitoring() {
    fetch("<?= site_url('monitoring_mengajar/load_data') ?>")
        .then(res => res.json())
        .then(data => {
            let tbody = '';
            data.forEach(row => {

                let badge = '';
                if (row.status === 'sedang') {
                    badge = '<span class="badge bg-success">Sedang Mengajar</span>';
                } else if (row.status === 'selesai') {
                    badge = '<span class="badge bg-primary">Selesai</span>';
                } else {
                    badge = '<span class="badge bg-warning text-dark">Belum Mulai</span>';
                }

                tbody += `
                    <tr>
                        <td>${row.guru}</td>
                        <td>${row.kelas}</td>
                        <td>${row.mapel}</td>
                        <td>${row.jam}</td>
                        <td>${row.mulai}</td>
                        <td>${row.selesai}</td>
                        <td class="text-center">${badge}</td>
                    </tr>
                `;
            });

            document.querySelector('#tblMonitoring tbody').innerHTML = tbody;
        });
}

// load awal
loadMonitoring();

// auto refresh tiap 30 detik
setInterval(loadMonitoring, 30000);
</script>
<script>
function loadFilter() {
    fetch("<?= site_url('monitoring_mengajar/filter_data') ?>")
        .then(res => res.json())
        .then(res => {
            let guruOpt = '<option value="">Semua Guru</option>';
            res.guru.forEach(g => {
                guruOpt += `<option value="${g.id}">${g.nama}</option>`;
            });
            document.getElementById('filterGuru').innerHTML = guruOpt;

            let kelasOpt = '<option value="">Semua Kelas</option>';
            res.kelas.forEach(k => {
                kelasOpt += `<option value="${k.id}">${k.nama}</option>`;
            });
            document.getElementById('filterKelas').innerHTML = kelasOpt;
        });
}

function loadMonitoring() {
    const guru  = document.getElementById('filterGuru').value;
    const kelas = document.getElementById('filterKelas').value;

    fetch(`<?= site_url('monitoring_mengajar/load_data') ?>?guru_id=${guru}&kelas_id=${kelas}`)
        .then(res => res.json())
        .then(data => {
            let tbody = '';
            data.forEach(row => {

                let badge = '';
                if (row.status === 'sedang') {
                    badge = '<span class="badge bg-success">Sedang Mengajar</span>';
                } else if (row.status === 'selesai') {
                    badge = '<span class="badge bg-primary">Selesai</span>';
                } else {
                    badge = '<span class="badge bg-warning text-dark">Belum Mulai</span>';
                }

                tbody += `
                    <tr>
                        <td>${row.guru}</td>
                        <td>${row.kelas}</td>
                        <td>${row.mapel}</td>
                        <td>${row.jam}</td>
                        <td>${row.mulai}</td>
                        <td>${row.selesai}</td>
                        <td class="text-center">${badge}</td>
                    </tr>
                `;
            });

            document.querySelector('#tblMonitoring tbody').innerHTML = tbody;
        });
}

// event filter
document.getElementById('filterGuru').addEventListener('change', loadMonitoring);
document.getElementById('filterKelas').addEventListener('change', loadMonitoring);

// init
loadFilter();
loadMonitoring();

// auto refresh tiap 30 detik
setInterval(loadMonitoring, 30000);
</script>

