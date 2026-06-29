<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Kelola kriteria ED</h4>
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
                    <?php if (!empty(session()->getFlashdata('gagal'))) : ?>
                        <div class="alert bg-danger" role="alert">

                            <div class="iq-alert-text"> <small><?= session()->getFlashdata('gagal') ?> </small></div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    <?php endif ?>
                    <a href="/admin/kriteria-ed" class="btn btn-warning mb-3">Kembali</a>
                    <a href="/admin/kriteria-ed/tambah" class="btn btn-primary mb-3">Tambah Kriteria Satu Prodi</a>
                    <a href="/admin/kriteria-ed/universitas/tambah" class="btn btn-primary mb-3">Tambah Kriteria Semua Prodi</a>
                    <div class="table-responsive">
                        <form id="deleteForm" action="/admin/kriteria-ed/hapus-multiple" method="POST">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-danger delete-selected-button mb-3" onclick="return confirm('Apakah anda ingin menghapus data yang dipilih?')" id="deleteSelectedButton">Hapus Data Terpilih</button>
                            <table id="datatable" class="table data-table table-striped">
                                <thead>
                                    <tr>
                                        <th class="checkbox-column"><input type="checkbox" id="selectAll"></th>
                                        <th scope="col">#</th>
                                        <th scope="col">Standar</th>
                                        <th scope="col">Kode Kriteria</th>
                                        <th scope="col">Kriteria</th>

                                        <th scope="col">Nama Prodi</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($kriteria as $key => $value) { ?>
                                        <tr>
                                            <td class="checkbox-column"><input type="checkbox" class="select-item" name="selectedItems[]" value="<?= $value['uuid'] ?>" id="checkbox-select"></td>
                                            <th scope="row"><?= $no; ?></th>
                                            <td><?= $value['standar']; ?></td>
                                            <td><?= $value['kode_kriteria']; ?></td>
                                            <td><?= $value['kriteria']; ?></td>

                                            <td><?= $value['nama_prodi']; ?></td>
                                            <td>
                                                <a href="/admin/kriteria-ed/ubah/<?= $value['uuid'] ?>" class="btn btn-primary">Ubah</a>
                                                <form action="/admin/kriteria-ed/hapus/<?= $value['uuid'] ?>" method="post" class="d-inline">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah ingin menghapus?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php $no++;
                                    } ?>

                                </tbody>
                            </table>
                        </form>

                    </div>
                </div>


            </div>

        </div>
    </div>

    <script>

        document.getElementById('selectAll').addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.select-item');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>

    <?= $this->endSection() ?>