<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <?php if (!empty(session()->getFlashdata('gagal'))) : ?>
        <div class="alert bg-danger" role="alert">
            <div class="iq-alert-text"> <small><?= session()->getFlashdata('gagal') ?> </small></div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
        </div>
    <?php endif ?>
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Lihat Form 3</h4>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="datatable" class="table data-table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Auditor</th>
                                    <th scope="col">Prodi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php $i = 0; ?>
                                <?php foreach ($penugasan_auditor as $key => $value) { ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td><?= $value['nama_auditor'] ?></td>
                                        <td><a href="/admin/form3/view/<?= $value['uuid_prodi'] ?>" class="btn btn-primary"><?= $value['nama_prodi'] ?></a></td>
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


    <?= $this->endSection() ?>