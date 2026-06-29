<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<?php if (!empty(session()->getFlashdata('sukses'))) : ?>
    <div class="alert bg-success" role="alert">
        <div class="iq-alert-text"> <small><?= session()->getFlashdata('sukses') ?> </small></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
<?php endif ?>
<?php if (!empty(session()->getFlashdata('gagal'))) : ?>
    <div class="alert bg-danger" role="alert">
        <div class="iq-alert-text"> <small><?= session()->getFlashdata('gagal') ?> </small></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
<?php endif ?>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4 class="card-title">Form 5 - Deskripsi Temuan <?= $prodi['nama'] ?></h4>
    </div>
    <div class="card-body">
        <a href="/admin/form-5/deskripsi-temuan/pdf/<?= $uuid ?>" class="btn btn-primary" target="_blank"><i class="bi bi-file-earmark-pdf"></i>PDF</a>
        <a href="/admin/form5/view" class="btn btn-warning ">Kembali</a>
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
                                    <?php foreach ($anggota as $key => $value) { ?>
                                        <li><?= $value; ?></li>
                                    <?php } ?>
                                </ol>
                            </td>
                            <td><?= $periode['penjaminan_mutu_audit'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="card-body">
                <div>
                    <?php if (count($deskripsiTemuan) == 0) { ?>
                        <p>Data Deskripsi Temuan Belum Ada</p>
                    <?php } else { ?>

                        <table id="user-list-table" class="table table-striped data-table mt-2" role="grid" aria-describedby="user-list-page-info">
                            <thead>
                                <tr>
                                    <th>Kode Kriteria</th>
                                    <th>No</th>
                                    <th>Deskripsi Temuan</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-break">
                                <?php $no = 1; ?>
                                <?php foreach ($deskripsiTemuan as $value) { ?>
                                    <tr>
                                        <td><?= $value['kode_kriteria'] ?></td>
                                        <td><?= $no; ?></td>
                                        <td><?= $value['deskripsi'] ?></td>
                                        <td><?= $value['kategori'] ?></td>
                                        <td><a href="/admin/form5/view/deskripsi-temuan/<?= $uuid2 ?>/<?= $value['uuid'] ?>" data-url="<?= $uuid ?>/<?= $value['uuid'] ?>" class="btn btn-primary"><i class="bi bi-eye"></i></a></td>
                                    </tr>
                                    <?php $no++; ?>
                                <?php } ?>
                            </tbody>
                        </table>

                    <?php } ?>
                </div>
                <!--  -->
            </div>
        </div>
        <hr>
    </div>
</div>

<?= $this->endSection() ?>