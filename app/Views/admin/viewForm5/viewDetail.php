<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<?php if (!empty(session()->getFlashdata('sukses'))) : ?>
    <div class="alert bg-success" role="alert">
        <div class="iq-alert-text"> <small><?= session()->getFlashdata('sukses') ?> </small></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
<?php endif ?>
<?php if (isset($error)) : ?>
    <div class="alert bg-danger mt-3" role="alert">
        <div class="iq-alert-text"> <small> <?= $error; ?> </small></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
<?php endif ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">

                    <h4 class="card-title">Form 5 - Kelola Edit Deskripsi Temuan - <?= $deskripsiTemuan['kode_kriteria'] ?> - <?= $prodi ?></h4>
                    <a href="/admin/form5/view/<?= $uuid ?>" class="btn btn-warning mb-3">Kembali</a>

                </div>
                <div class="card-body">
                    <div class="container text-center">
                        <input type="text" name="id_ringkasan_temuan" value="<?= $deskripsiTemuan['id'] ?>" hidden>
                        <input type="text" name="penjaminMutuAudit" value="<?= $deskripsiTemuan['reviewer'] ?>" hidden>
                        <input type="text" name="pimpinanAuditi" value="<?= $deskripsiTemuan['pimpinan_auditi'] ?>" hidden>

                        <div class="form-group">
                            <label for="deskripsiTemuan"><b>Deskripsi Temuan</b></label>
                            <div>
                                <?= $deskripsiTemuan['deskripsi_temuan']; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="kriteria"><b>Kriteria</b></label>
                            <div>
                                <?= $deskripsiTemuan['kriteria'] ?>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="akibat"><b>Akibat</b></label>
                            <p><?= $deskripsiTemuan['akibat'] ?></p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="akarPenyebab"><b>Akar Penyebab/Masalah</b></label>
                            <p><?= $deskripsiTemuan['akar_penyebab'] ?></p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="rekomendasiDisepakati"><b>Rekomendasi disepakati dengan audit</b></label>
                            <p><?= $deskripsiTemuan['rekomendasi']; ?></p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="tanggapanAuditi"><b>Tanggapan Auditi</b></label>
                            <p><?= $deskripsiTemuan['tanggapan_auditi'] ?></p>
                                
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="rencanaPerbaikan"><b>Rencana Perbaikan</b></label>
                            <p><?= $deskripsiTemuan['rencana_perbaikan']; ?></p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="jadwalPerbaikan" id="jadwalPerbaikan"><b>Jadwal Perbaikan</b></label>
                            <p><?= $deskripsiTemuan['jadwal_perbaikan'] ?></p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="rencanaPencegahan" id="rencanaPencegahan"><b>Rencana Pencegahan</b></label>
                            <p><?= $deskripsiTemuan['rencana_pencegahan'] ?></p>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="jadwalPencegahan" id="jadwalPencegahan"><b>Jadwal Pencegahan</b></label>
                            <p><?= $deskripsiTemuan['jadwal_pencegahan'] ?></p>
                        </div>
                        <hr>
                    </div>

                </div>


            </div>

        </div>
    </div>

    <?= $this->endSection() ?>