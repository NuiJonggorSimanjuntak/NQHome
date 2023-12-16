<?php 

namespace App\Models;

use CodeIgniter\Model;

class ModelGuru extends Model
{
    protected $table = 'tbl_guru';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'nik', 'id_jk', 'tanggal_lahir', 'alamat', 'no_telepon', 
        'pendidikan_terakhir', 'pengalaman_mengajar',
        'tentang_pengajar', 'status_perkawinan', 'nip', 'id_mp'
    ];

    public function getGuru() {
        $query = $this->table('tbl_guru')->select('tbl_guru.id, users.id as userid, nik, users.name, image, alamat, nip, nama_mp')
            ->join('users', 'users.id = tbl_guru.user_id')
            ->join('tbl_mp', 'tbl_mp.id = tbl_guru.id_mp');

        return $query;
    }

    public function getGuruKeyword($keyword) {
        $query = $this->table('tbl_guru')->select('tbl_guru.id, users.id as userid, nik, users.name, image, alamat, nip, nama_mp')
            ->join('users', 'users.id = tbl_guru.user_id')
            ->join('tbl_mp', 'tbl_mp.id = tbl_guru.id_mp')
            ->like('users.name', $keyword)
            ->orlike('nama_mp', $keyword)
            ->orlike('nip', $keyword)
            ->orlike('nama_mp', $keyword)
            ->orlike('nik', $keyword);  

        return $query;
    }
}
