<?php

namespace Modules\Api\Card\Controllers;

use App\Controllers\BaseController;
use App\Exceptions\ApiAccessErrorException;
use App\Libraries\Fpdf;
use Carbon\Carbon;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Paths;
use Modules\Admin\Setting\Models\SettingModel;
use Modules\Api\Berkas\Models\BerkasModel;
use Modules\Api\Card\Models\CardModel;
use Modules\Api\Pekerja\Models\PekerjaModel;

class CardController extends BaseController
{

    private $cardModel;
    private $pekerjaModel;
    private $berkasModel;
    private $settingModel;

    public function __construct()
    {
        $db = \Config\Database::connect();

        $this->cardModel = new CardModel($db);
        $this->pekerjaModel = new PekerjaModel($db);
        $this->berkasModel = new BerkasModel($db);
        $this->settingModel = new SettingModel($db);
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
            
            $actions = "
                <div class=\"text-center\">
                    <button data-pekerja-name=\"$item->card_owner\" data-card-id=\"$item->id\" type=\"button\" class=\"btn btn-primary btn-xs mr-2\"><i class=\"fa fa-print\"></i>&nbsp;Print</button>
                    <button data-toggle=\"modal\" data-target=\"#modal-show-image\" type=\"button\" data-id-berkas=\"$item->id_berkas\" class=\"btn btn-success btn-xs mr-2\"><i class=\"fa fa-info-circle\"></i>&nbsp;Lihat</button>
            ";

            if (session()->get('level') === 'admin') {
                $actions .= "
                    <a href=\"" . route_to('kartu.generate') . "?action=edit&cardId=$item->id\" class=\"btn btn-info btn-xs mr-2\"><i class=\"fa fa-pencil-square-o\"></i>&nbsp;Edit</a>
                    <button data-card-id=\"$item->id\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i>&nbsp;Hapus</button>
                ";
            }

            $actions .= "</div>";

            $row[]  = $actions;
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
        $pekerja = $this
            ->pekerjaModel
            ->getDetailWithBerkas($dataPost['id_pekerja'], 1);
        if (is_null($pekerja)) {
            throw new ApiAccessErrorException(
                message: 'Pekerja tidak ditemukan!',
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

        $generateRequest = $dataPost['generate_request'];

        $pubsImagePath = '';
        $resizePath = '';
        $workingPath = '';
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $path = new Paths();

            $pubsImagePath = $path->publicImagesDirectory;
            $resizePath = $path->publicResizeDirectory;

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
        } else {
            $pubsImagePath = ROOTPATH . '..' . DIRECTORY_SEPARATOR .
                'public_html' . DIRECTORY_SEPARATOR .
                'assets' . DIRECTORY_SEPARATOR .
                'images';
            $resizePath = ROOTPATH . '..' . DIRECTORY_SEPARATOR .
                'public_html' . DIRECTORY_SEPARATOR .
                'resize';
            if ($generateRequest == 'preview') {
                $workingPath = ROOTPATH . '..' . DIRECTORY_SEPARATOR .
                    'public_html' . DIRECTORY_SEPARATOR .
                    'preview';
            } else if ($generateRequest == 'save') {
                $workingPath = ROOTPATH . '..' . DIRECTORY_SEPARATOR .
                    'public_html' . DIRECTORY_SEPARATOR .
                    'kartu';
            } else {
                throw new ApiAccessErrorException(
                    message: 'Generate request is not recognized!',
                    statusCode: ResponseInterface::HTTP_BAD_REQUEST
                );
            }
        }

        $fcPath = $this->generateFrontCard($pubsImagePath, $workingPath, $resizePath, $pekerja, $dataPost['valid_until']);
        if (!$fcPath['success']) {
            throw new ApiAccessErrorException(
                message: 'Pas foto tidak ditemukan, silahkan upload terlebih dahulu!',
                statusCode: ResponseInterface::HTTP_BAD_REQUEST
            );
        }
        $bcPath = $this->generateBackCard($pubsImagePath, $workingPath);

        if ($generateRequest == 'save') {
            $fcFile = new \CodeIgniter\Files\File($fcPath['file_path']);
            $idBerkas = $this->berkasModel
                ->create([
                    'id_pekerja'    => $pekerja->id,
                    'path'          => $workingPath,
                    'filename'      => $fcPath['filename'],
                    'size_in_mb'    => $fcFile->getSizeByUnit('mb'),
                    'mime'          => $fcFile->getMimeType(),
                    'ext'           => $fcFile->getExtension(),
                    'berkas_type_id'          => 6,
                ], true);
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
        $ttdTemplate = $publicPath . '/ttd4.png';

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
        $dimen = imagettfbbox($titleFz, 0, $helveticaBold, $pekerja->lokasi_kerja);
        $titleWidth = abs($dimen[4] - $dimen[0]) + 30;
        $titleX = imagesx($image) - $titleWidth;

        $keyX       = imagesx($image) / 2 - 160;
        $dividerX   = imagesx($image) / 2 + 30;
        $valueX     = imagesx($image) / 2 + 50;

        imagettftext($image, $titleFz, 0, $titleX, $areaStart, $color, $helveticaBold, $pekerja->lokasi_kerja);
        $start = $areaStart + 50;

        // max allowed width text
        $maxallowedwidth = imagesx($image) - $valueX;

        imagettftext($image, $regularFz, 0, imagesx($image) / 2 - 160, $start, $color, $helvetica, 'Nama');
        imagettftext($image, $regularFz, 0, $dividerX, $start, $color, $helvetica, ':');
        // auto resize font if text width is bigger
        $namaFz = $regularFz;
        $dimen = imagettfbbox($namaFz, 0, $helveticaBold, $pekerja->nama);
        $namapekerjawidth = abs($dimen[4] - $dimen[0]) + 30;
        if ($namapekerjawidth > $maxallowedwidth) {
            $namaFz = 14;
        }
        imagettftext($image, $namaFz, 0, $valueX, $start, $color, $helveticaBold, $pekerja->nama);
        $start += 23;
        imagettftext($image, $regularFz, 0, $keyX, $start, $color, $helvetica, 'NIK');
        imagettftext($image, $regularFz, 0, $dividerX, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, $valueX, $start, $color, $helvetica, $pekerja->nik);
        $start += 23;
        imagettftext($image, $regularFz, 0, $keyX, $start, $color, $helvetica, 'TTL');
        imagettftext($image, $regularFz, 0, $dividerX, $start, $color, $helvetica, ':');
        // auto resize font if text width is bigger
        $ttlFz = $regularFz;
        $dimen = imagettfbbox($ttlFz, 0, $helveticaBold, $pekerja->tempat_lahir . ', ' . convertDate($pekerja->tgl_lahir));
        $ttlpekerjawidth = abs($dimen[4] - $dimen[0]) + 30;
        if ($ttlpekerjawidth > $maxallowedwidth) {
            $ttlFz = 14;
        }
        imagettftext($image, $ttlFz, 0, $valueX, $start, $color, $helvetica, $pekerja->tempat_lahir . ', ' . convertDate($pekerja->tgl_lahir));
        $start += 23;
        imagettftext($image, $regularFz, 0, $keyX, $start, $color, $helvetica, 'Alamat');
        imagettftext($image, $regularFz, 0, $dividerX, $start, $color, $helvetica, ':');
        // auto resize font if text width is bigger
        $alamatFz = $regularFz;
        $dimen = imagettfbbox($alamatFz, 0, $helveticaBold, $pekerja->alamat);
        $alamatpekerjawidth = abs($dimen[4] - $dimen[0]) + 30;
        if ($alamatpekerjawidth > $maxallowedwidth) {
            $alamatFz = 14;
        }
        $dimen = imagettfbbox($alamatFz, 0, $helveticaBold, $pekerja->alamat);
        $alamatpekerjawidth = abs($dimen[4] - $dimen[0]) + 30;
        if ($alamatpekerjawidth > $maxallowedwidth) {
            $alamatFz = 12;
        }
        $dimen = imagettfbbox($alamatFz, 0, $helveticaBold, $pekerja->alamat);
        $alamatpekerjawidth = abs($dimen[4] - $dimen[0]) + 30;
        if ($alamatpekerjawidth > $maxallowedwidth) {
            $alamatFz = 10;
        }
        $dimen = imagettfbbox($alamatFz, 0, $helveticaBold, $pekerja->alamat);
        $alamatpekerjawidth = abs($dimen[4] - $dimen[0]) + 30;
        if ($alamatpekerjawidth > $maxallowedwidth) {
            $alamatFz = 8;
        }
        imagettftext($image, $alamatFz, 0, $valueX, $start, $color, $helvetica, $pekerja->alamat);
        $start += 23;
        imagettftext($image, $regularFz, 0, $keyX, $start, $color, $helvetica, 'Pekerjaan');
        imagettftext($image, $regularFz, 0, $dividerX, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, $valueX, $start, $color, $helvetica, $pekerja->pekerjaan);
        $start += 23;
        imagettftext($image, $regularFz, 0, $keyX, $start, $color, $helvetica, 'Tempat Tinggal');
        imagettftext($image, $regularFz, 0, $dividerX, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, $valueX, $start, $color, $helvetica, $pekerja->tempat_lahir);

        $regularFz = 14;
        $start = imagesy($image) - 140;

        $namaTempat     = $this->settingModel->getByKey('nama_tempat') ?? '-';
        $jabatanKepala  = $this->settingModel->getByKey('jabatan_kepala') ?? '-';
        $namaKepala     = $this->settingModel->getByKey('nama_kepala') ?? '-';
        $nipKepala      = $this->settingModel->getByKey('nip_kepala') ?? '-';
        $todayDate      = Carbon::now()->format('Y-m-d');

        imagettftext($image, $regularFz, 0, $valueX, $start, $color, $helvetica, $namaTempat->value . ', ' . convertDate((string) $todayDate));
        $start += 23;
        imagettftext($image, $regularFz - 2, 0, $valueX, $start, $color, $helvetica, $jabatanKepala->value);
        $start = imagesy($image) - 40;
        imagettftext($image, $regularFz, 0, $valueX, $start, $color, $helveticaBold, $namaKepala->value);
        $start += 23;
        imagettftext($image, $regularFz, 0, $valueX, $start, $color, $helvetica, 'NIP. ' . $nipKepala->value);

        //-- masa berlaku
        $regularFz = 12;
        $color = imagecolorallocate($image, 255, 0, 0);
        imagettftext($image, $regularFz, 0, 25, $start, $color, $helveticaBold, 'Berlaku sampai ' . convertDate($validUntil));

        //-- cap
        $cap = imagecreatefromstring(file_get_contents($capTemplate));
        imagecopy($image, $cap, imagesx($image) / 2, imagesy($image) - 130, 0, 0, imagesx($cap), imagesy($cap));

        //-- ttd
        $ttd = imagecreatefromstring(file_get_contents($ttdTemplate));
        imagecopy($image, $ttd, imagesx($image) / 2 + 20, imagesy($image) - 180, 0, 0, imagesx($ttd), imagesy($ttd));

        //-- pasFoto
        $pasFotoPath = $pekerja->path . DIRECTORY_SEPARATOR . $pekerja->filename;
        if (!file_exists($pasFotoPath)) {
            return [
                'success'   => false,
                'url_path'  => null,
                'filename'  => null,
                'file_path' => null
            ];
        }
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
        $datasecret = site_url('show-data') . '?qrsecret=' . $pekerja->qr_secret;

        //-- convert to bitly
        $bitlyaccesstoken = 'b43c250fc0107927f5ea902dd1fe75687f74f2fe';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://api-ssl.bitly.com/v4/shorten",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 500,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => json_encode([
                'long_url'  => $datasecret,
                'domain'    => 'bit.ly'
            ]),
            CURLOPT_HTTPHEADER     => array(
                "Authorization: Bearer " . $bitlyaccesstoken,
                "content-type: application/json"
            ),
            // CURLOPT_SSL_VERIFYPEER  => false,
            // CURLOPT_SSL_VERIFYHOST => false
        ));

        $bitlyresponse = curl_exec($curl);
        $err = curl_error($curl);
        if ($err) {
            $datasecret = site_url('show-data') . '?id=' . $pekerja->id;
        } else {
            $bitlyresponse = (array) json_decode($bitlyresponse);
            $datasecret = $bitlyresponse['link'] ?? '';
            if ($datasecret == '') {
                $datasecret = site_url('show-data') . '?id=' . $pekerja->id;
            }
        }

        $qrcode = imagecreatefrompng('https://qrickit.com/api/qr.php?qrsize=100&d=' . $datasecret);
        imagecopy($image, $qrcode, imagesx($image) / 2 - imagesx($qrcode) / 2 - 90, imagesy($image) / 2 + 100, 0, 0, imagesx($qrcode), imagesy($qrcode));
        imagesavealpha($image, true);

        imagepng($image, $cardFrontSave, 9);

        $frontCardFilename = explode('/', $cardFrontSave)[count(explode('/', $cardFrontSave)) - 1];

        return [
            'success'   => true,
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
}
