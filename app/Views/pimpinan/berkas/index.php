<?= $this->extend('pimpinan/layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">


        <h4 class="card-title">Semua Berkas Berdasarkan Prodi</h4>


    </div>
    <div class="card-body">
        <div>
            <table id="user-list-table" class="table table-striped dataTable mt-2" role="grid" aria-describedby="user-list-page-info">
                <thead>
                    <tr class="ligth">
                        <th>No</th>
                        <th>Prodi</th>
                        <th>Link Form 4</th>
                        <th>Link Form 5</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!is_null($berkas_ttd)) {
                    ?>
                        <?php $no = 1; ?>
                        <?php foreach ($berkas_ttd as $value) { ?>
                            <tr>
                                <td class="text-center" style="width: 5%;"><?= $no; ?></td>
                                <td style="width: 20%;">
                                    <input type="text" class="form-control" value="<?= $value['nama_prodi'] ?>" disabled>

                                </td>
                                <td>
                                    <input type="text" class="form-control" value="<?= $value['link_form4'] ?>" disabled>

                                </td>
                                <td>
                                    <input type="text" class="form-control" value="<?= $value['link_form5'] ?>" disabled>

                                </td>
                            </tr>

                        <?php $no++;
                        } ?>
                    <?php
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>



</div>
<?= $this->endSection() ?>