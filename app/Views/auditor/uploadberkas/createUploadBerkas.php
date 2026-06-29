<?= $this->extend('auditor/layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">FORM Upload Berkas <?= $prodi['nama'] ?></h4>
                    </div>
                    <a href="/auditor/upload-berkas/<?= $uuid2 ?>" class=" text-end btn bg-warning">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="/auditor/upload-berkas/form-upload/tambah/<?= $uuid2 ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_prodi" value="<?= $prodi['id'] ?>">
                        <input type="hidden" name="id_penugasanAuditor" value="<?= $id_penugasanAuditor['id'] ?>">
                        <div class="row">
                            <div class="col-12">
                                <label for="link_form4" class="h5">Link Berkas Form 4</label>
                                <input type="text" class="form-control" name="link_form4" placeholder="Mohon disi Link Form 4" required>
                            </div>
                            <div class="col-12 mt-5">
                                <label for="link_form5" class="h5"> Link Berkas Form 5</label>
                                <input type="text" class="form-control" name="link_form5" placeholder="Mohon disi Link Form 5" required>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-5">
                            <button type="submit" class="btn btn-primary mr-3">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>