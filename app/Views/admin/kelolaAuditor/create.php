<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">FORM Tambah Auditor</h4>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session('validation')) { ?>
                        <div class="alert bg-danger" role="alert">

                            <?php foreach (session('validation')->getErrors() as $error) : ?>
                                <?= esc($error) ?>
                                <br>
                            <?php endforeach ?>

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
                    <form action="/admin/kelola-auditor/tambah" method="POST">
                        <?= csrf_field() ?>
                        <div class="row mb-5 text-start">
                            <div class="col-12 col-lg-6">
                                <label for="users" class="h6">Users</label>
                                <select class="form-control mb-3" name="users" id="users" required>
                                    <option value="">Pilih Users</option>
                                    <?php foreach ($users as $key) { ?>
                                        <option value="<?= $key['id']; ?>"><?= $key['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="Prodi" class="h6">Prodi</label>
                                <select class="form-control mb-3" name="prodi" id="prodi" required>
                                    <option value="">Pilih Prodi </option>
                                    <?php foreach ($prodi as $key) { ?>
                                        <option value="<?= $key['id']; ?>"><?= $key['nama']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6 mt-auto">
                                <label for="kode_auditor" class="h6">Kode Auditor</label>
                                <input type="text" class="form-control" placeholder="Silahkan isi Kode Auditor" id="kode_auditor" name="kode_auditor" value="<?= old('kode_auditor'); ?>">
                                <small></small>
                            </div>
                            <div class="col-12 col-lg-6 mt-auto">
                                <label for="nama" class="h6">Nama</label>
                                <input type="text" class="form-control" placeholder="Silahkan isi nama" id="nama" name="nama" value="<?= old('nama'); ?>">
                                <small></small>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="akhir_sertifikat" class="h6">Akhir Sertifikat</label>
                                <input type="date" class="form-control" id="akhir_sertifikat" name="akhir_sertifikat" value="<?= old('akhir_sertifikat'); ?>">
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary mr-3">Tambah Auditor</button>
                            <a href="/admin/kelola-auditor" class="btn bg-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>


        </div>

    </div>
</div>


<?= $this->endSection() ?>