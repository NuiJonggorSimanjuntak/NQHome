<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelKelas extends Model
{
    protected $table            = 'tbl_kelas';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_kelas', 'id_guru', 'kapasitas', 'id_jk'];

    public function getKelas() {
        return $this->table('tbl_kelas')->select('tbl_kelas.id, tbl_kelas.id_jk, nama_kelas, users.name, kapasitas, tbl_jenis_kelamin.jenis_kelamin as gender')
        ->join('tbl_guru', 'tbl_guru.id = tbl_kelas.id_guru')
        ->join('users', 'users.id = tbl_guru.user_id')
        ->join('tbl_jenis_kelamin', 'tbl_jenis_kelamin.id = tbl_kelas.id_jk')
        ->orderBy('id_jk', 'ASC')
        ->orderBy('nama_kelas', 'ASC');
    }
}
