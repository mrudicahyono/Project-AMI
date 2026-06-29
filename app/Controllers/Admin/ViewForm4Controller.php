<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RingkasanTemuanModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PeriodeModel;
use App\Models\KriteriaProdiModel;
use App\Models\ProdiModel;
use App\Models\KopKelengkapanDokumenModel;
use App\Libraries\MY_TCPDF as TCPDF;
use App\Models\PenugasanAuditorModel;

class ViewForm4Controller extends BaseController
{
    private $ringkasanTemuanModel;
    private $kopkelengkapanDokumen;
    private $periode_Model;
    private $prodi;
    private $kriteriaProdi;
    private $ringkasanTemuan;
    private $penugasanAuditorModel;

    public function __construct()
    {
        $this->ringkasanTemuanModel = new RingkasanTemuanModel();
        $this->kopkelengkapanDokumen = new KopKelengkapanDokumenModel();
        $this->kriteriaProdi = new KriteriaProdiModel();
        $this->periode_Model = new PeriodeModel();
        $this->prodi = new ProdiModel();
        $this->kopkelengkapanDokumen = new KopKelengkapanDokumenModel();
        $this->ringkasanTemuan = new RingkasanTemuanModel();
        $this->penugasanAuditorModel = new PenugasanAuditorModel();
    }

    public function index()
    {
        
        $penugasanAuditor = $this->penugasanAuditorModel->select('penugasan_auditor.id as id, prodi.uuid as uuid_prodi, auditor.nama as nama_auditor, prodi.nama as nama_prodi')
            ->join('auditor', 'auditor.id = penugasan_auditor.id_auditor')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('penugasan_auditor.ketua', "1")
            ->findAll();

        $data = [
            "title" => "Lihat Form 4",
            "currentPage" => "lihat-form4",
            'penugasan_auditor' => $penugasanAuditor
        ];

        return view('admin/viewForm4/index', $data);
    }

    public function view($uuid2)
    {
        $dataKopKelengkapanDokumen = $this->kopkelengkapanDokumen
            ->join('prodi', 'prodi.nama = lokasi')
            ->where('prodi.uuid', $uuid2)->first();

        // $dataKopKelengkapanDokumen = $this->kopkelengkapanDokumen->findAll();
        if(is_null($dataKopKelengkapanDokumen)){
            return redirect()->back()->withInput()->with('gagal', "Data kop kelengkapan dokumen belum diisi auditor");
        }

        $anggota = [];
        if (!is_null($dataKopKelengkapanDokumen)) {
            $anggota = $dataKopKelengkapanDokumen['auditor_anggota'];
            preg_match_all('/(?:[^,]+, [^,]+(?:, [^,]+)?)/', $anggota, $matches);
            $anggota = $matches[0];
        }

        $ringkasanTemuan = $this->ringkasanTemuan
            ->select('kode_kriteria, deskripsi, kategori, ringkasan_temuan.uuid as uuid, prodi.nama as nama_prodi')
            ->join('penugasan_auditor', 'penugasan_auditor.id = id_penugasan_auditor')
            ->join('kriteria', 'kriteria.id = id_kriteria')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('prodi.uuid', $uuid2)
            ->findAll();

        $prodi = $this->prodi->where('uuid', $uuid2)->first();

        $periode = $this->periode_Model->first();
        $form_ed = $this->kriteriaProdi->select('kriteria_prodi.uuid as uuid, standar, is_aktif, kriteria.kode_kriteria as kode_kriteria, kriteria.id_kriteria_standar as id_standar, id_kriteria, prodi.id as id_prodi, capaian, akar_penyebab, tautan_bukti, nama, id_lembaga_akreditasi, kriteria, bobot, catatan')
            ->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
            ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
            ->join('kriteria_standar', 'kriteria_standar.id = kriteria.id_kriteria_standar')
            ->where('prodi.uuid', $uuid2)
            ->where('is_aktif', 1)
            ->findAll();

        $data = [
            'title' => 'Form 4',
            'currentPage' => 'lihat-form4',
            'uuid2' => $uuid2,
            'prodi' => $prodi,
            'dataKopKelengkapanDokumen' => $dataKopKelengkapanDokumen,
            'anggota' => $anggota,
            'ringkasanTemuan' => $ringkasanTemuan,
            'periode' => $periode,
            'form_ed' => $form_ed
        ];

        return view('admin/viewForm4/viewDetail.php', $data);
    }
    public function PDFRingkasanTemuan($uuid2)
    {
       
        $dataKopKelengkapanDokumen = $this->kopkelengkapanDokumen
        ->join('prodi', 'prodi.nama = lokasi')
        ->where('prodi.uuid', $uuid2)->first();

    $anggota = [];
    if (!is_null($dataKopKelengkapanDokumen)) {
        $anggota = $dataKopKelengkapanDokumen['auditor_anggota'];
        preg_match_all('/(?:[^,]+, [^,]+(?:, [^,]+)?)/', $anggota, $matches);
        $anggota = $matches[0];
    }

    $ringkasanTemuan = $this->ringkasanTemuan
        ->select('kode_kriteria, deskripsi, kategori, ringkasan_temuan.uuid as uuid, prodi.nama as nama_prodi')
        ->join('penugasan_auditor', 'penugasan_auditor.id = id_penugasan_auditor')
        ->join('kriteria', 'kriteria.id = id_kriteria')
        ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
        ->where('prodi.uuid', $uuid2)
        ->findAll();

    $prodi = $this->prodi->where('uuid', $uuid2)->first();

    $periode = $this->periode_Model->first();
    $form_ed = $this->kriteriaProdi->select('kriteria_prodi.uuid as uuid, standar, is_aktif, kriteria.kode_kriteria as kode_kriteria, kriteria.id_kriteria_standar as id_standar, id_kriteria, prodi.id as id_prodi, capaian, akar_penyebab, tautan_bukti, nama, id_lembaga_akreditasi, kriteria, bobot, catatan')
        ->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
        ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
        ->join('kriteria_standar', 'kriteria_standar.id = kriteria.id_kriteria_standar')
        ->where('prodi.uuid', $uuid2)
        ->where('is_aktif', 1)
        ->findAll();
        $imagePath = FCPATH . 'assets/images/logo-title.jpg';

        $data = [
            // 'title' => "ringkasan-temuan-$namaprodi",
            'title' => "ringkasan-temuan",
            'uuid2' => $uuid2,
            'prodi' => $prodi,
            'dataKopKelengkapanDokumen' => $dataKopKelengkapanDokumen,
            'anggota' => $anggota,
            'ringkasanTemuan' => $ringkasanTemuan,
            'periode' => $periode,
            'form_ed' => $form_ed,
            'image_path' => $imagePath
        ];
        // ========================================================
        // GENERATE PDFNYA 
        $view = view('admin/viewForm4/PDFRingkasanTemuan', $data);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('AMI UMRAH');
        $pdf->SetTitle('Ringkasan Temuan PDF');
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
        // $pdf->Output("ringkasan-temuan-$namaprodi.pdf", "I");
        $pdf->Output("ringkasan-temuan.pdf", "I");
    }
}
