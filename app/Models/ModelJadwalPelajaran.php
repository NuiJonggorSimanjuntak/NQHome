<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJadwalPelajaran extends Model
{
    protected $table = 'tbl_jadwal_pelajaran';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_guru', 'tahun_ajaran', 'semester', 'jam', 'kegiatan', 'id_kelas'];

    public function getJadwalPelajaran()
    {
        $query = $this->table('tbl_jadwal_pelajaran')
            ->select('tbl_jadwal_pelajaran.id, tahun_ajaran, semester, name, jam, tbl_jadwal_pelajaran.id_guru, kegiatan, nama_kelas, jenis_kelamin, id_kelas')
            ->join('tbl_guru', 'tbl_guru.id = tbl_jadwal_pelajaran.id_guru')
            ->join('users', 'users.id = tbl_guru.user_id')
            ->join('tbl_kelas', 'tbl_kelas.id = tbl_jadwal_pelajaran.id_kelas')
            ->join('tbl_jenis_kelamin', 'tbl_jenis_kelamin.id = tbl_kelas.id_jk')
            ->orderBy('id_kelas', 'ASC')
            ->orderBy('jam', 'ASC');

        return $query;
    }

    public function getDataByTahunSemester($tahun_ajaran, $semester)
    {
        return $this->getJadwalPelajaran()
            ->where('tahun_ajaran', $tahun_ajaran)
            ->where('semester', $semester);
    }

    public function getAjaranTahunSemester()
    {
        $queryTerakhir = $this->getJadwalPelajaran()
            ->orderBy('tahun_ajaran', 'DESC')
            ->orderBy('semester', 'DESC')   
            ->first();

        if (!empty($queryTerakhir)) {
            $tahunAjaranTerakhir = $queryTerakhir['tahun_ajaran'];
            $semesterTerakhir = $queryTerakhir['semester'];
        } else {
            $tahunAjaranTerakhir = '';
            $semesterTerakhir = '';
        }

        $query = $this->getJadwalPelajaran()
            ->where('tahun_ajaran', $tahunAjaranTerakhir)
            ->where('semester', $semesterTerakhir);

        return $query;
    }

    public function getKeyword($keyword)
    {
        $query = $this->getJadwalPelajaran()
        ->like('name', $keyword)
        ->orlike('nama_kelas', $keyword);

        return $query;
    }
}
