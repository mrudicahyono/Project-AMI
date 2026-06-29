<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'Login::index');
$routes->post('/', 'Login::login_action');
$routes->get('/register', 'UserController::register');
$routes->post('register/save', 'UserController::saveRegister');
$routes->get('logout', 'Login::logout');
// Tambakan ['filter' => 'pimpinanFilter'] untuk memberikan filter routing / url hanya bisa diakses
// oleh role yang sama sesuai ketentuan yang telah di buat Folder Filters/xxxxFilter

$routes->get('pimpinan/dashboard', 'Pimpinan\Dashboard::index');
$routes->get('auditor/dashboard', 'Auditor\Dashboard::index');
$routes->get('auditi/dashboard', 'Auditi\Dashboard::index');
$routes->get('admin/dashboard', 'Admin\Dashboard::index');

// FITUR ROLE ADMIN 
// jadwal periode admin
$routes->group('admin', static function($routes){

    // jadwal periode
    $routes->group('jadwal-periode', static function($routes){
        $routes->get('', 'Admin\JadwalED::index');
        $routes->get('create', 'Admin\JadwalED::create');
        $routes->post('save', 'Admin\JadwalED::save');
        $routes->post('update/(:num)', 'Admin\JadwalED::update/$1');
        $routes->get('edit/(:segment)', 'Admin\JadwalED::edit/$1');
        $routes->delete('(:num)', 'Admin\JadwalED::delete/$1');

    });

    // kelola kriteria ed admin untuk prodi
    $routes->group('kriteria-ed', static function ($routes){
        $routes->get('', 'Admin\KriteriaED::index');
        $routes->get('tambah', 'Admin\KriteriaED::create');
        $routes->post('tambah', 'Admin\KriteriaED::save');
        $routes->get('ubah/(:segment)', 'Admin\KriteriaED::update/$1');
        $routes->post('ubah/(:segment)', 'Admin\KriteriaED::updatePost/$1');
        $routes->post('hapus/(:segment)', 'Admin\KriteriaED::delete/$1');
        // kelola kriteria ed admin untuk semua prodi
        $routes->get('universitas/tambah', 'Admin\KriteriaED::createUniv');
        $routes->post('universitas/tambah', 'Admin\KriteriaED::saveUniv');
        // admin hapus kriteria ed multiple
        $routes->post('hapus-multiple', 'Admin\KriteriaED::deleteMultiple');
        // lihat ed admin
        $routes->get('view', 'Admin\ViewEDController::index');
        $routes->get('view/(:segment)', 'Admin\ViewEDController::view/$1');
        // admin delete kriteria ed
        $routes->post('view/delete', 'Admin\ViewEDController::delete');

    });
    
    
    
    // lihat FORM 3 admin
    $routes->group('form3', static function ($routes){
        $routes->get('view', 'Admin\ViewForm3Controller::index');
        $routes->get('view/(:segment)', 'Admin\ViewForm3Controller::view/$1');
        $routes->get('view/form-3/catatan-audit/pdf/(:segment)', 'Admin\ViewForm3Controller::PDFCatatanAudit/$1');
        // admin delete FORM 3
        $routes->post('view/delete', 'Admin\ViewForm3Controller::delete');
    });
    
    // lihat FORM 4 admin
    $routes->group('form4', static function ($routes){
        $routes->get('view', 'Admin\ViewForm4Controller::index');
        $routes->get('view/(:segment)', 'Admin\ViewForm4Controller::view/$1');
        $routes->get('view/form-4/ringkasan-temuan/pdf/(:segment)', 'Admin\ViewForm4Controller::PDFRingkasanTemuan/$1');
        
    });
    
    
    // Lihat form 5 admin
    $routes->group('form5', static function ($routes){
        $routes->get('view', 'Admin\ViewForm5Controller::index');
        $routes->get('view/(:segment)', 'Admin\ViewForm5Controller::view/$1');
        $routes->get('view/deskripsi-temuan/(:segment)/(:segment)', 'Admin\ViewForm5Controller::viewDetail/$1/$2'); 
    });
    $routes->get('form-5/deskripsi-temuan/pdf/(:segment)', 'Admin\ViewForm5Controller::PDFDeskripsiTemuan/$1');
    
    // admin kelola standar
    $routes->group('kriteria-ed', static function ($routes){
        $routes->get('tambah/standar', 'Admin\StandarController::index');
        $routes->get('tambah/standar/tambah', 'Admin\StandarController::create');
        $routes->post('tambah/standar/tambah', 'Admin\StandarController::createPost');
        $routes->get('tambah/standar/edit/(:segment)', 'Admin\StandarController::edit/$1');
        $routes->post('tambah/standar/edit/(:segment)', 'Admin\StandarController::editPost/$1');
        $routes->post('tambah/standar/hapus/(:segment)', 'Admin\StandarController::hapusPost/$1');
        
    });
    
    // admin kelola data pengguna
    $routes->group('kelola-data', static function ($routes){
        $routes->get('', 'Admin\KelolaUserController::index');
        $routes->get('(:segment)', 'Admin\KelolaUserController::detail/$1');
        $routes->post('(:segment)', 'Admin\KelolaUserController::savePassword/$1');
    });
    
    // jadwal AMI
    $routes->group('jadwal-ami', static function ($routes){
        $routes->get('', 'Admin\Periode::index');
        $routes->get('create', 'Admin\Periode::create');
        $routes->post('save', 'Admin\Periode::save');
        $routes->post('update/(:num)', 'Admin\Periode::update/$1');
        $routes->get('edit/(:segment)', 'Admin\Periode::edit/$1');
        $routes->delete('(:num)', 'Admin\Periode::delete/$1');
        
    });
    
    // Kelola Auditor
    $routes->group('kelola-auditor', static function ($routes){
        $routes->get('', 'Admin\KelolaAuditor::index');
        $routes->get('tambah', 'Admin\KelolaAuditor::create');
        $routes->post('tambah', 'Admin\KelolaAuditor::save');
        $routes->get('ubah/(:segment)', 'Admin\KelolaAuditor::update/$1');
        $routes->post('ubah/(:segment)', 'Admin\KelolaAuditor::updatePost/$1');
        $routes->post('hapus/(:segment)', 'Admin\KelolaAuditor::delete/$1');
    });
    
    // Penugasan Auditor
    $routes->group('penugasan-auditor', static function ($routes){
        $routes->get('', 'Admin\PenugasanAuditor::index');
        $routes->get('tambah', 'Admin\PenugasanAuditor::create');
        $routes->get('getProdiNameByAuditor/(:num)', 'Admin\PenugasanAuditor::getProdiNameByAuditor/$1');
        $routes->post('tambah', 'Admin\PenugasanAuditor::save');
        $routes->get('ubah/(:segment)', 'Admin\PenugasanAuditor::update/$1');
        $routes->post('ubah/(:segment)', 'Admin\PenugasanAuditor::updatePost/$1');
        $routes->post('hapus/(:segment)', 'Admin\PenugasanAuditor::delete/$1');
    });
    
    // Kelola Auditi
    $routes->group('kelola-auditi', static function ($routes){
        $routes->get('', 'Admin\KelolaAuditi::index');
        // $routes->get('admin/kelola-auditi/tambah', 'Admin\KelolaAuditi::create');
        // $routes->post('admin/kelola-auditi/tambah', 'Admin\KelolaAuditi::save');
        $routes->get('kelola/(:segment)', 'Admin\KelolaAuditi::kelola/$1');
        $routes->post('kelola/(:segment)', 'Admin\KelolaAuditi::kelolaPost/$1');
        $routes->post('hapus/(:segment)', 'Admin\KelolaAuditi::delete/$1');
    });
    
    // admin kelola prodi
    $routes->group('kelola-prodi', static function ($routes){
        $routes->get('', 'Admin\KelolaProdi::index');
        $routes->get('tambah', 'Admin\KelolaProdi::tambah');
        $routes->post('tambah', 'Admin\KelolaProdi::tambahPost');
        $routes->get('edit/(:segment)', 'Admin\KelolaProdi::edit/$1');
        $routes->post('edit/(:segment)', 'Admin\KelolaProdi::editPost/$1');
        $routes->post('hapus/(:segment)', 'Admin\KelolaProdi::hapus/$1');
        
    });
    
    // admin kelola lembaga akreditasi
    $routes->group('kelola-lembaga-akreditasi', static function ($routes){
        $routes->get('', 'Admin\KelolaLembagaAkreditasi::index');
        $routes->get('tambah', 'Admin\KelolaLembagaAkreditasi::tambah');
        $routes->post('tambah', 'Admin\KelolaLembagaAkreditasi::tambahPost');
        $routes->get('edit/(:segment)', 'Admin\KelolaLembagaAkreditasi::edit/$1');
        $routes->post('edit/(:segment)', 'Admin\KelolaLembagaAkreditasi::editPost/$1');
        $routes->post('hapus/(:segment)', 'Admin\KelolaLembagaAkreditasi::hapus/$1');
        
    });
    
    // admin kelola akses akun pengguna
    $routes->group('kelola-akses', static function ($routes){
        $routes->get('', 'Admin\KelolaAkunController::index');
        $routes->post('terima/(:segment)', 'Admin\KelolaAkunController::terima/$1');
        $routes->post('tolak/(:segment)', 'Admin\KelolaAkunController::tolak/$1');
    });
    
    // admin kelola akun pengguna (role dan prodi)
    $routes->group('kelola-akun-pengguna', static function ($routes){
        $routes->get('', 'Admin\KelolaAkunPengguna::index');
        $routes->get('kelola/(:segment)', 'Admin\KelolaAkunPengguna::update/$1');
        $routes->post('kelola/(:segment)', 'Admin\KelolaAkunPengguna::updatePost/$1');
        $routes->post('hapus/(:segment)', 'Admin\KelolaAkunPengguna::hapus/$1');
        
    });

});

