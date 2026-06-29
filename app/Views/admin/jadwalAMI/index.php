<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata()) : ?>

    <div class="alert alert-success mt-4" role="alert">
        <?= session()->getFlashdata('pesan') ?>
    </div>

<?php endif; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h5 class="card-title">Jadwal Pelaksanaan AMI</h5>
                    <small class="text-danger">Jadwal Pelaksanaan AMI Hanya dapat di tambahkan hanya 1 kali saja</small>
                </div>

                <?php if ($showAddButton) : ?>
                    <div>
                        <a href="/admin/jadwal-ami/create" class="btn btn-primary">Tambah Jadwal AMI</a>
                    </div>
                <?php endif; ?>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="user-list-table" class="table table-striped dataTable mt-2" role="grid" aria-describedby="user-list-page-info">
                        <thead>
                            <tr class="ligth">
                                <th>#</th>
                                <th class="text-center">Nama Periode</th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">Ruang Lingkup</th>
                                <th class="text-center">Penjaminan Audit Mutu</th>
                                <th class="text-center">Tanggal Mulai</th>
                                <th class="text-center">Tanggal Selesai</th>
                                <th class="text-center" style="min-width: 100px">Aksi</th>
                            </tr>
                        </thead>
                        <?php $i = 1 ?>
                        <?php foreach ($jadwalAMI as $jdwlAMI) : ?>
                            <tbody>
                                <tr>
                                    <td class="text-center"><?= $i++ ?></td>
                                    <td class="text-center"><?= $jdwlAMI['nama_periode'] ?></td>
                                    <td class="text-center"><?= $jdwlAMI['tahun'] ?></td>
                                    <td class="text-center"><?= $jdwlAMI['ruang_lingkup'] ?></td>
                                    <td class="text-center"><?= $jdwlAMI['penjaminan_mutu_audit'] ?></td>
                                    <td class="text-center"><?= $jdwlAMI['tanggal_mulai'] ?></td>
                                    <td class="text-center"><?= $jdwlAMI['tanggal_selesai'] ?></td>

                                    <td class="text-center">
                                        <div class="flex align-items-center list-user-action">
                                            <a href="/admin/jadwal-ami/edit/<?= $jdwlAMI['uuid'] ?>" class="btn  btn-primary">Edit</a>
                                            <form action="/admin/jadwal-ami/<?= $jdwlAMI['id'] ?>" method="POST" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button class="btn  btn-danger" onclick="return confirm('Apakah anda yakin?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        <?php endforeach ?>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>