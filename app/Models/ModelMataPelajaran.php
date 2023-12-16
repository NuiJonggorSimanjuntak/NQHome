<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelMataPelajaran extends Model
{
    protected $table = 'tbl_mp';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id, kode_mp', 'nama_mp'];

    public function search($keyword)
    {
        return $this->table('tbl_mp')->like('nama_mp', $keyword)->orLike('kode_mp', $keyword);
    }
}
