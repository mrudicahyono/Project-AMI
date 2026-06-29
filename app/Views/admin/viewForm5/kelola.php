<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<?php if (isset($error)) : ?>
    <div class="alert bg-danger mt-3" role="alert">
        <div class="iq-alert-text"> <small> <?= $error; ?> </small></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
<?php endif ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">

                    <h4 class="card-title">Form 5 - Kelola Deskripsi Temuan - <?= $prodi ?></h4>
                    <a href="/admin/form5/view/<?= $uuid ?>" class="btn btn-warning mb-3">Kembali</a>
                </div>
                <div class="card-body">
                    <div>
                        <?php if (count($deskripsiTemuan) == 0) { ?>
                            <p>Data Deskripsi Temuan Belum Ada</p>
                        <?php } else { ?>

                            <div>
                                <input type="text" id="customDropdownSearch" class="form-control mb-2" placeholder="Cari Kode Kriteria">
                                <div id="customDropdownMenu" class="list-group">
                                    <?php foreach ($deskripsiTemuan as $key => $value) { ?>
                                        <a class="list-group-item list-group-item-action" href="<?= $uuid ?>/<?= $value['uuid'] ?>" data-url="<?= $uuid ?>/<?= $value['uuid'] ?>"><?= $value['kode_kriteria'] ?></a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!--  -->
                </div>


            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownItems = document.querySelectorAll('#customDropdownMenu .list-group-item');
            var dropdownSearch = document.getElementById('customDropdownSearch');
            var dropdownMenu = document.getElementById('customDropdownMenu');

            // Menampilkan dropdown saat input pencarian diklik
            dropdownSearch.addEventListener('focus', function() {
                dropdownMenu.classList.add('d-block');
            });

            // Menyembunyikan dropdown ketika klik di luar
            document.addEventListener('click', function(event) {
                if (!event.target.closest('#customDropdownSearch') && !event.target.closest('#customDropdownMenu')) {
                    dropdownMenu.classList.remove('d-block');
                }
            });

            // Event listener untuk item dropdown
            dropdownItems.forEach(function(item) {
                item.addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah link default
                    var url = this.getAttribute('data-url');
                    window.location.href = url;
                });
            });

            // Event listener untuk input pencarian
            dropdownSearch.addEventListener('keyup', function() {
                var filter = this.value.toLowerCase();
                var hasVisibleItems = false;
                dropdownItems.forEach(function(item) {
                    var text = item.textContent.toLowerCase();
                    if (text.includes(filter)) {
                        item.style.display = 'block';
                        hasVisibleItems = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Menampilkan dropdown hanya jika ada item yang cocok
                if (hasVisibleItems) {
                    dropdownMenu.classList.add('d-block');
                } else {
                    dropdownMenu.classList.remove('d-block');
                }
            });
        });
    </script>


    <?= $this->endSection() ?>