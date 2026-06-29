<?php

namespace App\Controllers\Auditor;

use App\Models\PenugasanAuditorModel;
use App\Models\PeriodeModel;
use App\Models\AuditorModel;
use App\Models\UserModel;

use App\Models\KriteriaProdiModel;
use App\Controllers\BaseController;
use App\Models\KopKelengkapanDokumenModel;
use App\Models\KriteriaModel;
use App\Models\ProdiModel;
use App\Models\RingkasanTemuanModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\Pdf;
use App\Libraries\MY_TCPDF as TCPDF;
use App\Models\DeskripsiTemuanModel;
use App\Models\KelengkapanDokumenModel;

class Form4 extends BaseController
{
    protected $auditor;
    protected $penugasanAuditor;
    protected $periode_Model;
    protected $users;
    protected $prodi;
    protected $kriteriaProdi;
    protected $kriteria;
    protected $ringkasanTemuan;
    protected $kopkelengkapanDokumen;
    private $kelengkapanDokumen;
    private $deskripsi_temuan;

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
        $this->ringkasanTemuan = new RingkasanTemuanModel();
        $this->kelengkapanDokumen = new KelengkapanDokumenModel();
        $this->deskripsi_temuan = new DeskripsiTemuanModel();
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
            "title" => "Form 4",
            "currentPage" => "form-4",
            'penugasan_auditor' => $penugasan_auditor,
            'formTerkunci' => $formTerkunci,
        ];

        return view('auditor/form4/beranda', $data);
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
            ->select('kode_kriteria, deskripsi,kategori, ringkasan_temuan.uuid as uuid, prodi.nama as nama_prodi')
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
        // dd($form_ed);
        $data = [
            'title' => 'Form 4',
            'currentPage' => 'form-4',
            'uuid2' => $uuid2,
            'prodi' => $prodi,
            'dataKopKelengkapanDokumen' => $dataKopKelengkapanDokumen,
            'anggota' => $anggota,
            'ringkasanTemuan' => $ringkasanTemuan,
            'periode' => $periode,
            'form_ed' => $form_ed
        ];

        return view('auditor/form4/index', $data);
    }

    public function ringkasanTemuan($uuid2)
    {
        $uuid = session()->get('uuid');
        $user = $this->users->where('uuid', $uuid)->first();
        $auditor = $this->auditor->where('id_user', $user['id'])->first();
        $prodi = $this->prodi->where('uuid', $uuid2)->first();

        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id')
            ->join('prodi', 'prodi.id = id_prodi')->where('id_auditor', $auditor['id'])->where('prodi.uuid', $uuid2)->first();

        $form_ed = $this->kriteriaProdi->select('kriteria_prodi.uuid as uuid, standar, is_aktif, kriteria.kode_kriteria as kode_kriteria, kriteria.id_kriteria_standar as id_standar, id_kriteria, prodi.id as id_prodi, capaian, akar_penyebab, tautan_bukti, nama, id_lembaga_akreditasi, kriteria, bobot, catatan')
            ->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
            ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
            ->join('kriteria_standar', 'kriteria_standar.id = kriteria.id_kriteria_standar')
            ->where('prodi.uuid', $uuid2)
            ->where('is_aktif', 1)
            ->findAll();

        $dataKelengkapanDokumen = $this->kelengkapanDokumen
            ->select('kode_kriteria')
            ->join('penugasan_auditor', 'penugasan_auditor.id = id_penugasan_auditor')
            ->join('kriteria', 'kriteria.id = id_kriteria')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('prodi.uuid', $uuid2)
            ->findAll();

        $form_edFilter = [];
        $i = 0;
        foreach ($form_ed as $key => $value) {
            if(isset($dataKelengkapanDokumen[$i])){
                foreach ($dataKelengkapanDokumen as $key2 => $valueKelengkapanDokumen) {
                    if($value['kode_kriteria'] == $valueKelengkapanDokumen['kode_kriteria']){
                        array_push($form_edFilter, $value);
                        $i++;
                        break;
                    }
                }

            }
        }
        
        $dataKelengkapanDokumen = [];
        $form_ed = [];

        $data = [
            'title' => 'Form 4',
            'currentPage' => 'form-4',
            'form_ed' => $form_edFilter,
            'id_penugasanAuditor' => $penugasan_auditor,
            'uuid2' => $uuid2,
            'prodi' => $prodi,
            'dataKelengkapanDokumen' => $dataKelengkapanDokumen,
        ];
        return view("auditor/form4/createRingkasanTemuan", $data);
    }

    public function ringkasanTemuanPost($uuid2)
    {
        $data = [
            "uuid" => service('uuid')->uuid4()->toString(),
            'id_penugasan_auditor' => $this->request->getPost('id_penugasanAuditor'),
            'id_kriteria' => $this->request->getPost('id_kriteria'),
            'kategori' => $this->request->getPost('kategori'),
            'deskripsi' => $this->request->getPost('deskripsi'),

        ];
        // dd($data);
        $this->ringkasanTemuan->insert($data);
        return redirect()->to("/auditor/form-4/$uuid2")->with('sukses', 'Berhasil menyimpan data ringkasan temuan');
    }

    public function ringkasanTemuanUpdate($uuid, $uuid2)
    {

        $ringkasanTemuan = $this->ringkasanTemuan->where('uuid', $uuid)->first();


        if (!$ringkasanTemuan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Kelengkapan Dokumen not found");
        }

        // Fetch the penugasan auditor using id_penugasan_auditor from kelengkapanDokumen
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id, id_prodi, prodi.uuid as uuid_prodi')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('penugasan_auditor.id', $ringkasanTemuan['id_penugasan_auditor'])->first();
        // dd($penugasan_auditor);
        if (!$penugasan_auditor) {
            // Handle case when the penugasan auditor is not found
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Penugasan Auditor not found");
        }

        // Get id_prodi from penugasan_auditor
        $id_prodi = $penugasan_auditor['id_prodi'];
        $uuid_prodi = $penugasan_auditor['uuid_prodi'];
        // dd($penugasan_auditor);

        // Fetch form_ed data using id_prodi
        $form_ed = $this->kriteriaProdi->select('kriteria.id as id_kriteria, kriteria.kode_kriteria')
            ->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
            ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
            ->where('prodi.id', $id_prodi)
            ->findAll();

        // Prepare data for the view
        $data = [
            'title' => 'Ubah Ringkasan Temuan',
            'currentPage' => 'form-4',
            'ringkasanTemuan' => $ringkasanTemuan,
            'form_ed' => $form_ed,
            'uuid' => $uuid,
            'uuid2' => $uuid2,
            'uuid_prodi' => $uuid_prodi

        ];

        return view("auditor/form4/updateRingkasanTemuan", $data);
    }
    public function ringkasanTemuanUpdatePost($uuid)
    {
        $data = [
            'id_kriteria' => $this->request->getPost('id_kriteria'),
            'kategori' => $this->request->getPost('kategori'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];
        $this->ringkasanTemuan->set($data)->where('uuid', $uuid)->update();

        
        $ringkasanTemuan = $this->ringkasanTemuan->where('uuid', $uuid)->first();
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id, id_prodi, prodi.uuid as uuid_prodi')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('penugasan_auditor.id', $ringkasanTemuan['id_penugasan_auditor'])->first();
        $uuid_prodi = $penugasan_auditor['uuid_prodi'];
        
        $deskripsi_temuanData = [
            'deskripsi_temuan' => $this->request->getPost('deskripsi')
        ];

        $this->deskripsi_temuan->set($deskripsi_temuanData)->where('id_ringkasan_temuan', $ringkasanTemuan['id'])->update();

        return redirect()->to("/auditor/form-4/$uuid_prodi")->with('sukses', 'Berhasil mengedit data  ringkasan temuan');
    }
    public function ringkasanTemuanDelete($uuid)
    {
        $ringkasanTemuan = $this->ringkasanTemuan->where('uuid', $uuid)->first();
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id, id_prodi, prodi.uuid as uuid_prodi')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('penugasan_auditor.id', $ringkasanTemuan['id_penugasan_auditor'])->first();
        $uuid_prodi = $penugasan_auditor['uuid_prodi'];

        $this->ringkasanTemuan->where('uuid', $uuid)->delete();

        return redirect()->to("/auditor/form-4/$uuid_prodi")->with('sukses', 'Berhasil menghapus data ringkasan temuan');
    }
    public function PDFRingkasanTemuan($uuid2)
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

        if(is_null($dataKopKelengkapanDokumen)){
            return redirect()->back()->withInput()->with('gagal', "Data kop kelengkapan dokumen belum ada, silahkan isi data kop kelengkapan dokumen pada Form 1");
        }

        $anggota = [];
        if (!is_null($dataKopKelengkapanDokumen)) {
            $anggota = $dataKopKelengkapanDokumen['auditor_anggota'];
            // Gunakan regex untuk memisahkan nama auditor
            preg_match_all('/(?:[^,]+, [^,]+(?:, [^,]+)?)/', $anggota, $matches);
            $anggota = $matches[0];
        }


        $ringkasanTemuan = $this->ringkasanTemuan
            ->select('kode_kriteria, deskripsi,kategori, ringkasan_temuan.uuid as uuid, prodi.nama as nama_prodi')
            ->join('penugasan_auditor', 'penugasan_auditor.id = id_penugasan_auditor')
            ->join('kriteria', 'kriteria.id = id_kriteria')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('prodi.uuid', $uuid2)
            ->orderBy('kode_kriteria') // Urutkan berdasarkan kode kriteria
            ->findAll();


        $prodi = $this->prodi->where('uuid', $uuid2)->first();
        $namaprodi = $prodi['nama'];

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
            'title' => "ringkasan-temuan-$namaprodi",
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
        $view = view('auditor/form4/PDFRingkasanTemuan', $data);
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
        $pdf->Output("ringkasan-temuan-$namaprodi.pdf", "I");
    }
}
