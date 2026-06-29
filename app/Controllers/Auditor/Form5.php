<?php

namespace App\Controllers\Auditor;

use App\Controllers\BaseController;
use App\Models\AuditorModel;
use App\Models\DeskripsiTemuanModel;
use App\Models\KopKelengkapanDokumenModel;
use App\Models\KriteriaProdiModel;
use App\Models\PenugasanAuditorModel;
use App\Models\PeriodeModel;
use App\Models\ProdiModel;
use App\Models\RingkasanTemuanModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use PDO;
use App\Libraries\Pdf;
use App\Libraries\MY_TCPDF as TCPDF;

class Form5 extends BaseController
{

    private $users;
    private $periodeModel;
    private $auditor;
    private $penugasanAuditor;
    private $kopkelengkapanDokumen;
    private $ringkasanTemuan;
    private $prodi;
    private $kriteriaProdi;
    private $deskripsiTemuan;

    public function __construct()
    {
        $this->users = new UserModel();
        $this->periodeModel = new PeriodeModel();
        $this->auditor = new AuditorModel();
        $this->penugasanAuditor = new PenugasanAuditorModel();
        $this->kopkelengkapanDokumen = new KopKelengkapanDokumenModel();
        $this->ringkasanTemuan = new RingkasanTemuanModel();
        $this->prodi = new ProdiModel();
        $this->kriteriaProdi = new KriteriaProdiModel();
        $this->deskripsiTemuan = new DeskripsiTemuanModel();
    }

    public function beranda()
    {
        $jadwalPeriode = $this->periodeModel->first();
        if (is_null($jadwalPeriode) || !isset($jadwalPeriode)) {
            return redirect()->to('auditor/dashboard')->with('gagal', 'Jadwal AMI Belum dibuat');;
        }
        $tanggalSelesai = $jadwalPeriode['tanggal_selesai'];
        // Mengonversi tanggal selesai ke format yang dapat dibandingkan
        $tanggalSelesaiTimestamp = strtotime($tanggalSelesai);
        $tanggalSekarangTimestamp = time();
        // Jika tanggal selesai sudah lewat, kunci form
        $formTerkunci = false;
        if ($tanggalSelesaiTimestamp < $tanggalSekarangTimestamp) {
            $formTerkunci = true;
        }

        $id_user = session()->get('id');
        $user = $this->users->where('id', $id_user)->first();
        $auditor = $this->auditor->where('id_user', $id_user)->first();
        if (is_null($auditor)) {
            $data = [
                'title' => 'Dashboard',
                'currentPage' => 'dashboard',
                'error' => $user['name'] . " Belum memiliki prodi, silahkan hubungi admin",

            ];
            return view('auditor/dashboard', $data);
        }

        // dd($auditor);
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id,penugasan_auditor.uuid, prodi.uuid as uuid_prodi, ketua, auditor.nama as nama_auditor, fakultas, kode_auditor, prodi.nama as nama_prodi')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->join('auditor', 'auditor.id = penugasan_auditor.id_auditor')
            ->where('id_auditor', $auditor['id'])->findAll();
        // dd($penugasan_auditor); 

        if (is_null($penugasan_auditor) || count($penugasan_auditor) == 0) {
            return redirect()->to('auditor/dashboard')->with('gagal', $auditor['nama'] . " Belum ditugaskan");
        }

        $data = [
            "title" => "Form 5",
            "currentPage" => "form-5",
            'penugasan_auditor' => $penugasan_auditor,
            'formTerkunci' => $formTerkunci,
        ];

        return view('auditor/form5/beranda', $data);
    }

    public function index($uuid2)
    {

        $id_user = session()->get('id');
        $auditor = $this->auditor->where('id_user', $id_user)->first();
        if (!$auditor) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Auditor not found");
        }
        $prodiIds = $this->penugasanAuditor->select('id_prodi')
            ->where('id_auditor', $auditor['id'])
            ->findColumn('id_prodi');

        if (empty($prodiIds)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("No prodi found for the auditor");
        }

        $dataKopKelengkapanDokumen = $this->kopkelengkapanDokumen
            ->join('prodi', 'prodi.nama = lokasi')
            ->where('prodi.uuid', $uuid2)->first();