// FITUR ROLE AUDITI
$routes->group('auditi', static function($routes){
    // isi form ed
    $routes->group('form-ed', static function ($routes){
        $routes->get('', 'Auditi\FormEDController::create');
        $routes->post('', 'Auditi\FormEDController::save');
        $routes->get('ubah', 'Auditi\FormEDController::ubah');
        $routes->post('ubah', 'Auditi\FormEDController::ubahPost');
        
    });
    
    
    // lihat berkas AUDIII
    $routes->get('lihat-berkas', 'Auditi\LihatBerkas::index');
    
    // Kelola data auditi
    $routes->get('kelola-data', 'Auditi\KelolaAuditiController::index');
    $routes->post('kelola-data', 'Auditi\KelolaAuditiController::savePassword');

});

// FITUR ROLE AUDITOR
$routes->group('auditor', static function ($routes){
    // lihat form ed
    $routes->get('form-ed/view', 'Auditor\ViewEDAuditorController::index');
    $routes->get('form-ed/view/(:segment)', 'Auditor\ViewEDAuditorController::create/$1');
    $routes->post('form-ed/view/(:segment)', 'Auditor\ViewEDAuditorController::createPost/$1');

    // FORM 1
    $routes->group('form-1', static function($routes){

        $routes->get('', 'Auditor\Form1::beranda');
        $routes->get('(:segment)', 'Auditor\Form1::index/$1');
        // kop kelengkapan dokumen
        $routes->group('kop-kelengkapan-dokumen', static function($routes){
            $routes->get('(:segment)', 'Auditor\Form1::kopKelengkapanDokumen/$1');
            $routes->post('tambah/(:segment)', 'Auditor\Form1::kopKelengkapanDokumenPost/$1');
            $routes->get('ubah/(:segment)', 'Auditor\Form1::kopkelengkapanDokumenUpdate/$1');
            $routes->post('ubah/(:segment)', 'Auditor\Form1::kopkelengkapanDokumenUpdatePost/$1');
            $routes->post('hapus/(:segment)', 'Auditor\Form1::kopkelengkapanDokumenDelete/$1');
            
        });
        // kelengkapan dokumen
        $routes->group('kelengkapan-dokumen', static function($routes){
            $routes->get('(:segment)', 'Auditor\Form1::kelengkapanDokumen/$1');
            $routes->post('tambah/(:segment)', 'Auditor\Form1::kelengkapanDokumenPost/$1');
            
            $routes->get('ubah/(:segment)', 'Auditor\Form1::kelengkapanDokumenUpdate/$1');
            $routes->post('ubah/(:segment)', 'Auditor\Form1::kelengkapanDokumenUpdatePost/$1');
            $routes->post('hapus/(:segment)', 'Auditor\Form1::kelengkapanDokumenDelete/$1');
        });

    });
    
    // FORM 2
    $routes->group('form-2', static function($routes){
        $routes->get('', 'Auditor\Form2::index');
    });
    // FORM 3 - catatan audit
    $routes->group('form-3', static function($routes){
        $routes->get('', 'Auditor\Form3::beranda');
        $routes->get('(:segment)', 'Auditor\Form3::index/$1');

        // catatan-audit
        $routes->group('catatan-audit', static function($routes){
            $routes->get('tambah/positif/(:segment)', 'Auditor\Form3::createCatatanPositif/$1');
            $routes->get('tambah/negatif/(:segment)', 'Auditor\Form3::createCatatanNegatif/$1');
            $routes->post('tambah/positif/(:segment)', 'Auditor\Form3::createCatatanPositifPost/$1');
            $routes->post('tambah/negatif/(:segment)', 'Auditor\Form3::createCatatanNegatifPost/$1');
            $routes->get('ubah/positif/(:segment)', 'Auditor\Form3::updateCatatanPositif/$1');
            $routes->get('ubah/negatif/(:segment)', 'Auditor\Form3::updateCatatanNegatif/$1');
            $routes->post('ubah/positif/(:segment)', 'Auditor\Form3::updateCatatanPositifPost/$1');
            $routes->post('ubah/negatif/(:segment)', 'Auditor\Form3::updateCatatanNegatifPost/$1');
            $routes->post('positif/hapus/(:segment)', 'Auditor\Form3::catatanPositifDelete/$1');
            $routes->post('negatif/hapus/(:segment)', 'Auditor\Form3::catatanNegatifDelete/$1');
            $routes->get('pdf/(:segment)', 'Auditor\Form3::PDFCatatanAudit/$1');

        });
    });
    
    
    // FORM 4 ringkasan temuan
    $routes->group('form-4', static function($routes){
        $routes->get('', 'Auditor\Form4::beranda');
        $routes->get('(:segment)', 'Auditor\Form4::index/$1');
        // ringkasan temuan
        $routes->group('ringkasan-temuan', static function($routes){
            $routes->get('(:segment)', 'Auditor\Form4::ringkasanTemuan/$1');
            $routes->post('tambah/(:segment)', 'Auditor\Form4::ringkasanTemuanPost/$1');
            $routes->get('ubah/(:segment)/(:segment)', 'Auditor\Form4::ringkasanTemuanUpdate/$1/$2');
            $routes->post('ubah/(:segment)', 'Auditor\Form4::ringkasanTemuanUpdatePost/$1');
            $routes->post('hapus/(:segment)/(:segment)', 'Auditor\Form4::ringkasanTemuanDelete/$1/$2');
            $routes->get('pdf/(:segment)', 'Auditor\Form4::PDFRingkasanTemuan/$1');
        });

    });
    
    
    // FORM 5 Deskripsi Temuan Audit
    $routes->group('form-5', static function($routes){
        $routes->get('', 'Auditor\Form5::beranda');
        $routes->get('(:segment)', 'Auditor\Form5::index/$1');
        $routes->post('(:segment)', 'Auditor\Form5::create/$1');
        // kelola
        $routes->group('kelola', static function($routes){
            $routes->get('(:segment)', 'Auditor\Form5::kelola/$1');
            $routes->get('(:segment)/(:segment)', 'Auditor\Form5::kelolaUbah/$1/$2');
            $routes->post('(:segment)/(:segment)', 'Auditor\Form5::kelolaUbahPost/$1/$2');
            $routes->post('(:segment)/(:segment)/hapus', 'Auditor\Form5::kelolaDeletePost/$1/$2');
        });
        $routes->get('deskripsi-temuan/pdf/(:segment)', 'Auditor\Form5::PDFDeskripsiTemuan/$1');

    });
    
    // UPLOAD BERKAS
    $routes->group('upload-berkas', static function($routes){
        $routes->get('', 'Auditor\UploadBerkas::beranda');
        $routes->get('(:segment)', 'Auditor\UploadBerkas::index/$1');
        $routes->get('form-upload/(:segment)', 'Auditor\UploadBerkas::formUpload/$1');
        $routes->post('form-upload/tambah/(:segment)', 'Auditor\UploadBerkas::formUploadPost/$1');
        
        $routes->get('form-upload/(:segment)/ubah/(:segment)', 'Auditor\UploadBerkas::formUploadUpdate/$1/$2');
        $routes->post('form-upload/(:segment)/ubah/(:segment)', 'Auditor\UploadBerkas::formUploadUpdatePost/$1/$2');
        $routes->post('(:segment)/delete/(:segment)', 'Auditor\UploadBerkas::formUploadDelete/$1/$2');

    });
    
    // ubah data auditor
    $routes->group('kelola-data', static function($routes){
        $routes->get('', 'Auditor\KelolaAuditorController::index');
        $routes->post('', 'Auditor\KelolaAuditorController::savePassword');
    });
        
});



// PIMPINAN
$routes->group('pimpinan', static function($routes){
    $routes->get('lihat-berkas', 'Pimpinan\LihatBerkas::index');
    // ubah data pimpinan
    $routes->get('kelola-data', 'Pimpinan\KelolaPimpinanController::index');
    $routes->post('kelola-data', 'Pimpinan\KelolaPimpinanController::savePassword');

});
