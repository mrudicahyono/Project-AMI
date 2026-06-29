<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">FORM Ubah Data Prodi</h4>
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
                    <form action="/admin/kelola-prodi/edit/<?= $uuid ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row mb-5 text-start">
                            <div class="col-12 col-lg-6">
                                <label for="nama_jurusan" class="h6">Nama Jurusan </label>
                                <input type="text" class="form-control" id="nama_jurusan" name="jurusan" value="<?= $prodi['nama']; ?>" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="nama_fakultas" class="h6">Nama Fakultas </label>
                                <input type="text" class="form-control" id="nama_fakultas" name="fakultas" value="<?= $prodi['fakultas']; ?>" required>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary mr-3">Edit Kriteria</button>
                            <a href="/admin/kelola-prodi" class="btn bg-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>


        </div>

    </div>
</div>


<?= $this->endSection() ?>