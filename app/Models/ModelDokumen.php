<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDokumen extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'tbl_dokumen';
    protected $primaryKey           = 'id';
    protected $returnType           = 'object';
    protected $useTimestamps        = true;
    protected $allowedFields        = ['nama_dokumen', 'keterangan'];

    public function getDokumen()
    {
        $query = $this->table('tbl_dokumen')->select('id, nama_dokumen, keterangan, created_at, updated_at');

        return $query;
    }

    public function getDokumenKeyword($keyword)
    {
        $query = $this->table('tbl_dokumen')->select('id, nama_dokumen, keterangan, created_at, updated_at')
            ->like('keterangan', $keyword)
            ->orLike('nama_dokumen', $keyword);

        return $query;
    }
}
