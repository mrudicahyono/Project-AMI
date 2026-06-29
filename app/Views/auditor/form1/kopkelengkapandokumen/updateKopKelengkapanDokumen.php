<?= $this->extend('auditor/layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title d-flex">

                        <h4 class="card-title">FORM Edit Data Kop Kelengkapan Dokumen</h4>
                    </div>
                    <a href="/auditor/form-1/<?= $uuid ?>" class=" text-end btn bg-warning">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="/auditor/form-1/kop-kelengkapan-dokumen/ubah/<?= $uuid ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <label for="lokasi" class="h6">Lokasi</label>
                                <input type="text" class="form-control" name="lokasi" value="<?= $kopkelengkapanDokumen['lokasi'] ?>" disabled>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="ruang_lingkup" class="h6">Ruang Lingkup</label>
                                <input type="text" class="form-control" name="ruang_lingkup" value="<?= $kopkelengkapanDokumen['ruang_lingkup'] ?>" disabled>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="tanggal_audit" class="h6">Tanggal Audit</label>
                                <input type="text" class="form-control" name="tanggal_audit" value="<?= $kopkelengkapanDokumen['tanggal_audit'] ?>" disabled>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-lg-4">
                                <label for="wakil_auditi" class="h6">Wakil Auditi</label>
                                <input type="text" class="form-control" name="wakil_auditi" placeholder="Mohon disi Wakil Auditi" value="<?= (old('wakil_auditi')) ? old('wakil_auditi') : $kopkelengkapanDokumen['wakil_auditi'] ?>" required>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="auditor_ketua" class="h6">Auditor Ketua</label>
                                <input type="text" class="form-control" name="auditor_ketua" value="<?= $kopkelengkapanDokumen['auditor_ketua'] ?>" disabled>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="auditor_anggota" class="h6">Auditor Anggota</label>
                                <?php foreach ($anggota as $key => $value) { ?>
                                    <input type="text" class="form-control mt-2" name="auditor_anggota" value="<?= $value ?>" disabled>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-5">
                            <button type="submit" class="btn btn-primary mr-3">Edit Data Kop Kelengkapan Dokumen</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>