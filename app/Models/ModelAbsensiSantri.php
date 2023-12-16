<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAbsensiSantri extends Model
{
    protected $table = 'tbl_qrcode_santri';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tanggal', 'jam_masuk', 'jam_keluar', 'qr_code'];

    public function getQR() {
        return $this->table('tbl_qrcode_santri')->select('id, tanggal, jam_masuk, jam_keluar, qr_code');
    }

    public function getQRTanggal($tanggalSantri)
    {
        $query = $this->table('tbl_qrcode_santri')->select('id, tanggal, jam_masuk, jam_keluar, qr_code')
            ->like('tanggal', $tanggalSantri);
        return $query;
    }
}
