<?= $this->extend('auditor/layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">FORM Ringkasan Temuan <?= $prodi['nama'] ?></h4>
                    </div>
                    <a href="/auditor/form-4/<?= $uuid2 ?>" class=" text-end btn bg-warning">Kembali</a>
                </div>
                <div class="card-body">
                    <form action="/auditor/form-4/ringkasan-temuan/tambah/<?= $uuid2 ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_penugasanAuditor" value="<?= $id_penugasanAuditor['id'] ?>">
                        <div class="row">
                            <div class="col-2">
                                <label for="kode_kriteria" class="h6">Kode Kriteria</label>
                                <select class="form-control" name="id_kriteria" required>
                                    <option value="">Pilih Kode Kriteria</option>
                                    <?php foreach ($form_ed as $item) : ?>
                                        <option value="<?= $item['id_kriteria']; ?>"><?= $item['kode_kriteria']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-danger">* Kode kriteria hanya akan muncul jika kode kriteria pada kelengkapan dokumen form 1 sudah ditambahkan</small>
                            </div>
                            <div class="col-8">
                                <label for="deskripsi" class="h6">Deskripsi Temuan</label>
                                <input type="text" class="form-control" name="deskripsi" placeholder="Mohon disi Deskripsi Temuan" required>
                            </div>
                            <div class="col-2">
                                <label for="kategori" class="h6">Kategori (OB/KTS)</label>
                                <select class="form-control mb-3" name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="KTS">KTS</option>
                                    <option value="OB">OB</option>
                                </select>
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