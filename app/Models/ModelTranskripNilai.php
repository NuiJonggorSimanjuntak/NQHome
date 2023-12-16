<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTranskripNilai extends Model
{
    protected $table = 'tbl_transkrip_nilai';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'id_santri',
        'id_guru',
        'id_jadwal_pelajaran',
        'nilai_tugas',
        'nilai_uts',
        'nilai_uas',
        'nilai_rapot',
        'tulisan',
        'grade',
        'rata_rata_nilai',
        'total_nilai',
        'kelakuan',
        'kerajianan',
        'kerapian',
    ];

    public function __construct()
    {
        parent::__construct();

        for ($i = 1; $i <= 5; $i++) {
            $this->allowedFields[] = "id_mata_pelajaran_{$i}";
        }
    }

    public function getTranskripNilai()
    {
        $query = $this->table('tbl_transkrip_nilai')->select('user_guru.name as nama_guru, tbl_transkrip_nilai.id_guru, nip, tbl_transkrip_nilai.id, nis, user_santri.name as nama_santri, tahun_ajaran, semester, nilai_tugas as nilai, nilai_uts as uts, nilai_uas as uas, tulisan, grade, id_jadwal_pelajaran, rata_rata_nilai, total_nilai, kelas, id_santri, kelakuan, kerajianan, kerapian, tbl_santri.id_kelas, tingkat, nilai_rapot');

        for ($i = 1; $i <=  5; $i++) {
            $query->select("id_mata_pelajaran_$i as id_mp$i, mp$i.kode_mp as kodeMp$i, mp$i.nama_mp as namaMp$i")
                ->join("tbl_mp as mp$i", "mp$i.id = tbl_transkrip_nilai.id_mata_pelajaran_$i");
        }

        $query->join('tbl_santri', 'tbl_santri.id = tbl_transkrip_nilai.id_santri')
            ->join('tbl_guru', 'tbl_guru.id = tbl_transkrip_nilai.id_guru')
            ->join('tbl_kelas', 'tbl_kelas.id = tbl_santri.id_kelas')
            ->join('users as user_santri', 'user_santri.id = tbl_santri.user_id')
            ->join('users as user_guru', 'user_guru.id = tbl_guru.user_id')
            ->join('tbl_jadwal_pelajaran', 'tbl_jadwal_pelajaran.id = tbl_transkrip_nilai.id_jadwal_pelajaran')
            ->orderBy('rata_rata_nilai', 'DESC');
        return $query;
    }

    public function search($keyword)
    {
        return $this->getTranskripNilai()->like('nis', $keyword)->orLike('user_santri.name', $keyword)->orLike('tahun_ajaran', $keyword)->orLike('semester', $keyword);
    }
}
