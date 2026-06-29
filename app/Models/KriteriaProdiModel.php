<?php

namespace App\Models;

use CodeIgniter\Model;

class KriteriaProdiModel extends Model
{
    protected $table            = 'kriteria_prodi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'uuid',
        'id_kriteria',
        'id_prodi',
        'capaian_auditi',
        'capaian',
        'akar_penyebab',
        'tautan_bukti',
        'catatan',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
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

    public function checkEdCompletion($prodiId)
    {
        $completed = $this->getEdProgress($prodiId);
        // dd($completed);
        if ($completed === 100) {
            return true;
        }

        return false;
    }

    public function getEdProgress($prodiId)
    {
        $query = $this->db->query("
        SELECT 
            IFNULL(SUM(CASE WHEN capaian IS NOT NULL AND capaian != '' THEN bobot ELSE 0 END), 0) AS completed_weight,
            IFNULL(SUM(bobot), 0) AS total_weight
        FROM kriteria_prodi
        JOIN kriteria ON kriteria.id = kriteria_prodi.id_kriteria
        JOIN kriteria_standar ON kriteria.id_kriteria_standar = kriteria_standar.id
        WHERE kriteria_prodi.id_prodi = ?
          AND kriteria_standar.is_aktif = 1
    ", [$prodiId]);

        $result = $query->getRow();

        if ($result) {
            if ($result->total_weight > 0) {
                return ($result->completed_weight / $result->total_weight) * 100;
            }
        }

        // Jika tidak ada data atau total weight adalah 0, maka persentase dianggap 0
        return 0;
    }
}
