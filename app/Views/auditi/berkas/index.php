<?= $this->extend('auditi/layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">


        <h4 class="card-title">Berkas untuk Jurusan <?= $prodi['nama'] ?></h4>


    </div>
    <div class="card-body">
        <div>
            <table id="user-list-table" class="table table-striped dataTable mt-2" role="grid" aria-describedby="user-list-page-info">
                <thead>
                    <tr class="ligth">
                        <th>No</th>
                        <th>Berkas Ringkasan Temuan</th>
                        <th>Berkas Deskripsi Temuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!is_null($berkas_ttd)) {
                    ?>
                        <tr>
                            <td class="text-center" style="width: 5%;">1</td>
                            <td>
                                <input type="text" class="form-control" value="<?= $berkas_ttd['link_form4'] ?>" disabled>

                            </td>
                            <td>
                                <input type="text" class="form-control" value="<?= $berkas_ttd['link_form5'] ?>" disabled>

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