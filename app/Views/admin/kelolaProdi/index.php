<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Kelola Prodi</h4>
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
                    <a href="/admin/kriteria-ed" class="btn btn-warning mb-3">Kembali</a>
                    <a href="/admin/kelola-prodi/tambah" class="btn btn-primary mb-3">Tambah Prodi</a>
                    <div class="table-responsive">
                        <table id="datatable" class="table data-table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama Prodi</th>
                                    <th scope="col">Fakultas</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($prodi as $key => $value) { ?>
                                    <tr>
                                        <th scope="row"><?= $no; ?></th>
                                        <td><?= $value['nama']; ?></td>
                                        <td><?= $value['fakultas']; ?></td>
                                        <td>
                                            <a href="/admin/kelola-prodi/edit/<?= $value['uuid'] ?>" class="btn btn-primary">Ubah</a>
                                            <form action="/admin/kelola-prodi/hapus/<?= $value['uuid'] ?>" method="post" class="d-inline">
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