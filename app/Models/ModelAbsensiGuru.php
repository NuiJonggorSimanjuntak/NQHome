<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAbsensiGuru extends Model
{
    protected $table = 'tbl_qrcode_guru';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'jam_masuk', 'jam_keluar', 'qr_code'];

    public function getQR()
    {
        return $this->table('tbl_qrcode_guru')->select('id, tanggal, jam_masuk, jam_keluar, qr_code');
    }

    public function getQRTanggal($tanggalGuru)
    {
        $query = $this->table('tbl_qrcode_guru')->select('id, tanggal, jam_masuk, jam_keluar, qr_code')
            ->like('tanggal', $tanggalGuru);
        return $query;
    }
}
