<?= $this->extend('auditor/layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">FORM UPDATE Kelengkapan Dokumen</h4>
                    </div>
                    <a href="/auditor/form-1/<?= $uuid_prodi ?>" class="text-end btn bg-warning">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="/auditor/form-1/kelengkapan-dokumen/ubah/<?= $uuid ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-3">
                                <label for="kode_kriteria" class="h6">Kode Kriteria</label>
                                <select class="form-control" name="id_kriteria" required>
                                    <option value="">Pilih Kode Kriteria</option>
                                    <?php foreach ($form_ed as $item) : ?>
                                        <option value="<?= $item['id_kriteria']; ?>" <?= $kelengkapanDokumen['id_kriteria'] == $item['id_kriteria'] ? 'selected' : '' ?>><?= $item['kode_kriteria']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="status_dokumen" class="h6">Status Dokumen</label>
                                <select class="form-control mb-3" name="status_dokumen" required>
                                    <option value="">Pilih Status Dokumen</option>
                                    <option value="Ada" <?= $kelengkapanDokumen['status_dokumen'] == 'Ada' ? 'selected' : '' ?>>Ada</option>
                                    <option value="Tidak" <?= $kelengkapanDokumen['status_dokumen'] == 'Tidak' ? 'selected' : '' ?>>Tidak</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="nama_dokumen" class="h6">Nama Dokumen</label>
                                <input type="text" class="form-control" name="nama_dokumen" placeholder="Mohon disi Nama Dokumen" value="<?= $kelengkapanDokumen['nama_dokumen'] ?>" required>
                            </div>
                            <div class="col-3">
                                <label for="keterangan" class="h6">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan" placeholder="Mohon disi Keterangan" value="<?= $kelengkapanDokumen['keterangan'] ?>" required>
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