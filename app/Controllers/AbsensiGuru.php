<?php

namespace App\Controllers;

use App\Models\ModelAbsensiGuru;
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
use Dompdf\Dompdf;
use Dompdf\Options;

class AbsensiGuru extends BaseController
{
    protected $modelAbsensi, $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->modelAbsensi = new ModelAbsensiGuru();
    }

    public function index()
    {
        $query = $this->modelAbsensi->findAll();

        $data = [
            'title' => 'Data QR Guru',
            'users' => $query
        ];

        return view('guru/absensi', $data);
    }

    public function tambahAbsen()
    {
        $query = $this->modelAbsensi->findAll();
        $data = [
            'title' => 'Form Tambah QR Guru',
            'guru_list' => $query
        ];

        session()->setFlashdata('berhasil', 'QR CODE berhasil ditambah');

        return view('guru/tambahAbsen', $data);
    }

    // public function simpanAbsen()
    // {
    //     $rules = config('Validation')->registrationRules ?? [
    //         'tanggal' => [
    //             'rules' => 'required|valid_date[Y-m-d]|is_unique[tbl_qrcode_guru.tanggal]',
    //             'errors' => [
    //                 'required' => 'Tanggal harus diisi.',
    //                 'valid_date' => 'Format tanggal tidak valid.',
    //                 'is_unique' => 'Tanggal sudah ada.'
    //             ]
    //         ],

    //         'jam_masuk' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Jam masuk harus diisi.',
    //             ]
    //         ],

    //         'jam_keluar' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => 'Jam keluar harus diisi.',
    //             ]
    //         ],
    //     ];

    //     if (!$this->validate($rules)) {
    //         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    //     }
    //     date_default_timezone_set('Asia/Jakarta');
    //     $tanggal = $this->request->getVar('tanggal');
    //     $jam_masuk = $this->request->getVar('jam_masuk');
    //     $jam_keluar = $this->request->getVar('jam_keluar');

    //     $writer = new PngWriter();

    //     $qrCode = QrCode::create(base_url('guru/hasilScanGuru/' . $tanggal))
    //         ->setEncoding(new Encoding('UTF-8'))
    //         ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    //         ->setSize(300)
    //         ->setMargin(10)
    //         ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    //         ->setForegroundColor(new Color(0, 0, 0))
    //         ->setBackgroundColor(new Color(255, 255, 255));

    //     $logo = Logo::create('logo.png')
    //         ->setResizeToWidth(30);

    //     $label = Label::create($tanggal)
    //         ->setTextColor(new Color(255, 0, 0));

    //     $result = $writer->write($qrCode, $logo, $label);

    //     $qrcodeDirectory = FCPATH . 'qrcodes';
    //     if (!is_dir($qrcodeDirectory)) {
    //         mkdir($qrcodeDirectory, 0777, true);
    //     }

    //     $qrcodeFilename = 'qrcode_' . $tanggal . '.png';
    //     $qrcodePath = $qrcodeDirectory . '/' . $qrcodeFilename;

    //     try {
    //         $result->saveToFile($qrcodePath);
    //     } catch (Exception $e) {
    //     }

    //     $data = [
    //         'tanggal' => $tanggal,
    //         'jam_masuk' => $jam_masuk,
    //         'jam_keluar' => $jam_keluar,
    //         'qr_code' => $qrcodeFilename,
    //     ];

    //     $this->modelAbsensi->save($data);
    //     session()->setFlashdata('berhasil', 'QR CODE guru berhasil ditambah');
    //     return redirect()->to('guru/absensi');
    // }

    public function simpanAbsen()
    {
        $datesJSON = $this->request->getVar('dates');
        $dates['tanggal'] = json_decode($datesJSON);

        $existingDates = $this->modelAbsensi->whereIn('tanggal', $dates['tanggal'])->findAll();
        if (!empty($existingDates)) {
            session()->setFlashdata('same', 'Tanggal sudah ada');
            return redirect()->to('admin/cetakQR');
        }

        $firstDate = $dates['tanggal'][0];
        $lastDate = $dates['tanggal'][count($dates['tanggal']) - 1];
        $resultString = $firstDate . ' - ' . $lastDate;


        $writer = new PngWriter();
        $qrCode = QrCode::create(base_url('guru/hasilScanGuru/' . $resultString))
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $logo = Logo::create('logo.png')
            ->setResizeToWidth(50);

        $label = Label::create($resultString)
            ->setTextColor(new Color(255, 0, 0));

        $result = $writer->write($qrCode, $logo, $label);

        $qrcodeDirectory = FCPATH . 'qrcodesGuru';
        if (!is_dir($qrcodeDirectory)) {
            mkdir($qrcodeDirectory, 0777, true);
        }

        $qrcodeFilename = 'qrcode_' . $resultString . '.png';
        $qrcodePath = $qrcodeDirectory . '/' . $qrcodeFilename;

        try {
            $result->saveToFile($qrcodePath);
        } catch (Exception $e) {
        }

        foreach ($dates['tanggal'] as $tanggal) {
            $data = [
                'tanggal' => $tanggal,
                'qr_code' => $qrcodeFilename,
            ];
            $this->modelAbsensi->save($data);
        }

        session()->setFlashdata('berhasil', 'QR CODE guru berhasil ditambah');
        // return redirect()->to('guru/absensi');
        return redirect()->back();
    }

    public function hapusAbsen($id)
    {
        $absensi = $this->modelAbsensi->find($id);
        if (!$absensi) {
            session()->setFlashdata('gagal', 'Data absensi tidak ditemukan');
            return redirect()->to('guru/absensi');
        }

        $qrCodeFilename = $absensi['qr_code'];
        $qrcodeDirectory = FCPATH . 'qrcodes';
        $qrcodePath = $qrcodeDirectory . '/' . $qrCodeFilename;

        $this->modelAbsensi->delete($id);

        session()->setFlashdata('berhasil', 'QR CODE guru berhasil dihapus');
        if (file_exists($qrcodePath)) {
            unlink($qrcodePath);
        }


        return redirect()->to('guru/absensi');
    }

    public function scanqr()
    {
        $data = [
            'title' => 'Scan QR Guru'
        ];
        return view('guru/scanqr', $data);
    }

    public function hasilScanGuru($tanggal)
    {
        $guru_id = $this->db->table('tbl_guru')
            ->select('tbl_guru.id as guru_id')
            ->join('users', 'users.id = tbl_guru.user_id')
            ->where('users.id', user()->id)
            ->get()
            ->getRow();

        $query = $this->modelAbsensi->where('tanggal', $tanggal)->first();

        date_default_timezone_set('Asia/Jakarta');

        $jam_masuk = date('H:i:s');
        $jam_keluar = date('H:i:s');

        $jamMasukValid = $this->modelAbsensi->select('jam_masuk')->where('tanggal', $tanggal)->first();
        $jamKeluarValid = $this->modelAbsensi->select('jam_keluar')->where('tanggal', $tanggal)->first();

        date_default_timezone_set('Asia/Jakarta');

        $jamMasukValidObj = DateTime::createFromFormat('H:i:s', $jamMasukValid['jam_masuk']);
        $jamMasukObj = DateTime::createFromFormat('H:i:s', $jam_masuk);

        $jamKeluarValidObj = DateTime::createFromFormat('H:i:s', $jamKeluarValid['jam_keluar']);
        $jamKeluarObj = DateTime::createFromFormat('H:i:s', $jam_masuk);

        $existingEntry = $this->db->table('tbl_absen_guru')
            ->where('guru_id', $guru_id->guru_id)
            ->where('qr_id', $query['id'])
            ->countAllResults();

        if ($jamMasukObj <= $jamMasukValidObj) {

            if ($existingEntry > 0) {
                session()->setFlashdata('gagal', 'Anda sudah melakukan absen masuk silakan absen lagi ketika pulang dijam ' . $jamKeluarValidObj->format('H:i'));
                return redirect()->to('guru/scanqr');
            }
            $data = [
                'jam_masuk' => $jam_masuk,
                'guru_id' => $guru_id->guru_id,
                'qr_id' => $query['id'],
                'keterangan' => "hadir",
            ];

            $this->db->table('tbl_absen_guru')->where('guru_id', $guru_id->guru_id)->insert($data);
            session()->setFlashdata('berhasil', 'Absen masuk berhasil.');
        } elseif ($existingEntry > 0 && $jamKeluarObj > $jamKeluarValidObj) {
            $jamKeluar = $this->db->table('tbl_absen_guru')->select('jam_keluar')
                ->where('qr_id', $query['id'])
                ->where('guru_id', $guru_id->guru_id)
                ->get()->getRow();

            if (empty($jamKeluar->jam_keluar)) {
                $data = [
                    'jam_keluar' => $jam_keluar,
                ];
                $this->db->table('tbl_absen_guru')->where('guru_id', $guru_id->guru_id)->where('qr_id', $query['id'])->update($data);
                session()->setFlashdata('berhasil', 'Absen pulang berhasil.');
            } else {
                session()->setFlashdata('gagal', 'Anda sudah absen pulang.');
                return redirect()->to('guru/scanqr');
            }
        } else {
            session()->setFlashdata('gagal', 'Jam sudah melebihi jam masuk ' . $jamMasukValidObj->format('H:i'));
            return redirect()->to('guru/scanqr');
        }

        return redirect()->to('guru/scanqr');
    }

    public function editAbsen($id)
    {
        $query = $this->modelAbsensi->where('id', $id)->get()->getRow();
        $data = [
            'title' => 'Form Edit QR Guru',
            'guru_list' => $query
        ];

        return view('guru/editAbsen', $data);
    }

    public function updateAbsen($id)
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

        date_default_timezone_set('Asia/Jakarta');
        $tanggal = $this->request->getVar('tanggal');
        $jam_masuk = $this->request->getVar('jam_masuk');
        $jam_keluar = $this->request->getVar('jam_keluar');


        $writer = new PngWriter();

        $qrCode = QrCode::create(base_url('guru/hasilScanGuru/' . $tanggal))
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $logo = Logo::create('logo.png')
            ->setResizeToWidth(50);

        $label = Label::create($tanggal)
            ->setTextColor(new Color(255, 0, 0));

        $result = $writer->write($qrCode, $logo, $label);

        $qrcodeDirectory = FCPATH . 'qrcodes';
        if (!is_dir($qrcodeDirectory)) {
            mkdir($qrcodeDirectory, 0777, true);
        }

        $qrcodeFilename = 'qrcode_' . $tanggal . '.png';
        $qrcodePath = $qrcodeDirectory . '/' . $qrcodeFilename;

        try {
            $result->saveToFile($qrcodePath);
        } catch (Exception $e) {
        }

        $data = [
            'tanggal' => $tanggal,
            'jam_masuk' => date('H:i:s', strtotime($jam_masuk)),
            'jam_keluar' => date('H:i:s', strtotime($jam_keluar)),
            'qr_code' => $qrcodeFilename,
        ];

        $dataLama = $this->modelAbsensi->where('id', $id)->get()->getRow();

        if (
            $dataLama->qr_code === $data['qr_code'] &&
            $dataLama->tanggal === $data['tanggal'] &&
            $dataLama->jam_masuk === $data['jam_masuk'] &&
            $dataLama->jam_keluar == $data['jam_keluar']
        ) {
            session()->setFlashdata('same', 'Tidak ada data absen guru yang diubah');
            return redirect()->route('admin/cetakQR');
        } else {
            $this->modelAbsensi->update($id, $data);
            session()->setFlashdata('berhasil', 'QR CODE guru berhasil diubah');

            return redirect()->to('admin/cetakQR');
        }
    }

    public function printpdf($id)
    {
        $data = $this->modelAbsensi->select('qr_code')->where('id', $id)->get()->getRow();

        $qrcodeDirectory = FCPATH . 'qrcodesGuru' . DIRECTORY_SEPARATOR;
        $qrcodeImagePath = $qrcodeDirectory . $data->qr_code;

        $imageData = base64_encode(file_get_contents($qrcodeImagePath));
        $imageBase64 = 'data:image/png;base64,' . $imageData;

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        $html = '
                    <!DOCTYPE html>
                    <html>
                        <head>
                            <style>
                                .gambar-container {
                                    width: 100%;
                                    text-align: center;
                                }
                                .gambar {
                                    width: 40pc;
                                    height: 40pc;
                                }
                            </style>
                        </head>
                        <body>
                            <div class="gambar-container">
                                <img src="' . $imageBase64 . '" alt="QR Code" class="gambar">
                            </div>
                        </body>
                    </html>
                ';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $pdfFilename = 'QRCode_Guru_' . $id . '.pdf';

        $oldPdfPath = FCPATH . 'printQRCode/' . $pdfFilename;
        if (file_exists($oldPdfPath)) {
            unlink($oldPdfPath);
        }

        $newPdfPath = FCPATH . 'printQRCode/' . $pdfFilename;
        file_put_contents($newPdfPath, $dompdf->output());

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $pdfFilename . '"');
        echo file_get_contents($newPdfPath);

        $pdfPathMessage = 'PDF berhasil dicetak. Lokasi file: ' . $newPdfPath;

        session()->setFlashdata('berhasil', $pdfPathMessage);
        return redirect()->to('admin/daftarQR');
    }

    public function printpdfAll()
    {
        $data = $this->modelAbsensi->select('qr_code')->get()->getResult();

        $qrcodeDirectory = FCPATH . 'qrcodes' . DIRECTORY_SEPARATOR;

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);

        $html = '<!DOCTYPE html>
                <html>
                    <head>
                        <style>
                            .gambar-container {
                                width: 100%;
                                text-align: center;
                            }
                            .gambar {
                                width: 40pc;
                                height: 40pc;
                            }
                        </style>
                    </head>
                    <body>';

        foreach ($data as $row) {
            $qrcodeImagePath = $qrcodeDirectory . $row->qr_code;
            $imageData = base64_encode(file_get_contents($qrcodeImagePath));
            $imageBase64 = 'data:image/png;base64,' . $imageData;

            $html .= '<div class="gambar-container">
                                <img src="' . $imageBase64 . '" alt="QR Code" class="gambar">
                            </div>';
        }

        $html .= '</body>
                </html>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $pdfFilename = 'QRCode_Guru_All.pdf';

        $newPdfPath = FCPATH . 'printQRCode/' . $pdfFilename;
        file_put_contents($newPdfPath, $dompdf->output());

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $pdfFilename . '"');
        echo file_get_contents($newPdfPath);

        $pdfPathMessage = 'PDF berhasil dicetak. Lokasi file: ' . $newPdfPath;

        session()->setFlashdata('berhasil', $pdfPathMessage);
        return redirect()->to('guru/absensi');
    }

    public function generateQR()
    {
        $data = session('data');

        date_default_timezone_set('Asia/Jakarta');
        // $tanggal = $this->request->getVar('tanggal');
        // $jam_masuk = $this->request->getVar('jam_masuk');
        // $jam_keluar = $this->request->getVar('jam_keluar');

        $tanggal = $data['tanggal'];
        $jam_masuk = $data['jam_masuk'];
        $jam_keluar = $data['jam_keluar'];

        $writer = new PngWriter();

        $qrCode = QrCode::create(base_url('guru/hasilScanGuru/' . $tanggal))
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        $logo = Logo::create('logo.png')
            ->setResizeToWidth(50);

        $label = Label::create($tanggal)
            ->setTextColor(new Color(255, 0, 0));

        $result = $writer->write($qrCode, $logo, $label);

        $qrcodeDirectory = FCPATH . 'qrcodesGuru';
        if (!is_dir($qrcodeDirectory)) {
            mkdir($qrcodeDirectory, 0777, true);
        }

        $qrcodeFilename = 'qrcode_' . $tanggal . '.png';
        $qrcodePath = $qrcodeDirectory . '/' . $qrcodeFilename;

        try {
            $result->saveToFile($qrcodePath);
        } catch (Exception $e) {
        }

        $data = [
            'tanggal' => $tanggal,
            'jam_masuk' => date('H:i:s', strtotime($jam_masuk)),
            'jam_keluar' => date('H:i:s', strtotime($jam_keluar)),
            'qr_code' => $qrcodeFilename,
        ];

        $dataLama = $this->modelAbsensi->where('tanggal', $tanggal)->get()->getRow();
        // dd($data, $dataLama);

        if (
            $dataLama->tanggal === $data['tanggal'] &&
            $dataLama->jam_masuk === $data['jam_masuk'] &&
            $dataLama->jam_keluar == $data['jam_keluar']
        ) {
            session()->setFlashdata('same', 'Tidak ada data absen guru yang diubah');
            return redirect()->route('admin/cetakQR');
        } else {
            $this->db->table('tbl_qrcode_guru')->where('tanggal', $tanggal)->update($data);
            session()->setFlashdata('berhasil', 'QR CODE guru berhasil diubah');

            return redirect()->route('admin/cetakQR');
        }
    }
}
