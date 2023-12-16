<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSantri extends Model
{
    protected $table = 'tbl_santri';
    protected $primaryKey = 'id';
    protected $allowedFields  = [
        'user_id', 'nis', 'id_kelas', 'tingkat', 'kelas', 'awal_masuk', 'tanggal_lahir', 'id_jk', 'password_hash',
        'riwayat_akademik', 'riwayat_kesehatan', 'nama_kontak_darurat', 'telepon_kontak_darurat', 'status', 'alamat', 'nama_ortu'
    ];

    public function getSantri()
    {
        $query = $this->table('tbl_santri')->select('tbl_santri.id, users.id as userid, nis, users.name, users.image, kelas, id_kelas, tingkat, alamat, nama_kelas, jenis_kelamin')
            ->join('users', 'users.id = tbl_santri.user_id')
            ->join('tbl_kelas', 'tbl_kelas.id = tbl_santri.id_kelas')
            ->join('tbl_jenis_kelamin', 'tbl_jenis_kelamin.id = tbl_santri.id_jk')
            ->orderBy('jenis_kelamin', 'asc')
            // ->orderBy('users.name', 'ASC')
            ->orderBy('nama_kelas', 'asc');

        return $query;
    }

    public function getSantriKeyword($keyword)
    {
        $query = $this->table('tbl_santri')->select('tbl_santri.id, users.id as userid, nis, users.name, users.image, kelas, id_kelas, tingkat, alamat, nama_kelas, jenis_kelamin')
            ->join('users', 'users.id = tbl_santri.user_id')
            ->join('tbl_kelas', 'tbl_kelas.id = tbl_santri.id_kelas')
            ->join('tbl_jenis_kelamin', 'tbl_jenis_kelamin.id = tbl_santri.id_jk')
            ->orderBy('nis', 'ASC')
            ->like('tingkat', $keyword)
            ->orlike('users.name', $keyword)
            ->orlike('nis', $keyword);

        return $query;
    }

    public function keyword($keyword)
    {
        return $this->table('tbl_santri')
            ->select('tbl_santri.id, name, nis, tanggal, tbl_absen_santri.jam_masuk, tbl_absen_santri.jam_keluar, keterangan, kelas, id_kelas, alamat, tbl_absen_santri.id as id_absen, nama_kelas, jenis_kelamin')
            ->join('tbl_absen_santri', 'tbl_absen_santri.santri_id = tbl_santri.id')
            ->join('tbl_qrcode_santri', 'tbl_qrcode_santri.id = tbl_absen_santri.qr_id')
            ->join('users', 'users.id = tbl_santri.user_id')
            ->join('tbl_kelas', 'tbl_kelas.id = tbl_santri.id_kelas')
            ->join('tbl_jenis_kelamin', 'tbl_jenis_kelamin.id = tbl_santri.id_jk')
            ->distinct('name')
            ->orderBy('CAST(kelas AS SIGNED)', 'asc')
            ->like('tanggal', $keyword);
    }

    public function getAbsenSantri()
    {
        return $this->table('tbl_santri')
            ->select('tbl_santri.id, name, nis, tanggal, tbl_absen_santri.jam_masuk, tbl_absen_santri.jam_keluar, keterangan, kelas, id_kelas, alamat, tbl_absen_santri.id as id_absen, nama_kelas, jenis_kelamin')
            ->join('tbl_absen_santri', 'tbl_absen_santri.santri_id = tbl_santri.id')
            ->join('tbl_qrcode_santri', 'tbl_qrcode_santri.id = tbl_absen_santri.qr_id')
            ->join('users', 'users.id = tbl_santri.user_id')
            ->join('tbl_kelas', 'tbl_kelas.id = tbl_santri.id_kelas')
            ->join('tbl_jenis_kelamin', 'tbl_jenis_kelamin.id = tbl_santri.id_jk')
            ->distinct('name')
            ->orderBy('CAST(kelas AS SIGNED)', 'asc');
    }
}
