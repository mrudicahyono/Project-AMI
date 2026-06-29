<?= $this->extend('auditor/layout') ?>
<?= $this->section('content') ?>
<?php if (!empty(session()->getFlashdata('sukses'))) : ?>
    <div class="alert bg-success" role="alert">
        <div class="iq-alert-text"> <small><?= session()->getFlashdata('sukses') ?> </small></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
<?php endif ?>
<div class="card">
    <div class="card-header d-flex justify-content-between">

        <h4 class="card-title">Form 3 - Catatan Audit <?= $prodi['nama'] ?></h4>
        <a href="/auditor/form-3" class="btn btn-warning">Kembali</a>

    </div>
    <div class="d-flex justify-content-end px-3 py-3">
        <a href="/auditor/form-3/catatan-audit/pdf/<?= $uuid2 ?>" target="_blank" class="btn btn-primary"><i class="las la-file-download"></i>PDF</a>
    </div>
    <div class="card-body">

        <div class="mb-3">
            <small class="text-danger">Catatan Audit Hanya bisa di isi 1 kali saja !</small>
        </div>

        <?php if (empty($dataCatatanAuditPositifBerdasakanProdi)) : ?>
            <a href="/auditor/form-3/catatan-audit/tambah/positif/<?= $uuid2 ?>" class="btn btn-primary mb-3">Catatan Audit Positif</a>
        <?php endif; ?>
        <?php if (empty($dataCatatanAuditNegatifBerdasakanProdi)) : ?>
            <a href="/auditor/form-3/catatan-audit/tambah/negatif/<?= $uuid2 ?>" class="btn btn-primary mb-3">Catatan Audit Negatif</a>
        <?php endif; ?>


        <div class="row">
            <div class="card-body">
                <h4>Catatan Positif </h4>
                <hr>
                <?php if (empty($dataCatatanAuditPositifBerdasakanProdi)) : ?>
                    <textarea class="form-control" disabled rows="10">Catatan Audit Belum diisi</textarea>
                <?php else : ?>
                    <?php foreach ($dataCatatanAuditPositifBerdasakanProdi as $catatan) : ?>
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <div>
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="card-text"><?= $catatan['catatan_audit'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 col-lg-1 mt-3 mt-lg-0 d-flex justify-content-center align-items-center">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <a href="/auditor/form-3/catatan-audit/ubah/positif/<?= $catatan['uuid'] ?>" class="btn btn-primary btn-block">Ubah</a>
                                    </div>
                                    <div class="col-12">
                                        <form action="/auditor/form-3/catatan-audit/positif/hapus/<?= $catatan['uuid'] ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Apakah ingin menghapus?')">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="card-body">
                <h4>Catatan Negatif </h4>
                <hr>
                <?php if (empty($dataCatatanAuditNegatifBerdasakanProdi)) : ?>
                    <textarea class="form-control" disabled rows="10">Catatan Audit Belum diisi</textarea>
                <?php else : ?>
                    <?php foreach ($dataCatatanAuditNegatifBerdasakanProdi as $catatan) : ?>
                        <div class="row">
                            <div class="col-12 col-lg-11">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-text"><?= $catatan['catatan_audit'] ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-1 mt-3 mt-lg-0 d-flex justify-content-center align-items-center">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <a href="/auditor/form-3/catatan-audit/ubah/negatif/<?= $catatan['uuid'] ?>" class="btn btn-primary btn-block">Ubah</a>
                                    </div>
                                    <div class="col-12">
                                        <form action="/auditor/form-3/catatan-audit/negatif/hapus/<?= $catatan['uuid'] ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Apakah ingin menghapus?')">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>