        $anggota = [];
        if (!is_null($dataKopKelengkapanDokumen)) {
            $anggota = $dataKopKelengkapanDokumen['auditor_anggota'];
            // Gunakan regex untuk memisahkan nama auditor
            preg_match_all('/(?:[^,]+, [^,]+(?:, [^,]+)?)/', $anggota, $matches);
            $anggota = $matches[0];
        }

        $ringkasanTemuan = $this->ringkasanTemuan
            ->select('kode_kriteria, ringkasan_temuan.id as id, deskripsi,kategori, kriteria, ringkasan_temuan.uuid as uuid, prodi.nama as nama_prodi')
            ->join('penugasan_auditor', 'penugasan_auditor.id = id_penugasan_auditor')
            ->join('kriteria', 'kriteria.id = id_kriteria')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('prodi.uuid', $uuid2)
            ->where('kategori', 'kts')
            ->findAll();

        $prodi = $this->prodi->where('uuid', $uuid2)->first();

        $periode = $this->periodeModel->first();
        $form_ed = $this->kriteriaProdi->select('kriteria_prodi.uuid as uuid, standar, is_aktif, kriteria.kode_kriteria as kode_kriteria, kriteria.id_kriteria_standar as id_standar, id_kriteria, prodi.id as id_prodi, capaian, akar_penyebab, tautan_bukti, nama, id_lembaga_akreditasi, kriteria, bobot, catatan')
            ->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
            ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
            ->join('kriteria_standar', 'kriteria_standar.id = kriteria.id_kriteria_standar')
            ->where('prodi.uuid', $uuid2)
            ->where('is_aktif', 1)
            ->findAll();


        if (count($ringkasanTemuan) == 0) {

            $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id,penugasan_auditor.uuid, prodi.uuid as uuid_prodi, ketua, auditor.nama as nama_auditor, fakultas, kode_auditor, prodi.nama as nama_prodi')
                ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
                ->join('auditor', 'auditor.id = penugasan_auditor.id_auditor')
                ->where('id_auditor', $auditor['id'])->findAll();

            $data = [
                "title" => "Form 5",
                "currentPage" => "form-5",
                'penugasan_auditor' => $penugasan_auditor,
                'error' => "Form 4 - Ringkasan Temuan Audit pada prodi " . $prodi['nama'] . " belum dibuat atau tidak ada ringkasan temuan yang memiliki kategori KTS",
                'formTerkunci' => false
            ];

            return view('auditor/form5/beranda', $data);
        }

        $deskripsiTemuan = $this->deskripsiTemuan->select()
            ->join('ringkasan_temuan', 'ringkasan_temuan.id = deskripsi_temuan.id_ringkasan_temuan')
            ->join('penugasan_auditor', 'penugasan_auditor.id = ringkasan_temuan.id_penugasan_auditor')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->join('kriteria', 'kriteria.id = id_kriteria')
            ->where('prodi.uuid', $uuid2)
            ->findAll();
        // foreach ($deskripsiTemuan as $key => $value) {
        //     echo $value['kode_kriteria'] . "===";
        // }


        if ($dataKopKelengkapanDokumen == null) {
            $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id,penugasan_auditor.uuid, prodi.uuid as uuid_prodi, ketua, auditor.nama as nama_auditor, fakultas, kode_auditor, prodi.nama as nama_prodi')
                ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
                ->join('auditor', 'auditor.id = penugasan_auditor.id_auditor')
                ->where('id_auditor', $auditor['id'])->findAll();


            $data = [
                "title" => "Form 5",
                "currentPage" => "form-5",
                'penugasan_auditor' => $penugasan_auditor,
                'error' => "Form 1 - Data kelengkapan dokumen pada prodi " . $prodi['nama'] . " belum dibuat, silahkan buat terlebih dahulu",
                'formTerkunci' => false
            ];

            return view('auditor/form5/beranda', $data);
        }

        // d($ringkasanTemuan);
        // dd($deskripsiTemuan);

