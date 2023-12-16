<?php

namespace App\Controllers;

use App\Models\ModelSantri;
use App\Models\ModelGuru;
use App\Models\ModelUsers;
use App\Models\ModelJadwalPelajaran;
use App\Models\ModelTranskripNilai;
use App\Models\ModelInformasi;
use Myth\Auth\Password;
use Dompdf\Dompdf;
use Dompdf\Options;
use NumberToWords\NumberToWords;

class Santri extends BaseController
{
    protected $modelSantri, $db, $modelGuru, $modelUsers, $modelJadwalPelajaran, $modelTranskripNilai, $modelInformasi;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->modelSantri = new ModelSantri();
        $this->modelGuru = new ModelGuru();
        $this->modelUsers = new Modelusers();
        $this->modelJadwalPelajaran = new ModelJadwalPelajaran();
        $this->modelTranskripNilai = new ModelTranskripNilai();
        $this->modelInformasi = new ModelInformasi();
    }
    public function index()
    {
        $query = $this->modelTranskripNilai->select('tbl_transkrip_nilai.id, id_santri, nilai_tugas, nilai_uts, nilai_uas, nilai_rapot');

        $informasi = $this->modelInformasi->getInformasi()->findAll();

        for ($i = 1; $i <= 5; $i++) {
            $query->select("mp$i.nama_mp as namaMp$i")
                ->join("tbl_mp as mp$i", "mp$i.id = tbl_transkrip_nilai.id_mata_pelajaran_$i");
        }
        $result = $query->join('tbl_santri', 'tbl_santri.id =  tbl_transkrip_nilai.id_santri')
            ->where('user_id', user()->id)
            ->get()
            ->getLastRow();


        if ($result != null) {
            $tugas_array = explode(',', $result->nilai_tugas);
            $uts_array = explode(',', $result->nilai_uts);
            $uas_array = explode(',', $result->nilai_uas);
            $raport_array = explode(',', $result->nilai_rapot);

            for ($i = 0; $i < count($tugas_array); $i++) {
                $tugas[] = [$i + 1, (int)$tugas_array[$i]];
                $uts[] = [$i + 1, (int)$uts_array[$i]];
                $uas[] = [$i + 1, (int)$uas_array[$i]];
                $raport[] = [$i + 1, (int)$raport_array[$i]];
            }
        } else {
            $tugas = null;
            $uts = null;
            $uas = null;
            $raport = null;
        }

        $data = [
            'title' => 'Dashboard',
            'data' => $result,
            'tugas' => $tugas,
            'uts' => $uts,
            'uas' => $uas,
            'raport' => $raport,
            'informasi' => $informasi,
        ];

        return view('santri/index', $data);
    }

    public function profile()
    {
        $query = $this->modelSantri
            ->select('nis, name, nama_kelas, tanggal_lahir, tingkat, jenis_kelamin, awal_masuk, tbl_santri.status, image')
            ->join('users', 'users.id = tbl_santri.user_id')
            ->join('tbl_kelas', 'tbl_kelas.id = tbl_santri.id_kelas')
            ->join('tbl_jenis_kelamin', 'tbl_jenis_kelamin.id = tbl_santri.id_jk')
            ->where('user_id', user()->id)
            ->first();

        // dd($query);

        $data = [
            'title' => 'Profile',
            'users' => $query
        ];
        return view('santri/profile', $data);
    }

    public function detailProfile()
    {
        $query = $this->modelSantri
            ->select('tbl_santri.id, image, name, nis, jenis_kelamin, tanggal_lahir, nama_kelas, email, id_kelas, tingkat, kelas, alamat, awal_masuk, nama_kontak_darurat, telepon_kontak_darurat, riwayat_akademik, riwayat_kesehatan, password_hash, nama_ortu')
            ->join('users', 'users.id = tbl_santri.user_id')
            ->join('tbl_kelas', 'tbl_kelas.id = tbl_santri.id_kelas')
            ->join('tbl_jenis_kelamin', 'tbl_jenis_kelamin.id = tbl_santri.id_jk')
            ->where('user_id', user()->id)
            ->get()->getRow();

        $kelas = $this->db->table('tbl_kelas')->select('id as id_kelas, nama_kelas')->get()->getResultArray();

        $data = [
            'title' => 'Detail Profile',
            'santris' => $query,
            'kelas' => $kelas,
        ];
        return view('santri/detailProfile', $data);
    }

    public function updateDetailProfile($id)
    {
        $rules = [
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'email harus diisi.',
                ]
            ],
            'password_hash' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'password_hash harus diisi.',
                ]
            ],
            'name' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'Nama Lengkap harus diisi.'
                ]
                ],
            'tingkat' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'jenjang pendidikan harus dipilih.'
                ]
            ],
            'kelas' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'kelas harus dipilih.'
                ]
            ],
            'tanggal_lahir' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'tanggal lahir harus diisi.'
                ]
            ],
            'alamat' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'alamat harus dipilih.'
                ]
            ],
            'awal_masuk' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'tahun awal masuk harus diisi.'
                ]
            ],
            'nama_kontak_darurat' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'tahun awal masuk harus diisi.'
                ]
            ],
            'telepon_kontak_darurat' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'telepon kontak darurat harus diisi.'
                ]
            ],
            'jenis_kelamin' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'jenis kelamin harus diisi.'
                ]
            ],
            'riwayat_akademik' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'riwayat akademik harus diisi.'
                ]
            ],
            'riwayat_kesehatan' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'riwayat kesehatan harus diisi.'
                ]
            ],
            'image' => [
                'rules' => 'max_size[image,5000]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang dipilih bukan gambar',
                    'mime_in'  => 'Yang dipilih bukan gambar',
                ]
            ],
            'nama_ortu' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'nama orang tua harus diisi.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileImage = $this->request->getFile('image');
        $imageLama = $this->request->getVar('imagelama');
        if ($fileImage->getError() == 4) {
            $namaImage = $imageLama;
        } else {
            $namaImage = $fileImage->getRandomName();
            $fileImage->move('pas_photo', $namaImage);
            if ($imageLama !== 'default.jpg') {
                unlink('pas_photo/' . $imageLama);
            }
        }

        $data = [
            'id' => $id,
            'tingkat' => $this->request->getVar('tingkat'),
            'kelas' => $this->request->getVar('kelas'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'alamat' => $this->request->getVar('alamat'),
            'awal_masuk' => $this->request->getVar('awal_masuk'),
            'nama_kontak_darurat' => $this->request->getVar('nama_kontak_darurat'),
            'telepon_kontak_darurat' => $this->request->getVar('telepon_kontak_darurat'),
            'jenis_kelamin' => $this->request->getVar('jenis_kelamin'),
            'riwayat_akademik' => $this->request->getVar('riwayat_akademik'),
            'riwayat_kesehatan' => $this->request->getVar('riwayat_kesehatan'),
            'nama_ortu' => $this->request->getVar('nama_ortu'),
        ];

        $dataLama = $this->modelSantri->where('id', $id)->first();

        $idUsers = $this->modelUsers->select('id, email, name, password_hash, image')->where('id', $dataLama['user_id'])->get()->getRow();

        $password = $this->request->getVar('password_hash');
        $password_hash = Password::hash($password);

        $dataUsers = [
            'id'    => $idUsers->id,
            'email' => $this->request->getVar('email'),
            'name' => $this->request->getVar('name'),
            'password_hash' => $password_hash,
            'image' => $namaImage
        ];
        

        if (
            $idUsers->email === $dataUsers['email'] &&
            $idUsers->name === $dataUsers['name'] &&
            $idUsers->password_hash === $dataUsers['password_hash'] &&
            $idUsers->image === $dataUsers['image'] &&
            $dataLama['tingkat'] === $data['tingkat'] &&
            $dataLama['kelas'] === $data['kelas'] &&
            $dataLama['tanggal_lahir'] === $data['tanggal_lahir'] &&
            $dataLama['alamat'] === $data['alamat'] &&
            $dataLama['awal_masuk'] === $data['awal_masuk'] &&
            $dataLama['nama_kontak_darurat'] === $data['nama_kontak_darurat'] &&
            $dataLama['telepon_kontak_darurat'] === $data['telepon_kontak_darurat'] &&
            $dataLama['jenis_kelamin'] === $data['jenis_kelamin'] &&
            $dataLama['riwayat_akademik'] === $data['riwayat_akademik'] &&
            $dataLama['riwayat_kesehatan'] === $data['riwayat_kesehatan'] &&
            $dataLama['nama_ortu'] === $data['nama_ortu']
        ) {
            session()->setFlashdata('pesan', 'Tidak ada data yang diubah');
            return redirect()->to('santri/profile');
        }

        $this->modelSantri->save($data);
        $this->db->table('users')->where('id', $dataLama['user_id'])->update($dataUsers);
        session()->setFlashdata('pesan', 'data berhasil diubah');
        return redirect()->to('santri/profile');
    }

    public function jadwalPelajaran()
    {
        $namaKelas = $this->modelSantri->select('id_kelas, nama_kelas')
            ->join('users', 'users.id = tbl_santri.user_id')
            ->join('tbl_kelas', 'tbl_kelas.id = tbl_santri.id_kelas')
            ->where('user_id', user()->id)
            ->first();
        
            // dd($namaKelas);

        $tahunAjaran = $this->modelJadwalPelajaran->getJadwalPelajaran()->distinct()->groupBy(['tahun_ajaran', 'semester'])->orderBy('tahun_ajaran', 'DESC')->findAll();

        $selectedValue = $this->request->getVar('filter');

        if ($selectedValue) {
            list($tahun_ajaran, $semester) = explode('-', $selectedValue);
            $query = $this->modelJadwalPelajaran->where('tbl_kelas.nama_kelas', $namaKelas['nama_kelas'])->getDataByTahunSemester($tahun_ajaran, $semester);
        } else {
            $query = $this->modelJadwalPelajaran->getAjaranTahunSemester()->where('tbl_kelas.nama_kelas', $namaKelas['nama_kelas']);
        }

        $data = [
            'title'           => 'Jadwal Pelajaran',
            'data'            => $query->paginate('19', 'tbl_jadwal_pelajaran'),
            'tahunAjaran'     => $tahunAjaran,
            'pager'           => $this->modelJadwalPelajaran->pager,
        ];

        return view('santri/jadwalPelajaran', $data);
    }

    public function cetakJp()
    {
        $idKelas = $this->modelSantri->select('id_kelas')
            ->join('users', 'users.id = tbl_santri.user_id')
            ->join('tbl_kelas', 'tbl_kelas.id = tbl_santri.id_kelas')
            ->where('user_id', user()->id)
            ->first();

        $filter = $this->request->getVar('filter');

        if ($filter) {
            list($tahun_ajaran, $semester) = explode('-', $filter);
            $query = $this->modelJadwalPelajaran->getDataByTahunSemester($tahun_ajaran, $semester)->where('tbl_jadwal_pelajaran.id_kelas', $idKelas['id_kelas'])->findAll();
            $data = [
                'title' => 'Daftar Jadwal Pelajaran Santri',
                'data' => $query
            ];

            $pdf = new Dompdf();
            $view = view('admin/cetakJp', $data);
            $pdf->loadHtml($view);
            $pdf->render();
            $pdf->stream("jadwal_pelajaran" . $filter, ['Attachment' => false]);
        } else {
            session()->setFlashdata('error', 'Perhatikan Pilihan Data jangan sampai kosong');
            return redirect()->back();
        }
    }

    public function transkripNilai()
    {
        $idKelas = $this->modelSantri->select('tbl_santri.id')
            ->join('users', 'users.id = tbl_santri.user_id')
            ->where('user_id', user()->id)
            ->first();

        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $query = $this->modelTranskripNilai->search($keyword);
        } else {
            $query = $this->modelTranskripNilai->getTranskripNilai()->where('id_santri', $idKelas['id']);
        }

        $data = [
            'title'         => 'Transkrip Nilai',
            'data'          => $query->paginate('10', 'tbl_transkrip_nilai'),
            'pager'           => $this->modelTranskripNilai->pager,
        ];

        return view('santri/transkripNilai', $data);
    }

    public function cetakNilai($id)
    {
        $options = new Options();
        $options->set('isPhpEnabled', true);

        $pdf = new Dompdf($options);

        $query = $this->modelTranskripNilai->getTranskripNilai()->where('tbl_transkrip_nilai.id', $id)->find($id);

        $idSantri = $this->modelSantri->getAbsenSantri()->where('tbl_santri.id', $query['id_santri'])->find();

        $absen = $this->db->table('tbl_absen_santri')->select('santri_id, keterangan')
            ->where('santri_id', $query['id_santri'])
            ->get()->getResult();

        $jlhTdkHadir = 0;
        $jlhIzin = 0;
        $jlhSakit = 0;
        foreach ($absen as $a) {
            $ket = $a->keterangan;
            $attendanceValueTdk = ($ket === 'tanpa keterangan') ? 1 : 0;
            $attendanceValueSkt = ($ket === 'sakit') ? 1 : 0;
            $attendanceValueIzn = ($ket === 'izin') ? 1 : 0;
            $jlhTdkHadir += $attendanceValueTdk;
            $jlhIzin += $attendanceValueSkt;
            $jlhSakit += $attendanceValueIzn;
        }

        $ketTidakHadir = [
            'tnpKet' => $jlhTdkHadir,
            'iznKet' => $jlhIzin,
            'sktKet' => $jlhSakit
        ];

        $max = $this->modelTranskripNilai->selectMax('total_nilai', 'nilai_tertinggi')->get()->getRow();
        $min = $this->modelTranskripNilai->selectMin('total_nilai', 'nilai_terendah')->get()->getRow();

        if ($query['total_nilai'] == $max->nilai_tertinggi) {
            $ket = '1';
        } else {
            if ($query['total_nilai'] == $min->nilai_terendah) {
                $ket = '0';
            } else {
                $ket = '2';
            }
        }

        $nilaiString = $query['nilai'];
        $nilaiArray = explode(",", $nilaiString);
        $nilaiData = [];
        $tulisanData = [];
        $grade = [];
        for ($i = 1; $i <= 7; $i++) {
            if (isset($nilaiArray[$i - 1])) {
                $nilaiData['nilai_' . $i] = $nilaiArray[$i - 1];
                $tulisanData['tulisan_' . $i] = $this->numberToWords($nilaiData['nilai_' . $i]);
                $nilai = $nilaiData['nilai_' . $i];
                if ($nilai >= 90) {
                    $grade['grade_' . $i] = 'A';
                } elseif ($nilai >= 80 && $nilai < 90) {
                    $grade['grade_' . $i] = 'B';
                } elseif ($nilai >= 65 && $nilai < 90) {
                    $grade['grade_' . $i] = 'C';
                } elseif ($nilai >= 45 && $nilai < 65) {
                    $grade['grade_' . $i] = 'D';
                } else {
                    $grade['grade_' . $i] = 'E';
                }
            } else {
                $nilaiData[] = null;
                $tulisanData[] = null;
                $grade[] = null;
            }
        }

        $data = [
            'title'         => 'Tampilan Raport Semester Santri',
            'data'          => $query,
            'nilai'         => $nilaiData,
            'tulisan'       => $tulisanData,
            'grade'         => $grade,
            'peringkat'     => $ket,
            'ketTdkHadir'   => $ketTidakHadir,
        ];

        if ($idSantri != null) {
            $view = view('guru/cetakRaport', $data);
            $pdf->loadHtml($view);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();

            $pdf->stream("raportSantri.pdf", ['Attachment' => false]);
        } else {
            session()->setFlashdata('warning', 'Data absensi masih kosong');
            return redirect()->back();
        }
    }

    private function numberToWords($number)
    {
        $numberToWords = new NumberToWords();
        $transformer = $numberToWords->getNumberTransformer('id');

        $intPart = (int) $number;
        $fracPart = ($number - $intPart) * 10;
        $intWords = $transformer->toWords($intPart);
        $fracWords = $transformer->toWords($fracPart);

        return ucfirst($intWords) . " koma " . $fracWords;
    }

    public function downloadInformasi($id)
    {
        $data = $this->modelInformasi->find($id);

        return $this->response->download('arsip_informasi/' . $data->berkas, null);
    }
}
