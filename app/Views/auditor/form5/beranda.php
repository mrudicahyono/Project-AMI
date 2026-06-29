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
    <?php if (isset($error)) : ?>
        <div class="alert bg-warning mt-3" role="alert">
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
                        <div class="header-title">
                            <h4 class="card-title">Form 5 - Deskripsi Temuan Audit</h4>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table data-table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Jabatan</th>
                                        <th scope="col">Prodi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php $i = 0; ?>
                                    <?php foreach ($penugasan_auditor as $key => $value) { ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td>
                                                <?php if ($value['ketua'] == 1) { ?>
                                                    Ketua
                                                <?php } else { ?>
                                                    Anggota
                                                <?php } ?>
                                            </td>
                                            <td><a href="/auditor/form-5/<?= $value['uuid_prodi'] ?>" class="btn btn-primary"><?= $value['nama_prodi'] ?></a></td>
                                        </tr>
                                    <?php $no++;
                                        $i++;
                                    } ?>

                                </tbody>
                            </table>

                        </div>
                        <!--  -->
                    </div>


                </div>

            </div>
        </div>

    <?php endif; ?>

    <?= $this->endSection() ?>