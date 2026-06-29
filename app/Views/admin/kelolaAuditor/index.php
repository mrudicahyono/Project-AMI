<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Kelola Auditor</h4>
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
                    <a href="/admin/kelola-auditor/tambah" class="btn btn-primary mb-3 ">Tambah</a>
                    <div class="table-responsive text-center">
                        <table id="datatable" class="table data-table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kode Auditor</th>
                                    <th scope="col">Nama </th>
                                    <th scope="col">Prodi</th>
                                    <th scope="col">Akhir Sertifikat </th>
                                    <th scope="col">Aksi </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($auditor as $key => $value) { ?>
                                    <tr>
                                        <th scope="row"><?= $no; ?></th>
                                        <td><?= $value['kode_auditor']; ?></td>
                                        <td><?= $value['nama']; ?></td>
                                        <td><?= $value['prodi']; ?></td>
                                        <td><?= $value['akhir_sertifikat']; ?></td>
                                        <td>
                                            <a href="/admin/kelola-auditor/ubah/<?= $value['uuid'] ?>" class="btn  btn-primary">Ubah</a>
                                            <form action="/admin/kelola-auditor/hapus/<?= $value['uuid'] ?>" method="post" class="d-inline">
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