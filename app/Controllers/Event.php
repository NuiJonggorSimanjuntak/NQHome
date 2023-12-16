<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelEvent;

class Event extends BaseController
{
    protected $modelEvent;

    public function __construct()
    {
        $this->modelEvent = new ModelEvent();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_tbl_event') ? $this->request->getVar('page_tbl_event') : 1;
        $query = $this->modelEvent->getEvent();
        $data = [
            'title' => 'Daftar Event',
            'data' => $query->paginate('10', 'tbl_event'),
            'pager' => $this->modelEvent->pager,
            'currentPage' => $currentPage
        ];

        return view('event/index', $data);
    }

    public function simpanEvent()
    {
        $rules = [
            'judul' => [
                'rules' => 'required|is_unique[tbl_event.judul]',
                'errors' => [
                    'is_unique' => 'tidak boleh sama',
                    'required' => 'judul harus diisi.',
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'deskripsi harus diisi.',
                ]
            ],
            'gambar' => [
                'rules' => 'max_size[gambar,2000]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'is_image' => 'file yang dipilih bukanlah gambar.',
                    'max_size' => 'ukuran gambar terlalu besar. Maksimum 2MB.',
                    'mime_in'  => 'tipe file yang dipilih bukan jpg, jpeg, atau png.',
                ],
            ]


        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors_simpan', $this->validator->getErrors());
        }

        $fileImage = $this->request->getFile('gambar');

        if ($fileImage->getError() == 4) {
            $namaImage = 'default.png';
        } else {
            $namaImage = $fileImage->getName();
            $fileImage->move('event', $namaImage);
        }

        $data = [
            'judul' => $this->request->getVar('judul'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'gambar' => $namaImage,
        ];

        $this->modelEvent->save($data);
        session()->setFlashdata('pesan', 'Event berhasil ditambahkan');
        return redirect()->back();
    }

    public function ubahEvent($id)
    {
        $judulLama = $this->modelEvent->select('judul')->where('id', $id)->get()->getRow();
        $judul = $this->request->getVar('judul');
        
        if ($judul == $judulLama->judul) {
            $ruleJudul = 'required';
        } else {
            $ruleJudul = 'required|is_unique[tbl_event.judul]';
        }
        $rules = [
            'judul' => [
                'rules' => $ruleJudul,
                'errors' => [
                    'required' => 'judul harus diisi.',
                    'is_unique' => 'tidak boleh sama',
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'deskripsi harus diisi.',
                ]
            ],
            'gambar' => [
                'rules' => 'max_size[gambar,2000]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'is_image' => 'file yang dipilih bukanlah gambar.',
                    'max_size' => 'ukuran gambar terlalu besar. Maksimum 2MB.',
                    'mime_in'  => 'tipe file yang dipilih bukan jpg, jpeg, atau png.',
                ],
            ]


        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors_ubah', $this->validator->getErrors());
        }

        $fileImage = $this->request->getFile('gambar');
        $imageLama = $this->request->getVar('gambarLama');

        if ($fileImage->getError() == 4) {
            $namaImage = $imageLama;
        } else {
            $namaImage = $fileImage->getName();
            $fileImage->move('event', $namaImage);
            if ($imageLama !== 'default.png') {
                unlink('event/' . $imageLama);
            }
        }
        

        $data = [
            'id' => $id,
            'judul' => $judul,
            'deskripsi' => $this->request->getVar('deskripsi'),
            'gambar' => $namaImage,
        ];

        $dataLama = $this->modelEvent->find($id);

        if (
            $dataLama['judul'] == $data['judul'] &&
            $dataLama['deskripsi'] == $data['deskripsi'] &&
            $dataLama['gambar'] == $data['gambar']
        ) {
            session()->setFlashdata('batal', 'tidak ada berkas diubah.');
            return redirect()->back();
        }

        $this->modelEvent->save($data);
        session()->setFlashdata('pesan', 'Event berhasil diubah');
        return redirect()->back();
    }

    public function hapusEvent($id)
    {
        $data = $this->modelEvent->find($id);
        $namaGambar = $data['gambar'];
        unlink('event/' . $namaGambar);

        $this->modelEvent->where('id', $id)->delete();
        session()->setFlashdata('pesan', 'event berhasil dihapus');
        return redirect()->back();
    }

    public function updateStatus($id)
    {
        $status = $this->request->getVar('status');

        if ($status == 'on') {
            $status = 1;
        } else {
            $status = 0;
        }
        $data = [
            'id' => $id,
            'status' => $status
        ];

        $this->modelEvent->save($data);
        return redirect()->to('event/dataEvent');
    }
}
