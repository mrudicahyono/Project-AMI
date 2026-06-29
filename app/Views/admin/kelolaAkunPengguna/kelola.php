<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Kelola Akun Pengguna - <?= $user['name']; ?></h4>
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
                    <form action="/admin/kelola-akun-pengguna/kelola/<?= $uuid ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row mb-5 text-start">
                            <div class="col-12">
                                <label for="prodi" class="h6">Prodi</label>
                                <select class="form-control mb-3" name="prodi" id="prodi" required>
                                    <option value="" selected disabled>Pilih Prodi</option>
                                    <?php foreach ($prodi as $key) { ?>
                                        <option value="<?= $key['id']; ?>"><?= $key['nama']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="role" class="h6">Role</label>
                                <select class="form-control mb-3" name="role" id="role" required>
                                    <option value="" selected disabled>Pilih Role</option>
                                    <?php foreach ($role as $key) { ?>
                                        <option value="<?= $key; ?>"><?= $key; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary mr-3">Simpan Data</button>
                            <a href="/admin/kelola-akun-pengguna" class="btn bg-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>


        </div>

    </div>
</div>


<?= $this->endSection() ?>