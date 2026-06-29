<?= $this->extend('auditor/layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title d-flex">

                        <h4 class="card-title">FORM Kop Kelengkapan Dokumen <?= $prodi['nama'] ?></h4>
                    </div>
                    <a href="/auditor/form-1/<?= $uuid2 ?>" class=" text-end btn bg-warning">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="/auditor/form-1/kop-kelengkapan-dokumen/tambah/<?= $uuid2 ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_penugasanAuditor" value="<?= $id_penugasanAuditor['id'] ?>">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <label for="lokasi" class="h6">Lokasi</label>
                                <input type="hidden" class="form-control" name="lokasi" value="<?= $lokasi ?>">
                                <input type="text" class="form-control" name="lokasi" value="<?= $lokasi ?>" disabled>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="ruang_lingkup" class="h6">Ruang Lingkup</label>
                                <input type="hidden" class="form-control" name="ruang_lingkup" value="<?= $periode['ruang_lingkup'] ?>">
                                <input type="text" class="form-control" name="ruang_lingkup" value="<?= $periode['ruang_lingkup'] ?>" disabled>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="tanggal_audit" class="h6">Tanggal Audit</label>
                                <input type="hidden" class="form-control" name="tanggal_audit" value="<?= $periode['tanggal_mulai'] . "/" . $periode['tanggal_selesai'] ?>">
                                <input type="text" class="form-control" name="tanggal_audit" value="<?= $periode['tanggal_mulai'] . "/" . $periode['tanggal_selesai'] ?>" disabled>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 col-lg-4">
                                <label for="wakil_auditi" class="h6">Wakil Auditi</label>
                                <input type="text" class="form-control" name="wakil_auditi" placeholder="Mohon disi Wakil Auditi" required>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="auditor_ketua" class="h6">Auditor Ketua</label>
                                <input type="hidden" class="form-control" name="auditor_ketua" value="<?= $auditor_ketua[0] ?>">
                                <input type="text" class="form-control" name="auditor_ketua" value="<?= $auditor_ketua[0] ?>" disabled>
                            </div>
                            <div class="col-12 col-lg-4">
                                <label for="auditor_anggota" class="h6">Auditor Anggota</label>
                                <?php foreach ($auditor_anggota as $key => $value) { ?>
                                    <input type="hidden" class="form-control mt-2" name="auditor_anggota<?= $value ?>" value="<?= $value ?>">
                                    <input type="text" class="form-control mt-2" name="auditor_anggota" value="<?= $value ?>" disabled>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-5">
                            <button type="submit" class="btn btn-primary mr-3">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>