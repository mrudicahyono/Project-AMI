<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">FORM pengisian kriteria ED</h4>
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
                    <a href="/admin/kriteria-ed/tambah/standar" class="btn bg-warning">Kembali</a>
                    <!-- form -->
                    <form action="/admin/kriteria-ed/tambah/standar/tambah" method="POST">
                        <?= csrf_field() ?>
                        <div class="row mb-5 text-start">

                            <div class="col-12 col-lg-6 mt-auto">
                                <label for="standar" class="h6">Standar</label>
                                <input type="text" class="form-control" id="standar" name="standar" value="<?= old('standar'); ?>">
                                <small></small>
                            </div>
                            <div class="col-12 col-lg-6 mt-5">
                                <h5>Apakah Aktif</h5>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="aktif" type="radio" name="isactive" value="1">
                                    <label class="form-check-label" for="aktif">Aktif</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="tidakaktif" type="radio" name="isactive" value="0">
                                    <label class="form-check-label" for="tidakaktif">Tidak aktif</label>
                                </div>
                            </div>

                        </div>

                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary mr-3">Tambah Standar</button>
                            <a href="/admin/kriteria-ed/tambah/standar" class="btn bg-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>


        </div>

    </div>
</div>


<?= $this->endSection() ?>