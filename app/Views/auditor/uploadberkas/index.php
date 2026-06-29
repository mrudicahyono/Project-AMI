<?= $this->extend('auditor/layout') ?>
<?= $this->section('content') ?>
<?php

use function PHPUnit\Framework\isNull;

if (!empty(session()->getFlashdata('sukses'))) : ?>
    <div class="alert bg-success" role="alert">
        <div class="iq-alert-text"> <small><?= session()->getFlashdata('sukses') ?> </small></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
<?php endif ?>
<div class="card">
    <div class="card-header d-flex justify-content-between">


        <h4 class="card-title">Form Upload Berkas <?= $prodi['nama'] ?></h4>
        <a href="/auditor/upload-berkas" class="btn btn-warning">Kembali</a>

    </div>
    <div class="card-body">
        <?php if (empty($uploadBerkas)) : ?>
            <a href="/auditor/upload-berkas/form-upload/<?= $uuid2 ?>" class="btn btn-primary mb-3">Upload Berkas</a>
        <?php endif; ?>
        <div>
            <table id="user-list-table" class="table table-striped dataTable mt-2" role="grid" aria-describedby="user-list-page-info">
                <thead>
                    <tr class="ligth">
                        <th>No</th>
                        <th>Link Form 4</th>
                        <th>Link Form 5</th>
                        <th class="text-center" style="min-width: 100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!is_null($uploadBerkas)) {

                    ?>

                        <tr>
                            <td class="text-center" style="width: 5%;">1</td>
                            <td>
                                <input type="text" class="form-control" value="<?= $uploadBerkas['link_form4'] ?>" disabled>

                            </td>
                            <td>
                                <input type="text" class="form-control" value="<?= $uploadBerkas['link_form5'] ?>" disabled>

                            </td>
                            <td class="text-center" style="width: 20%;">
                                <div class="flex align-items-center list-user-action">
                                    <a href="/auditor/upload-berkas/form-upload/<?= $uuid2 ?>/ubah/<?= $uploadBerkas['uuid'] ?>" class="btn  btn-primary">Edit</a>
                                    <form action="/auditor/upload-berkas/<?= $uuid2 ?>/delete/<?= $uploadBerkas['uuid'] ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah ingin menghapus?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>



</div>
<?= $this->endSection() ?>