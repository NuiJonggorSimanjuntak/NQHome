<?php

namespace App\Controllers;

use DateTime;
use DateTimeZone;
use Twilio\Rest\Client;
use NumberToWords\NumberToWords;

use App\Models\ModelTranskripNilai;
use App\Models\ModelSantri;
use App\Models\ModelJadwalPelajaran;
use App\Models\ModelMataPelajaran;
use App\Models\ModelGuru;
use App\Models\ModelUsers;
use Dompdf\Dompdf;
use Dompdf\Options;
use Myth\Auth\Password;
use NumberToWords\Legacy\Numbers\Words\Locale\Id;

class Guru extends BaseController
{

    protected $db, $session, $modelTranskripNilai, $modelSantri, $modelJadwalPelajaran, $modelMataPelajaran, $modelGuru, $modelUsers;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = service('session');

        $this->modelTranskripNilai = new ModelTranskripNilai();
        $this->modelSantri = new ModelSantri();
        $this->modelJadwalPelajaran = new ModelJadwalPelajaran();
        $this->modelMataPelajaran = new ModelMataPelajaran();
        $this->modelGuru = new ModelGuru();
        $this->modelUsers = new Modelusers();
    }

    public function index()
    {

        $kelas = $this->db->table('tbl_kelas')->select('tbl_kelas.id, nama_kelas, jenis_kelamin')
            ->join('tbl_jenis_kelamin', 'tbl_jenis_kelamin.id = tbl_kelas.id_jk')
            ->get()->getResult();

        $id_guru = $this->modelGuru->select('id')->where('user_id', user()->id)->first();


        if (user()->id == 1) {
            $jadwal = $this->modelJadwalPelajaran
                ->getJadwalPelajaran()->findAll();
        } else {
            $jadwal = $this->modelJadwalPelajaran
                ->getJadwalPelajaran()
                ->where('tbl_jadwal_pelajaran.id_guru', $id_guru['id'])
                ->findAll();
        }

        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $query = $this->modelSantri->keyword($keyword);
        } else {
            $query = $this->modelSantri->getAbsenSantri()
                ->orderBy('tanggal', 'asc')
                ->orderBy('nama_kelas', 'asc');
        }
        foreach ($jadwal as $j) {
            $query->orWhere('nama_kelas', $j['nama_kelas']);
        }

        $result = $query->findAll();

        $santri = $this->modelSantri->getSantri()
            ->join('tbl_absen_santri', 'tbl_absen_santri.santri_id = tbl_santri.id', 'left')
            ->distinct();
        foreach ($jadwal as $j) {
            $santri->orWhere('nama_kelas', $j['nama_kelas']);
        }

        $data = [
            'title'  => 'Dashboard',
            'data'   => $result,
            'santri' => $santri->findAll(),
            'kelas'  => $kelas
        ];

        return view('guru/index', $data);
    }

    public function wa($id)
    {
        $data = $this->modelSantri->select('telepon_kontak_darurat, name')
            ->join('users', 'users.id = tbl_santri.user_id')
            ->where('tbl_santri.id', $id)->get()->getRow();

        $tanggalObject = $this->db->table('tbl_absen_santri')
            ->select('tanggal')
            ->join('tbl_qrcode_santri', 'tbl_qrcode_santri.id = tbl_absen_santri.qr_id')
            ->where('santri_id', $id)
            ->get()
            ->getRow();

        $tanggal = $tanggalObject->tanggal;
        $tanggalAsString = (string) $tanggal;

        if (empty($data->telepon_kontak_darurat)) {
            $this->session->setFlashdata('error', 'Data Tidak ditemukan!');
            return redirect()->back();
        }

        $sid    = "AC575f10d0f24ebc9055a2c99c1a76beba";
        $token  = "fe0400399d30b661d96939bc9c4426bd";

        $twilio = new Client($sid, $token);

        $phoneNumber = $data->telepon_kontak_darurat;

        $jamZona = new DateTimeZone('Asia/Jakarta');
        $WaktuSaatIni = new DateTime('now', $jamZona);
        $jamSaatIni = $WaktuSaatIni->format('H:i');

        $jam = '';
        if ($jamSaatIni >= '00:00' && $jamSaatIni < '12:00') {
            $jam = 'Selamat Pagi';
        } elseif ($jamSaatIni >= '12:00' && $jamSaatIni < '15:00') {
            $jam = 'Selamat Siang';
        } elseif ($jamSaatIni >= '15:00' && $jamSaatIni < '18:00') {
            $jam = 'Selamat Sore';
        } else {
            $jam = 'Selamat Malam';
        }

        try {
            $twilio->messages->create(
                "whatsapp:$phoneNumber",
                [
                    'from' => 'whatsapp:+14155238886',
                    'body' => $jam . ' Pak/Ibu. Saya Guru dari yayasan NQHome ingin memberitahukan ketidakhadiran anak Bapak/Ibu pada tanggal ' . $tanggalAsString . ', silakan hubungi kami balik '
                ]
            );

            $this->session->setFlashdata('success', 'Pesan berhasil terkirim!');
        } catch (\Twilio\Exceptions\RestException $e) {
            $this->session->setFlashdata('error', 'Terjadi kesalahan dalam mengirim pesan: ' . $e->getMessage());
        }

        return redirect()->to('guru');
    }

    public function nilaiSantri()
    {
        $keyword = $this->request->getVar('keyword');

        $user_login = $this->db
            ->table('auth_groups_users')
            ->select('auth_groups.name')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
            ->where('user_id', user()->id)
            ->get()
            ->getRow();

        if ($keyword) {
            $query = $this->modelTranskripNilai->search($keyword);
            if ($user_login->name !== 'admin') {
                $query->where('user_guru.id', user()->id);
            }
        } else {
            $query = $this->modelTranskripNilai->getTranskripNilai();
            if ($user_login->name !== 'admin') {
                $query->where('user_guru.id', user()->id);
            }
        }

        $santri = $this->modelSantri->select('tbl_santri.id, name, nis')
            ->join('users', 'users.id = tbl_santri.user_id')
            ->findAll();

        $tahunAjaran = $this->modelJadwalPelajaran->getJadwalPelajaran()->distinct()->groupBy(['tahun_ajaran', 'semester'])->orderBy('tahun_ajaran', 'DESC')->findAll();

        $mataPelajaran = $this->modelMataPelajaran->select('id, kode_mp, nama_mp')
            ->findAll();

        $guru = $this->modelGuru->select('tbl_guru.id, name, nip')
            ->join('users', 'users.id = tbl_guru.user_id')
            ->findAll();

        $data = [
            'title'         => 'Data Transkrip Nilai Santri',
            'data'          => $query->paginate('10', 'tbl_transkrip_nilai'),
            'pager'           => $this->modelTranskripNilai->pager,
            'santri'        => $santri,
            'guru'        => $guru,
            'tahunAjaran'   => $tahunAjaran,
            'mataPelajaran' => $mataPelajaran,
        ];
        // dd($data);

        return view('guru/transkrip_nilai', $data);
    }

    public function simpanNilaiSantri()
    {
        $id_santri = $this->request->getVar('id_santri');
        $id_jadwal_pelajaran = $this->request->getVar('id_jadwal_pelajaran');
        $id_mata_pelajaran = [];
        for ($i = 1; $i <= 7; $i++) {
            $id_mata_pelajaran["id_mata_pelajaran_{$i}"]  = $this->request->getVar("id_mata_pelajaran_{$i}");
        }

        $dataLama = $this->modelTranskripNilai->select('id_santri, id_jadwal_pelajaran')->where('id_santri', $id_santri)->first();

        if (!empty($dataLama['id_santri'])) {
            if ($id_jadwal_pelajaran == $dataLama['id_jadwal_pelajaran'] && $id_santri == $dataLama['id_santri']) {
                $id_santriRule = 'required|is_unique[tbl_transkrip_nilai.id_santri]';
                $id_jadwal_pelajaranRule = 'required|is_unique[tbl_transkrip_nilai.id_jadwal_pelajaran]';
            } else {
                $id_santriRule = 'required';
                $id_jadwal_pelajaranRule = 'required';
            }
        } else {
            $id_santriRule = 'required';
            $id_jadwal_pelajaranRule = 'required';
        }

        $rules = [
            'id_santri' => [
                'rules' => $id_santriRule,
                'errors' => [
                    'required' => 'santri harus dipilih.',
                    'is_unique' => 'tidak boleh sama',
                ]
            ],
            'id_jadwal_pelajaran' => [
                'rules' => $id_jadwal_pelajaranRule,
                'errors' => [
                    'required' => 'tahun ajaran harus dipilih.',
                    'is_unique' => 'tidak boleh sama',
                ]
            ],
            'id_guru' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'guru harus dipilih.',
                ]
            ],
        ];


        for ($i = 1; $i <= 5; $i++) {
            $rules["id_mata_pelajaran_{$i}"] = [
                'rules'  => 'required',
                'errors' => [
                    'required' => "mata pelajaran {$i} harus dipilih",
                ],
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $mataPelajaranData = [];
        for ($i = 1; $i <= 5; $i++) {
            $idMataPelajaran = $this->request->getVar("id_mata_pelajaran_{$i}");
            if ($idMataPelajaran) {
                $mataPelajaranData["id_mata_pelajaran_{$i}"] = $idMataPelajaran;
            }
        }
        $data = [
            'id_santri' => $this->request->getVar('id_santri'),
            'id_guru' => $this->request->getVar('id_guru'),
            'id_jadwal_pelajaran' => $this->request->getVar('id_jadwal_pelajaran'),
        ];

        $data = array_merge($data, $mataPelajaranData);
        // dd($data);

        $this->modelTranskripNilai->save($data);

        session()->setFlashdata('pesan', 'input nilai berhasil');
        return redirect()->to('guru/transkrip_nilai');
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

    public function hapusTranskripNilai($id)
    {
        $this->modelTranskripNilai->where('id', $id)->delete();
        session()->setFlashdata('pesan', 'Data transkrip berhasil dihapus');
        return redirect()->to('guru/transkrip_nilai');
    }

    public function editTranskripNilai($id)
    {
        $query = $this->modelTranskripNilai->getTranskripNilai()->find($id);

        $santri = $this->modelSantri->select('tbl_santri.id, name, nis')
            ->join('users', 'users.id = tbl_santri.user_id')
            ->findAll();

        $tahunAjaran = $this->modelJadwalPelajaran->getJadwalPelajaran()->distinct()->groupBy(['tahun_ajaran', 'semester'])->orderBy('tahun_ajaran', 'DESC')->findAll();

        $mataPelajaran = $this->modelMataPelajaran->select('id, kode_mp, nama_mp')
            ->findAll();

        $guru = $this->modelGuru->select('tbl_guru.id, name, nip')
            ->join('users', 'users.id = tbl_guru.user_id')
            ->findAll();

        $ujian = $this->modelMataPelajaran
            ->where('nama_mp', 'Ujian Lisan')
            ->orWhere('nama_mp', 'Ujian Praktek')
            ->findAll();

        $data = [
            'title' => 'Edit Form Transkrip Nilai',
            'data'  => $query,
            'santri' => $santri,
            'guru'  => $guru,
            'tahunAjaran' => $tahunAjaran,
            'mataPelajaran' => $mataPelajaran,
            'ujian' => $ujian,
            'jumlahMp' => count($mataPelajaran)
        ];

        return view('guru/editTranskripNilai', $data);
    }

    public function updateTranskripNilai($id)
    {
        $rules = [
            'id_santri' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'Santri harus dipilih.'
                ]
            ],
            'id_guru' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'Guru harus dipilih.'
                ]
            ],
            'id_jadwal_pelajaran' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'Tahun Ajaran harus dipilih.'
                ]
            ],
        ];

        for ($i = 1; $i <= 5; $i++) {
            $rules["id_mata_pelajaran_{$i}"] = [
                'rules'  => 'required',
                'errors' => [
                    'required' => "Mata pelajaran {$i} harus dipilih",
                ],
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $mataPelajaranData = [];
        for ($i = 1; $i <= 5; $i++) {
            $idMataPelajaran = $this->request->getVar("id_mata_pelajaran_{$i}");
            if ($idMataPelajaran) {
                $mataPelajaranData["id_mata_pelajaran_{$i}"] = $idMataPelajaran;
            }
        }

        $data = [
            'id'                    => $id,
            'id_guru'               => $this->request->getVar('id_guru'),
            'id_jadwal_pelajaran'   => $this->request->getVar('id_jadwal_pelajaran'),
        ];

        $data = array_merge($data, $mataPelajaranData);

        $dataLama = $this->modelTranskripNilai->find($id);
        $isDataChanged = false;

        // if (
        //     $dataLama['id_jadwal_pelajaran'] === $data['id_jadwal_pelajaran']
        // ) {
        //     for ($i = 1; $i <= 5; $i++) {
        //         if ($dataLama["id_mata_pelajaran_{$i}"] !== $data["id_mata_pelajaran_{$i}"]) {
        //             $isDataChanged = true;
        //             break;
        //         }
        //     }
        //     session()->setFlashdata('pesan', 'Tidak ada data yang diubah');
        //     return redirect()->to('guru/transkrip_nilai');
        // }

        $this->modelTranskripNilai->save($data);
        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('guru/transkrip_nilai');
    }

    public function isiNilai($id)
    {
        $query = $this->modelTranskripNilai->getTranskripNilai()->where('tbl_transkrip_nilai.id', $id)
            ->findAll();

        $field = $this->modelTranskripNilai->getTranskripNilai()->find($id);
        // dd($field);

        $jumlahMp = count($this->modelMataPelajaran->findAll());

        $nilaiString = $field['nilai'];
        $utsString = $field['uts'];
        $uasString = $field['uas'];

        $nilaiArray = explode(",", $nilaiString);
        $utsArray = explode(",", $utsString);
        $uasArray = explode(",", $uasString);

        $nilaiData = [];
        for ($i = 1; $i <= $jumlahMp; $i++) {
            if (isset($nilaiArray[$i - 1])) {
                $nilaiData['nilai_' . $i] = $nilaiArray[$i - 1];
                $nilaiData['uts_' . $i] = $utsArray[$i - 1];
                $nilaiData['uas_' . $i] = $uasArray[$i - 1];
            } else {
                $nilaiData['nilai_' . $i] = null;
                $nilaiData['uts_' . $i] = null;
                $nilaiData['uas_' . $i] = null;
            }
        }

        $data = [
            'data'  => $query,
            'field' => $field,
            'jumlahMp' => $jumlahMp,
        ];
        for ($i = 1; $i <= $jumlahMp; $i++) {
            $keyNilai = "nilai_" . $i;
            $keyUts = "uts_" . $i;
            $keyUas = "uas_" . $i;
            $data[$keyNilai] = $nilaiData[$keyNilai];
            $data[$keyUts] = $nilaiData[$keyUts];
            $data[$keyUas] = $nilaiData[$keyUas];
        }
        return view('guru/isiNilai', $data);
    }

    public function simpanNilai($id)
    {
        for ($i = 1; $i <= 5; $i++) {
            $rules["nilai_{$i}"] = [
                'rules'  => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
                'errors' => [
                    'required' => "nilai {$i} harus diisi",
                    'numeric' => "nilai {$i} harus berupa angka",
                    'greater_than_equal_to' => "nilai {$i} tidak boleh kurang dari 0",
                    'less_than_equal_to' => "nilai {$i} tidak boleh lebih dari 100",
                ],
            ];
            $rules["uts_{$i}"] = [
                'rules'  => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
                'errors' => [
                    'required' => "nilai {$i} harus diisi",
                    'numeric' => "nilai {$i} harus berupa angka",
                    'greater_than_equal_to' => "nilai {$i} tidak boleh kurang dari 0",
                    'less_than_equal_to' => "nilai {$i} tidak boleh lebih dari 100",
                ],
            ];
            $rules["uas_{$i}"] = [
                'rules'  => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
                'errors' => [
                    'required' => "nilai {$i} harus diisi",
                    'numeric' => "nilai {$i} harus berupa angka",
                    'greater_than_equal_to' => "nilai {$i} tidak boleh kurang dari 0",
                    'less_than_equal_to' => "nilai {$i} tidak boleh lebih dari 100",
                ],
            ];
        }

        $rules = [
            'kelakuan' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'Kelakuan harus dipilih.'
                ]
            ],
            'kerajianan' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'Kerajinan harus dipilih.'
                ]
            ],
            'kerapian' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'Kerapian harus dipilih.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nilaiTugas = [];
        $nilaiUts = [];
        $nilaiUas = [];
        for ($i = 1; $i <= 5; $i++) {
            $nNilai = $this->request->getVar("nilai_{$i}");
            $nUts = $this->request->getVar("uts_{$i}");
            $nUas = $this->request->getVar("uas_{$i}");
            if ($nNilai) {
                $nilaiTugas[] = $nNilai;
                $nilaiUts[] = $nUts;
                $nilaiUas[] = $nUas;
            }
        }

        $tugas = implode(",", $nilaiTugas);
        $uts = implode(",", $nilaiUts);
        $uas = implode(",", $nilaiUas);

        $persenTugas = 70 / 100;
        $persenUts = 10 / 100;
        $persenUas = 20 / 100;
        $nilaiPersenTugas = [];
        $nilaiPersenUts = [];
        $nilaiPersenUas = [];

        foreach ($nilaiTugas as $nilai) {
            $nilaiPersenTugas[] = $nilai * $persenTugas;
        }
        foreach ($nilaiUts as $nilai) {
            $nilaiPersenUts[] = $nilai * $persenUts;
        }
        foreach ($nilaiUas as $nilai) {
            $nilaiPersenUas[] = $nilai * $persenUas;
        }

        $totalAkhir = [];

        for ($i = 0; $i < count($nilaiPersenTugas); $i++) {
            $totalAkhir[] = $nilaiPersenTugas[$i] + $nilaiPersenUts[$i] + $nilaiPersenUas[$i];
        }

        $totalAkhirString = implode(",", $totalAkhir);

        $nilaiTotalAkhir = array_merge($totalAkhir);
        $totalNilai = array_sum($nilaiTotalAkhir);
        $rataRataNilai = $totalNilai / count($nilaiTotalAkhir);

        if ($rataRataNilai >= 90) {
            $grade = 'A';
        } elseif ($rataRataNilai >= 80 && $rataRataNilai < 90) {
            $grade = 'B';
        } elseif ($rataRataNilai >= 65 && $rataRataNilai < 80) {
            $grade = 'C';
        } elseif ($rataRataNilai >= 45 && $rataRataNilai < 65) {
            $grade = 'D';
        } else {
            $grade = 'E';
        }


        $data = [
            'id'              => $id,
            'nilai_tugas'     => $tugas,
            'nilai_uts'       => $uts,
            'nilai_uas'       => $uas,
            'grade'           => $grade,
            'total_nilai'     => $totalNilai,
            'rata_rata_nilai' => $rataRataNilai,
            'nilai_rapot'     => $totalAkhirString,
            'tulisan'         => $this->numberToWords($rataRataNilai),
            'kelakuan'        => $this->request->getVar('kelakuan'),
            'kerajianan'      => $this->request->getVar('kerajianan'),
            'kerapian'        => $this->request->getVar('kerapian')

        ];

        $this->modelTranskripNilai->save($data);
        session()->setFlashdata('pesan', 'berhasil memberi nilai santri');
        return redirect()->to('guru/transkrip_nilai');
    }

    public function raport($id)
    {
        $query = $this->modelTranskripNilai->getTranskripNilai()->where('tbl_transkrip_nilai.id', $id)->find($id);

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

        $jumlahMp = count($this->modelMataPelajaran->findAll());

        if ($query['nilai'] != null) {
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

            $nilaiString = $query['nilai_rapot'];
            $nilaiArray = explode(",", $nilaiString);
            $nilaiData = [];
            $tulisanData = [];
            $grade = [];
            for ($i = 1; $i <= $jumlahMp; $i++) {
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
                'jumlahMp'      => $jumlahMp
            ];
        } else {
            session()->setFlashdata('warning', 'Guru Belum Memberi Nilai');
            return redirect()->to('guru/transkrip_nilai');
        }

        return view('guru/raport', $data);
    }

    public function cetakRaport($id)
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
        $jumlahMp = count($this->modelMataPelajaran->findAll());
        for ($i = 1; $i <= $jumlahMp; $i++) {
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
            'jumlahMp'   => $jumlahMp,
        ];

        // if ($idSantri != null) {
        //     $view = view('guru/cetakRaport', $data);
        //     $pdf->loadHtml($view);
        //     $pdf->setPaper('A4', 'portrait');
        //     $pdf->render();
        //     $pdf->stream("raportSantri.pdf", ['Attachment' => false]);
        // } else {
        //     session()->setFlashdata('warning', 'Data absensi masih kosong');
        //     return redirect()->to('guru/transkrip_nilai');
        // }

        $view = view('guru/cetakRaport', $data);
        $pdf->loadHtml($view);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdf->stream("raportSantri.pdf", ['Attachment' => false]);
    }

    public function ketAbsen($id)
    {
        $queri = $this->modelSantri->getSantri()
            ->join('tbl_absen_santri', 'tbl_absen_santri.santri_id = tbl_santri.id', 'left')
            ->find($id);

        $tanggal = $this->db->table('tbl_qrcode_santri')->select('id as qr_id, tanggal')->get()->getResult();

        $data = [
            'title' => 'Form Tambah Absen Santri',
            'data' => $queri,
            'tanggal' => $tanggal
        ];
        return view('guru/ketAbsen', $data);
    }

    public function updateKetAbsen($id)
    {
        $santri = $this->db->table('tbl_absen_santri')
            ->select('*')
            ->where('santri_id', $id)
            ->get()->getRow();

        $tanggal = $this->request->getVar('tanggal');
        $keterangan = $this->request->getVar('keterangan');

        $qrIdRow = $this->db->table('tbl_qrcode_santri')
            ->select('id')
            ->where('tanggal', $tanggal)
            ->get()->getRow();

        $data = [
            'santri_id' => $id,
            'qr_id'     => $qrIdRow ? $qrIdRow->id : null,
            'keterangan' => $keterangan
        ];
        if (empty($santri)) {
            $this->db->table('tbl_absen_santri')->insert($data);
        } else {
            $this->db->table('tbl_absen_santri')
                ->where('santri_id', $id)
                ->orWhere('qr_id', $qrIdRow->id)->update($data);
        }

        session()->setFlashdata('success', 'Data berhasil diubah');
        return redirect()->to('guru');
    }



    public function profile()
    {
        $query = $this->modelGuru
            ->select('name, email, nik, no_telepon, alamat, nama_mp, image, pendidikan_terakhir, tanggal_lahir')
            ->join('users', 'users.id = tbl_guru.user_id')
            ->join('tbl_mp', 'tbl_mp.id = tbl_guru.id_mp')
            ->where('user_id', user()->id)
            ->first();

        $data = [
            'title' => 'Profile',
            'users' => $query
        ];
        return view('guru/profile', $data);
    }

    public function detailProfile()
    {
        $query = $this->modelGuru
            ->select('tbl_guru.id, pendidikan_terakhir, no_telepon, alamat, pengalaman_mengajar, tentang_pengajar, status_perkawinan, id_mp, image, name, nik, jenis_kelamin, tanggal_lahir, email')
            ->join('users', 'users.id = tbl_guru.user_id')
            ->join('tbl_mp', 'tbl_mp.id = tbl_guru.id_mp')
            ->join('tbl_jenis_kelamin', 'tbl_jenis_kelamin.id = tbl_guru.id_jk')
            ->where('user_id', user()->id)
            ->first();

        $mataPelajaran = $this->modelMataPelajaran
            ->select('id, kode_mp, nama_mp')
            ->findAll();

        $data = [
            'title' => 'Detail Profile',
            'users' => $query,
            'mataPelajaran'    => $mataPelajaran
        ];
        return view('guru/detailProfile', $data);
    }

    public function updateDetailProfile($id)
    {
        $rules = [
            'pendidikan_terakhir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'pendidikan terakhir harus dipilih.',
                ]
            ],
            'no_telepon' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'no. telepon harus dipilih.'
                ]
            ],
            'alamat' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'alamat harus dipilih.'
                ]
            ],
            'pengalaman_mengajar' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'pengalaman mengajar harus dipilih.'
                ]
            ],
            'tentang_pengajar' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'tentang pengajar harus dipilih.'
                ]
            ],
            'status_perkawinan' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'status perkawinan harus dipilih.'
                ]
            ],
            'id_mp' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'mata pelajaran harus dipilih.'
                ]
            ],
            'tanggal_lahir' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'tanggal lahir harus dipilih.'
                ]
            ],
            'jenis_kelamin' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'jenis kelamin harus dipilih.'
                ]
            ],
            'email' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'email harus dipilih.'
                ]
            ],
            'name' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'nama lengkap harus dipilih.'
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
            'password_hash' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'password_hash harus diisi.',
                ]
            ],
            'nik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'password_hash harus diisi.',
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
            'pendidikan_terakhir' => $this->request->getVar('pendidikan_terakhir'),
            'no_telepon' => $this->request->getVar('no_telepon'),
            'alamat' => $this->request->getVar('alamat'),
            'pengalaman_mengajar' => $this->request->getVar('pengalaman_mengajar'),
            'tentang_pengajar' => $this->request->getVar('tentang_pengajar'),
            'status_perkawinan' => $this->request->getVar('status_perkawinan'),
            'tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'id_jk' => $this->request->getVar('jenis_kelamin'),
            'id_mp' => $this->request->getVar('id_mp'),
            'nik' => $this->request->getVar('nik'),
        ];

        $dataLama = $this->modelGuru->where('id', $id)->first();
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
            $dataLama['pendidikan_terakhir'] === $data['pendidikan_terakhir'] &&
            $dataLama['no_telepon'] === $data['no_telepon'] &&
            $dataLama['alamat'] === $data['alamat'] &&
            $dataLama['pengalaman_mengajar'] === $data['pengalaman_mengajar'] &&
            $dataLama['tentang_pengajar'] === $data['tentang_pengajar'] &&
            $dataLama['status_perkawinan'] === $data['status_perkawinan'] &&
            $dataLama['id_mp'] === $data['id_mp'] &&
            $dataLama['id_jk'] === $data['id_jk'] &&
            $dataLama['tanggal_lahir'] === $data['tanggal_lahir'] &&
            $dataLama['nik'] === $data['nik']
        ) {
            session()->setFlashdata('pesan', 'Tidak ada data yang diubah');
            return redirect()->to('guru/profile');
        }

        $this->modelGuru->save($data);
        $this->db->table('users')->where('id', $dataLama['user_id'])->update($dataUsers);
        session()->setFlashdata('pesan', 'data berhasil diubah');
        return redirect()->to('guru/profile');
    }

    public function hapusAbsen($id)
    {
        $this->db->table('tbl_absen_santri')->where('id', $id)->delete();
        session()->setFlashdata('pesan', 'Berhasil dihapus');
        return redirect()->back();
    }
}
