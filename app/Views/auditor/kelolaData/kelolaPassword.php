<?= $this->extend('auditor/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">FORM Ubah Password Auditor</h4>
                    </div>

                </div>
                <div class="card-body">
                    <?php if (!empty(session()->getFlashdata('gagal'))) : ?>
                        <div class="alert bg-danger" role="alert">
                            <div class="iq-alert-text"> <small><?= session()->getFlashdata('gagal') ?> </small></div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    <?php endif ?>
                    <?php if (!empty(session()->getFlashdata('sukses'))) : ?>
                        <div class="alert bg-success" role="alert">
                            <div class="iq-alert-text"> <small><?= session()->getFlashdata('sukses') ?> </small></div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="ri-close-line"></i>
                            </button>
                        </div>
                    <?php endif ?>
                    <form action="/auditor/kelola-data" method="POST">
                        <?= csrf_field() ?>
                        <div class="row mb-5 text-start">
                            <div class="col-12 col-lg-6 mt-auto">
                                <label for="password" class="d-block">Masukkan Password Baru</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input name="password" type="password" value="" class="input form-control" id="password" placeholder="password" required="true" aria-label="password" aria-describedby="basic-addon1" />
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="password_show_hide();">
                                            <i class="fas fa-eye" id="show_eye"></i>
                                            <i class="fas fa-eye-slash d-none" id="hide_eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mt-auto">
                                <label for="confirmpassword" class="d-block">Masukkan Konfirmasi Password Baru</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon11"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input name="confirmpassword" type="password" value="" class="input form-control" id="confirmpassword" placeholder="Confirm Password" required="true" aria-label="password" aria-describedby="basic-addon11" />
                                    <div class="input-group-append">
                                        <span class="input-group-text" onclick="password_show_hide2();">
                                            <i class="fas fa-eye" id="show_eye2"></i>
                                            <i class="fas fa-eye-slash d-none" id="hide_eye2"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <button type="submit" class="btn btn-primary mr-3">Ubah Password</button>
                            <a href="/admin/kelola-auditor" class="btn bg-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>


        </div>

    </div>
</div>

<script>
    function password_show_hide() {
        var x = document.getElementById("password");
        var show_eye = document.getElementById("show_eye");
        var hide_eye = document.getElementById("hide_eye");
        hide_eye.classList.remove("d-none");
        if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
        } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
        }
    }

    function password_show_hide2() {
        var x = document.getElementById("confirmpassword");
        var show_eye = document.getElementById("show_eye2");
        var hide_eye = document.getElementById("hide_eye2");
        hide_eye.classList.remove("d-none");
        if (x.type === "password") {
            x.type = "text";
            show_eye.style.display = "none";
            hide_eye.style.display = "block";
        } else {
            x.type = "password";
            show_eye.style.display = "block";
            hide_eye.style.display = "none";
        }
    }
</script>

<?= $this->endSection() ?>