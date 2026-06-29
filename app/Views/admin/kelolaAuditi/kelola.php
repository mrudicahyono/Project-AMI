<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">FORM Auditi</h4>
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
                    <form action="/admin/kelola-auditi/kelola/<?= $uuid ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row mb-5 text-start">
                            <div class="col-12">
                                <label for="prodi" class="h6">Prodi</label>
                                <select class="form-control mb-3" name="prodi" id="prodi" required>
                                    <?php if (!empty($users['id']) && !empty($users['nama'])) { ?>
                                        <option value="<?= $users['id'] ?>" selected><?= $users['nama'] ?></option>
                                    <?php } else { ?>
                                        <option value="" selected disabled>Pilih Prodi</option>
                                    <?php } ?>
                                    <?php foreach ($prodi as $key) { ?>
                                        <?php if (!empty($key['id']) && !empty($key['nama'])) { ?>
                                            <option value="<?= $key['id']; ?>"><?= $key['nama']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <?php if (!empty($users['id'])) { ?>
                                <button type="submit" class="btn btn-primary mr-3">Ubah Prodi</button>
                            <?php } else { ?>
                                <button type="submit" class="btn btn-primary mr-3">Tambah Prodi</button>
                            <?php } ?>
                            <a href="/admin/kelola-auditi" class="btn bg-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>


        </div>

    </div>
</div>


<?= $this->endSection() ?>