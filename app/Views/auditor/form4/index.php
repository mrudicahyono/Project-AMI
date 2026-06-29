<?= $this->extend('auditor/layout') ?>
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
        <h4 class="card-title">Form 4 - Ringkasan Temuan <?= $prodi['nama'] ?></h4>
        <a href="/auditor/form-4" class="btn btn-warning ">Kembali</a>


    </div>
    <div class="card-header d-flex justify-content-between">
        <a href="/auditor/form-4/ringkasan-temuan/<?= $uuid2 ?>" class="btn btn-primary">Tambah Ringkasan Temuan</a>
        <a href="/auditor/form-4/ringkasan-temuan/pdf/<?= $uuid2 ?>" target="_blank" class="btn btn-primary"><i class="las la-file-download"></i>PDF</a>
    </div>
    <div class="card-body">
        <div class="row text-center">
            <table id="datatable" class="table table-striped">
                <thead>
                    <tr>
                        <!-- <th>Kode Kriteria</th> -->
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
                            <!-- <td>
                                <ol>
                                    <?php foreach ($form_ed as $value) { ?>
                                        <li><?= $value['kode_kriteria']; ?></li>
                                    <?php } ?>
                                </ol>
                            </td> -->
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
        </div>
    </div>
    <hr class="mt-2">

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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-break">
                        <?php $no = 1; ?>
                        <?php $i = 0; ?>
                        <?php if (!is_null($ringkasanTemuan)) { ?>
                            <?php foreach ($ringkasanTemuan as $key => $value) { ?>

                                <tr>
                                    <td><?= $value['kode_kriteria'] ?></td>
                                    <td><?= $no; ?></td>
                                    <td><?= $value['deskripsi'] ?></td>
                                    <td><?= $value['kategori'] ?></td>
                                    <td>
                                        <a href="/auditor/form-4/ringkasan-temuan/ubah/<?= $value['uuid'] ?>/<?= $uuid2 ?>" class="btn btn-primary ">Ubah</a>
                                        <form action="/auditor/form-4/ringkasan-temuan/hapus/<?= $value['uuid'] ?>/<?= $uuid2 ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah ingin menghapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                            <?php $no++;
                                $i++;
                            } ?>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
            <!--  -->
        </div>
    </div>



</div>

<?= $this->endSection() ?>