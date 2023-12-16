<?php

namespace App\Controllers;

use App\Models\ModelUsers;
use App\Models\ModelSantri;
use App\Models\ModelGuru;
use App\Models\ModelMataPelajaran;
use App\Models\ModelJadwalPelajaran;
use App\Models\ModelInformasi;
use App\Models\ModelKelas;
use App\Models\ModelAbsensiGuru;
use App\Models\ModelAbsensiSantri;
use App\Models\ModelTranskripNilai;
use CodeIgniter\Database\Query;
use Myth\Auth\Entities\User;
use Dompdf\Dompdf;
use NumberToWords\Legacy\Numbers\Words\Locale\Id;
use Twilio\Rest\Serverless\V1\Service\FunctionPage;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Exception;
use DateTime;
use Dompdf\Options;

class Admin extends BaseController
{
    protected $db, $builder, $auth, $config, $session, $modelMp, $modelSantri, $modelGuru, $modelJadwalPelajaran, $modelUsers, $modelInformasi, $modelKelas, $modelAbsensiGuru, $modelAbsensiSantri, $modelTranskripNilai;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->session = service('session');

        $this->config = config('Auth');
        $this->auth   = service('authentication');

        $this->modelUsers = new ModelUsers();
        $this->modelMp = new ModelMataPelajaran();
        $this->modelSantri = new ModelSantri();
        $this->modelGuru = new ModelGuru();
        $this->modelJadwalPelajaran = new ModelJadwalPelajaran();
        $this->modelInformasi = new ModelInformasi();
        $this->modelKelas = new ModelKelas();
        $this->modelAbsensiGuru = new ModelAbsensiGuru();
        $this->modelAbsensiSantri = new ModelAbsensiSantri();
        $this->modelTranskripNilai = new ModelTranskripNilai();
    }

    public function index()
    {
        $guru = $this->modelGuru->findAll();
        $jumlahPengajar = count($guru);
        $jumlahPengajarLk = $this->modelGuru->where('id_jk', '1')->countAllResults();
        $jumlahPengajarPr = $this->modelGuru->where('id_jk', '2')->countAllResults();

        $santri = $this->modelSantri->findAll();
        $jumlahSantri = count($santri);
        $jumlahSantriLk = $this->modelSantri->where('id_jk', '1')->countAllResults();
        $jumlahSantriPr = $this->modelSantri->where('id_jk', '2')->countAllResults();

        $mp = $this->modelMp->findAll();
        $jumlahMp = count($mp);

        $kelas = $this->modelKelas->findAll();
        $jumlahKelas = count($kelas);


        // $kelas = $this->db->table('tbl_kelas')->select('nama_kelas, tingkat, kapasitas')->get()->getResultArray();

        // $tingkatYangDicari = [];

        // foreach ($kelas as $dataKelas) {
        //     $tingkat = $dataKelas['tingkat'];
        //     if (!in_array($tingkat, $tingkatYangDicari)) {
        //         $tingkatYangDicari[] = $tingkat;
        //     }
        // }

        // $jlhTingkat = [];

        // foreach ($tingkatYangDicari as $tingkat) {
        //     $jlhTingkat[$tingkat] = $this->modelSantri->select('tingkat')
        //         ->join('tbl_kelas', 'tbl_kelas.id = tbl_santri.id_kelas')
        //         ->where('tingkat', $tingkat)
        //         ->countAllResults();
        // }

        $data = [
            'title'             => 'Dashboard',
            'absenGuru'         => 'Daftar Absen Guru',
            'absenSantri'       => 'Daftar Absen Santri',
            'jumlah_pengajar'   => $jumlahPengajar,
            'jumlah_santri'     => $jumlahSantri,
            'jumlah_mp'         => $jumlahMp,
            'GL'                => $jumlahPengajarLk,
            'GP'                => $jumlahPengajarPr,
            'SL'                => $jumlahSantriLk,
            'SP'                => $jumlahSantriPr,
            'kelas'             => $kelas,
            // 'jlhTingkat'        => $jlhTingkat,
            'jumlah_kelas'        => $jumlahKelas,
        ];

        return view('admin/index', $data);
    }

    public function daftarUsers()
    {

        $currentPage = $this->request->getVar('page_users') ? $this->request->getVar('page_users') : 1;

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $query = $this->modelUsers->getUsersKeyword($keyword);
        } else {
            $query = $this->modelUsers->getUsers();
        }

        $data = [
            'title' => 'Data Users',
            'users' => $query->paginate('10', 'users'),
            'pager' => $this->modelUsers->pager,
            'currentPage' => $currentPage
        ];

        return view('admin/daftarUsers', $data);
    }

    public function updateStatus($id)
    {
        $status = $this->request->getVar('active');
        if ($status == 'on') {
            $status = 1;
        } else {
            $status = 0;
        }
        $data = [
            'id' => $id,
            'active' => $status
        ];

        $this->modelUsers->save($data);
        return redirect()->back();
    }

    public function tambahUsers()
    {
        $kelas = $this->db->table('tbl_kelas')->select('tbl_kelas.id, nama_kelas, id_guru, id_jk, kapasitas, jenis_kelamin')
            ->join('tbl_jenis_kelamin', 'tbl_jenis_kelamin.id = tbl_kelas.id_jk')
            ->get()->getResultArray();

        $mp = $this->modelMp->findAll();

        $nip = $this->modelGuru->selectMax('nip')->get()->getRow();
        $nis = $this->modelSantri->selectMax('nis')->get()->getRow();
        if (!empty($nip->nip) || !empty($nis->nis)) {
            $numericPartGuru = (int)substr($nip->nip, 0);
            $newNumericPartGuru = $numericPartGuru + 1;
            $newNip = '' . str_pad($newNumericPartGuru, 2, '0', STR_PAD_LEFT);

            $numericPartSantri = (int)substr($nis->nis, 0);
            $newNumericPartSantri = $numericPartSantri + 1;
            $newNis = '' . str_pad($newNumericPartSantri, 2, '0', STR_PAD_LEFT);
        } else {
            $newNip = '191011400791';
            $newNis = '1098780101';
        }

        $data = [
            'title' => 'Form Tambah Data Users',
            'kelas' => $kelas,
            'nip' => $newNip,
            'nis' => $newNis,
            'mp'  => $mp
        ];

        return view('admin/tambahUsers', $data);
    }

    public function simpanUsers()
    {
        $users = model(ModelUsers::class);
        $level = $this->request->getVar('role');
        $rules = [
            'username' => [
                'rules' => 'required|alpha_numeric_space|min_length[1]|max_length[30]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username harus diisi.',
                    'alpha_numeric_space' => 'Username hanya dapat berisi karakter alfanumerik dan spasi.',
                    'min_length' => 'Username harus memiliki panjang minimal 1 karakter.',
                    'max_length' => 'Username tidak boleh lebih dari 30 karakter.',
                    'is_unique' => 'Username sudah digunakan oleh pengguna lain. Silakan pilih username lain.'
                ]
            ],

            'email'    => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email harus diisi.',
                    'valid_email' => 'Masukkan alamat email yang valid.',
                    'is_unique' => 'Email sudah digunakan oleh pengguna lain. Silakan gunakan email lain.'
                ]
            ],

            'name'     => [
                'rules' => 'required|is_unique[users.name]',
                'errors' => [
                    'required' => 'Nama harus diisi.',
                    'is_unique' => 'Nama sudah digunakan oleh pengguna lain. Silakan gunakan nama lain.'
                ]
            ],

            'password' => [
                'rules' => 'required|strong_password',
                'errors' => [
                    'required' => 'Password harus diisi.',
                    'strong_password' => 'Password harus mengandung minimal 8 karakter dan memenuhi syarat keamanan.'
                ]
            ],

            'role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilih salah satu (role).'
                ]
            ],

            'image' => [
                'rules' => 'max_size[image,3000]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang dipilih bukan gambar',
                    'mime_in'  => 'Yang dipilih bukan gambar',
                ]
            ]
        ];

        if ($level == 'guru') {
            $rules['nik'] = [
                'rules' => 'required|is_unique[tbl_guru.nik]',
                'errors' => [
                    'required' => 'NIK harus diisi',
                    'is_unique' => 'NIK tidak boleh sama'
                ]
            ];
            $rules['id_mp'] = [
                'rules' => 'required',
                'errors' => [
                    'required' => 'mata pelajaran harus dipilih',
                ]
            ];
        } elseif ($level == 'santri') {
            $rules['nis'] = [
                'rules' => 'required|is_unique[tbl_santri.nis]',
                'errors' => [
                    'required' => 'NIS harus diisi',
                    'is_unique' => 'NIS tidak boleh sama'
                ]
            ];
            $rules['id_kelas'] = [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilih jenjang pendidikan'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileImage = $this->request->getFile('image');

        if ($fileImage->getError() == 4) {
            $namaImage = 'default.jpg';
        } else {
            $namaImage = $fileImage->getRandomName();
            $fileImage->move('pas_photo', $namaImage);
        }

        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user              = new User($this->request->getPost($allowedPostFields));
        $user->image = $namaImage;

        $this->config->requireActivation === null ? $user->activate() : $user->generateActivateHash();

        $role = $this->request->getVar('role');

        if (!empty($role)) {
            $users = $users->withGroup($role);
        }


        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        if ($this->config->requireActivation !== null) {
            $activator = service('activator');
            $sent      = $activator->send($user);

            if (!$sent) {
                return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
            }
            return redirect()->route('admin/daftarUsers')->with('message', lang('Auth.activationSuccess'));
        }

        $idUsers = $users->orderBy('id', 'desc')->first();
        $idGroup = $users->withGroup($role);

        if ($idGroup->assignGroup == '2') {
            $data = [
                'user_id' => $idUsers->id,
                'nik' => $this->request->getVar('nik'),
                'nip' => $this->request->getVar('nip'),
                'id_mp' => $this->request->getVar('id_mp')
            ];
            $this->modelGuru->save($data);
        } elseif ($idGroup->assignGroup == '3') {
            $kelas = $this->request->getVar('id_kelas');
            list($id_kelas, $id_jk) = explode(' . ', $kelas);
            $data = [
                'user_id' => $idUsers->id,
                'nis' => $this->request->getVar('nis'),
                'id_kelas' => $id_kelas,
                'id_jk' => $id_jk
            ];
            $this->modelSantri->save($data);
        }

        session()->setFlashdata('pesan', 'Users berhasil ditambahkan');

        return redirect()->route('admin/daftarUsers');
    }

    public function hapusUsers($id)
    {
        $data = $this->modelUsers->find($id);
        $namaImage = $data->image;

        if ($namaImage != 'default.jpg') {
            unlink('pas_photo/' . $namaImage);
        }

        $this->builder->where('id', $id)->delete();
        session()->setFlashdata('pesan', 'Users berhasil dihapus');
        return redirect()->to('admin/daftarUsers');
    }

    public function editUsers($id)
    {
        $this->builder->select('users.id as userid, username, email, auth_groups.name as role, users.name as fullname, image, password_hash as password')
            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
            ->where('users.id', $id);

        $query = $this->builder->get();

        $data = [
            'title' => 'Daftar Users',
            'users' => $query->getRow()
        ];

        return view('admin/editUsers', $data);
    }

    public function updateUsers($id)
    {
        $users = model(ModelUsers::class);
        $user = $users->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        $rules = [
            'username' => [
                'rules' => "required|alpha_numeric_space|min_length[1]|max_length[30]|is_unique[users.username,id,$id]",
                'errors' => [
                    'required' => 'Username harus diisi.',
                    'alpha_numeric_space' => 'Username hanya dapat berisi karakter alfanumerik dan spasi.',
                    'min_length' => 'Username harus memiliki panjang minimal 3 karakter.',
                    'max_length' => 'Username tidak boleh lebih dari 30 karakter.',
                    'is_unique' => 'Username sudah digunakan oleh pengguna lain. Silakan pilih username lain.'
                ]
            ],
            'email' => [
                'rules' => "required|valid_email|is_unique[users.email,id,$id]",
                'errors' => [
                    'required' => 'Email harus diisi.',
                    'valid_email' => 'Masukkan alamat email yang valid.',
                    'is_unique' => 'Email sudah digunakan oleh pengguna lain. Silakan gunakan email lain.'
                ]
            ],
            'name' => [
                'rules' => "required|is_unique[users.name,id,$id]",
                'errors' => [
                    'required' => 'Nama harus diisi.',
                    'is_unique' => 'Nama sudah digunakan oleh pengguna lain. Silakan gunakan nama lain.'
                ]
            ],
            'password' => [
                'rules' => 'required|strong_password',
                'errors' => [
                    'required' => 'Password harus diisi.',
                    'strong_password' => 'Password harus mengandung minimal 8 karakter dan memenuhi syarat keamanan.'
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
            'role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilih salah satu (role).'
                ]
            ]

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

        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user->fill($this->request->getPost($allowedPostFields));
        $user->image = $namaImage;

        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        session()->setFlashdata('pesan', 'Users berhasil diperbarui');

        return redirect()->route('admin/daftarUsers');
    }

    public function daftarGuru()
    {
        $currentPage = $this->request->getVar('page_tbl_guru') ? $this->request->getVar('page_tbl_guru') : 1;

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $query = $this->modelGuru->getGuruKeyword($keyword);
        } else {
            $query = $this->modelGuru->getGuru();
        }

        $data = [
            'title' => 'Data Guru',
            'users' => $query->paginate('10', 'tbl_guru'),
            'pager' => $this->modelGuru->pager,
            'currentPage' => $currentPage
        ];

        return view('admin/daftarGuru', $data);
    }

    public function detailGuru($id = 0)
    {
        $query = $this->modelGuru
            ->select('tbl_guru.id, users.name, pendidikan_terakhir, no_telepon, alamat, pengalaman_mengajar, tentang_pengajar, image, status_perkawinan, nip, nik, jenis_kelamin, tanggal_lahir, email')
            ->join('users', 'users.id = tbl_guru.user_id')
            ->join('tbl_jenis_kelamin', 'tbl_jenis_kelamin.id = tbl_guru.id_jk')
            ->where('tbl_guru.id', $id)
            ->get()
            ->getRow();

        $data = [
            'title' => 'Detail Guru',
            'users' => $query,
        ];

        return view('admin/detailGuru', $data);
    }

    public function hapusGuru($id)
    {
        $this->db->table('tbl_guru')->where('id', $id)->delete();
        session()->setFlashdata('pesan', 'Guru berhasil dihapus');
        return redirect()->to('admin/daftarGuru');
    }

    public function editGuru($id)
    {
        $query = $this->db->table('tbl_guru')->select('nip, tbl_guru.id, users.name, user_id, nik, jenis_kelamin as jk, tanggal_lahir as tgl_lahir, alamat, no_telepon, pendidikan_terakhir, pengalaman_mengajar, tentang_pengajar, status_perkawinan, users.image, email')
            ->join('users', 'users.id = tbl_guru.user_id')
            ->join('tbl_jenis_kelamin', 'tbl_jenis_kelamin.id = tbl_guru.id_jk')
            ->where('tbl_guru.id', $id)
            ->get()->getRow();

        $data = [
            'title' => 'Edit Form Guru',
            'gurus' => $query,
        ];
        return view('admin/editGuru', $data);
    }

    public function updateGuru($id)
    {
        $rules = [
            'user_id' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'ID harus dipilih.',
                ]
            ],
            'nik' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'NIK harus diisi.',
                ]
            ],
            'jk' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'jenis kelamin harus dipilih.',
                ]
            ],
            'tgl_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'tanggal lahir harus diisi.',
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'alamat rumah harus diisi.'
                ]
            ],
            'no_telepon' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'telepon rumah harus diisi.'
                ]
            ],
            'pendidikan_terakhir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'pendidikan terakhir harus diisi.'
                ]
            ],
            'pengalaman_mengajar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'mata pelajaran harus diisi.'
                ]
            ],
            'tentang_pengajar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'mata pelajaran harus diisi.'
                ]
            ],
            'status_perkawinan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'mata pelajaran harus diisi.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }


        $data = [
            'id' => $id,
            'user_id' => $this->request->getVar('user_id'),
            'nik' => $this->request->getVar('nik'),
            'id_jk' => $this->request->getVar('jk'),
            'tanggal_lahir' => $this->request->getVar('tgl_lahir'),
            'alamat' => $this->request->getVar('alamat'),
            'no_telepon' => $this->request->getVar('no_telepon'),
            'pendidikan_terakhir' => $this->request->getVar('pendidikan_terakhir'),
            'nip' => $this->request->getVar('nip'),
            'pengalaman_mengajar' => $this->request->getVar('pengalaman_mengajar'),
            'tentang_pengajar' => $this->request->getVar('tentang_pengajar'),
            'status_perkawinan' => $this->request->getVar('status_perkawinan'),
        ];

        $guru = $this->db->table('tbl_guru')->where('id', $id)->get()->getRow();

        if (
            $guru->nik === $data['nik'] &&
            $guru->id_jk === $data['id_jk'] &&
            $guru->tanggal_lahir === $data['tanggal_lahir'] &&
            $guru->alamat === $data['alamat'] &&
            $guru->no_telepon === $data['no_telepon'] &&
            $guru->pendidikan_terakhir === $data['pendidikan_terakhir'] &&
            $guru->nip === $data['nip'] &&
            $guru->pengalaman_mengajar === $data['pengalaman_mengajar'] &&
            $guru->tentang_pengajar === $data['tentang_pengajar'] &&
            $guru->status_perkawinan === $data['status_perkawinan']
        ) {
            session()->setFlashdata('sama', 'Tidak ada data guru yang diubah');
            return redirect()->route('admin/daftarGuru');
        }

        $this->db->table('tbl_guru')->where('id', $id)->update($data);

        session()->setFlashdata('pesan', 'Data Guru berhasil diubah');
        return redirect()->route('admin/daftarGuru');
    }

    public function daftarSantri()
    {
        $currentPage = $this->request->getVar('page_tbl_santri') ? $this->request->getVar('page_tbl_santri') : 1;

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $query = $this->modelSantri->getSantriKeyword($keyword);
        } else {
            $query = $this->modelSantri->getSantri();
        }

        $data = [
            'title' => 'Data Santri',
            'users' => $query->paginate('10', 'tbl_santri'),
            'pager' => $this->modelSantri->pager,
            'currentPage' => $currentPage
        ];

        return view('admin/daftarSantri', $data);
    }

    public function hapusSantri($id)
    {
        $this->db->table('tbl_santri')->where('id', $id)->delete();
        session()->setFlashdata('pesan', 'Santri berhasil dihapus');
        return redirect()->to('admin/daftarSantri');
    }

    public function editSantri($id)
    {
        $kelas = $this->db->table('tbl_kelas')->select('id as id_kelas, nama_kelas')->get()->getResultArray();

        $query = $this->db->table('tbl_santri')->select('tbl_santri.id, users.name, users.id as user_id, nis, tingkat, kelas, awal_masuk, tanggal_lahir, jenis_kelamin, riwayat_akademik, riwayat_kesehatan, nama_kontak_darurat, telepon_kontak_darurat, tbl_santri.status, id_kelas, alamat, nama_ortu')
            ->join('users', 'users.id = tbl_santri.user_id')
            ->join('tbl_jenis_kelamin', 'tbl_jenis_kelamin.id = tbl_santri.id_jk')
            ->where('tbl_santri.id', $id)
            ->get()->getRow();

        $data = [
            'title' => 'Edit Form Santri',
            'santris' => $query,
            'kelas' => $kelas
        ];

        return view('admin/editSantri', $data);
    }

    public function updateSantri($id)
    {
        $rules = [
            'user_id' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'id harus dipilih.',
                    'is_unique' => 'id sudah ada.'
                ]
            ],
            'nis' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'nis harus diisi.',
                    'is_unique' => 'nis sudah ada.'
                ]
            ],
            'awal_masuk' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'awal masuk harus diisi.',
                ]
            ],
            'jk' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'jenis kelamin harus dipilih.',
                ]
            ],
            'id_kelas' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'jenjang pendidikan harus dipilih.',
                ]
            ],
            'tingkat' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'jenjang pendidikan harus dipilih.',
                ]
            ],
            'kelas' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'kelas harus dipilih.',
                ]
            ],
            'tgl_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'tanggal lahir harus diisi.',
                ]
            ],
            'riwayat_akademik' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'riwayat akademik harus diisi.'
                ]
            ],
            'riwayat_kesehatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'riwayat kesehatan harus diisi.'
                ]
            ],
            'nama_kontak_darurat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'nama kontak darurat harus diisi.'
                ]
            ],
            'telepon_kontak_darurat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'telepon kontak darurat harus diisi.'
                ]
            ],
            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'status harus diisi.'
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'alamat harus diisi.'
                ]
            ],
            'nama_ortu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'nama ortu harus diisi.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id' => $id,
            'user_id' => $this->request->getVar('user_id'),
            'nis' => $this->request->getVar('nis'),
            'awal_masuk' => $this->request->getVar('awal_masuk'),
            'id_jk' => $this->request->getVar('jk'),
            'id_kelas' => $this->request->getVar('id_kelas'),
            'tingkat' => $this->request->getVar('tingkat'),
            'kelas' => $this->request->getVar('kelas'),
            'tanggal_lahir' => $this->request->getVar('tgl_lahir'),
            'riwayat_akademik' => $this->request->getVar('riwayat_akademik'),
            'riwayat_kesehatan' => $this->request->getVar('riwayat_kesehatan'),
            'nama_kontak_darurat' => $this->request->getVar('nama_kontak_darurat'),
            'telepon_kontak_darurat' => $this->request->getVar('telepon_kontak_darurat'),
            'status' => $this->request->getVar('status'),
            'alamat' => $this->request->getVar('alamat'),
            'nama_ortu' => $this->request->getVar('nama_ortu'),
        ];

        $santri = $this->db->table('tbl_santri')->where('id', $id)->get()->getRow();

        if (
            $santri->nis === $data['nis'] &&
            $santri->id_jk === $data['id_jk'] &&
            $santri->awal_masuk === $data['awal_masuk'] &&
            $santri->id_kelas === $data['id_kelas'] &&
            $santri->tingkat === $data['tingkat'] &&
            $santri->kelas === $data['kelas'] &&
            $santri->tanggal_lahir === $data['tanggal_lahir'] &&
            $santri->riwayat_akademik === $data['riwayat_akademik'] &&
            $santri->riwayat_kesehatan === $data['riwayat_kesehatan'] &&
            $santri->nama_kontak_darurat === $data['nama_kontak_darurat'] &&
            $santri->status === $data['status'] &&
            $santri->telepon_kontak_darurat === $data['telepon_kontak_darurat'] &&
            $santri->alamat === $data['alamat'] &&
            $santri->nama_ortu === $data['nama_ortu']
        ) {
            session()->setFlashdata('pesan', 'Tidak ada data santri yang diubah');
            return redirect()->route('admin/daftarSantri');
        }

        $this->db->table('tbl_santri')->where('id', $id)->update($data);

        session()->setFlashdata('pesan', 'Data Santri berhasil diubah');
        return redirect()->route('admin/daftarSantri');
    }

    public function detailSantri($id = 0)
    {
        $query = $this->modelSantri
            ->select('tbl_santri.id, image, name, nis, jenis_kelamin, tanggal_lahir, nama_kelas, email, id_kelas, kelas, alamat, awal_masuk, nama_kontak_darurat, telepon_kontak_darurat, riwayat_akademik, riwayat_kesehatan, password_hash, nama_ortu, tingkat, tbl_santri.status')
            ->join('users', 'users.id = tbl_santri.user_id')
            ->join('tbl_kelas', 'tbl_kelas.id = tbl_santri.id_kelas')
            ->join('tbl_jenis_kelamin', 'tbl_jenis_kelamin.id = tbl_santri.id_jk')
            ->where('tbl_santri.id', $id)
            ->get()->getRow();

        $data = [
            'title' => 'Detail Santri',
            'santris' => $query,
        ];

        return view('admin/detailSantri', $data);
    }

    public function mp()
    {
        $kode_mp = $this->modelMp->selectMax('kode_mp')->get()->getRow();

        if (!empty($kode_mp->kode_mp)) {
            $numericPart = (int)substr($kode_mp->kode_mp, 2);
            $newNumericPart = $numericPart + 1;
            $newCode = 'MP' . str_pad($newNumericPart, 2, '0', STR_PAD_LEFT);
        } else {
            $newCode = "MP01";
        }

        $currentPage = $this->request->getVar('page_tbl_mp') ? $this->request->getVar('page_tbl_mp') : 1;

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $mataPelajaran = $this->modelMp->search($keyword);
        } else {
            $mataPelajaran = $this->modelMp;
        }

        $data = [
            'title' => 'Data Mata Pelajaran',
            'data' => $mataPelajaran->paginate(10, 'tbl_mp'),
            'pager' => $this->modelMp->pager,
            'currentPage' => $currentPage,
            'kode_mp'  => $newCode,
        ];
        return view('admin/daftarMp', $data);
    }

    public function simpanMp()
    {
        $rules = [
            'kode_mp' => [
                'rules' => "required|is_unique[tbl_mp.kode_mp]",
                'errors' => [
                    'required' => 'Kode harus dipilih.',
                    'is_unique' => 'Kode sudah ada.'
                ]
            ],
            'nama_mp' => [
                'rules' => "required|is_unique[tbl_mp.nama_mp]",
                'errors' => [
                    'required' => 'Mata Pelajaran harus diisi.',
                    'is_unique' => 'Mata Pelajaran sudah ada.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors_simpan', $this->validator->getErrors());
        }

        $kode_mp = $this->request->getVar('kode_mp');
        $nama_mp = $this->request->getVar('nama_mp');

        $data = [
            'kode_mp' => $kode_mp,
            'nama_mp' => $nama_mp
        ];

        $this->db->table('tbl_mp')->insert($data);

        session()->setFlashdata('pesan', 'Data Mata Pelajaran berhasil ditambahkan');
        return redirect()->to('admin/daftarMp');
    }

    public function updateMp($id)
    {
        $rules = [
            'kode_mp' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'Kode harus dipilih.',
                ]
            ],
            'nama_mp' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'Mata Pelajaran harus diisi.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors_edit', $this->validator->getErrors());
        }

        $data = [
            'id' => $id,
            'kode_mp' => $this->request->getVar('kode_mp'),
            'nama_mp' => $this->request->getVar('nama_mp')
        ];

        $dataLama = $this->db->table('tbl_mp')->where('id', $id)->get()->getRow();

        if (
            $dataLama->kode_mp === $data['kode_mp'] &&
            $dataLama->nama_mp === $data['nama_mp']
        ) {
            session()->setFlashdata('pesan', 'Tidak ada data mata pelajaran yang diubah');
            return redirect()->route('admin/daftarMp');
        }

        $this->db->table('tbl_mp')->where('id', $id)->update($data);

        session()->setFlashdata('pesan', 'Data Mata Pelajaran berhasil diubah');
        return redirect()->route('admin/daftarMp');
    }

    public function hapusMp($id)
    {
        $this->db->table('tbl_mp')->where('id', $id)->delete();
        session()->setFlashdata('pesan', 'Mata pelajaran berhasil dihapus');
        return redirect()->to('admin/daftarMp');
    }

    public function daftarJadwalPelajaran()
    {
        $currentPage = $this->request->getVar('page_tbl_jadwal_pelajaran') ? $this->request->getVar('page_tbl_jadwal_pelajaran') : 1;

        $guru = $this->modelGuru->getGuru()->findAll();

        $kelas = $this->db->table('tbl_kelas')
            ->orderBy('id_jk', 'ASC')
            ->orderBy('nama_kelas', 'ASC')
            ->get()->getResultArray();
        // dd($kelas);

        $tahunAjaran = $this->modelJadwalPelajaran->getJadwalPelajaran()->distinct()->groupBy(['tahun_ajaran', 'semester'])->orderBy('tahun_ajaran', 'DESC')->findAll();

        $selectedValue = $this->request->getVar('filter');

        $user_login = $this->db
            ->table('auth_groups_users')
            ->select('auth_groups.name')
            ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
            ->where('user_id', user()->id)
            ->get()
            ->getRow();

        $guru_id = $this->modelGuru->select('tbl_guru.id')->where('tbl_guru.user_id', user()->id)->first();

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $query = $this->modelJadwalPelajaran->getKeyword($keyword);
        } else {
            if ($selectedValue) {
                list($tahun_ajaran, $semester) = explode('-', $selectedValue);
                $query = $this->modelJadwalPelajaran->getDataByTahunSemester($tahun_ajaran, $semester);
                if ($user_login->name !== 'admin') {
                    $query->where('tbl_jadwal_pelajaran.id_guru', $guru_id);
                }
            } else {
                $query = $this->modelJadwalPelajaran->getAjaranTahunSemester();
                if ($user_login->name !== 'admin') {
                    $query->where('tbl_jadwal_pelajaran.id_guru', $guru_id);
                }
            }
        }

        $data = [
            'title'           => 'Jadwal Harian',
            'data'            => $query->paginate('19', 'tbl_jadwal_pelajaran'),
            'gurus'           => $guru,
            'tahunAjaran'     => $tahunAjaran,
            'kelas'           => $kelas,
            'pager'           => $this->modelJadwalPelajaran->pager,
            'currentPage'     => $currentPage

        ];

        return view('admin/daftarJadwalPelajaran', $data);
    }

    public function simpanJadwalPelajaran()
    {
        $dataLama = $this->modelJadwalPelajaran->select('id_guru, tahun_ajaran, semester, kegiatan')->findAll();
        $id_guru = $this->request->getVar('id_guru');
        $tahun_ajaran = $this->request->getVar('tahun_ajaran');
        $semester = $this->request->getVar('semester');
        $kegiatan = $this->request->getVar('kegiatan');

        $ruleIdGuru = 'required';
        $ruleTahunAjaran = 'required';
        $ruleSemester = 'required';
        $ruleKegiatan = 'required';

        foreach ($dataLama as $data) {
            $data_id_guru = $data['id_guru'];
            $data_tahun_ajaran = $data['tahun_ajaran'];
            $data_semester = $data['semester'];
            $data_kegiatan = $data['kegiatan'];

            if ($data_id_guru == $id_guru && $data_tahun_ajaran == $tahun_ajaran && $data_semester == $semester && $data_kegiatan == $kegiatan) {
                $ruleIdGuru = 'required|is_unique[tbl_jadwal_pelajaran.id_guru]';
            }
        }

        $rules = [
            'id_guru' => [
                'rules' => $ruleIdGuru,
                'errors' => [
                    'required' => 'guru harus dipilih.',
                    'is_unique' => 'guru sudah ada.'
                ]
            ],
            'tahun_ajaran' => [
                'rules' => $ruleTahunAjaran,
                'errors' => [
                    'required' => 'tahun ajaran harus diisi.',
                ]
            ],
            'kegiatan' => [
                'rules' => $ruleKegiatan,
                'errors' => [
                    'required' => 'kegiatan harus diisi.',
                ]
            ],
            'jam_mulai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'jam mulai harus diisi.'
                ]
            ],
            'jam_selesai' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'jam selesai harus diisi.'
                ]
            ],
            'semester' => [
                'rules' => $ruleSemester,
                'errors' => [
                    'required' => 'semester akhir harus diisi.',
                ]
            ],
            'id_kelas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'ruang kelas dipilih.',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $jamMulai = $this->request->getVar('jam_mulai');
        $jamSelesai = $this->request->getVar('jam_selesai');
        $jam = $jamMulai . '-' . $jamSelesai;

        $data = [
            'id_guru'       => $this->request->getVar('id_guru'),
            'tahun_ajaran'  => $this->request->getVar('tahun_ajaran'),
            'kegiatan'      => $this->request->getVar('kegiatan'),
            'jam'           => $jam,
            'semester'      => $this->request->getVar('semester'),
            'id_kelas'      => $this->request->getVar('id_kelas')
        ];

        $this->modelJadwalPelajaran->save($data);

        session()->setFlashdata('pesan', 'Data Jadwal Pelajaran berhasil ditambah');
        return redirect()->to('admin/daftarJadwalPelajaran');
    }

    public function hapusJP($id)
    {
        $this->modelJadwalPelajaran->where('id', $id)->delete();
        session()->setFlashdata('pesan', 'Jadwal pelajaran berhasil dihapus');
        return redirect()->to('admin/daftarJadwalPelajaran');
    }

    public function editJP($id)
    {
        $query = $this->modelJadwalPelajaran->getJadwalPelajaran()
            ->where('tbl_jadwal_pelajaran.id', $id)
            ->get()->getRow();

        $jam = $query->jam;
        $pecahWaktu = explode("-", $jam);

        $jam_mulai = $pecahWaktu[0];
        $jam_selesai = $pecahWaktu[1];

        $guru = $this->modelGuru->getGuru()->findAll();

        $kelas = $this->db->table('tbl_kelas')
            ->orderBy('id_jk', 'ASC')
            ->orderBy('nama_kelas', 'ASC')
            ->get()->getResultArray();

        $data = [
            'title'       => 'Edit Data Mata Pelajaran',
            'data'        => $query,
            'gurus'       => $guru,
            'jam_mulai'   => $jam_mulai,
            'jam_selesai' => $jam_selesai,
            'kelas'       => $kelas
        ];

        return view('admin/editJp', $data);
    }

    public function updateJp($id)
    {
        $rules = [
            'id_guru' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'guru harus dipilih.'
                ]
            ],
            'tahun_ajaran' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'tahun ajaran harus diisi.'
                ]
            ],
            'kegiatan' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'kegiatan harus diisi.'
                ]
            ],
            'jam_mulai' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'jam mulai harus diisi.'
                ]
            ],
            'jam_selesai' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'jam selesai harus diisi.'
                ]
            ],
            'semester' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'semester harus diisi.'
                ]
            ],
            'id_kelas' => [
                'rules' => "required",
                'errors' => [
                    'required' => 'ruang kelas harus dipilih.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $jamMulai = $this->request->getVar('jam_mulai');
        $jamSelesai = $this->request->getVar('jam_selesai');
        $jam = $jamMulai . '-' . $jamSelesai;

        $data = [
            'id' => $id,
            'id_guru' => $this->request->getVar('id_guru'),
            'tahun_ajaran' => $this->request->getVar('tahun_ajaran'),
            'semester' => $this->request->getVar('semester'),
            'kegiatan' => $this->request->getVar('kegiatan'),
            'jam' => $jam,
            'id_kelas' => $this->request->getVar('id_kelas'),
        ];

        $dataLama = $this->modelJadwalPelajaran->where('id', $id)->get()->getRow();
        // dd($data, $dataLama);

        if (
            $dataLama->id_guru === $data['id_guru'] &&
            $dataLama->tahun_ajaran === $data['tahun_ajaran'] &&
            $dataLama->kegiatan === $data['kegiatan'] &&
            $dataLama->semester === $data['semester'] &&
            $dataLama->jam === $jam &&
            $dataLama->id_kelas === $data['id_kelas']
        ) {
            session()->setFlashdata('pesan', 'Tidak ada data jadwal pelajaran yang diubah');
            return redirect()->route('admin/daftarJadwalPelajaran');
        }


        $this->modelJadwalPelajaran->save($data);

        session()->setFlashdata('pesan', 'Data Jadwal Pelajaran berhasil diubah');
        return redirect()->to('admin/daftarJadwalPelajaran');
    }

    public function cetakJp()
    {
        $filter = $this->request->getVar('filter');
        if ($filter) {
            list($tahun_ajaran, $semester) = explode('-', $filter);
            $query = $this->modelJadwalPelajaran->getDataByTahunSemester($tahun_ajaran, $semester)->findAll();
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

    public function daftarKelas()
    {
        $currentPage = $this->request->getVar('page_tbl_kelas') ? $this->request->getVar('page_tbl_kelas') : 1;
        $kelas = $this->modelKelas->getKelas();
        $data = [
            'title' => 'Data Kelas',
            'kelas' => $kelas->paginate('10', 'tbl_kelas'),
            'pager' => $this->modelKelas->pager,
            'currentPage' => $currentPage
        ];

        return view('admin/daftarKelas', $data);
    }

    public function tambahKelas()
    {
        $guru = $this->modelGuru->getGuru()->findAll();
        $data = [
            'title' => 'Tambah Kelas',
            'guru' => $guru
        ];
        return view('admin/tambahKelas', $data);
    }

    public function simpanKelas()
    {
        $rules = [
            'id_guru' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'wali kelas harus dipilih',
                    'is_unique' => 'wali kelas sudah ada'
                ]
            ],
            'nama_kelas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'nama kelas harus diisi',
                    'is_unique' => 'nama kelas sudah ada'
                ]
            ],
            'id_jk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'gender harus diisi',
                ]
            ],
            'kapasitas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kapasitas kelas harus diisi',
                ]
            ],
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_kelas' => $this->request->getVar('nama_kelas'),
            'id_jk' => $this->request->getVar('id_jk'),
            'kapasitas' => $this->request->getVar('kapasitas'),
            'id_guru' => $this->request->getVar('id_guru'),
        ];

        $this->db->table('tbl_kelas')->insert($data);
        session()->setFlashdata('pesan', 'Data Jadwal Pelajaran berhasil ditambah');
        return redirect()->to('admin/daftarKelas');
    }

    public function editKelas($id)
    {
        $kelas = $this->db->table('tbl_kelas')->where('id', $id)->get()->getRow();
        $guru = $this->modelGuru->getGuru()->findAll();
        $data = [
            'title' => 'Tambah Kelas',
            'guru' => $guru,
            'kelas' => $kelas
        ];

        return view('admin/editKelas', $data);
    }

    public function hapusKelas($id)
    {
        $this->db->table('tbl_kelas')->where('id', $id)->delete();
        session()->setFlashdata('pesan', 'Kelas berhasil dihapus');
        return redirect()->to('admin/daftarKelas');
    }

    public function updateKelas($id)
    {
        $kelas = $this->db->table('tbl_kelas')->where('id', $id)->get()->getRow();

        $id_guru = $this->request->getVar('id_guru');
        $nama_kelas = $this->request->getVar('nama_kelas');

        if ($kelas->id_guru == $id_guru) {
            $required_idGuru = 'required';
        } else {
            $required_idGuru = 'required|is_unique[tbl_kelas.id_guru]';
        }

        if ($kelas->nama_kelas == $nama_kelas) {
            $required_namaKelas = 'required';
        } else {
            $required_namaKelas = 'required|is_unique[tbl_kelas.nama_kelas]';
        }

        $rules = [
            'id_guru' => [
                'rules' => $required_idGuru,
                'errors' => [
                    'required' => 'wali kelas harus dipilih',
                    'is_unique' => 'wali kelas sudah ada'
                ]
            ],
            'nama_kelas' => [
                'rules' => $required_namaKelas,
                'errors' => [
                    'required' => 'nama kelas harus diisi',
                    'is_unique' => 'nama kelas sudah ada'
                ]
            ],
            'tingkat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'tingkat kelas harus diisi',
                ]
            ],
            'kapasitas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kapasitas kelas harus diisi',
                ]
            ],
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id' => $id,
            'nama_kelas' => $nama_kelas,
            'kapasitas' => $this->request->getVar('kapasitas'),
            'tingkat' => $this->request->getVar('tingkat'),
            'id_guru' => $this->request->getVar('id_guru')
        ];

        if (
            $kelas->id_guru == $data['id_guru'] &&
            $kelas->nama_kelas == $data['nama_kelas'] &&
            $kelas->kapasitas == $data['kapasitas'] &&
            $kelas->tingkat == $data['tingkat']
        ) {
            session()->setFlashdata('batal', 'tidak ada kelas diubah');
            return redirect()->to('admin/daftarKelas');
        }

        $this->db->table('tbl_kelas')->where('id', $id)->update($data);
        session()->setFlashdata('pesan', 'Kelas berhasil diubah');
        return redirect()->to('admin/daftarKelas');
    }

    public function informasi()
    {
        $currentPage = $this->request->getVar('page_tbl_arsip') ? $this->request->getVar('page_tbl_arsip') : 1;

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $query = $this->modelInformasi->getInformasiKeyword($keyword);
        } else {
            $query = $this->modelInformasi->getInformasi();
        }

        $data = [
            'title' => 'Upload File Informasi',
            'data' => $query->paginate('10', 'tbl_arsip'),
            'pager' => $this->modelInformasi->pager,
            'currentPage' => $currentPage
        ];

        return view('admin/informasi', $data);
    }

    public function simpanInformasi()
    {
        $rules = [
            'berkas' => [
                'rules' => 'uploaded[berkas]|max_size[berkas,2048]|mime_in[berkas,application/pdf]',
                'errors' => [
                    'uploaded' => 'Berkas harus diunggah.',
                    'max_size' => 'Ukuran berkas terlalu besar (maksimal 2 MB).',
                    'mime_in' => 'Berkas harus berupa file PDF.',
                ],
            ],

            'keterangan'    => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'keterangan harus diisi.',
                ]
            ]
        ];

        $this->validateFile($rules);

        $fileBerkas = $this->request->getFile('berkas');

        $namaBerkas = $fileBerkas->getRandomName();
        $fileBerkas->move('arsip_informasi', $namaBerkas);

        $data = [
            'berkas' => $namaBerkas,
            'keterangan' => $this->request->getVar('keterangan')
        ];

        $this->modelInformasi->save($data);
        session()->setFlashdata('pesan', 'Berkas berhasil ditambahkan');
        return redirect()->to('admin/informasi');
    }

    public function ubahInformasi($id)
    {
        $rules = [
            'berkas' => [
                'rules' => 'uploaded[berkas]|max_size[berkas,2048]|mime_in[berkas,application/pdf]',
                'errors' => [
                    'uploaded' => 'Berkas harus diunggah.',
                    'max_size' => 'Ukuran berkas terlalu besar (maksimal 2 MB).',
                    'mime_in' => 'Berkas harus berupa file PDF.',
                ],
            ],

            'keterangan'    => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'keterangan harus diisi.',
                ]
            ]
        ];

        $this->validateFile($rules);

        $fileBerkas = $this->request->getFile('berkas');
        $berkasLama = $this->request->getVar('berkasLama');

        if ($fileBerkas->getError() == 4) {
            $namaBerkas = $berkasLama;
        } else {
            $namaBerkas = $fileBerkas->getRandomName();
            $fileBerkas->move('arsip_informasi', $namaBerkas);
            if ($berkasLama !== '') {
                unlink('arsip_informasi/' . $berkasLama);
            }
        }

        $data = [
            'id_berkas' => $id,
            'berkas' => $namaBerkas,
            'keterangan' => $this->request->getVar('keterangan')
        ];

        $dataLama = $this->modelInformasi->find($id);

        if (
            $dataLama->berkas == $data['berkas'] &&
            $dataLama->keterangan == $data['keterangan']
        ) {
            session()->setFlashdata('batal', 'tidak ada berkas diubah.');
            return redirect()->to('admin/informasi');
        }

        $this->modelInformasi->save($data);
        session()->setFlashdata('pesan', 'berkas berhasil diubah.');
        return redirect()->to('admin/informasi');
    }

    private function validateFile($rules)
    {
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function hapusInformasi($id)
    {
        $data = $this->modelInformasi->find($id);
        $namaBerkas = $data->berkas;
        unlink('arsip_informasi/' . $namaBerkas);

        $this->modelInformasi->where('id_berkas', $id)->delete();
        session()->setFlashdata('pesan', 'Users berhasil dihapus');
        return redirect()->to('admin/informasi');
    }

    public function daftarQR()
    {

        $currentPageGuru = $this->request->getVar('page_tbl_qrcode_guru') ? $this->request->getVar('page_tbl_qrcode_guru') : 1;
        $currentPageSantri = $this->request->getVar('page_tbl_qrcode_santri') ? $this->request->getVar('page_tbl_qrcode_santri') : 1;

        $tanggalGuru = $this->request->getVar('dateGuru');
        if ($tanggalGuru) {
            $gurus = $this->modelAbsensiGuru->getQRTanggal($tanggalGuru);
        } else {
            $gurus = $this->modelAbsensiGuru->getQR();
        }

        $tanggalSantri = $this->request->getVar('dateSantri');
        if ($tanggalSantri) {
            $santris = $this->modelAbsensiSantri->getQRTanggal($tanggalSantri);
        } else {
            $santris = $this->modelAbsensiSantri->getQR();
        }

        $data = [
            'titleGuru' => 'Data QR Guru',
            'gurus' => $gurus->paginate('10', 'tbl_qrcode_guru'),
            'pagerGuru' => $this->modelAbsensiGuru->pager,
            'currentPageGuru' => $currentPageGuru,

            'titleSantri' => 'Data QR Santri',
            'santris' => $santris->paginate('10', 'tbl_qrcode_santri'),
            'pagerSantri' => $this->modelAbsensiSantri->pager,
            'currentPageSantri' => $currentPageSantri,
        ];

        return view('admin/daftarQR', $data);
    }

    public function cetakQR()
    {
        $entity = $this->request->getVar('entity');
        $tanggal = $this->request->getVar('tanggal');
        if ($tanggal) {
            if ($entity === 'guru') {
                $query = $this->modelAbsensiGuru->getQRTanggal($tanggal)->first();
            } else {
                $query = $this->modelAbsensiSantri->getQRTanggal($tanggal)->first();
            }
        } else {
            $query = '';
        }

        $data = [
            'title' => 'Data QR Guru',
            'absen' => $query,
            'entity' => $entity
        ];

        return view('admin/cetakQR', $data);
    }

    public function generateQR()
    {
        $rules = config('Validation')->registrationRules ?? [
            'tanggal' => [
                'rules' => 'required|valid_date[Y-m-d]',
                'errors' => [
                    'required' => 'Tanggal harus diisi.',
                    'valid_date' => 'Format tanggal tidak valid.',
                ]
            ],

            'jam_masuk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jam masuk harus diisi.',
                ]
            ],

            'jam_keluar' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jam keluar harus diisi.',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $entity = $this->request->getVar('entity');
        $data = [
            'tanggal' => $this->request->getVar('tanggal'),
            'jam_masuk' => $this->request->getVar('jam_masuk'),
            'jam_keluar' => $this->request->getVar('jam_keluar'),
        ];

        if ($entity === 'guru') {
            return redirect()->to(base_url('guru/generateQR'))->with('data', $data);
        } else if ($entity === 'santri') {
            return redirect()->to(base_url('santri/generateQR'))->with('data', $data);
        }
    }

    public function daftarAbsen()
    {
        $keywordGuru = $this->request->getVar('keywordGuru');
        $keywordSantri = $this->request->getVar('keywordSantri');
        if ($keywordGuru) {
            $queryGuru = $this->db->table('tbl_absen_guru')->select('name, nip, tanggal, tbl_absen_guru.jam_masuk, tbl_absen_guru.jam_keluar, keterangan')
                ->join('tbl_guru', 'tbl_guru.id = tbl_absen_guru.guru_id')
                ->join('users', 'users.id = tbl_guru.user_id')
                ->join('tbl_qrcode_guru', 'tbl_qrcode_guru.id = tbl_absen_guru.qr_id')
                ->like('name', $keywordGuru)
                ->orLike('nip', $keywordGuru)
                ->orLike('tanggal', $keywordGuru)
                ->get()->getResultArray();
        } else {
            $queryGuru = $this->db->table('tbl_absen_guru')->select('name, nip, tanggal, tbl_absen_guru.jam_masuk, tbl_absen_guru.jam_keluar, keterangan')
                ->join('tbl_guru', 'tbl_guru.id = tbl_absen_guru.guru_id')
                ->join('users', 'users.id = tbl_guru.user_id')
                ->join('tbl_qrcode_guru', 'tbl_qrcode_guru.id = tbl_absen_guru.qr_id')
                ->get()->getResultArray();
        }

        if ($keywordSantri) {
            $querySantri = $this->db->table('tbl_absen_santri')->select('name, nis, tanggal, tbl_absen_santri.jam_masuk, tbl_absen_santri.jam_keluar, keterangan')
                ->join('tbl_santri', 'tbl_santri.id = tbl_absen_santri.santri_id')
                ->join('users', 'users.id = tbl_santri.user_id')
                ->join('tbl_qrcode_santri', 'tbl_qrcode_santri.id = tbl_absen_santri.qr_id')
                ->like('name', $keywordSantri)
                ->orLike('nis', $keywordSantri)
                ->orLike('tanggal', $keywordSantri)
                ->get()->getResultArray();
        } else {
            $querySantri = $this->db->table('tbl_absen_santri')->select('name, nis, tanggal, tbl_absen_santri.jam_masuk, tbl_absen_santri.jam_keluar, keterangan')
                ->join('tbl_santri', 'tbl_santri.id = tbl_absen_santri.santri_id')
                ->join('users', 'users.id = tbl_santri.user_id')
                ->join('tbl_qrcode_santri', 'tbl_qrcode_santri.id = tbl_absen_santri.qr_id')
                ->get()->getResultArray();
        }

        $data = [
            'titleGuru' => 'Absen Guru',
            'titleSantri' => 'Absen Santri',
            'dataGuru'  => $queryGuru,
            'dataSantri'    => $querySantri
        ];

        return view('admin/daftarAbsen', $data);
    }
}
