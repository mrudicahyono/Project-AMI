<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Lihat FORM 3 - <?= $catatanAuditDetail[0]['nama_prodi']  ?></h4>
                    </div>
                </div>

                <div class="card-body">
                <a href="/admin/form3/view/form-3/catatan-audit/pdf/<?= $prodi_uuid ?>" target="_blank" class="btn btn-primary"><i class="las la-file-download"></i>PDF</a>
                    <a href="/admin/form3/view" class="btn bg-warning">Kembali</a>
                    <form action="/admin/form3/view/delete" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_penugasan_auditor" value="<?= $catatanAuditDetail[0]['id_penugasan_auditor'] ?>">
                        <button class="btn btn-danger mt-4" type="submit" onclick="return confirm('Yakin ingin menghapus?')">Hapus Catatan Audit Form 3</button>
                        <small class="d-block mt-2 text-red">Hanya menghapus data yang sudah diisi oleh auditor</small>

                        <div class="row mt-4">
                            <div class="col-12">
                                <h4>Catatan Positif</h4>
                                <hr>
                                <?php foreach ($positifNotes as $item) : ?>
                                    <div class="mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="card-text"><?= $item['catatan_audit'] ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="col-12">
                                <h4>Catatan Negatif</h4>
                                <hr>
                                <?php foreach ($negatifNotes as $item) : ?>
                                    <div class="mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="card-text"><?= $item['catatan_audit'] ?></p>
                                        </div>
                                    </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('selectAll').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.select-item');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>

<?= $this->endSection() ?>