<?= $this->extend('auditi/layout') ?>
<?= $this->section('content') ?>


<?php if ($formTerkunci) : ?>
    <div class="alert bg-danger" role="alert">
        <div class="iq-alert-text">
            <small>Form Evaluasi Diri sudah tidak dapat diisi lagi karena sudah melewati batas waktu !</small>
            <br>
            <small>Silahkan Hubungi Admin untuk informasi lebih lanjut.</small>
        </div>
    </div>
    <p></p>
<?php else : ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Form Tambah Data Evaluasi Diri</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (!empty(session()->getFlashdata('sukses'))) : ?>
                            <div class="alert bg-success" role="alert">

                                <div class="iq-alert-text"> <small><?= session()->getFlashdata('sukses') ?> </small></div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="ri-close-line"></i>
                                </button>
                            </div>
                        <?php endif ?>
                        <h4>Progress Form Evaluasi Diri <?= $prodi ?></h4>
                        <?php if (!empty(session()->getFlashdata('persentase'))) { ?>
                            <div class="progress mt-3 mb-4">
                                <div class="progress-bar" role="progressbar" style="width: <?= session()->getFlashdata('persentase') ?>%;" aria-valuenow="<?= session()->getFlashdata('persentase') ?>" aria-valuemin="0" aria-valuemax="100"><?= session()->getFlashdata('persentase') ?>%</div>
                            </div>
                        <?php } else { ?>
                            <div class="progress mt-3 mb-4">
                                <div class="progress-bar" role="progressbar" style="width: <?= $persentase ?>%;" aria-valuenow="<?= $persentase ?>" aria-valuemin="0" aria-valuemax="100"><?= $persentase ?>%</div>
                            </div>
                        <?php } ?>
                        <form action="/auditi/form-ed" method="POST">
                            <?= csrf_field() ?>
                            <a href="/auditi/form-ed/ubah" class="btn btn-primary mb-3">Ubah Data</a>
                            <div class="table-responsive">
                                <table id="datatable" class="table data-table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Standar</th>
                                            <th>Kode Kriteria</th>
                                            <th>Kriteria</th>
                                            <th class="text-center">Akar Penyebab</th>
                                            <th class="text-center">Tautan Bukti</th>
                                            <th class="text-center">Capaian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php for ($i = 0; $i < count($form_ed); $i++) { ?>
                                            <!-- jika standar aktif -->
                                            <tr>
                                                <td scope="row"><?= $no; ?></td>
                                                <td><?= $form_ed[$i]['standar']; ?></td>
                                                <td><?= $form_ed[$i]['kode_kriteria']; ?></td>
                                                <td><?= $form_ed[$i]['kriteria']; ?></td>
                                                <td class="text-center" style="width: 25%;">
                                                    <?php if (!is_null($form_ed[$i]['akar_penyebab'])) { ?>
                                                        <div class="col-12 col-lg-12 mt-auto">

                                                            <?= $form_ed[$i]['akar_penyebab']; ?>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12 col-lg-12 mt-auto">

                                                            <input type="text" class="form-control" id="akarpenyebab<?= $form_ed[$i]['uuid'] ?>" name="akarpenyebab<?= $form_ed[$i]['uuid'] ?>" value="">
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-center" style="width: 25%;">
                                                    <?php if (!is_null($form_ed[$i]['tautan_bukti'])) { ?>
                                                        <div class="col-12 col-lg-12 mt-auto">
                                                            <a href="<?= $form_ed[$i]['tautan_bukti'] ?>" target="_blank"><?= substr($form_ed[$i]['tautan_bukti'], 0, 40) ?>....</a>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-12 col-lg-12 mt-auto">
                                                            <input type="text" class="form-control" id="tautan_bukti<?= $form_ed[$i]['uuid'] ?>" name="tautanbukti<?= $form_ed[$i]['uuid'] ?>" value="">
                                                        </div>
                                                    <?php } ?>

                                                </td>
                                                <td class="text-center" style="width: 10%;">
                                                    <?php if ($form_ed[$i]['capaian_auditi'] != 0) { ?>
                                                        <?= $form_ed[$i]['capaian_auditi'] ?>
                                                    <?php } else { ?>
                                                        <select class="custom-select" id="validationCustom04" name="capaian_auditi<?= $form_ed[$i]['uuid'] ?>">
                                                            <option selected disabled value="">Pilih Capaian</option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                        </select>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php $no++; ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row justify-content-center mt-5">
                                <button type="submit" class="btn btn-primary mr-3">Simpan</button>
                                <a href="/auditi/dashboard" class="btn bg-danger">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>


            </div>

        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>