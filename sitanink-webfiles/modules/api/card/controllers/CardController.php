<?php

namespace Modules\Api\Card\Controllers;

use App\Controllers\BaseController;
use App\Exceptions\ApiAccessErrorException;
use App\Libraries\Fpdf;
use Carbon\Carbon;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Paths;
use Modules\Admin\Pekerja\Models\PekerjaModel;
use Modules\Api\Berkas\Models\BerkasModel;
use Modules\Api\Card\Models\CardModel;

class CardController extends BaseController
{

    private $cardModel;
    private $pekerjaModel;
    private $berkasModel;

    public function __construct()
    {
        $db = \Config\Database::connect();

        $this->cardModel = new CardModel($db);
        $this->pekerjaModel = new PekerjaModel();
        $this->berkasModel = new BerkasModel($db);
    }

    public function getData()
    {
        $postData   = $this->request->getPost();
        $data       = $this->cardModel->getData($postData);
        $num        = $postData['start'];

        $resData = [];
        foreach ($data as $item) {
            $num++;

            $row    = [];
            $row[]  = "<input type=\"hidden\" value=\"" . $item->id . "\">{$num}.";
            $row[]  = $item->id ?? '-';
            $row[]  = $item->card_owner ?? '-';
            $row[]  = $item->generated_by ?? '-';
            $row[]  = $item->valid_until ?? '-';
            $row[]  = Carbon::parse($item->valid_until)->diffForHumans(Carbon::now());
            $row[]  = $item->created_at ?? '-';
            $row[]  = "<div class=\"text-center\">
                            <button data-pekerja-name=\"$item->card_owner\" data-card-id=\"$item->id\" type=\"button\" class=\"btn btn-primary btn-xs mr-2\"><i class=\"fa fa-print\"></i>&nbsp;Print</button>
                            <button data-toggle=\"modal\" data-target=\"#modal-show-image\" type=\"button\" data-id-berkas=\"$item->id_berkas\" class=\"btn btn-success btn-xs mr-2\"><i class=\"fa fa-info-circle\"></i>&nbsp;Lihat</button>
                            <a href=\"" . route_to('kartu.generate') . "?action=edit&cardId=$item->id\" class=\"btn btn-info btn-xs mr-2\"><i class=\"fa fa-pencil-square-o\"></i>&nbsp;Edit</a>
                            <button data-card-id=\"$item->id\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i>&nbsp;Hapus</button>
                        </div>";
            $resData[] = $row;
        }

        return $this->response
            ->setJSON([
                'draw'              => $postData['draw'],
                'recordsTotal'      => $this->cardModel->countData(),
                'recordsFiltered'   => $this->cardModel->countFilteredData($postData),
                'data'              => $resData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function generate()
    {
        if (!$this->request->isAJAX()) {
            throw new ApiAccessErrorException(
                message: 'Bad request',
                statusCode: ResponseInterface::HTTP_BAD_REQUEST
            );
        }

        if (!$this->validate(['id_pekerja' => 'required', 'valid_until' => 'required'])) {
            throw new ApiAccessErrorException(
                message: 'Cannot process entity',
                statusCode: ResponseInterface::HTTP_UNPROCESSABLE_ENTITY,
                extras: $this->validator->getErrors()
            );
        }

        $dataPost = $this->request->getPost();

        // check pekerja has pas foto or not
        $pekerja = $this->cardModel->getPasFoto($dataPost['id_pekerja']);
        if (is_null($pekerja)) {
            throw new ApiAccessErrorException(
                message: 'Pas foto tidak ada, silahkan upload terlebih dahulu!',
                statusCode: ResponseInterface::HTTP_BAD_REQUEST
            );
        }

        // check if already generated qr
        if (is_null($pekerja->qr_secret)) {
            throw new ApiAccessErrorException(
                message: 'QR belum digenerate, silahkan generate terlebih dahulu!',
                statusCode: ResponseInterface::HTTP_BAD_REQUEST
            );
        }

        if ($dataPost['action'] !== 'edit' && $dataPost['action'] !== 'add') {
            throw new ApiAccessErrorException(
                message: 'Action not supported!',
                statusCode: ResponseInterface::HTTP_BAD_REQUEST
            );
        }

        $path = new Paths();

        $pubsImagePath = $path->publicImagesDirectory;
        $resizePath = $path->publicResizeDirectory;

        $generateRequest = $dataPost['generate_request'];
        $workingPath = '';
        if ($generateRequest == 'preview') {
            $workingPath = $path->publicPreviewDirectory;
        } else if ($generateRequest == 'save') {
            $workingPath = $path->publicKartuDirectory;
        } else {
            throw new ApiAccessErrorException(
                message: 'Generate request is not recognized!',
                statusCode: ResponseInterface::HTTP_BAD_REQUEST
            );
        }

        $fcPath = $this->generateFrontCard($pubsImagePath, $workingPath, $resizePath, $pekerja, $dataPost['valid_until']);
        $bcPath = $this->generateBackCard($pubsImagePath, $workingPath);

        if ($generateRequest == 'save') {
            $fcFile = new \CodeIgniter\Files\File($fcPath['file_path']);
            $idBerkas = $this->pekerjaModel
                ->insertBerkas([
                    'id_pekerja'    => $pekerja->id,
                    'path'          => $workingPath,
                    'filename'      => $fcPath['filename'],
                    'size_in_mb'    => $fcFile->getSizeByUnit('mb'),
                    'mime'          => $fcFile->getMimeType(),
                    'ext'           => $fcFile->getExtension(),
                    'berkas_type_id'          => 6,
                ]);
            if ($dataPost['action'] === 'edit') {
                $this->cardModel
                    ->update([
                        'card_id'   => $dataPost['card_id'],
                        'id_berkas' => $idBerkas,
                        'generated_by'  => session()->get('user_id'),
                        'valid_until'   => $dataPost['valid_until']
                    ]);
            } else if ($dataPost['action'] === 'add') {
                $this->cardModel
                    ->insert([
                        'id_berkas' => $idBerkas,
                        'generated_by'  => session()->get('user_id'),
                        'valid_until'   => $dataPost['valid_until']
                    ]);
            }
        }

        // remove generated by pekerja nik
        $generateImages = scandir($workingPath);
        if (is_array($generateImages)) {
            foreach ($generateImages as $image) {
                if (is_file($workingPath . '/' . $image) && str_contains($image, $pekerja->nik)) {
                    if ($fcPath['filename'] !== $image) {
                        unlink($workingPath . '/' . $image);
                    }
                }
            }
        }

        // remove generated resize by pekerja nik
        $files = scandir($resizePath);
        if (is_array($files)) {
            foreach ($files as $file) {
                if (is_file($resizePath . '/' . $file) && str_contains($file, $pekerja->nik)) {
                    unlink($resizePath . '/' . $file);
                }
            }
        }

        return $this->response
            ->setJSON([
                'success'       => true,
                'card_front_path' => $fcPath['url_path'],
                'card_front_back' => $bcPath['url_path'],
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function getCard($id)
    {
        $berkas = $this->berkasModel->get((int)$id);

        return $this->response
            ->setJSON([
                'success'   => true,
                'data'  => $berkas
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function print($id)
    {
        $card = $this->cardModel->get($id);
        $fpdf = new Fpdf();
        $fpdf->AddPage();
        $fpdf->SetFont('Arial', 'B', 16);
        $fpdf->Cell(40, 40, $fpdf->Image($card->path . '/' . $card->filename, $fpdf->GetX(), $fpdf->GetY(), 100), 0, 0, 'L', false);
        $fpdf->Cell(40, 40, $fpdf->Image($card->path . '/back-card.png', $fpdf->GetX() - 40, $fpdf->GetY() + 70, 100), 0, 0, 'L', false);
        $fpdf->Output(name: time() . '_' . $card->name . '.pdf');
    }

    public function testGenerateBackCard()
    {
        $configPath = new Paths();

        $cardBackTemplate = $configPath->publicImagesDirectory . '/card-back.png';
        $cardPreviewBackSave = $configPath->publicPreviewDirectory . '/test-back-card.png';

        $image = imagecreatefrompng($cardBackTemplate);

        $color = imagecolorallocate($image, 0, 0, 0);
        $colorRed = imagecolorallocate($image, 255, 0, 0);

        $helvetica = ROOTPATH . '..' . DIRECTORY_SEPARATOR .
            'public_html' . DIRECTORY_SEPARATOR .
            'assets' . DIRECTORY_SEPARATOR .
            'fonts' . DIRECTORY_SEPARATOR .
            'Helvetica.ttf';
        $helveticaBold = ROOTPATH . '..' . DIRECTORY_SEPARATOR .
            'public_html' . DIRECTORY_SEPARATOR .
            'assets' . DIRECTORY_SEPARATOR .
            'fonts' . DIRECTORY_SEPARATOR .
            'Helvetica-Bold.ttf';

        $start = 30;
        $titleFz = 12;
        $bodyFz = 11;

        imagettftext($image, $titleFz, 0, 20, $start, $color, $helveticaBold, 'KETENTUAN PENGGUNAAN KARTU');
        $start += 30;
        imagettftext($image, $bodyFz, 0, 20, $start, $color, $helvetica, '1.');
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'Kartu ini hanya berlaku sesuai dengan identitas yang tercantum pada kartu dan hanya');
        $start += 15;
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'berlaku selama 1 (satu) Tahun yang dapat dilakukan perpanjangan kembali');
        $start += 15;
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'sesuai dengan ketentuan.');
        $start += 20;
        imagettftext($image, $bodyFz, 0, 20, $start, $color, $helvetica, '2.');
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'Apabila kartu hilang untuk segera lapor kepada Lapas Kelas I Batu Nusakambangan.');
        $start += 20;
        imagettftext($image, $bodyFz, 0, 20, $start, $color, $helvetica, '3.');
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'Kartu ini hanya berlaku sebagai surat ijin melaksanakan kerja didalam');
        $start += 15;
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'Pulau Nusakambangan.');
        $start += 20;
        imagettftext($image, $bodyFz, 0, 20, $start, $color, $helvetica, '4.');
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'Dalam hal lain sudah tidak melaksanakan kerja lagi didalam Pulau Nusakambangan');
        $start += 15;
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'untuk mengembalikan kembali kepada Lapas Kelas I Batu Nusakambangan.');
        $start += 20;
        imagettftext($image, $bodyFz, 0, 20, $start, $color, $helvetica, '5.');
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'Bagi Orang yang menemukan kartu ini dimohon untuk mengembalikan');
        $start += 15;
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'ke Lapas kelas I Batu Nusakambangan.');

