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
                    <a href="/auditor/form-5/kelola/<?= $uuid ?>" class="btn btn-warning mb-3">Kembali</a>

                </div>
                <div class="card-body">
                    <form class="text-right" action="/auditor/form-5/kelola/<?= $uuid ?>/<?= $uuid_deskripsi_temuan ?>/hapus" method="post">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger mb-3" onclick="return confirm('Apakah ingin menghapus?')">Hapus <?= $deskripsiTemuan['kode_kriteria'] ?></button>
                    </form>
                    <div class="container">
                        <form action="/auditor/form-5/kelola/<?= $uuid ?>/<?= $uuid_deskripsi_temuan ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="text" name="id_ringkasan_temuan" value="<?= $deskripsiTemuan['id'] ?>" hidden>
                            <input type="text" name="penjaminMutuAudit" value="<?= $deskripsiTemuan['reviewer'] ?>" hidden>
                            <input type="text" name="pimpinanAuditi" value="<?= $deskripsiTemuan['pimpinan_auditi'] ?>" hidden>

                            <div class="form-group">
                                <label for="deskripsiTemuan"><b>Deskripsi Temuan</b></label>
                                <div>
                                    <?= $deskripsiTemuan['deskripsi_temuan']; ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kriteria"><b>Kriteria</b></label>
                                <div>
                                    <?= $deskripsiTemuan['kriteria'] ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="akibat" class="form-label"><b>Akibat</b></label>
                                <input id="akibat" type="hidden" name="akibat" value="<?= $deskripsiTemuan['akibat'] ?>">
                                <trix-editor input="akibat"></trix-editor>
                            </div>
                            <div class="form-group">
                                <label for="akarPenyebab" class="form-label"><b>Akar Penyebab</b></label>
                                <input id="akarPenyebab" type="hidden" name="akarPenyebab" value="<?= $deskripsiTemuan['akar_penyebab'] ?>">
                                <trix-editor input="akarPenyebab"></trix-editor>
                            </div>
                            <div class="form-group">
                                <label for="rekomendasiDisepakati" class="form-label"><b>Rekomendasi disepakati dengan audit</b></label>
                                <input id="rekomendasiDisepakati" type="hidden" name="rekomendasiDisepakati" value="<?= $deskripsiTemuan['rekomendasi'] ?>">
                                <trix-editor input="rekomendasiDisepakati"></trix-editor>
                            </div>
                            <div class="form-group">
                                <label for="tanggapanAuditi"><b>Tanggapan Auditi</b></label>
                                <select id="dropdown" class="form-control" name="tanggapanAuditi" required>
                                    <option value="<?= $deskripsiTemuan['tanggapan_auditi']; ?>"><?= $deskripsiTemuan['tanggapan_auditi'] ?></option>
                                    <option value="Setuju">Setuju</option>
                                    <option value="Tidak Setuju">Tidak Setuju</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="rencanaPerbaikan" class="form-label"><b>Rencana Perbaikan</b></label>
                                <input id="rencanaPerbaikan" type="hidden" name="rencanaPerbaikan" value="<?= $deskripsiTemuan['rencana_perbaikan'] ?>">
                                <trix-editor input="rencanaPerbaikan"></trix-editor>
                            </div>
                            <div class="form-group">
                                <label for="jadwalPerbaikan" id="jadwalPerbaikan"><b>Jadwal Perbaikan</b></label>
                                <input type="date" class="form-control" id="jadwalPerbaikan" name="jadwalPerbaikan" value="<?= $deskripsiTemuan['jadwal_perbaikan'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="rencanaPencegahan" class="form-label"><b>Rencana Pencegahan</b></label>
                                <input id="rencanaPencegahan" type="hidden" name="rencanaPencegahan" value="<?= $deskripsiTemuan['rencana_pencegahan'] ?>">
                                <trix-editor input="rencanaPencegahan"></trix-editor>
                            </div>
                            <div class="form-group">
                                <label for="jadwalPencegahan" id="jadwalPencegahan"><b>Jadwal Pencegahan</b></label>
                                <input type="date" class="form-control" id="jadwalPencegahan" name="jadwalPencegahan" value="<?= $deskripsiTemuan['jadwal_pencegahan'] ?>" required>
                            </div>
                            <div class="text-center">

                                <button type="submit" class="btn btn-primary">Edit Data Deskripsi Temuan</button>
                            </div>
                        </form>
                    </div>

                </div>


            </div>

        </div>
    </div>

    <style>
        trix-toolbar {
            display: none;
        }
    </style>
    <?= $this->endSection() ?>