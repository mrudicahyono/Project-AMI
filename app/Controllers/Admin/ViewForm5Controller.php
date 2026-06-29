<?php

namespace App\Controllers\Admin;

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
use App\Libraries\MY_TCPDF as TCPDF;

class ViewForm5Controller extends BaseController
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

    public function index()
    {
        
        $penugasanAuditors = $this->penugasanAuditor->select('penugasan_auditor.id as id, prodi.uuid as uuid_prodi, auditor.nama as nama_auditor, prodi.nama as nama_prodi')
            ->join('auditor', 'auditor.id = penugasan_auditor.id_auditor')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('penugasan_auditor.ketua', "1")
            ->findAll();

        $data = [
            "title" => "Lihat Form 5",
            "currentPage" => "lihat-form5",
            'penugasan_auditor' => $penugasanAuditors,
        ];

        return view('admin/viewForm5/index', $data);
    }

    public function view($uuid2)
    {

        $dataKopKelengkapanDokumen = $this->kopkelengkapanDokumen
            ->join('prodi', 'prodi.nama = lokasi')
            ->where('prodi.uuid', $uuid2)->first();

        if(is_null($dataKopKelengkapanDokumen)){
            return redirect()->back()->withInput()->with('gagal', "Data kop kelengkapam dokumen belum diisi");
        }

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


        $deskripsiTemuan = $this->deskripsiTemuan->select('kode_kriteria, deskripsi_temuan.uuid as uuid, ringkasan_temuan.deskripsi as deskripsi, ringkasan_temuan.kategori as kategori, prodi.nama as nama_prodi')
            ->join('ringkasan_temuan', 'ringkasan_temuan.id = deskripsi_temuan.id_ringkasan_temuan')
            ->join('penugasan_auditor', 'penugasan_auditor.id = ringkasan_temuan.id_penugasan_auditor')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->join('kriteria', 'kriteria.id = id_kriteria')
            ->where('prodi.uuid', $uuid2)
            ->findAll();


        $data = [
            'title' => 'Form 5',
            'currentPage' => 'lihat-form5',
            'uuid' => $uuid2,
            'uuid2' => $uuid2,
            'prodi' => $prodi,
            'dataKopKelengkapanDokumen' => $dataKopKelengkapanDokumen,
            'anggota' => $anggota,
            // 'ringkasanTemuan' => $ringkasanTemuan,
            'periode' => $periode,
            'form_ed' => $form_ed,
            'wakil_auditi' => $dataKopKelengkapanDokumen['wakil_auditi'],
            'penjaminMutuAudit' => $periode['penjaminan_mutu_audit'],
            'deskripsiTemuan' => $deskripsiTemuan
        ];

        return view('admin/viewForm5/beranda', $data);
    }



    public function viewDetail($uuid, $uuid_deskripsi_temuan)
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
            'currentPage' => 'lihat-form5',
            'uuid' => $uuid,
            'uuid_deskripsi_temuan' => $uuid_deskripsi_temuan,
            'deskripsiTemuan' => $deskripsiTemuan,
            'prodi' => $prodi['nama'],
        ];

        return view('admin/viewForm5/viewDetail', $data);
    }

    public function PDFDeskripsiTemuan($uuid2)
    {
        // $id_user = session()->get('id');
        // $auditor = $this->auditor->where('id_user', $id_user)->first();
        // if (!$auditor) {
        //     throw new \CodeIgniter\Exceptions\PageNotFoundException("Auditor not found");
        // }
        // $prodiIds = $this->penugasanAuditor->select('id_prodi')
        //     ->where('id_auditor', $auditor['id'])
        //     ->findColumn('id_prodi');

        // if (empty($prodiIds)) {
        //     throw new \CodeIgniter\Exceptions\PageNotFoundException("No prodi found for the auditor");
        // }

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