        $titleFz = 11;
        $start = imagesy($image) - 40;
        imagettftext($image, $titleFz, 0, imagesx($image) / 2 - 10, $start, $colorRed, $helveticaBold, 'KARTU INI ADALAH MILIK');
        $start += 20;
        imagettftext($image, $titleFz, 0, imagesx($image) / 2 - 10, $start, $colorRed, $helveticaBold, 'LAPAS KELAS I BATU NUSAKAMBANGAN');

        imagepng($image, $cardPreviewBackSave, 9);
    }

    private function generateFrontCard(
        string $publicPath,
        string $workingPath,
        string $resizePath,
        object $pekerja,
        string $validUntil
    ): array {
        $cardFrontTemplate = $publicPath . '/card-front.png';
        $capTemplate = $publicPath . '/cap.png';
        $ttdTemplate = $publicPath . '/ttd2.png';

        $cardFrontSave = $workingPath . '/' .
            time() . '_' . $pekerja->nik . '_' . $pekerja->nama . '_front.png';

        $pasFotoResize = $resizePath . '/' .
            time() . '_' . $pekerja->nik . '_' . $pekerja->nama . '_resize.png';
        $helvetica = ROOTPATH . '..' . DIRECTORY_SEPARATOR .
            'public_html' . DIRECTORY_SEPARATOR .
            'assets' . DIRECTORY_SEPARATOR .
            'fonts' . DIRECTORY_SEPARATOR .
            'Helvetica.ttf';
        $helveticaBold = ROOTPATH . '..' . DIRECTORY_SEPARATOR .
            'public_html' . DIRECTORY_SEPARATOR .
            'assets' . DIRECTORY_SEPARATOR .
            'fonts' . DIRECTORY_SEPARATOR .
            'Helvetica-Bold.ttf';

        //-- font size
        $regularFz = 16;
        $titleFz = 18;

        //-- text
        $image = imagecreatefrompng($cardFrontTemplate);
        $color = imagecolorallocate($image, 0, 0, 0);

        $areaStart = 135;
        $dimen = imagettfbbox($titleFz, 0, $helvetica, $pekerja->lokasi_kerja);
        $titleWidth = abs($dimen[4] - $dimen[0]) + 30;
        $titleX = imagesx($image) - $titleWidth;
        imagettftext($image, $titleFz, 0, $titleX, $areaStart, $color, $helveticaBold, $pekerja->lokasi_kerja);
        $start = $areaStart + 50;
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 - 160, $start, $color, $helvetica, 'Nama');
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 40, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 60, $start, $color, $helveticaBold, $pekerja->nama);
        $start += 23;
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 - 160, $start, $color, $helvetica, 'NIK');
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 40, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 60, $start, $color, $helvetica, $pekerja->nik);
        $start += 23;
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 - 160, $start, $color, $helvetica, 'TTL');
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 40, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 60, $start, $color, $helvetica, $pekerja->tempat_lahir . ', ' . $this->convertDate($pekerja->tgl_lahir));
        $start += 23;
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 - 160, $start, $color, $helvetica, 'Alamat');
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 40, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 60, $start, $color, $helvetica, $pekerja->alamat);
        $start += 23;
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 - 160, $start, $color, $helvetica, 'Pekerjaan');
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 40, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 60, $start, $color, $helvetica, $pekerja->pekerjaan);
        $start += 23;
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 - 160, $start, $color, $helvetica, 'Tempat Tinggal');
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 40, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 60, $start, $color, $helvetica, $pekerja->tempat_lahir);

        $regularFz = 14;
        $start = imagesy($image) - 140;
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 60, $start, $color, $helvetica, 'Nusakembangan, 21 Juni 2022');
        $start += 23;
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 60, $start, $color, $helvetica, 'Kalapas Kelas I Batu');
        $start = imagesy($image) - 40;
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 60, $start, $color, $helveticaBold, 'JALU YUSWA PANJANG');
        $start += 23;
        imagettftext($image, $regularFz, 0, imagesx($image) / 2 + 60, $start, $color, $helvetica, 'NIP. 197312221998031001');

        //-- masa berlaku
        $regularFz = 12;
        $color = imagecolorallocate($image, 255, 0, 0);
        imagettftext($image, $regularFz, 0, 25, $start, $color, $helveticaBold, 'Berlaku sampai ' . $this->convertDate($validUntil));

        //-- cap
        $cap = imagecreatefromstring(file_get_contents($capTemplate));
        imagecopy($image, $cap, imagesx($image) / 2 - 20, imagesy($image) - 130, 0, 0, imagesx($cap), imagesy($cap));

        //-- ttd
        $ttd = imagecreatefromstring(file_get_contents($ttdTemplate));
        imagecopy($image, $ttd, imagesx($image) / 2 + 50, imagesy($image) - 120, 0, 0, imagesx($ttd), imagesy($ttd));

        //-- pasFoto
        $pasFotoPath = $pekerja->path . DIRECTORY_SEPARATOR . $pekerja->filename;
        list($ppw, $pph, $pptype) = getimagesize($pasFotoPath);
        $npp = '';
        if ($pptype == IMAGETYPE_JPEG) {
            $npp = imagecreatefromjpeg($pasFotoPath);
        } else if ($pptype == IMAGETYPE_PNG) {
            $npp = imagecreatefrompng($pasFotoPath);
        } else {
            throw new ApiAccessErrorException(
                message: 'Image you uploaded for Foto is not supported',
                statusCode: ResponseInterface::HTTP_BAD_REQUEST
            );
        }

        $nppw = 65 * 2;
        $npph = 95 * 2;

        $pptc = imagecreatetruecolor($nppw, $npph);
        imagecopyresampled($pptc, $npp, 0, 0, 0, 0, $nppw, $npph, $ppw, $pph);

        if ($pptype == IMAGETYPE_JPEG) {
            imagejpeg($pptc, $pasFotoResize, 100);
        } else if ($pptype == IMAGETYPE_PNG) {
            imagepng($pptc, $pasFotoResize, 9);
        }

        $pp = imagecreatefromstring(file_get_contents($pasFotoResize));
        imagecopy($image, $pp, 50, imagesy($image) / 2 - $npph / 2 + 40, 0, 0, $nppw, $npph);

        //-- qrcode
        $qrcode = imagecreatefrompng('https://qrickit.com/api/qr.php?qrsize=100&d=' . $pekerja->qr_secret);
        imagecopy($image, $qrcode, imagesx($image) / 2 - imagesx($qrcode) / 2 - 90, imagesy($image) / 2 + 100, 0, 0, imagesx($qrcode), imagesy($qrcode));
        imagesavealpha($image, true);

        imagepng($image, $cardFrontSave, 9);

        $frontCardFilename = explode('/', $cardFrontSave)[count(explode('/', $cardFrontSave)) - 1];

        return [
            'url_path'  => site_url('preview/' . $frontCardFilename),
            'filename'  => $frontCardFilename,
            'file_path' => $cardFrontSave
        ];
    }

    private function generateBackCard(
        string $publicPath,
        string $workingPath
    ): array {
        $cardBackTemplate = $publicPath . '/card-back.png';
        $cardBackSave = $workingPath . '/back-card.png';

        $image = imagecreatefrompng($cardBackTemplate);

        $color = imagecolorallocate($image, 0, 0, 0);
        $colorRed = imagecolorallocate($image, 255, 0, 0);

        $helvetica = ROOTPATH . '..' . DIRECTORY_SEPARATOR .
            'public_html' . DIRECTORY_SEPARATOR .
            'assets' . DIRECTORY_SEPARATOR .
            'fonts' . DIRECTORY_SEPARATOR .
            'Helvetica.ttf';
        $helveticaBold = ROOTPATH . '..' . DIRECTORY_SEPARATOR .
            'public_html' . DIRECTORY_SEPARATOR .
            'assets' . DIRECTORY_SEPARATOR .
            'fonts' . DIRECTORY_SEPARATOR .
            'Helvetica-Bold.ttf';

        $start = 30;
        $titleFz = 12;
        $bodyFz = 11;

        imagettftext($image, $titleFz, 0, 20, $start, $color, $helveticaBold, 'KETENTUAN PENGGUNAAN KARTU');
        $start += 30;
        imagettftext($image, $bodyFz, 0, 20, $start, $color, $helvetica, '1.');
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'Kartu ini hanya berlaku sesuai dengan identitas yang tercantum pada kartu dan hanya');
        $start += 15;
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'berlaku selama 1 (satu) Tahun yang dapat dilakukan perpanjangan kembali');
        $start += 15;
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'sesuai dengan ketentuan.');
        $start += 20;
        imagettftext($image, $bodyFz, 0, 20, $start, $color, $helvetica, '2.');
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'Apabila kartu hilang untuk segera lapor kepada Lapas Kelas I Batu Nusakambangan.');
        $start += 20;
        imagettftext($image, $bodyFz, 0, 20, $start, $color, $helvetica, '3.');
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'Kartu ini hanya berlaku sebagai surat ijin melaksanakan kerja didalam');
        $start += 15;
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'Pulau Nusakambangan.');
        $start += 20;
        imagettftext($image, $bodyFz, 0, 20, $start, $color, $helvetica, '4.');
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'Dalam hal lain sudah tidak melaksanakan kerja lagi didalam Pulau Nusakambangan');
        $start += 15;
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'untuk mengembalikan kembali kepada Lapas Kelas I Batu Nusakambangan.');
        $start += 20;
        imagettftext($image, $bodyFz, 0, 20, $start, $color, $helvetica, '5.');
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'Bagi Orang yang menemukan kartu ini dimohon untuk mengembalikan');
        $start += 15;
        imagettftext($image, $bodyFz, 0, 40, $start, $color, $helvetica, 'ke Lapas kelas I Batu Nusakambangan.');

        $titleFz = 11;
        $start = imagesy($image) - 40;
        imagettftext($image, $titleFz, 0, imagesx($image) / 2 - 10, $start, $colorRed, $helveticaBold, 'KARTU INI ADALAH MILIK');
        $start += 20;
        imagettftext($image, $titleFz, 0, imagesx($image) / 2 - 10, $start, $colorRed, $helveticaBold, 'LAPAS KELAS I BATU NUSAKAMBANGAN');

        imagepng($image, $cardBackSave, 9);

        $backCardFilename = explode('/', $cardBackSave)[count(explode('/', $cardBackSave)) - 1];
        return [
            'url_path'  => site_url('preview/' . $backCardFilename),
            'filename'  => $backCardFilename,
            'file_path' => $cardBackSave
        ];
    }

    private function convertDate(string $date)
    {
        $dateArr = explode('-', $date);
        if ($dateArr[1] == '01') {
            return $dateArr[2] . ' Januari ' . $dateArr[0];
        } else if ($dateArr[1] == '02') {
            return $dateArr[2] . ' Februari ' . $dateArr[0];
        } else if ($dateArr[1] == '03') {
            return $dateArr[2] . ' Maret ' . $dateArr[0];
        } else if ($dateArr[1] == '04') {
            return $dateArr[2] . ' April ' . $dateArr[0];
        } else if ($dateArr[1] == '05') {
            return $dateArr[2] . ' Mei ' . $dateArr[0];
        } else if ($dateArr[1] == '06') {
            return $dateArr[2] . ' Juni ' . $dateArr[0];
        } else if ($dateArr[1] == '07') {
            return $dateArr[2] . ' Juli ' . $dateArr[0];
        } else if ($dateArr[1] == '08') {
            return $dateArr[2] . ' Agustus ' . $dateArr[0];
        } else if ($dateArr[1] == '09') {
            return $dateArr[2] . ' September ' . $dateArr[0];
        } else if ($dateArr[1] == '10') {
            return $dateArr[2] . ' Oktober ' . $dateArr[0];
        } else if ($dateArr[1] == '11') {
            return $dateArr[2] . ' November ' . $dateArr[0];
        } else if ($dateArr[1] == '12') {
            return $dateArr[2] . ' Desember ' . $dateArr[0];
        }
    }
}
