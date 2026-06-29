<?= $this->extend('auditor/layout') ?>
<?= $this->section('content') ?>

<?php if ($formTerkunci) : ?>
    <div class="alert bg-danger" role="alert">
        <div class="iq-alert-text">
            <small>Pelaksanaan Audit Mutu Internal sudah tidak dapat dilakukan lagi karena sudah melewati batas waktu !</small>
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
                            <h4 class="card-title">Form Data Evaluasi Diri</h4>
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
                        <a href="/auditor/form-ed/view" class="btn btn-warning mb-3">Kembali</a>
                        <form action="/auditor/form-ed/view/<?= $uuid ?>" method="POST">
                            <?= csrf_field() ?>
                            <div class="table-responsive">
                                <table id="datatable" class="table data-table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Standar</th>
                                            <th>Kode Kriteria</th>
                                            <th>Kriteria</th>
                                            <th>Akar Penyebab</th>
                                            <th>Tautan Bukti</th>
                                            <th>Capaian Auditi</th>
                                            <th>Pilih Capaian</th>
                                            <th>Masukkan Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php for ($i = 0; $i < count($form_ed); $i++) { ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td style="width: 10%;"><?= $form_ed[$i]['standar']; ?></td>
                                                <td><?= $form_ed[$i]['kode_kriteria'] ?></td>
                                                <td style="width: 20%;"><?= $form_ed[$i]['kriteria']; ?></td>
                                                <td style="width: 15%;">
                                                    <div class="col-12 col-lg-12 mt-auto">
                                                        <?php if($form_ed[$i]['akar_penyebab'] == ""){ ?>
                                                            <input type="text" class="form-control" id="akarpenyebab<?= $form_ed[$i]['uuid'] ?>" name="akarpenyebab<?= $form_ed[$i]['uuid'] ?>" value="<?= $form_ed[$i]['akar_penyebab'] ?>" disabled>

                                                        <?php }else{ ?>
                                                            <p><?= $form_ed[$i]['akar_penyebab']; ?></p>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                                <td style="width: 15%;">
                                                    <div class="col-12 col-lg-12 mt-auto">
                                                        <?php if($form_ed[$i]['tautan_bukti'] == ""){ ?>
                                                            
                                                            <input type="text" class="form-control" id="tautan_bukti<?= $form_ed[$i]['uuid'] ?>" name="tautanbukti<?= $form_ed[$i]['uuid'] ?>" value="<?= $form_ed[$i]['tautan_bukti'] ?>" disabled>
                                                        <?php }else{ ?>
                                                            <a href="<?= $form_ed[$i]['tautan_bukti'] ?>" target="_blank"><?= substr($form_ed[$i]['tautan_bukti'], 0, 40) ?>....</a>
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?= $form_ed[$i]['capaian_auditi']; ?>
                                                </td>
                                                <td style="width: 10%;">
                                                    <select class="custom-select" id="validationCustom04" name="<?= $form_ed[$i]['uuid'] ?>">
                                                        <?php if ($form_ed[$i]['capaian'] != 0) { ?>
                                                            <option selected value="<?= $form_ed[$i]['capaian'] ?>"><?= $form_ed[$i]['capaian'] ?></option>
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
                                                <td style="width: 20%;">
                                                    <textarea class="form-control" id="catatan" rows="3" name="catatan<?= $form_ed[$i]['uuid'] ?>"><?= $form_ed[$i]['catatan'] ?></textarea>
                                                </td>
                                            </tr>
                                            <?php $no++; ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row justify-content-center mt-5">
                                <button type="submit" class="btn btn-primary mr-3">Simpan</button>
                                <a href="/auditor/form-ed/view" class="btn bg-danger">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>