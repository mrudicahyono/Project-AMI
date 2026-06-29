<?php

namespace App\Controllers\Auditor;

use App\Models\PenugasanAuditorModel;
use App\Models\PeriodeModel;
use App\Models\AuditorModel;
use App\Models\UserModel;

use App\Models\KriteriaProdiModel;
use App\Controllers\BaseController;
use App\Models\CatatanAuditModel;
use App\Models\DokumenModel;
use App\Models\KelengkapanDokumenModel;
use App\Models\KopKelengkapanDokumenModel;
use App\Models\KriteriaModel;
use App\Models\ProdiModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\MY_TCPDF as TCPDF;

class Form3 extends BaseController
{
    protected $auditor;
    protected $penugasanAuditor;
    protected $periode_Model;
    protected $users;
    protected $prodi;
    protected $kriteriaProdi;
    protected $kelengkapanDokumen;
    protected $kopkelengkapanDokumen;
    protected $kriteria;
    protected $catatanAudit;
    public function __construct()
    {
        $this->kriteriaProdi = new KriteriaProdiModel();
        $this->auditor = new AuditorModel();
        $this->penugasanAuditor = new PenugasanAuditorModel();
        $this->periode_Model = new PeriodeModel();
        $this->users = new UserModel();
        $this->prodi = new ProdiModel();
        $this->kriteria = new KriteriaModel();
        $this->kopkelengkapanDokumen = new KopKelengkapanDokumenModel();
        $this->kelengkapanDokumen = new KelengkapanDokumenModel();
        $this->catatanAudit = new CatatanAuditModel();
    }

    public function beranda()
    {

        $jadwalPeriode = $this->periode_Model->first();
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
            "title" => "Form 3",
            "currentPage" => "form-3",
            'penugasan_auditor' => $penugasan_auditor,
            'formTerkunci' => $formTerkunci,
        ];

