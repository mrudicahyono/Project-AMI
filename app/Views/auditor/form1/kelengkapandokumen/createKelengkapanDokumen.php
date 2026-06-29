<?= $this->extend('auditor/layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">FORM Kelengkapan Dokumen <?= $prodi['nama'] ?></h4>
                    </div>
                    <a href="/auditor/form-1/<?= $uuid2 ?>" class=" text-end btn bg-warning">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="/auditor/form-1/kelengkapan-dokumen/tambah/<?= $uuid2 ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_penugasanAuditor" value="<?= $id_penugasanAuditor['id'] ?>">
                        <div class="row">
                            <div class="col-3">
                                <label for="kode_kriteria" class="h6">Kode Kriteria</label>
                                <select class="form-control" name="id_kriteria" required>
                                    <option value="">Pilih Kode Kriteria</option>
                                    <?php foreach ($form_ed as $item) : ?>
                                        <option value="<?= $item['id_kriteria']; ?>"><?= $item['kode_kriteria']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="ketua" class="h6">Status Dokumen</label>
                                <select class="form-control mb-3" name="status_dokumen" required>
                                    <option value="">Pilih Status Dokumen</option>
                                    <option value="Ada">Ada</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="nama_dokumen" class="h6">Nama Dokumen</label>
                                <input type="text" class="form-control" name="nama_dokumen" placeholder="Mohon disi Nama Dokumen" required>
                            </div>
                            <div class="col-3">
                                <label for="keterangan" class="h6">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan" placeholder="Mohon disi Keterangan" required>
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