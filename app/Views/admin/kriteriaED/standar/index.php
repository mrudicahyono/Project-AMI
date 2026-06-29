<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Kelola Standar ED</h4>
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
                    <a href="/admin/dashboard" class="btn btn-danger mb-3">Kembali</a>
                    <a href="/admin/kriteria-ed/tambah/standar/tambah" class="btn btn-primary mb-3">Tambah Standar</a>
                    <div class="table-responsive text-center">
                        <table id="datatable" class="table data-table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Standar</th>
                                    <th scope="col">Aktif</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($standar as $key => $value) { ?>
                                    <tr>
                                        <td><?= $no; ?></td>
                                        <td>
                                            <div class="col-12 col-lg-12 mt-auto">
                                                <input type="text" class="form-control" id="catatan" name="<?= $value['standar'] ?>" value="<?= $value['standar'] ?>" disabled>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($value['is_aktif'] == 1) { ?>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" id="aktif<?= $value['uuid'] ?>" type="radio" name="isactive<?= $value['uuid'] ?>" value="1" checked disabled>
                                                    <label class="form-check-label" for="aktif<?= $value['uuid'] ?>">Aktif</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" id="tidakaktif<?= $value['uuid'] ?>" type="radio" name="isactive<?= $value['uuid'] ?>" value="0" disabled>
                                                    <label class="form-check-label" for="tidakaktif<?= $value['uuid'] ?>">Tidak aktif</label>
                                                </div>
                                            <?php } else if ($value['is_aktif'] == 0) { ?>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" id="aktif<?= $value['uuid'] ?>" type="radio" name="isactive<?= $value['uuid'] ?>" value="1" disabled>
                                                    <label class="form-check-label" for="aktif<?= $value['uuid'] ?>">Aktif</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" id="tidakaktif<?= $value['uuid'] ?>" type="radio" name="isactive<?= $value['uuid'] ?>" value="0" checked disabled>
                                                    <label class="form-check-label" for="tidakaktif<?= $value['uuid'] ?>">Tidak aktif</label>
                                                </div>
                                            <?php } else { ?>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" id="aktif<?= $value['uuid'] ?>" type="radio" name="isactive<?= $value['uuid'] ?>" value="1" disabled>
                                                    <label class="form-check-label" for="aktif<?= $value['uuid'] ?>">Aktif</label>
                                                </div>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" id="tidakaktif<?= $value['uuid'] ?>" type="radio" name="isactive<?= $value['uuid'] ?>" value="0" disabled>
                                                    <label class="form-check-label" for="tidakaktif<?= $value['uuid'] ?>">Tidak aktif</label>
                                                </div>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="/admin/kriteria-ed/tambah/standar/edit/<?= $value['uuid'] ?>" class="btn btn-primary">Ubah</a>
                                            <form action="/admin/kriteria-ed/tambah/standar/hapus/<?= $value['uuid'] ?>" method="post" class="d-inline">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah ingin menghapus?')">Hapus</button>
                                            </form>
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