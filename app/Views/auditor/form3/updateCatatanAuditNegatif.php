<?= $this->extend('auditor/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">FORM Ubah Catatan Audit Negatif</h4>
                    </div>
                    <a href="/auditor/form-3/<?= $uuid_prodi ?>" class="text-end btn bg-warning">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="/auditor/form-3/catatan-audit/ubah/negatif/<?= $uuid ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-12 mt-3">
                                <label for="catatan_audit" class="form-label">Catatan Audit Negatif</label>
                                <input id="catatan_audit" type="hidden" name="catatan_audit" value="<?= old('catatan_audit', $catatanNegatif['catatan_audit']); ?>">
                                <trix-editor input="catatan_audit"></trix-editor>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-5">
                            <button type="submit" class="btn btn-primary mr-3">Ubah Catatan Audit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>