        foreach ($ringkasanTemuan as $keyRingkasan => $valueRingkasan) {

            if(count($deskripsiTemuan) == 0){
                $ringkasanTemuan[$keyRingkasan]['sudah_terisi'] = false;
                continue;
            }

            foreach ($deskripsiTemuan as $keyDeskripsi => $valueDeskripsi) {
                // d($deskripsiTemuan[$key]);
                
                if ($valueRingkasan['deskripsi'] === $valueDeskripsi['deskripsi_temuan']) {
                    // echo $valueRingkasan['kriteria'] . "==" . $valueDeskripsi['kriteria'] . "endl<br>";
                    $ringkasanTemuan[$keyRingkasan]['sudah_terisi'] = true;
                    break;
                }else{
                    $ringkasanTemuan[$keyRingkasan]['sudah_terisi'] = false;
                }
            }

        }
        // d($deskripsiTemuan);
        // dd($ringkasanTemuan);

        $data = [
            'title' => 'Form 5',
            'currentPage' => 'form-5',
            'uuid2' => $uuid2,
            'prodi' => $prodi,
            'dataKopKelengkapanDokumen' => $dataKopKelengkapanDokumen,
            'anggota' => $anggota,
            'ringkasanTemuan' => $ringkasanTemuan,
            'periode' => $periode,
            'form_ed' => $form_ed,
            'wakil_auditi' => $dataKopKelengkapanDokumen['wakil_auditi'],
            'penjaminMutuAudit' => $periode['penjaminan_mutu_audit'],
            'deskripsiTemuan' => $deskripsiTemuan
        ];

