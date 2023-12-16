<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelInformasi extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'tbl_arsip';
    protected $primaryKey           = 'id_berkas';
    protected $returnType           = 'object';
    protected $useTimestamps        = true;
    protected $allowedFields        = ['id_berkas', 'berkas', 'keterangan'];

    public function getInformasi()
    {
        $query = $this->table('tbl_arsip')->select('id_berkas, berkas, keterangan, created_at, updated_at');

        return $query;
    }

    public function getInformasiKeyword($keyword)
    {
        $query = $this->table('tbl_arsip')->select('id_berkas, berkas, keterangan, created_at, updated_at')
            ->like('keterangan', $keyword);

        return $query;
    }
}
