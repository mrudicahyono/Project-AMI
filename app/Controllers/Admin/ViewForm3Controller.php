<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CatatanAuditModel;
use App\Models\PenugasanAuditorModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\MY_TCPDF as TCPDF;
use App\Models\PeriodeModel;
use App\Models\AuditorModel;
use App\Models\UserModel;
use App\Models\KriteriaProdiModel;
use App\Models\DokumenModel;
use App\Models\KelengkapanDokumenModel;
use App\Models\KopKelengkapanDokumenModel;
use App\Models\KriteriaModel;
use App\Models\ProdiModel;
class ViewForm3Controller extends BaseController
{
    private $catatanAuditModel;
    private $penugasanAuditorModel;
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
        $this->catatanAuditModel = new CatatanAuditModel();
        $this->penugasanAuditorModel = new PenugasanAuditorModel();
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

    public function index()
    {

        $penugasanAuditor = $this->penugasanAuditorModel->select('penugasan_auditor.id as id, prodi.uuid as uuid_prodi, auditor.nama as nama_auditor, prodi.nama as nama_prodi')
            ->join('auditor', 'auditor.id = penugasan_auditor.id_auditor')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('penugasan_auditor.ketua', "1")
            ->findAll();


        $data = [
            "title" => "Lihat Form 3",
            "currentPage" => "lihat-form3",
            'penugasan_auditor' => $penugasanAuditor,
        ];

        return view('admin/viewForm3/index', $data);
    }

    public function view($uuid)
    {
        $catatanAuditDetail = $this->catatanAuditModel->select('catatan_audit.*, prodi.nama as nama_prodi')
            ->join('penugasan_auditor', 'penugasan_auditor.id = catatan_audit.id_penugasan_auditor')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('prodi.uuid', $uuid)
            ->findAll();
        
        if(count($catatanAuditDetail) == 0){
            return redirect()->back()->withInput()->with('gagal', "Data form 3 belum diisi auditor");
        }

        $positifNotes = [];
        $negatifNotes = [];

        foreach ($catatanAuditDetail as $item) {
            if ($item['label'] == '+') {
                $positifNotes[] = $item;
            } elseif ($item['label'] == '-') {
                $negatifNotes[] = $item;
            }
        }
        
        $data = [
            'title' => 'Lihat Detail Form 3',
            'currentPage' => 'lihat-form3',
            'positifNotes' => $positifNotes,
            'negatifNotes' => $negatifNotes,
            'catatanAuditDetail' => $catatanAuditDetail,
            'prodi_uuid' => $uuid
        ];

        return view('admin/viewForm3/viewDetail', $data);
    }


    public function delete()
    {
        // Ambil id_penugasan_auditor dari request
        $id_penugasan_auditor = $this->request->getPost('id_penugasan_auditor');

        // Cari id_prodi terkait dengan id_penugasan_auditor
        $penugasanAuditor = $this->penugasanAuditorModel->where('id', $id_penugasan_auditor)->first();

        // Jika tidak ditemukan, kembalikan dengan pesan error
        if (!$penugasanAuditor) {
            return redirect()->to('/admin/form3/view')->with('error', 'Penugasan auditor tidak ditemukan.');
        }

        // Ambil id_prodi dari penugasan auditor
        $id_prodi = $penugasanAuditor['id_prodi'];

        // Cari semua id_penugasan_auditor yang terkait dengan id_prodi
        $penugasanAuditorList = $this->penugasanAuditorModel->where('id_prodi', $id_prodi)->findAll();
        $idPenugasanAuditorList = array_column($penugasanAuditorList, 'id');

        // Hapus semua catatan audit yang terkait dengan id_penugasan_auditor dalam daftar id_penugasan_auditor
        $this->catatanAuditModel->whereIn('id_penugasan_auditor', $idPenugasanAuditorList)->delete();

        // Redirect ke halaman '/admin/form3/view' dengan pesan sukses
        return redirect()->to('/admin/form3/view')->with('success', 'Catatan audit Form 3 berhasil dihapus.');
    }
    public function PDFCatatanAudit($uuid2)
    {
     
        $dataKopKelengkapanDokumen = $this->kopkelengkapanDokumen
            ->join('prodi', 'prodi.nama = lokasi')
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
        $view = view('admin/viewForm3/PDFCatatanAudit', $data);
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
