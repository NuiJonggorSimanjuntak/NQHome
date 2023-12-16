<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDokumen;

class Dokumen extends BaseController
{
    protected $modelDokumen;
    public function __construct()
    {
        $this->modelDokumen = new ModelDokumen();
    }
    public function index()
    {
        $currentPage = $this->request->getVar('page_tbl_dokumen') ? $this->request->getVar('page_tbl_dokumen') : 1;

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $query = $this->modelDokumen->getDokumenKeyword($keyword);
        } else {
            $query = $this->modelDokumen->getDokumen();
        }

        $data = [
            'title' => 'Dokumen',
            'data' => $query->paginate('10', 'tbl_dokumen'),
            'pager' => $this->modelDokumen->pager,
            'currentPage' => $currentPage
        ];

        return view('dokumen/index', $data);
    }

    public function simpanDokumen()
    {
        $rules = [
            'nama_dokumen' => [
                'rules' => 'uploaded[nama_dokumen]|max_size[nama_dokumen,2048]|mime_in[nama_dokumen,application/pdf]',
                'errors' => [
                    'uploaded' => 'dokumen harus diunggah.',
                    'max_size' => 'Ukuran dokumen terlalu besar (maksimal 2 MB).',
                    'mime_in' => 'dokumen harus berupa file PDF.',
                ],
            ],

            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'keterangan harus diisi.',
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors_simpan', $this->validator->getErrors());
        }

        $fileBerkas = $this->request->getFile('nama_dokumen');

        $namaBerkas = $fileBerkas->getName();

        $fileBerkas->move('arsip_informasi', $namaBerkas);

        $data = [
            'nama_dokumen' => $namaBerkas,
            'keterangan' => $this->request->getVar('keterangan')
        ];

        $this->modelDokumen->save($data);
        session()->setFlashdata('pesan', 'Dokumen berhasil ditambahkan');
        return redirect()->back();
    }

    public function ubahDokumen($id)
    {
        $rules = [
            'nama_dokumen' => [
                'rules' => 'uploaded[nama_dokumen]|max_size[nama_dokumen,2048]|mime_in[nama_dokumen,application/pdf]',
                'errors' => [
                    'uploaded' => 'dokumen harus diunggah.',
                    'max_size' => 'Ukuran dokumen terlalu besar (maksimal 2 MB).',
                    'mime_in' => 'dokumen harus berupa file PDF.',
                ],
            ],

            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'keterangan harus diisi.',
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors_ubah', $this->validator->getErrors());
        }

        $fileBerkas = $this->request->getFile('nama_dokumen');
        $berkasLama = $this->request->getVar('berkasLama');

        if ($fileBerkas->getError() == 4) {
            $namaBerkas = $berkasLama;
        } else {
            $namaBerkas = $fileBerkas->getName();
            $fileBerkas->move('arsip_informasi', $namaBerkas);
            if ($berkasLama !== '') {
                unlink('arsip_informasi/' . $berkasLama);
            }
        }

        $data = [
            'id' => $id,
            'nama_dokumen' => $namaBerkas,
            'keterangan' => $this->request->getVar('keterangan')
        ];

        $dataLama = $this->modelDokumen->find($id);

        if (
            $dataLama->nama_dokumen == $data['nama_dokumen'] &&
            $dataLama->keterangan == $data['keterangan']
        ) {
            session()->setFlashdata('batal', 'tidak ada berkas diubah.');
            return redirect()->back();
        }

        $this->modelDokumen->save($data);
        session()->setFlashdata('pesan', 'dokumen berhasil diubah.');
        return redirect()->back();
    }

    public function hapusDokumen($id)
    {
        $data = $this->modelDokumen->find($id);
        $namaBerkas = $data->nama_dokumen;
        unlink('arsip_informasi/' . $namaBerkas);

        $this->modelDokumen->where('id', $id)->delete();
        session()->setFlashdata('pesan', 'dokumen berhasil dihapus');
        return redirect()->back();
    }

    public function downloadDokumen($id)
    {
        $data = $this->modelDokumen->find($id);

        return $this->response->download('arsip_informasi/' . $data->nama_dokumen, null);
    }
}