        return view('auditor/form3/beranda', $data);
    }

    public function index($uuid2)
    {
        $id_user = session()->get('id');
        $auditor = $this->auditor->where('id_user', $id_user)->first();
        if (!$auditor) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Auditor not found");
        }

        // Get all prodi ids associated with the current auditor
        $prodiIds = $this->penugasanAuditor->select('id_prodi')
            ->where('id_auditor', $auditor['id'])
            ->findColumn('id_prodi');

        if (empty($prodiIds)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("No prodi found for the auditor");
        }
        $penugasan_auditor = $this->penugasanAuditor
            ->select('penugasan_auditor.*')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('prodi.uuid', $uuid2)
            ->findAll();
        $dataCatatanAuditPositifBerdasakanProdi = [];
        $dataCatatanAuditNegatifBerdasakanProdi = [];
        foreach ($penugasan_auditor as $penugasan) {
            $catatanAudit = $this->catatanAudit->where('id_penugasan_auditor', $penugasan['id'])->findAll();
            foreach ($catatanAudit as $catatan) {
                if ($catatan['label'] === '+') {
                    $dataCatatanAuditPositifBerdasakanProdi[] = $catatan;
                } else if ($catatan['label'] === '-') {
                    $dataCatatanAuditNegatifBerdasakanProdi[] = $catatan;
                }
            }
        }
        $prodi = $this->prodi->where('uuid', $uuid2)->first();
        $data = [
            'title' => 'Form 3',
            'currentPage' => 'form-3',
            'uuid2' => $uuid2,
            'prodi' => $prodi,
            'dataCatatanAuditPositifBerdasakanProdi' => $dataCatatanAuditPositifBerdasakanProdi,
            'dataCatatanAuditNegatifBerdasakanProdi' => $dataCatatanAuditNegatifBerdasakanProdi,

        ];

        return view('auditor/form3/index', $data);
    }
    public function createCatatanPositif($uuid2)
    {
        $uuid = session()->get('uuid');
        $user = $this->users->where('uuid', $uuid)->first();
        $auditor = $this->auditor->where('id_user', $user['id'])->first();

        $prodi = $this->prodi->where('uuid', $uuid2)->first();
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id')
            ->join('prodi', 'prodi.id = id_prodi')->where('id_auditor', $auditor['id'])->where('prodi.uuid', $uuid2)->first();




        $data = [
            'title' => 'Tambah Catatan Audit Positif',
            'currentPage' => 'form-3',
            'uuid2' => $uuid2,
            'prodi' => $prodi,
            'penugasan_auditor' => $penugasan_auditor,
        ];
        return view('auditor/form3/createCatatanAuditPositif', $data);
    }

    public function createCatatanPositifPost($uuid2)
    {

        $data = [
            "uuid" => service('uuid')->uuid4()->toString(),
            'id_penugasan_auditor' => $this->request->getPost('id_penugasan_auditor'),
            'label' => $this->request->getPost('label'),
            'catatan_audit' => $this->request->getPost('catatan_audit')
        ];
        // dd($data);
        $this->catatanAudit->insert($data);
        return redirect()->to("/auditor/form-3/$uuid2")->with('sukses', 'Berhasil menambahkan catatan Audit Positif');
    }

    public function createCatatanNegatif($uuid2)
    {
        $uuid = session()->get('uuid');
        $user = $this->users->where('uuid', $uuid)->first();
        $auditor = $this->auditor->where('id_user', $user['id'])->first();

        $prodi = $this->prodi->where('uuid', $uuid2)->first();
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id')
            ->join('prodi', 'prodi.id = id_prodi')->where('id_auditor', $auditor['id'])->where('prodi.uuid', $uuid2)->first();

        $data = [
            'title' => 'Tambah Catatan Audit Negatif',
            'currentPage' => 'form-3',
            'uuid2' => $uuid2,
            'prodi' => $prodi,
            'penugasan_auditor' => $penugasan_auditor,
        ];
        return view('auditor/form3/createCatatanAuditNegatif', $data);
    }

    public function createCatatanNegatifPost($uuid2)
    {

        $data = [
            "uuid" => service('uuid')->uuid4()->toString(),
            'id_penugasan_auditor' => $this->request->getPost('id_penugasan_auditor'),
            'label' => $this->request->getPost('label'),
            'catatan_audit' => $this->request->getPost('catatan_audit')
        ];
        // dd($data);
        $this->catatanAudit->insert($data);
        return redirect()->to("/auditor/form-3/$uuid2")->with('sukses', 'Berhasil menambahkan catatan Audit Negatif');
    }


    public function updateCatatanPositif($uuid)
    {
        $catatanPositif = $this->catatanAudit->where('uuid', $uuid)->first();
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id, id_prodi, prodi.uuid as uuid_prodi')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('penugasan_auditor.id', $catatanPositif['id_penugasan_auditor'])->first();
        $uuid_prodi = $penugasan_auditor['uuid_prodi'];
        $data = [
            'title' => 'Ubah Catatan Audit Positif',
            'currentPage' => 'form-3',
            'catatanPositif' => $catatanPositif,
            'uuid' => $uuid,
            'uuid_prodi' => $uuid_prodi

        ];
        return view('auditor/form3/updateCatatanAuditPositif', $data);
    }
    public function updateCatatanPositifPost($uuid)
    {
        $data = [
            'catatan_audit' => $this->request->getPost('catatan_audit'),
        ];

        $this->catatanAudit->set($data)->where('uuid', $uuid)->update();

        $catatanAudit = $this->catatanAudit->where('uuid', $uuid)->first();
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id, id_prodi, prodi.uuid as uuid_prodi')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('penugasan_auditor.id', $catatanAudit['id_penugasan_auditor'])->first();
        $uuid_prodi = $penugasan_auditor['uuid_prodi'];
        return redirect()->to("/auditor/form-3/$uuid_prodi")->with('sukses', 'Berhasil mengedit Catatan Audit Positif');
    }
    public function updateCatatanNegatif($uuid)
    {
        $catatanNegatif = $this->catatanAudit->where('uuid', $uuid)->first();
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id, id_prodi, prodi.uuid as uuid_prodi')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('penugasan_auditor.id', $catatanNegatif['id_penugasan_auditor'])->first();
        $uuid_prodi = $penugasan_auditor['uuid_prodi'];
        $data = [
            'title' => 'Ubah Catatan Audit Positif',
            'currentPage' => 'form-3',
            'catatanNegatif' => $catatanNegatif,
            'uuid' => $uuid,
            'uuid_prodi' => $uuid_prodi

        ];
        return view('auditor/form3/updateCatatanAuditNegatif', $data);
    }
    public function updateCatatanNegatifPost($uuid)
    {
        $data = [
            'catatan_audit' => $this->request->getPost('catatan_audit'),
        ];

        $this->catatanAudit->set($data)->where('uuid', $uuid)->update();

        $catatanAudit = $this->catatanAudit->where('uuid', $uuid)->first();
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id, id_prodi, prodi.uuid as uuid_prodi')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('penugasan_auditor.id', $catatanAudit['id_penugasan_auditor'])->first();
        $uuid_prodi = $penugasan_auditor['uuid_prodi'];

        return redirect()->to("/auditor/form-3/$uuid_prodi")->with('sukses', 'Berhasil mengedit Catatan Audit Negatif');
    }
    public function catatanPositifDelete($uuid)
    {
        $catatanAudit = $this->catatanAudit->where('uuid', $uuid)->first();
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id, id_prodi, prodi.uuid as uuid_prodi')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('penugasan_auditor.id', $catatanAudit['id_penugasan_auditor'])->first();
        $uuid_prodi = $penugasan_auditor['uuid_prodi'];
        $this->catatanAudit->where('uuid', $uuid)->delete();
        return redirect()->to("/auditor/form-3/$uuid_prodi")->with('sukses', 'Berhasil menghapus Catatan Audit Positif');
    }
    public function catatanNegatifDelete($uuid)
    {
        $catatanAudit = $this->catatanAudit->where('uuid', $uuid)->first();
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id, id_prodi, prodi.uuid as uuid_prodi')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('penugasan_auditor.id', $catatanAudit['id_penugasan_auditor'])->first();
        $uuid_prodi = $penugasan_auditor['uuid_prodi'];
        $this->catatanAudit->where('uuid', $uuid)->delete();
        return redirect()->to("/auditor/form-3/$uuid_prodi")->with('sukses', 'Berhasil menghapus Catatan Audit Negatif');
    }

    public function PDFCatatanAudit($uuid2)
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
            ->whereIn('prodi.id', $prodiIds)
            ->where('prodi.uuid', $uuid2) // Pastikan $uuid2 sudah didefinisikan sebelumnya
            ->first();

        $auditorList = [];
        if (!is_null($dataKopKelengkapanDokumen)) {
            $auditorKetua = $dataKopKelengkapanDokumen['auditor_ketua'];
            $auditorAnggota = $dataKopKelengkapanDokumen['auditor_anggota'];

            // Menggabungkan ketua dan anggota menjadi satu string
            $auditorString = $auditorKetua . ', ' . $auditorAnggota;

            // Gunakan regex untuk memisahkan nama auditor
            preg_match_all('/(?:[^,]+, [^,]+(?:, [^,]+)?)/', $auditorString, $matches);
            $auditorList = $matches[0];
        }

        $penugasan_auditor = $this->penugasanAuditor
            ->select('penugasan_auditor.*')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('prodi.uuid', $uuid2)
            ->findAll();
        $dataCatatanAuditPositifBerdasakanProdi = [];
        $dataCatatanAuditNegatifBerdasakanProdi = [];
        foreach ($penugasan_auditor as $penugasan) {
            $catatanAudit = $this->catatanAudit->where('id_penugasan_auditor', $penugasan['id'])->findAll();
            foreach ($catatanAudit as $catatan) {
                if ($catatan['label'] === '+') {
                    $dataCatatanAuditPositifBerdasakanProdi[] = $catatan;
                } else if ($catatan['label'] === '-') {
                    $dataCatatanAuditNegatifBerdasakanProdi[] = $catatan;
                }
            }
        }

        // dd($dataCatatanAuditPositifBerdasakanProdi, $dataCatatanAuditNegatifBerdasakanProdi);

        // untuk nama file aja
        $prodi = $this->prodi->where('uuid', $uuid2)->first();
        $namaprodi = $prodi['nama'];



        $imagePath = FCPATH . 'assets/images/logo-title.jpg';

        $data = [
            'title' => "catatan-audit-$namaprodi",
            'uuid2' => $uuid2,
            'lokasi' => $dataKopKelengkapanDokumen['lokasi'],
            'tanggal_audit' => $dataKopKelengkapanDokumen['tanggal_audit'],
            'auditor' => $auditorList,
            'prodi' => $prodi,
            'catatan_positif' => $dataCatatanAuditPositifBerdasakanProdi,
            'catatan_negatif' => $dataCatatanAuditNegatifBerdasakanProdi,
            'image_path' => $imagePath
        ];
        // ========================================================
        // GENERATE PDFNYA 
        $view = view('auditor/form3/PDFCatatanAudit', $data);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('AMI UMRAH');
        $pdf->SetTitle('Catatan Audit PDF');
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
        $pdf->Output("catatan-audit-$namaprodi.pdf", "I");
    }
}
