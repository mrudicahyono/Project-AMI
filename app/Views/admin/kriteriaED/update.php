<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">FORM Ubah Data kriteria ED Prodi</h4>
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
                    <form action="/admin/kriteria-ed/ubah/<?= $uuid ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row mb-5 text-start">

                            <div class="col-12 col-lg-4">
                                <label for="standar" class="h6">Standar</label>
                                <select class="form-control" name="standar" required>
                                    <option value="<?= $kriteria['id_standar'] ?>" selected><?= $kriteria['standar'] ?></option>
                                    <?php foreach ($kriteria_standar as $key) { ?>
                                        <option value="<?= $key['id']; ?>"><?= $key['standar']; ?></option>
                                    <?php } ?>
                                </select>
                                <small class="ms-5">Tidak ada standar? <a href="/admin/kriteria-ed/tambah/standar">Klik disini</a> Untuk menambah standar</small>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="id_prodi" class="h6">Prodi</label>
                                <select class="form-control mb-3" name="id_prodi" required>
                                    <option value="<?= $kriteria['id_prodi'] ?>" selected><?= $kriteria['nama_prodi'] ?></option>
                                    <?php foreach ($prodi as $key) { ?>
                                        <option value="<?= $key['id']; ?>"><?= $key['nama']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="kode_kriteria" class="h6">Kode Kriteria</label>
                                <input type="text" class="form-control" id="kode_kriteria" name="kode_kriteria" value="<?= $kriteria['kode_kriteria'] ?>">
                            </div>

                            <div class="col-12 mt-3">
                                <label for="kriteria" class="form-label">Kriteria</label>
                                <input id="kriteria" type="hidden" name="kriteria" value="<?= $kriteria['kriteria'] ?>">
                                <trix-editor input="kriteria"></trix-editor>
                            </div>
                            <div class="col-12 col-lg-6 mt-3">
                                <label for="bobot" class="h6">Bobot</label>
                                <input type="text" class="form-control" id="bobot" name="bobot" value="<?= $kriteria['bobot'] ?>">
                                <small></small>
                            </div>
                            <div class="col-12 col-lg-6 mt-3">
                                <label for="lembaga_akreditasi" class="h6">Lembaga Akreditasi </label>
                                <select class="form-control" name="lembaga_akreditasi" required>
                                    <option value="<?= $kriteria['id_lembaga_akreditasi'] ?>"><?= $kriteria['lembaga_akreditasi'] ?></option>
                                    <?php foreach ($lembaga_akreditasi as $key) { ?>
                                        <option value="<?= $key['id']; ?>"><?= $key['nama']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>

                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary mr-3">Ubah Kriteria</button>
                            <a href="/admin/kriteria-ed" class="btn bg-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>


        </div>

    </div>
</div>


<?= $this->endSection() ?>