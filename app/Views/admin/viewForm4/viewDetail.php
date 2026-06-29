<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Lihat FORM 4 - <?= $prodi['nama']  ?></h4>
                    </div>
                </div>
                <div class="card-body">
                <a href="/admin/form4/view/form-4/ringkasan-temuan/pdf/<?= $uuid2 ?>" target="_blank" class="btn btn-primary"><i class="las la-file-download"></i>PDF</a>
                    <a href="/admin/form4/view" class="btn bg-warning">Kembali</a>
                    <div class="row text-center">
                        <table id="datatable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Lokasi</th>
                                    <th>Ruang Lingkup</th>
                                    <th>Tanggal Audit</th>
                                    <th>Wakil Auditi</th>
                                    <th>Auditor Ketua</th>
                                    <th>Auditor Anggota</th>
                                    <th>Penjamin Mutu Audit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!is_null($dataKopKelengkapanDokumen)) { ?>
                                    <tr>
                                        <td><?= $dataKopKelengkapanDokumen['lokasi'] ?></td>
                                        <td><?= $dataKopKelengkapanDokumen['ruang_lingkup'] ?></td>
                                        <td><?= $dataKopKelengkapanDokumen['tanggal_audit'] ?></td>
                                        <td><?= $dataKopKelengkapanDokumen['wakil_auditi'] ?></td>
                                        <td><?= $dataKopKelengkapanDokumen['auditor_ketua'] ?></td>
                                        <td>
                                            <ol>
                                                <?php foreach ($anggota as $value) { ?>
                                                    <li><?= $value; ?></li>
                                                <?php } ?>
                                            </ol>
                                        </td>
                                        <td><?= $periode['penjaminan_mutu_audit'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="table-responsive">
                            <table id="user-list-table" class="table table-striped dataTable mt-2" role="grid" aria-describedby="user-list-page-info">
                                <thead>
                                    <tr>
                                        <th>Kode Kriteria</th>
                                        <th>No</th>
                                        <th>Deskripsi Temuan</th>
                                        <th>Kategori</th>
                                    </tr>
                                </thead>
                                <tbody class="text-break">
                                    <?php $no = 1; ?>
                                    <?php if (!is_null($ringkasanTemuan)) { ?>
                                        <?php foreach ($ringkasanTemuan as $value) { ?>
                                            <tr>
                                                <td><?= $value['kode_kriteria'] ?></td>
                                                <td><?= $no; ?></td>
                                                <td><?= $value['deskripsi'] ?></td>
                                                <td><?= $value['kategori'] ?></td>
                                            </tr>
                                            <?php $no++; ?>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('selectAll').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('.select-item');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
<?= $this->endSection() ?>