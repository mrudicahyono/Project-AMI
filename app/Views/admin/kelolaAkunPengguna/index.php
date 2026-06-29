<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Kelola Akun Pengguna</h4>
                    </div>
                </div>
                <div class="card-body">
                    <p>Data akun akan muncul jika sudah mendapatkan akses masuk ke aplikasi</p>
                    <small class="mb-5">Catatan: Jika data yang ditambahkan adalah role auditor, maka harap tambahkan lagi data auditor pada <b>Kelola Auditor</b> yang terdapat di menu sidebar</small>
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
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($users as $key => $value) { ?>
                                    <tr>
                                        <th scope="row"><?= $no; ?></th>
                                        <td><?= $value['name']; ?></td>
                                        <td><?= $value['email']; ?></td>
                                        <td>
                                            <?php if (isset($value['id_prodi']) && isset($value['role'])) { ?>
                                                Sudah memiliki prodi <?= $value['id_prodi'] ?> dan role <?= $value['role']; ?>
                                            <?php } else if (isset($value['id_prodi'])) { ?>
                                                Sudah memiliki prodi <?= $value['id_prodi']; ?>
                                            <?php } else if (isset($value['role'])) { ?>
                                                <?php if ($value['role'] == "auditor") { ?>
                                                    Sudah memiliki role <?= $value['role']; ?>
                                                <?php } else { ?>
                                                    Sudah memiliki role <?= $value['role']; ?>, Namun belum memiliki prodi
                                                <?php } ?>
                                            <?php } else { ?>
                                                Belum memiliki role dan prodi
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="/admin/kelola-akun-pengguna/kelola/<?= $value['uuid'] ?>" class="btn  btn-primary">Kelola</a>
                                            <form action="/admin/kelola-akun-pengguna/hapus/<?= $value['uuid'] ?>" method="post" class="d-inline">
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