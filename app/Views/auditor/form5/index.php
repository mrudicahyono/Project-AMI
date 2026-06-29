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
<div class="card">
    <div class="card-header d-flex justify-content-between">

        <h4 class="card-title">Form 5 - Deskripsi Temuan <?= $prodi['nama'] ?></h4>
        <a href="/auditor/form-5" class="btn btn-warning ">Kembali</a>

    </div>
    <div class="card-header d-flex justify-content-between">
        <a href="/auditor/form-5/kelola/<?= $uuid2 ?>" class="btn btn-primary">Kelola Deskripsi Temuan</a>
        <a href="/auditor/form-5/deskripsi-temuan/pdf/<?= $uuid2 ?>" target="_blank" class="btn btn-primary"><i class="las la-file-download"></i>PDF</a>
    </div>
    <div class="card-body">
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
        </div>
        <hr>
        <div class="row ">
            <div class="card-body">
                <div class="container">
                    <h4 class="text-left">Tambah Deskripsi Temuan</h4>
                    <div class="form-group">
                        <label for="dropdown">Pilih Kode Kriteria:</label>
                        <!--  -->
                        <select id="dropdown" class="form-control">
                            <option value="">--Pilih Kode Kriteria--</option>
                            <?php foreach ($ringkasanTemuan as $key => $value) { ?>
                                <?php $uniqueKey = $value['kode_kriteria'] . '-' . $value['id']; ?>
                                <option value="<?= $uniqueKey ?>"><?= $value['kode_kriteria']; ?> - <?= ($value['sudah_terisi']) ? 'Sudah diisi' : 'Belum diisi' ?></option>
                            <?php } ?>
                        </select>
                        <!--  -->
                    </div>
                    <?php foreach ($ringkasanTemuan as $key => $value) { ?>
                        <?php $uniqueKey = $value['kode_kriteria'] . '-' . $value['id']; ?>
                        <div id="<?= $uniqueKey ?>" class="hidden form-temuan">
                            <p>Kode kriteria - <?= $value['kode_kriteria'] ?></p>

                            <?php if ($value['sudah_terisi'] == true) { ?>
                                <p>Deskripsi temuan pada <b>"<?= $value['deskripsi'] ?>"</b> pada kode kriteria <b><?= $value['kode_kriteria'] ?></b> sudah diisi, silakan cek pada <b>Kelola Deskripsi Temuan</b></p>
                            <?php } else { ?>
                                <form class="row text-center" action="/auditor/form-5/<?= $uuid2 ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="text" name="id_ringkasan_temuan" value="<?= $value['id'] ?>" hidden>
                                    <input type="text" name="penjaminMutuAudit" value="<?= $penjaminMutuAudit ?>" hidden>
                                    <input type="text" name="pimpinanAuditi" value="<?= $wakil_auditi ?>" hidden>

                                    <div class="col-12 col-lg-6 form-group">
                                        <label for="deskripsiTemuan">Deskripsi Temuan</label>
                                        <textarea class="form-control" id="deskripsiTemuan-visible-<?= $uniqueKey ?>" rows="3" disabled></textarea>
                                        <textarea class="form-control hidden-textarea" id="deskripsiTemuan-<?= $uniqueKey ?>" name="deskripsiTemuan" rows="3" style="display: none;"></textarea>
                                    </div>
                                    <div class="col-12 col-lg-6 form-group">
                                        <label for="kriteria">Kriteria</label>
                                        <div class="form-control-static" id="kriteria-visible-<?= $uniqueKey ?>" style="height: auto; padding: 10px; background: #f1f1f1; border-radius: 5px;"></div>
                                        <textarea class="form-control hidden-textarea" id="kriteria-<?= $uniqueKey ?>" name="kriteria" rows="3" style="display: none;"></textarea>
                                    </div>
                                    <div class="col-12 col-lg-6 form-group">
                                        <label for="akibat">Akibat</label>
                                        <textarea class="form-control" id="akibat" name="akibat" rows="3" required></textarea>
                                        <!-- <label for="akibat" class="form-label">Akibat</label>
                                        <input id="akibat" type="hidden" name="akibat">
                                        <trix-editor input="akibat"></trix-editor> -->
                                    </div>
                                    <div class="col-12 col-lg-6 form-group">
                                        <label for="akarPenyebab">Akar Penyebab/Masalah</label>
                                        <textarea class="form-control" id="akarPenyebab" name="akarPenyebab" rows="3" required></textarea>
                                        <!-- <label for="akarPenyebab" class="form-label">Akar Penyebab</label>
                                        <input id="akarPenyebab" type="hidden" name="akarPenyebab">
                                        <trix-editor input="akarPenyebab"></trix-editor> -->
                                    </div>
                                    <div class="col-12 col-lg-6 form-group">
                                        <label for="rekomendasiDisepakati">Rekomendasi disepakati dengan audit</label>
                                        <textarea class="form-control" id="rekomendasiDisepakati" name="rekomendasiDisepakati" rows="3" required></textarea>
                                        <!-- <label for="rekomendasiDisepakati" class="form-label">Rekomendasi disepakati dengan audit</label>
                                        <input id="rekomendasiDisepakati" type="hidden" name="rekomendasiDisepakati">
                                        <trix-editor input="rekomendasiDisepakati"></trix-editor> -->
                                    </div>
                                    <div class="col-12 col-lg-6 form-group">
                                        <label for="tanggapanAuditi">Tanggapan Auditi</label>
                                        <select id="dropdown" class="form-control" name="tanggapanAuditi" required>
                                            <option value="">Tanggapan Auditi</option>
                                            <option value="Setuju">Setuju</option>
                                            <option value="Tidak Setuju">Tidak Setuju</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-lg-6 form-group">
                                        <label for="rencanaPerbaikan">Rencana Perbaikan</label>
                                        <textarea class="form-control" id="rencanaPerbaikan" name="rencanaPerbaikan" rows="3" required></textarea>
                                        <!-- <label for="rencanaPerbaikan" class="form-label">Rencana Perbaikan</label>
                                        <input id="rencanaPerbaikan" type="hidden" name="rencanaPerbaikan">
                                        <trix-editor input="rencanaPerbaikan"></trix-editor> -->
                                    </div>
                                    <div class="col-12 col-lg-6 form-group">
                                        <label for="jadwalPerbaikan" id="jadwalPerbaikan">Jadwal Perbaikan</label>
                                        <input type="date" class="form-control" id="jadwalPerbaikan" name="jadwalPerbaikan" required>
                                    </div>
                                    <div class="col-12 col-lg-6 form-group">
                                        <label for="rencanaPencegahan" id="rencanaPencegahan">Rencana Pencegahan</label>
                                        <textarea class="form-control" id="rencanaPencegahan" rows="3" name="rencanaPencegahan" required></textarea>
                                        <!-- <label for="rencanaPencegahan" class="form-label">Rencana Pencegahan</label>
                                        <input id="rencanaPencegahan" type="hidden" name="rencanaPencegahan">
                                        <trix-editor input="rencanaPencegahan"></trix-editor> -->
                                    </div>
                                    <div class="col-12 col-lg-6 form-group">
                                        <label for="jadwalPencegahan" id="jadwalPencegahan">Jadwal Pencegahan</label>
                                        <input type="date" class="form-control" id="jadwalPencegahan" name="jadwalPencegahan" required>
                                    </div>
                                    <div class="col-12 mt-5">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include the ringkasanTemuan and kriteria data as JSON -->
<script>
    const ringkasanTemuan = <?= json_encode($ringkasanTemuan) ?>;
    const kriteriaData = <?= json_encode($form_ed) ?>;

    document.addEventListener('DOMContentLoaded', function() {
        // Hide all forms on page load
        document.querySelectorAll('.hidden').forEach(function(form) {
            form.style.display = 'none';
        });

        document.getElementById('dropdown').addEventListener('change', function() {
            // Hide all forms
            document.querySelectorAll('.hidden').forEach(function(form) {
                form.style.display = 'none';
            });

            // Show the selected form
            var selectedForm = this.value;
            if (selectedForm) {
                document.getElementById(selectedForm).style.display = 'block';

                // Fill the Deskripsi Temuan and Kriteria fields automatically
                const [selectedKodeKriteria, selectedId] = selectedForm.split('-');
                const selectedTemuan = ringkasanTemuan.find(item => item.kode_kriteria === selectedKodeKriteria && item.id == selectedId);
                const selectedKriteria = kriteriaData.find(item => item.kode_kriteria === selectedKodeKriteria);

                if (selectedTemuan) {
                    document.getElementById(`deskripsiTemuan-visible-${selectedForm}`).value = selectedTemuan.deskripsi;
                    document.getElementById(`deskripsiTemuan-${selectedForm}`).value = selectedTemuan.deskripsi;
                }
                if (selectedKriteria) {
                    document.getElementById(`kriteria-visible-${selectedForm}`).innerHTML = selectedKriteria.kriteria;
                    document.getElementById(`kriteria-${selectedForm}`).value = selectedKriteria.kriteria;
                }
            }
        });
    });
</script>
<style>
    .hidden-textarea {
        display: none;
    }

    .form-control-static {
        padding: 10px;
        background: #f1f1f1;
        border-radius: 5px;
        height: auto;
    }

    trix-toolbar {
        display: none;
    }
    trix-editor {
        text-align: left;
    }
</style>
<?= $this->endSection() ?>