        return view('auditor/form5/index', $data);
    }

    public function create($uuid2)
    {
        // dd($this->request->getVar());

        $data = [

            'uuid' => service('uuid')->uuid4()->toString(),
            'id_ringkasan_temuan' => $this->request->getVar('id_ringkasan_temuan'),
            'kriteria' => $this->request->getVar('kriteria'),
            'deskripsi_temuan' => $this->request->getVar('deskripsiTemuan'),
            'akibat' => $this->request->getVar('akibat'),
            'akar_penyebab' => $this->request->getVar('akarPenyebab'),
            'rekomendasi' => $this->request->getVar('rekomendasiDisepakati'),
            'tanggapan_auditi' => $this->request->getVar('tanggapanAuditi'),
            'rencana_perbaikan' => $this->request->getVar('rencanaPerbaikan'),
            'jadwal_perbaikan' => $this->request->getVar('jadwalPerbaikan'),
            'penanggung_jawab_perbaikan' => $this->request->getVar('pimpinanAuditi'),
            'rencana_pencegahan' => $this->request->getVar('rencanaPencegahan'),
            'jadwal_pencegahan' => $this->request->getVar('jadwalPencegahan'),
            'penanggung_jawab_pencegahan' => $this->request->getVar('pimpinanAuditi'),
            'pimpinan_auditi' => $this->request->getVar('pimpinanAuditi'),
            'reviewer' => $this->request->getVar('penjaminMutuAudit'),

        ];


        $this->deskripsiTemuan->insert($data);
        return redirect()->to("/auditor/form-5/$uuid2")->with('sukses', "Berhasil menyimpan data deskripsi temuan");
    }


    public function kelola($uuid)
    {
        $deskripsiTemuan = $this->deskripsiTemuan->select('kode_kriteria, deskripsi_temuan.uuid as uuid, prodi.nama as nama_prodi')
            ->join('ringkasan_temuan', 'ringkasan_temuan.id = deskripsi_temuan.id_ringkasan_temuan')
            ->join('penugasan_auditor', 'penugasan_auditor.id = ringkasan_temuan.id_penugasan_auditor')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->join('kriteria', 'kriteria.id = id_kriteria')
            ->where('prodi.uuid', $uuid)
            ->findAll();

        $prodi = $this->prodi->where('uuid', $uuid)->first();

        $data = [
            'title' => 'Form 5',
            'currentPage' => 'form-5',
            'uuid' => $uuid,
            'prodi' => $prodi['nama'],
            'deskripsiTemuan' => $deskripsiTemuan
        ];


        return view('auditor/form5/kelola', $data);
    }

    public function kelolaUbah($uuid, $uuid_deskripsi_temuan)
    {

        $deskripsiTemuan = $this->deskripsiTemuan->select('kode_kriteria, deskripsi_temuan.uuid as uuid, ringkasan_temuan.deskripsi as deskripsi_temuan, deskripsi_temuan.id as id, id_ringkasan_temuan, deskripsi_temuan.kriteria as kriteria, deskripsi_temuan.akibat as akibat, deskripsi_temuan.akar_penyebab as akar_penyebab, deskripsi_temuan.rekomendasi as rekomendasi, deskripsi_temuan.tanggapan_auditi as tanggapan_auditi, deskripsi_temuan.rencana_perbaikan as rencana_perbaikan, jadwal_perbaikan, penanggung_jawab_perbaikan, rencana_pencegahan, jadwal_pencegahan, penanggung_jawab_pencegahan, pimpinan_auditi, deskripsi_temuan.reviewer as reviewer')
            ->join('ringkasan_temuan', 'ringkasan_temuan.id = deskripsi_temuan.id_ringkasan_temuan')
            ->join('penugasan_auditor', 'penugasan_auditor.id = ringkasan_temuan.id_penugasan_auditor')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->join('kriteria', 'kriteria.id = id_kriteria')
            ->where('deskripsi_temuan.uuid', $uuid_deskripsi_temuan)
            ->first();

        $prodi = $this->prodi->select('nama')->where('uuid', $uuid)->first();
        // dd($deskripsiTemuan);


        $data = [
            "title" => 'Form 5',
            'currentPage' => 'form-5',
            'uuid' => $uuid,
            'prodi' => $prodi['nama'],
            'uuid_deskripsi_temuan' => $uuid_deskripsi_temuan,
            'deskripsiTemuan' => $deskripsiTemuan,
        ];

        return view('auditor/form5/kelolaUpdate', $data);
    }

    public function kelolaUbahPost($uuid, $uuid_deskripsi_temuan)
    {

        // dd($uuid_deskripsi_temuan);

        $data = [
            'akibat' => $this->request->getVar('akibat'),
            'akar_penyebab' => $this->request->getVar('akarPenyebab'),
            'rekomendasi' => $this->request->getVar('rekomendasiDisepakati'),
            'tanggapan_auditi' => $this->request->getVar('tanggapanAuditi'),
            'rencana_perbaikan' => $this->request->getVar('rencanaPerbaikan'),
            'jadwal_perbaikan' => $this->request->getVar('jadwalPerbaikan'),
            'penanggung_jawab_perbaikan' => $this->request->getVar('pimpinanAuditi'),
            'rencana_pencegahan' => $this->request->getVar('rencanaPencegahan'),
            'jadwal_pencegahan' => $this->request->getVar('jadwalPencegahan'),
            'penanggung_jawab_pencegahan' => $this->request->getVar('pimpinanAuditi'),
            'pimpinan_auditi' => $this->request->getVar('pimpinanAuditi'),
            'reviewer' => $this->request->getVar('penjaminMutuAudit'),
        ];

        // dd($data);
        $this->deskripsiTemuan->set($data)->where('uuid', $uuid_deskripsi_temuan)->update();
        return redirect()->to("/auditor/form-5/kelola/$uuid/$uuid_deskripsi_temuan")->with('sukses', 'Berhasil mengubah data deskripsi temuan');
    }


    public function kelolaDeletePost($uuid, $uuid_deskripsi_temuan)
    {

        $this->deskripsiTemuan->where('uuid', $uuid_deskripsi_temuan)->delete();
        return redirect()->to("/auditor/form-5/$uuid")->with('sukses', 'Berhasil menghapus data deskripsi temuan');
    }

    public function PDFDeskripsiTemuan($uuid2)
    {
        $id_user = session()->get('id');
        $auditor = $this->auditor->where('id_user', $id_user)->first();
        if (!$auditor) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Auditor not found");
        }
        $prodiIds = $this->penugasanAuditor->select('id_prodi')
            ->where('id_auditor', $auditor['id'])
            ->findColumn('id_prodi');

        if (empty($prodiIds)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("No prodi found for the auditor");
        }

        $dataKopKelengkapanDokumen = $this->kopkelengkapanDokumen
            ->join('prodi', 'prodi.nama = lokasi')
            ->where('prodi.uuid', $uuid2)->first();

        $anggota = [];
        if (!is_null($dataKopKelengkapanDokumen)) {
            $anggota = $dataKopKelengkapanDokumen['auditor_anggota'];
            // Gunakan regex untuk memisahkan nama auditor
            preg_match_all('/(?:[^,]+, [^,]+(?:, [^,]+)?)/', $anggota, $matches);
            $anggota = $matches[0];
        }

        $prodi = $this->prodi->where('uuid', $uuid2)->first();
        $namaprodi = $prodi['nama'];

        $ringkasanTemuan = $this->ringkasanTemuan
            ->select('kode_kriteria, ringkasan_temuan.id as id, deskripsi, kategori, kriteria, ringkasan_temuan.uuid as uuid, prodi.nama as nama_prodi')
            ->join('penugasan_auditor', 'penugasan_auditor.id = ringkasan_temuan.id_penugasan_auditor')
            ->join('kriteria', 'kriteria.id = ringkasan_temuan.id_kriteria')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('prodi.uuid', $uuid2)
            ->where('kategori', 'kts')
            ->findAll();

        $periode = $this->periodeModel->first();

        $deskripsiTemuan = $this->deskripsiTemuan
            ->select('
            deskripsi_temuan.id,
            ringkasan_temuan.deskripsi AS deskripsi_temuan,
            deskripsi_temuan.kriteria AS kriteria,
            deskripsi_temuan.akibat AS akibat,
            deskripsi_temuan.akar_penyebab AS akar_penyebab,
            deskripsi_temuan.rekomendasi AS rekomendasi,
            deskripsi_temuan.tanggapan_auditi AS tanggapan_auditi,
            deskripsi_temuan.rencana_perbaikan AS rencana_perbaikan,
            deskripsi_temuan.jadwal_perbaikan AS jadwal_perbaikan,
            deskripsi_temuan.penanggung_jawab_perbaikan AS penanggung_jawab_perbaikan,
            deskripsi_temuan.rencana_pencegahan AS rencana_pencegahan,
            deskripsi_temuan.jadwal_pencegahan AS jadwal_pencegahan,
            deskripsi_temuan.penanggung_jawab_pencegahan AS penanggung_jawab_pencegahan,
            kriteria.kode_kriteria
        ')
            ->join('ringkasan_temuan', 'deskripsi_temuan.id_ringkasan_temuan = ringkasan_temuan.id')
            ->join('kriteria', 'ringkasan_temuan.id_kriteria = kriteria.id')
            ->join('penugasan_auditor', 'ringkasan_temuan.id_penugasan_auditor = penugasan_auditor.id')
            ->where('penugasan_auditor.id_prodi', $prodi['id'])
            ->findAll();

        $imagePath = FCPATH . 'assets/images/logo-title.jpg';

        $data = [
            'title' => "deskripsi-temuan-$namaprodi",
            'uuid2' => $uuid2,
            'prodi' => $prodi,
            'dataKopKelengkapanDokumen' => $dataKopKelengkapanDokumen,
            'ringkasanTemuan' => $ringkasanTemuan,
            'anggota' => $anggota,
            'periode' => $periode,
            'deskripsiTemuan' => $deskripsiTemuan,
            'image_path' => $imagePath,
        ];

        // ========================================================
        // GENERATE PDF
        $view = view('auditor/form5/PDFDeskripsiTemuan', $data);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('AMI UMRAH');
        $pdf->SetTitle('Deskripsi Temuan PDF');
        $pdf->SetSubject('PDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $customBottomMargin = 34; // Ganti dengan nilai margin bawah yang Anda inginkan
        $pdf->SetAutoPageBreak(TRUE, $customBottomMargin);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // Add a callback for the footer

        $pdf->AddPage();
        $pdf->writeHTML($view);
        $this->response->setContentType('application/pdf');
        $pdf->Output("deskripsi-temuan-$namaprodi.pdf", "I");
    }
}
