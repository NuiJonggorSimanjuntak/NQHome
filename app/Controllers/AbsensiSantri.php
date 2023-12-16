<?php

namespace App\Controllers;

use App\Models\ModelAbsensiSantri;
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

class AbsensiSantri extends BaseController
{
    protected $modelAbsensi, $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->modelAbsensi = new ModelAbsensiSantri();
    }

    public function index()
    {
        $currentPage = $this->request->getVar('page_tbl_qrcode_santri') ? $this->request->getVar('page_tbl_qrcode_santri') : 1;
        $query = $this->modelAbsensi
            ->orderBy('tanggal');

        $data = [
            'title' => 'Data QR Santri',
            'users' => $query->paginate('10', 'tbl_qrcode_santri'),
            'pager' => $this->modelAbsensi->pager,
            'currentPage' => $currentPage
        ];

        return view('santri/absensi', $data);
    }

    // public function tambahAbsen()
    // {
    //     $query = $this->modelAbsensi->findAll();
    //     $data = [
    //         'title' => 'Form Tambah QR Santri',
    //         'santri_list' => $query
    //     ];

    //     session()->setFlashdata('berhasil', 'QR CODE berhasil ditambah');

    //     return view('santri/tambahAbsen', $data);
    // }

    // public function simpanAbsen()
    // {
    //     $rules = config('Validation')->registrationRules ?? [
    //         'tanggal' => [
    //             'rules' => 'required|valid_date[Y-m-d]|is_unique[tbl_qrcode_santri.tanggal]',
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

    //     $qrCode = QrCode::create(base_url('santri/hasilScanSantri/' . $tanggal))
    //         ->setEncoding(new Encoding('UTF-8'))
    //         ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    //         ->setSize(300)
    //         ->setMargin(10)
    //         ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    //         ->setForegroundColor(new Color(0, 0, 0))
    //         ->setBackgroundColor(new Color(255, 255, 255));

    //     $logo = Logo::create('logo.png')
    //         ->setResizeToWidth(50);

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
    //     session()->setFlashdata('berhasil', 'QR CODE santri berhasil ditambah');
    //     return redirect()->to('santri/absensi');
    // }

    public function simpanAbsen()
    {
        // dd('hello');
        $datesJSON = $this->request->getVar('dates');
        $dates['tanggal'] = json_decode($datesJSON);
        // dd($dates['tanggal']);

        $existingDates = $this->modelAbsensi->whereIn('tanggal', $dates['tanggal'])->findAll();
        if (!empty($existingDates)) {
            session()->setFlashdata('same', 'Tanggal sudah ada');
            return redirect()->to('admin/cetakQR');
        }

        $firstDate = $dates['tanggal'][0];
        $lastDate = $dates['tanggal'][count($dates['tanggal']) - 1];
        $resultString = $firstDate . ' - ' . $lastDate;


        $writer = new PngWriter();
        $qrCode = QrCode::create(base_url('santri/hasilScanSantri/' . $resultString))
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

        $qrcodeDirectory = FCPATH . 'qrcodesSantri';
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

        session()->setFlashdata('berhasil', 'QR CODE santri berhasil ditambah');
        return redirect()->to('admin/cetakQR');
    }

    // public function hapusAbsen($id)
    // {
    //     $absensi = $this->modelAbsensi->find($id);
    //     if (!$absensi) {
    //         session()->setFlashdata('gagal', 'Data absensi tidak ditemukan');
    //         return redirect()->to('santri/absensi');
    //     }

    //     $qrCodeFilename = $absensi['qr_code'];
    //     $qrcodeDirectory = FCPATH . 'qrcodes';
    //     $qrcodePath = $qrcodeDirectory . '/' . $qrCodeFilename;

    //     $this->modelAbsensi->delete($id);

    //     session()->setFlashdata('berhasil', 'QR CODE santri berhasil dihapus');
    //     if (file_exists($qrcodePath)) {
    //         unlink($qrcodePath);
    //     }


    //     return redirect()->to('santri/absensi');
    // }

    public function scanqr()
    {
        $data = [
            'title' => 'Scan QR Santri'
        ];
        return view('santri/scanqr', $data);
    }

    public function hasilScanSantri($tanggal)
    {
        $santri_id = $this->db->table('tbl_santri')
            ->select('tbl_santri.id as santri_id')
            ->join('users', 'users.id = tbl_santri.user_id')
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
        $jamKeluarObj = DateTime::createFromFormat('H:i:s', $jam_keluar);

        $existingEntry = $this->db->table('tbl_absen_santri')
            ->where('santri_id', $santri_id->santri_id)
            ->where('qr_id', $query['id'])
            ->countAllResults();

        if ($jamMasukObj <= $jamMasukValidObj) {

            if ($existingEntry > 0) {
                session()->setFlashdata('gagal', 'Anda sudah melakukan absen masuk silakan absen lagi ketika pulang dijam ' . $jamKeluarValidObj->format('H:i'));
                return redirect()->to('santri/scanqr');
            }
            $data = [
                'jam_masuk' => $jam_masuk,
                'santri_id' => $santri_id->santri_id,
                'qr_id' => $query['id'],
                'keterangan' => "hadir",
            ];

            $this->db->table('tbl_absen_santri')->where('santri_id', $santri_id->santri_id)->insert($data);
            session()->setFlashdata('berhasil', 'Absen masuk berhasil.');
        } elseif ($existingEntry > 0 && $jamKeluarObj > $jamKeluarValidObj) {
            $jamKeluar = $this->db->table('tbl_absen_santri')->select('jam_keluar')
                ->where('qr_id', $query['id'])
                ->where('santri_id', $santri_id->santri_id)
                ->get()->getRow();

            if (empty($jamKeluar->jam_keluar)) {
                $data = [
                    'jam_keluar' => $jam_keluar,
                ];
                $this->db->table('tbl_absen_santri')->where('santri_id', $santri_id->santri_id)->where('qr_id', $query['id'])->update($data);
                session()->setFlashdata('berhasil', 'Absen pulang berhasil.');
            } else {
                session()->setFlashdata('gagal', 'Anda sudah absen pulang.');
                return redirect()->to('santri/scanqr');
            }
        } else {
            session()->setFlashdata('gagal', 'Jam sudah melebihi jam masuk ' . $jamMasukValidObj->format('H:i'));
            return redirect()->to('santri/scanqr');
        }

        return redirect()->to('santri/scanqr');
    }

    // public function editAbsen($id)
    // {
    //     $query = $this->modelAbsensi->where('id', $id)->get()->getRow();
    //     $data = [
    //         'title' => 'Form Edit QR Santri',
    //         'santri_list' => $query
    //     ];

    //     return view('santri/editAbsen', $data);
    // }

    // public function updateAbsen($id)
    // {
    //     $rules = config('Validation')->registrationRules ?? [
    //         'tanggal' => [
    //             'rules' => 'required|valid_date[Y-m-d]',
    //             'errors' => [
    //                 'required' => 'Tanggal harus diisi.',
    //                 'valid_date' => 'Format tanggal tidak valid.',
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

    //     $qrCode = QrCode::create(base_url('santri/hasilScanSantri/' . $tanggal))
    //         ->setEncoding(new Encoding('UTF-8'))
    //         ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    //         ->setSize(300)
    //         ->setMargin(10)
    //         ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    //         ->setForegroundColor(new Color(0, 0, 0))
    //         ->setBackgroundColor(new Color(255, 255, 255));

    //     $logo = Logo::create('logo.png')
    //         ->setResizeToWidth(50);

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
    //         'jam_masuk' => date('H:i:s', strtotime($jam_masuk)),
    //         'jam_keluar' => date('H:i:s', strtotime($jam_keluar)),
    //         'qr_code' => $qrcodeFilename,
    //     ];

    //     $dataLama = $this->modelAbsensi->where('id', $id)->get()->getRow();

    //     if (
    //         $dataLama->tanggal === $data['tanggal'] &&
    //         $dataLama->jam_masuk === $data['jam_masuk'] &&
    //         $dataLama->jam_keluar == $data['jam_keluar']
    //     ) {
    //         session()->setFlashdata('same', 'Tidak ada data absen santri yang diubah');
    //         return redirect()->route('santri/absensi');
    //     } else {
    //         $this->modelAbsensi->update($id, $data);
    //         session()->setFlashdata('berhasil', 'QR CODE santri berhasil diubah');

    //         return redirect()->to('santri/absensi');
    //     }
    // }

    public function printpdf($id)
    {
        $data = $this->modelAbsensi->select('qr_code, tanggal')->where('id', $id)->get()->getRow();
        // dd($data->tanggal);

        $qrcodeDirectory = FCPATH . 'qrcodesSantri' . DIRECTORY_SEPARATOR;
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

        $pdfFilename = 'QRCode_Santri_' . $data->tanggal . '.pdf';

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

        if ($data != null) {
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

            $pdfFilename = 'QRCode_Santri_All.pdf';

            $newPdfPath = FCPATH . 'printQRCode/' . $pdfFilename;
            file_put_contents($newPdfPath, $dompdf->output());

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $pdfFilename . '"');
            echo file_get_contents($newPdfPath);

            $pdfPathMessage = 'PDF berhasil dicetak. Lokasi file: ' . $newPdfPath;

            session()->setFlashdata('berhasil', $pdfPathMessage);
            return redirect()->to('santri/absensi');
        } else {
            session()->setFlashdata('empty', 'Data kosong');
            return redirect()->back();
        }
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

        $qrCode = QrCode::create(base_url('santri/hasilScanSantri/' . $tanggal))
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

        $qrcodeDirectory = FCPATH . 'qrcodesSantri';
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

        if (
            $dataLama->tanggal === $data['tanggal'] &&
            $dataLama->jam_masuk === $data['jam_masuk'] &&
            $dataLama->jam_keluar == $data['jam_keluar']
        ) {
            session()->setFlashdata('same', 'Tidak ada data absen santri yang diubah');
            return redirect()->route('admin/cetakQR');
        } else {
            $this->db->table('tbl_qrcode_santri')->where('tanggal', $tanggal)->update($data);
            session()->setFlashdata('berhasil', 'QR CODE santri berhasil diubah');

            // return redirect()->to('santri/absensi');
            return redirect()->route('admin/cetakQR');
        }
    }
}
