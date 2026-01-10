<style>
.book-cover {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 8px;
    background: #f3f4f6;
}

.book-title {
    font-size: 15px;
    font-weight: 600;
    line-height: 1.3;
    max-height: 40px;
    overflow: hidden;
}
</style>

<div class="container-fluid">

    <h1 class="h4 mb-4 text-gray-800">
        <i class="fas fa-book-reader"></i> Bacaan / E-Book
    </h1>

    <!-- FILTER -->
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-body">
            <div class="row">

                <div class="col-md-4 mb-2">
                    <select id="filterKelas" class="form-control form-control-sm">
                        <option value="">Semua Kelas</option>
                        <option value="Umum">Umum</option>
                        <option value="X">X</option>
                        <option value="XI">XI</option>
                        <option value="XII">XII</option>
                    </select>
                </div>

                <div class="col-md-4 mb-2">
                    <select id="filterMapel" class="form-control form-control-sm">
                        <option value="">Semua Mapel</option>
                        <?php
                        $mapel_unik = array_unique(array_column($buku, 'mapel'));
                        foreach ($mapel_unik as $m):
                            if (!$m) continue;
                        ?>
                            <option value="<?= $m ?>"><?= $m ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-4 mb-2">
                    <button class="btn btn-secondary btn-sm w-100" onclick="resetFilter()">
                        <i class="fas fa-sync"></i> Reset
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- LIST BUKU -->
    <?php if (empty($buku)) : ?>
        <div class="alert alert-info">
            Belum ada bacaan tersedia.
        </div>
    <?php else : ?>
        <div class="row" id="listBuku">
            <?php foreach ($buku as $b) : ?>
                <div class="col-md-6 col-lg-3 mb-4 buku-item"
                     data-kelas="<?= $b->kelas ?>"
                     data-mapel="<?= $b->mapel ?>">

                    <div class="card shadow-sm h-100 border-0">

                        <!-- COVER -->
                        <?php if (!empty($b->cover)): ?>
                            <img src="<?= base_url('assets/uploads/cover_buku/'.$b->cover) ?>"
                                 class="book-cover">
                        <?php else: ?>
                            <div class="book-cover d-flex align-items-center justify-content-center text-muted">
                                <i class="fas fa-book fa-2x"></i>
                            </div>
                        <?php endif; ?>

                        <div class="card-body d-flex flex-column">

                            <div class="book-title mb-2">
                                <?= htmlspecialchars($b->judul); ?>
                            </div>

                            <small class="text-muted mb-1">
                                <i class="fas fa-book"></i> <?= $b->mapel ?: '-' ?>
                            </small>

                            <small class="text-muted mb-3">
                                <i class="fas fa-layer-group"></i> Kelas <?= $b->kelas ?>
                            </small>

                            <a href="<?= site_url('SiswaBacaan/baca/'.$b->id); ?>"
                               class="btn btn-primary btn-sm mt-auto">
                                <i class="fas fa-eye"></i> Baca
                            </a>

                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php if (!empty($pagination)) : ?>
    <div class="mt-4">
        <?= $pagination; ?>
    </div>
<?php endif; ?>

</div>

<script>
function resetFilter() {
    document.getElementById('filterKelas').value = '';
    document.getElementById('filterMapel').value = '';
    filterBuku();
}

function filterBuku() {
    const kelas = document.getElementById('filterKelas').value;
    const mapel = document.getElementById('filterMapel').value;

    document.querySelectorAll('.buku-item').forEach(item => {
        const show =
            (!kelas || item.dataset.kelas === kelas) &&
            (!mapel || item.dataset.mapel === mapel);

        item.style.display = show ? 'block' : 'none';
    });
}

document.getElementById('filterKelas').addEventListener('change', filterBuku);
document.getElementById('filterMapel').addEventListener('change', filterBuku);
</script>
