<?= $this->extend('auditi/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Form Ubah Data Evaluasi Diri</h4>
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
                    <a href="/auditi/form-ed" class="btn bg-warning mt-3">Kembali</a>
                    <?php if (!empty(session()->getFlashdata('persentase'))) { ?>
                        <div class="progress mt-3 mb-4">
                            <div class="progress-bar" role="progressbar" style="width: <?= session()->getFlashdata('persentase') ?>%;" aria-valuenow="<?= session()->getFlashdata('persentase') ?>" aria-valuemin="0" aria-valuemax="100"><?= session()->getFlashdata('persentase') ?>%</div>
                        </div>
                    <?php } else { ?>
                        <div class="progress mt-3 mb-4">
                            <div class="progress-bar" role="progressbar" style="width: <?= $persentase ?>%;" aria-valuenow="<?= $persentase ?>" aria-valuemin="0" aria-valuemax="100"><?= $persentase ?>%</div>
                        </div>
                    <?php } ?>
                    <form action="/auditi/form-ed/ubah" method="POST">
                        <?= csrf_field() ?>
                        <!-- kirim data lama -->

                        <div class="table-responsive">
                            <table id="datatable" class="table data-table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Standar</th>
                                        <th>Kriteria</th>
                                        <th class="text-center">Akar Penyebab</th>
                                        <th class="text-center">Tautan Bukti</th>
                                        <th class="text-center">Capaian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php for ($i = 0; $i < count($form_ed); $i++) { ?>

                                        <tr>
                                            <td scope="row"><?= $no; ?></td>
                                            <td><?= $form_ed[$i]['standar']; ?></td>
                                            <td><?= $form_ed[$i]['kriteria']; ?></td>
                                            <td class="text-center" style="width: 25%;">
                                                <?php if (!is_null($form_ed[$i]['akar_penyebab'])) { ?>
                                                    <div class="col-12 col-lg-12 mt-auto">

                                                        <input type="text" class="form-control" id="akarpenyebab<?= $form_ed[$i]['uuid'] ?>" name="akarpenyebab<?= $form_ed[$i]['uuid'] ?>" value="<?= $form_ed[$i]['akar_penyebab'] ?>">
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

                                                        <input type="text" class="form-control" id="tautan_bukti<?= $form_ed[$i]['uuid'] ?>" name="tautanbukti<?= $form_ed[$i]['uuid'] ?>" value="<?= $form_ed[$i]['tautan_bukti'] ?>">
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="col-12 col-lg-12 mt-auto">

                                                        <input type="text" class="form-control" id="tautan_bukti<?= $form_ed[$i]['uuid'] ?>" name="tautanbukti<?= $form_ed[$i]['uuid'] ?>" value="">
                                                    </div>
                                                <?php } ?>

                                            </td>
                                            <td class="text-center" style="width: 10%;">
                                                <select class="custom-select" id="validationCustom04" name="capaian_auditi<?= $form_ed[$i]['uuid'] ?>">
                                                    <?php if ($form_ed[$i]['capaian_auditi'] != 0) { ?>
                                                        <option selected value="<?= $form_ed[$i]['capaian_auditi'] ?>"><?= $form_ed[$i]['capaian_auditi'] ?></option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>

                                                    <?php } else { ?>
                                                        <option selected disabled value="">Pilih Capaian</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <?php $no++; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-center mt-5">
                            <button type="submit" class="btn btn-primary mr-3">Simpan</button>
                            <a href="/auditi/form-ed" class="btn bg-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>


        </div>

    </div>
</div>


<?= $this->endSection() ?>