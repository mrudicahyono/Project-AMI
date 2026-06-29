<?php

namespace App\Controllers\Auditor;

use App\Models\PenugasanAuditorModel;
use App\Models\PeriodeModel;
use App\Models\AuditorModel;
use App\Models\UserModel;

use App\Models\KriteriaProdiModel;
use App\Controllers\BaseController;
use App\Models\DokumenModel;
use App\Models\KelengkapanDokumenModel;
use App\Models\KopKelengkapanDokumenModel;
use App\Models\KriteriaModel;
use App\Models\ProdiModel;
use CodeIgniter\HTTP\ResponseInterface;
use LengthException;

use function PHPUnit\Framework\isNull;

class Form1 extends BaseController
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
            "title" => "Form 1",
            "currentPage" => "form-1",
            'penugasan_auditor' => $penugasan_auditor,
            'formTerkunci' => $formTerkunci,
        ];

        return view('auditor/form1/beranda', $data);
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

        $dataKopKelengkapanDokumen = $this->kopkelengkapanDokumen
            ->join('prodi', 'prodi.nama = lokasi')
            ->where('prodi.uuid', $uuid2)->first();

        $dataKelengkapanDokumen = $this->kelengkapanDokumen
            ->select('kode_kriteria, status_dokumen, nama_dokumen, keterangan, ketua, kelengkapan_dokumen.uuid as uuid, prodi.nama as nama_prodi')
            ->join('penugasan_auditor', 'penugasan_auditor.id = id_penugasan_auditor')
            ->join('kriteria', 'kriteria.id = id_kriteria')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('prodi.uuid', $uuid2)
            ->findAll();

        $anggota = [];
        if (!is_null($dataKopKelengkapanDokumen)) {
            $anggota = $dataKopKelengkapanDokumen['auditor_anggota'];
            // Gunakan regex untuk memisahkan nama auditor
            preg_match_all('/(?:[^,]+, [^,]+(?:, [^,]+)?)/', $anggota, $matches);
            $anggota = $matches[0];
        }

        $prodi = $this->prodi->where('uuid', $uuid2)->first();
        $data = [
            'title' => 'Form 1',
            'currentPage' => 'form-1',
            'uuid_prodi' => $uuid2,
            'dataKopKelengkapanDokumen' => $dataKopKelengkapanDokumen,
            'dataKelengkapanDokumen' => $dataKelengkapanDokumen,
            'uuid2' => $uuid2,
            'prodi' => $prodi,
            'anggota' => $anggota
        ];

        return view('auditor/form1/index', $data);
    }



    public function kopKelengkapanDokumen($uuid2)
    {
        $uuid = session()->get('uuid');
        $user = $this->users->where('uuid', $uuid)->first();
        $auditor = $this->auditor->where('id_user', $user['id'])->first();
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id, id_auditor, id_prodi, id_periode, penugasan_auditor.uuid as uuid, ketua, prodi.nama as nama_prodi')
            ->join('prodi', 'prodi.id = id_prodi')
            ->where('id_auditor', $auditor['id'])
            ->where('prodi.uuid', $uuid2)
            ->first();

        // dd($penugasan_auditor);

        // Mendapatkan nama prodi dari id_prodi yang didapat dari tabel penugasan auditor
        $prodiId = $penugasan_auditor['id_prodi'];
        $prodiName = $this->prodi->getProdiNameById($prodiId);
        // dd($prodiName);

        // Mendapatkan semua data dari tabel penugasan auditor yang memiliki id prodinya sama dengan id dari auditor yang sedang aktif
        $penugasan_auditor_with_same_prodi = $this->penugasanAuditor->where('id_prodi', $prodiId)->findAll();

        // Mendapatkan informasi tambahan dari hasil penugasan auditor
        $auditor_ketua = [];
        $auditor_anggota = [];

        // dd($penugasan_auditor_with_same_prodi);

        foreach ($penugasan_auditor_with_same_prodi as $pa) {
            $auditor_name = $this->auditor->getAuditorNameById($pa['id_auditor']);
            if ($pa['ketua'] == 1) {
                $auditor_ketua[] = $auditor_name;
            } else {
                $auditor_anggota[] = $auditor_name;
            }
        }
        $periode_Model = $this->periode_Model->first();
        $prodi = $this->prodi->where('uuid', $uuid2)->first();
        // dd($prodi);

        if (count($auditor_ketua) == 0) {
            return redirect()->to("/auditor/dashboard")->with('gagal', 'Prodi belum memiliki ketua auditor, silahkan hubungi admin');
        }
        if (count($auditor_anggota) == 0) {
            return redirect()->to("/auditor/dashboard")->with('gagal', 'Prodi belum memiliki anggota auditor, silahkan hubungi admin');
        }

        $data = [
            'title' => 'Kop Kelengkapan Dokumen',
            'currentPage' => 'form-1',
            'lokasi' => $prodiName,
            'auditor_ketua' => $auditor_ketua,
            'auditor_anggota' => $auditor_anggota,
            'periode' => $periode_Model,
            'id_penugasanAuditor' => $penugasan_auditor,
            'uuid2' => $uuid2,
            'prodi' => $prodi

        ];
        return view("auditor/form1/kopkelengkapandokumen/createKopKelengkapanDokumen", $data);
    }

    public function kopKelengkapanDokumenPost($uuid)
    {

        $anggota = [];
        foreach ($this->request->getVar() as $key => $value) {

            if ((substr($key, 0, 15)) == "auditor_anggota") {
                array_push($anggota, $value);
            }
        }

        $anggota = implode(',', $anggota);

        $data = [
            "uuid" => service('uuid')->uuid4()->toString(),
            'lokasi' => $this->request->getPost('lokasi'),
            'ruang_lingkup' => $this->request->getPost('ruang_lingkup'),
            'tanggal_audit' => $this->request->getPost('tanggal_audit'),
            'wakil_auditi' => $this->request->getPost('wakil_auditi'),
            'auditor_ketua' => $this->request->getPost('auditor_ketua'),
            'auditor_anggota' => $anggota,
            'id_penugasan_auditor' => $this->request->getPost('id_penugasanAuditor')
        ];

        $this->kopkelengkapanDokumen->insert($data);
        return redirect()->to("/auditor/form-1/$uuid")->with('sukses', 'Berhasil menyimpan data kop kelengkapan dokumen');
    }


    public function kopkelengkapanDokumenUpdate($uuid)
    {
        $kopkelengkapanDokumen = $this->kopkelengkapanDokumen->join('prodi', 'prodi.nama = lokasi')
            ->where('prodi.uuid', $uuid)->first();
        $anggota = $kopkelengkapanDokumen['auditor_anggota'];

        // Gunakan regex untuk memisahkan nama auditor
        preg_match_all('/(?:[^,]+, [^,]+(?:, [^,]+)?)/', $anggota, $matches);
        $anggota = $matches[0];

        $data = [
            'title' => 'Ubah Kop Kelengkapan Dokumen',
            'currentPage' => 'form-1',
            'kopkelengkapanDokumen' => $kopkelengkapanDokumen,
            'uuid' => $uuid,
            'anggota' => $anggota
        ];

        return view("auditor/form1/kopkelengkapandokumen/updateKopKelengkapanDokumen", $data);
    }


    public function kopkelengkapanDokumenUpdatePost($uuid)
    {

        $prodi = $this->prodi->where('uuid', $uuid)->first();

        $data = [
            'wakil_auditi' => $this->request->getPost('wakil_auditi'),
        ];

        $this->kopkelengkapanDokumen->set($data)->where('lokasi', $prodi['nama'])->update();
        return redirect()->to("/auditor/form-1/$uuid")->with('sukses', 'Berhasil mengedit data kop kelengkapan dokumen');
    }

    public function kopkelengkapanDokumenDelete($uuid)
    {
        $prodi = $this->prodi->where('uuid', $uuid)->first();

        $this->kopkelengkapanDokumen->where('lokasi', $prodi['nama'])->delete();
        return redirect()->to("/auditor/form-1/$uuid")->with('sukses', 'Berhasil menghapus data kop kelengkapan dokumen');
    }
    public function kelengkapanDokumen($uuid2)
    {
        $uuid = session()->get('uuid');
        $user = $this->users->where('uuid', $uuid)->first();
        $auditor = $this->auditor->where('id_user', $user['id'])->first();
        $prodi = $this->prodi->where('uuid', $uuid2)->first();

        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id')
            ->join('prodi', 'prodi.id = id_prodi')->where('id_auditor', $auditor['id'])->where('prodi.uuid', $uuid2)->first();
        // $penugasan_auditor = $this->penugasanAuditor->findAll();
        // dd($penugasan_auditor);

        $form_ed = $this->kriteriaProdi->select('kriteria_prodi.uuid as uuid, standar, is_aktif, kriteria.kode_kriteria as kode_kriteria, kriteria.id_kriteria_standar as id_standar, id_kriteria, prodi.id as id_prodi, capaian, akar_penyebab, tautan_bukti, nama, id_lembaga_akreditasi, kriteria, bobot, catatan')
            ->join('prodi', 'prodi.id = kriteria_prodi.id_prodi')
            ->join('kriteria', 'kriteria.id = kriteria_prodi.id_kriteria')
            ->join('kriteria_standar', 'kriteria_standar.id = kriteria.id_kriteria_standar')
            ->where('prodi.uuid', $uuid2)
            ->where('is_aktif', 1)
            ->findAll();


        $data = [
            'title' => 'Form 1',
            'currentPage' => 'form-1',
            'form_ed' => $form_ed,
            'id_penugasanAuditor' => $penugasan_auditor,
            'uuid2' => $uuid2,
            'prodi' => $prodi
        ];
        return view("auditor/form1/kelengkapandokumen/createKelengkapanDokumen", $data);
    }

    public function kelengkapanDokumenPost($uuid2)
    {


        $data = [
            "uuid" => service('uuid')->uuid4()->toString(),
            'id_penugasan_auditor' => $this->request->getPost('id_penugasanAuditor'),
            'id_kriteria' => $this->request->getPost('id_kriteria'),
            'status_dokumen' => $this->request->getPost('status_dokumen'),
            'nama_dokumen' => $this->request->getPost('nama_dokumen'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];
        // dd($data);
        $this->kelengkapanDokumen->insert($data);
        return redirect()->to("/auditor/form-1/$uuid2")->with('sukses', 'Berhasil menyimpan data kelengkapan dokumen');
    }

    public function kelengkapanDokumenUpdate($uuid)
    {

        // Fetch the current document data to be updated
        $kelengkapanDokumen = $this->kelengkapanDokumen->where('uuid', $uuid)->first();
        // dd($kelengkapanDokumen);

        if (!$kelengkapanDokumen) {
            // Handle case when the document is not found
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Kelengkapan Dokumen not found");
        }

        // Fetch the penugasan auditor using id_penugasan_auditor from kelengkapanDokumen
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id, id_prodi, prodi.uuid as uuid_prodi')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('penugasan_auditor.id', $kelengkapanDokumen['id_penugasan_auditor'])->first();
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
            'title' => 'Ubah Kelengkapan Dokumen',
            'currentPage' => 'form-1',
            'kelengkapanDokumen' => $kelengkapanDokumen,
            'form_ed' => $form_ed,
            'uuid' => $uuid,
            'uuid_prodi' => $uuid_prodi

        ];

        return view("auditor/form1/kelengkapandokumen/updateKelengkapanDokumen", $data);
    }



    public function kelengkapanDokumenUpdatePost($uuid)
    {
        $data = [
            'id_kriteria' => $this->request->getPost('id_kriteria'),
            'status_dokumen' => $this->request->getPost('status_dokumen'),
            'nama_dokumen' => $this->request->getPost('nama_dokumen'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];
        $this->kelengkapanDokumen->set($data)->where('uuid', $uuid)->update();

        $kelengkapanDokumen = $this->kelengkapanDokumen->where('uuid', $uuid)->first();
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id, id_prodi, prodi.uuid as uuid_prodi')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('penugasan_auditor.id', $kelengkapanDokumen['id_penugasan_auditor'])->first();
        $uuid_prodi = $penugasan_auditor['uuid_prodi'];

        return redirect()->to("/auditor/form-1/$uuid_prodi")->with('sukses', 'Berhasil mengedit data kelengkapan dokumen');
    }

    public function kelengkapanDokumenDelete($uuid)
    {

        $kelengkapanDokumen = $this->kelengkapanDokumen->where('uuid', $uuid)->first();
        $penugasan_auditor = $this->penugasanAuditor->select('penugasan_auditor.id as id, id_prodi, prodi.uuid as uuid_prodi')
            ->join('prodi', 'prodi.id = penugasan_auditor.id_prodi')
            ->where('penugasan_auditor.id', $kelengkapanDokumen['id_penugasan_auditor'])->first();
        $uuid_prodi = $penugasan_auditor['uuid_prodi'];

        $this->kelengkapanDokumen->where('uuid', $uuid)->delete();

        return redirect()->to("/auditor/form-1/$uuid_prodi")->with('sukses', 'Berhasil menghapus data kelengkapan dokumen');
    }
}
