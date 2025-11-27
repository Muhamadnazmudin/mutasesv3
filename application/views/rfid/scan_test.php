<!DOCTYPE html>
<html>
<head>
    <title>Scan RFID (Tes Manual)</title>

    <!-- CSRF TOKEN -->
    <meta name="csrf-name" content="<?= $this->security->get_csrf_token_name(); ?>">
    <meta name="csrf-hash" content="<?= $this->security->get_csrf_hash(); ?>">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

<h3>Scan RFID (Tes Manual)</h3>

<form id="scanForm">
    <label>UID RFID</label>
    <input type="text" id="uid" name="uid" class="form-control" placeholder="Tempel kartu atau isi manual">
    <br>
    <button type="submit" class="btn btn-primary">Kirim</button>
</form>

<div id="result" class="mt-4"></div>

<script>
window.onload = function() {

    const form = document.getElementById('scanForm');

    form.addEventListener('submit', function(e){
        e.preventDefault();

        let uid = document.getElementById('uid').value;

        if (uid.trim() === "") {
            alert("UID tidak boleh kosong");
            return;
        }

        // ambil token csrf
        let csrfName = document.querySelector("meta[name='csrf-name']").content;
        let csrfHash = document.querySelector("meta[name='csrf-hash']").content;

        let body = csrfName + "=" + csrfHash + "&uid=" + encodeURIComponent(uid);

        fetch("<?= base_url('index.php/RfidAbsensi/scan') ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: body
        })
        .then(res => res.json())
        .then(data => {

            // update CSRF baru
            if (data.csrfName && data.csrfHash) {
                document.querySelector("meta[name='csrf-name']").content = data.csrfName;
                document.querySelector("meta[name='csrf-hash']").content = data.csrfHash;
            }

            document.getElementById('result').innerHTML =
                "<pre>" + JSON.stringify(data, null, 2) + "</pre>";
        })
        .catch(err => {
            document.getElementById('result').innerHTML = 
                "<div class='alert alert-danger'>Terjadi error: " + err + "</div>";
        });
    });

};
</script>

</body>
</html>
