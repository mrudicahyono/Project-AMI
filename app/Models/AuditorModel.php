<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditorModel extends Model
{
    protected $table            = 'auditor';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "id_user",
        "id_prodi",
        "uuid",
        "kode_auditor",
        "nama",
        "akhir_sertifikat",
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function getProdiIdByAuditorId($auditorId)
    {
        // Query untuk mengambil id_prodi berdasarkan id_auditor
        $query = $this->select('id_prodi')
            ->where('id', $auditorId)
            ->get();

        // Mengembalikan hasil query
        return $query->getRow('id_prodi');
    }

    public function getAuditorNameById($auditorId)
    {
        // Query untuk mengambil nama auditor berdasarkan ID auditor
        $query = $this->select('nama')
            ->where('id', $auditorId)
            ->get();

        // Mengembalikan nama auditor
        return $query->getRow('nama');
    }
}
