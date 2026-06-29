<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Kelola Akses User</h4>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session('validation')) { ?>
                        <div class="alert bg-danger" role="alert">
                            <ul>
                                <?php foreach (session('validation')->getErrors() as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php } ?>
                    <?php if (!empty(session()->getFlashdata('sukses'))) : ?>
                        <div class="alert bg-success" role="alert">

                            <div class="iq-alert-text"> <small><?= session()->getFlashdata('sukses') ?> </small></div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    <?php endif ?>
                    <div class="table-responsive text-center">
                        <table id="datatable" class="table data-table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama User</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Akses</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($dataUsers as $key => $value) { ?>
                                    <tr>
                                        <th scope="row"><?= $no; ?></th>
                                        <td><?= $value['name']; ?></td>
                                        <td><?= $value['email']; ?></td>
                                        <?php if ($value['akses'] == 1) { ?>
                                            <td>Akses Diterima</td>
                                        <?php } else { ?>
                                            <td>Akses Ditolak</td>
                                        <?php } ?>
                                        <td>
                                            <?php if ($value['akses'] == 1) { ?>
                                                <form action="/admin/kelola-akses/tolak/<?= $value['uuid']; ?>" method="post" class="mt-2">
                                                    <?= csrf_field(); ?>
                                                    <button class="btn btn-danger" type="submit">Tolak Akses</button>
                                                </form>
                                            <?php } else { ?>
                                                <form action="/admin/kelola-akses/terima/<?= $value['uuid']; ?>" method="post">
                                                    <?= csrf_field(); ?>
                                                    <button class="btn btn-success" type="submit">Terima Akses</button>
                                                </form>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php $no++;
                                } ?>

                            </tbody>
                        </table>

                    </div>
                </div>


            </div>

        </div>
    </div>


    <?= $this->endSection() ?>