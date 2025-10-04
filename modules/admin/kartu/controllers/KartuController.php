<?php

namespace Modules\Admin\Kartu\Controllers;

use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\Admin\Kartu\Models\KartuModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class KartuController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $kartuModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();
        $this->kartuModel = new KartuModel($db);

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Data Kartu',
            'pageDesc'  => 'List data kartu'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-kartu' => [
                'url'       => route_to('kartu'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_index', $this->viewData);
    }

    public function generate()
    {
        $action = $this->request->getGet('action');
        $cardId = $this->request->getGet('cardId');

        $this->viewData['action']   = $action ?? 'add';
        if ($action == 'edit') {
            $pekerjaCard = $this->kartuModel->get((int)$cardId);
            $this->viewData['pekerjaCard'] = $pekerjaCard;
        }
        $this->viewData['listPekerja'] = $this->kartuModel->getPekerjaNoCard();
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-kartu' => [
                'url'       => route_to('kartu'),
                'active'    => false,
            ],
            'generate-kartu' => [
                'url'       => route_to('kartu.generate'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_generate', $this->viewData);
    }

    public function delete($id)
    {
        $card = $this->kartuModel->get($id);
        if (is_null($card)) {
            return $this->response
                ->setJSON([
                    'success'   => false,
                    'message'   => 'Kartu tidak ditemukan!'
                ]);
        }

        $berkas = $this->kartuModel->getBerkas($card->id_berkas);
        if (is_null($berkas)) {
            return $this->response
                ->setJSON([
                    'success'   => false,
                    'message'   => 'Berkas tidak ditemukan!'
                ]);
        }

        $this->kartuModel->delete($id);

        $this->kartuModel->deleteBerkas($berkas->id);
        unlink($berkas->path . '/' . $berkas->filename);

        return $this->response
            ->setJSON([
                'message' => 'Kartu berhasil dihapus!'
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function doGenerate()
    {

    }

    public function cardPreview()
    {

    }

    public function testGenerate()
    {
        $cardFrontPath = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR . 
            'assets' . DIRECTORY_SEPARATOR . 
            'images' . DIRECTORY_SEPARATOR . 
            'card-front2.png';
        $capPath = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR . 
            'assets' . DIRECTORY_SEPARATOR . 
            'images' . DIRECTORY_SEPARATOR . 
            'cap.png';
        $ttdPath = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR . 
            'assets' . DIRECTORY_SEPARATOR . 
            'images' . DIRECTORY_SEPARATOR . 
            'ttd2.png';
        $pasFotoPath = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR . 
            'assets' . DIRECTORY_SEPARATOR . 
            'images' . DIRECTORY_SEPARATOR . 
            'pasfotosample.jpeg';
        $savePath = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR . 
            'kartu' . DIRECTORY_SEPARATOR . 
            'test6.png';
        $resizePath = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR . 
            'resize' . DIRECTORY_SEPARATOR . 
            'res1.png';
        $resizePath2 = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR . 
            'resize' . DIRECTORY_SEPARATOR . 
            'res2.png';
        $resizePath3 = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR . 
            'resize' . DIRECTORY_SEPARATOR . 
            'res3.png';
        $helvetica = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR .
            'assets' . DIRECTORY_SEPARATOR .
            'fonts' . DIRECTORY_SEPARATOR .
            'Helvetica.ttf';
        $helveticaBold = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR .
            'assets' . DIRECTORY_SEPARATOR .
            'fonts' . DIRECTORY_SEPARATOR .
            'Helvetica-Bold.ttf';
        
        // font size
        $regularFz = 7;
        $titleFz = 8;

        // text
        $image = imagecreatefrompng($cardFrontPath);
        $color = imagecolorallocate($image, 0, 0, 0);
        
        // imagettftext($image, 9, 0, imagesx($image)/2, imagesy($image)/2, $color, $helvetica, 'AHMAD JAMIL AL RASYID');
        imagettftext($image, $titleFz, 0, imagesx($image)/2, 58, $color, $helveticaBold, 'AREA LAPAS KELAS I BATU');
        $start = 77;
        imagettftext($image, $regularFz, 0, imagesx($image)/2-60, $start, $color, $helvetica, 'Nama');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+10, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+20, $start, $color, $helveticaBold, 'Ahmad Jamil Al Rasyid');
        $start += 11;
        imagettftext($image, $regularFz, 0, imagesx($image)/2-60, $start, $color, $helvetica, 'NIK');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+10, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+20, $start, $color, $helvetica, '1234567890123456');
        $start += 11;
        imagettftext($image, $regularFz, 0, imagesx($image)/2-60, $start, $color, $helvetica, 'TTL');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+10, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+20, $start, $color, $helvetica, 'Palu, 07 Oktober 1996');
        $start += 11;
        imagettftext($image, $regularFz, 0, imagesx($image)/2-60, $start, $color, $helvetica, 'Alamat');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+10, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+20, $start, $color, $helvetica, 'Jln. Asam 2, Lorong 6');
        $start += 11;
        imagettftext($image, $regularFz, 0, imagesx($image)/2-60, $start, $color, $helvetica, 'Pekerjaan');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+10, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+20, $start, $color, $helvetica, 'SSO Dev');
        $start += 11;
        imagettftext($image, $regularFz, 0, imagesx($image)/2-60, $start, $color, $helvetica, 'Tempat Tinggal');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+10, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+20, $start, $color, $helvetica, 'Gamping Tengah');
        $start += 24;
        imagettftext($image, $regularFz, 0, imagesx($image)/2+20, $start, $color, $helvetica, 'Nusakembangan, 21 Juni 2022');
        $start += 8;
        imagettftext($image, $regularFz, 0, imagesx($image)/2+20, $start, $color, $helvetica, 'Kalapas Kelas I Batu');
        $start += 23;
        imagettftext($image, $regularFz, 0, imagesx($image)/2+30, $start, $color, $helveticaBold, 'JALU YUSWA PANJANG');
        $start += 8;
        imagettftext($image, $regularFz, 0, imagesx($image)/2+30, $start, $color, $helvetica, 'NIP. 197312221998031001');

        // cap
        list($cw, $ch) = getimagesize($capPath);
        $ncap = imagecreatefrompng($capPath);

        $ncw = 106*0.5;
        $nch = 105*0.5;

        $ctc = imagecreatetruecolor($ncw, $nch);
        imagealphablending($ctc, false);
        imagesavealpha($ctc, true);
        imagecolortransparent($ctc, imagecolorallocate($ctc, 0, 0, 0));

        imagecopyresampled($ctc, $ncap, 0, 0, 0, 0, $ncw, $nch, $cw, $ch);

        imagepng($ctc, $resizePath, 9);

        $cap = imagecreatefromstring(file_get_contents($resizePath));
        imagecopy($image, $cap, 323/2, 140, 0, 0, $ncw, $nch);

        // ttd
        list($tw, $th) = getimagesize($ttdPath);
        $nttd = imagecreatefrompng($ttdPath);

        $tcw = imagesx($nttd)*0.6;
        $tch = imagesy($nttd)*0.6;

        $ttc = imagecreatetruecolor($tcw, $tch);
        imagealphablending($ttc, false);
        imagesavealpha($ttc, true);
        imagecolortransparent($ttc, imagecolorallocate($ttc, 0, 0, 0));

        imagecopyresampled($ttc, $nttd, 0, 0, 0, 0, $tcw, $tch, $tw, $th);

        imagepng($ttc, $resizePath2, 9);

        $ttd = imagecreatefromstring(file_get_contents($resizePath2));
        imagecopy($image, $ttd, 323/2, 150, 0, 0, $tcw, $tch);

        // pasFoto
        list($ppw, $pph) = getimagesize($pasFotoPath);
        $npp = imagecreatefromjpeg($pasFotoPath);

        // $nppw = imagesx($npp)*0.15;
        // $npph = imagesy($npp)*0.15;
        $nppw = 65;
        $npph = 95;
        echo $nppw;
        echo "<br>";
        echo $npph;

        $pptc = imagecreatetruecolor($nppw, $npph);
        // imagealphablending($pptc, false);
        // imagesavealpha($pptc, true);
        // imagecolortransparent($pptc, imagecolorallocate($pptc, 0, 0, 0));

        imagecopyresampled($pptc, $npp, 0, 0, 0, 0, $nppw, $npph, $ppw, $pph);

        imagejpeg($pptc, $resizePath3, 100);

        $pp = imagecreatefromstring(file_get_contents($resizePath3));
        imagecopy($image, $pp, 30, imagesy($image)/2-$npph/2+20, 0, 0, $nppw, $npph);
        imagesavealpha($image, true);
        imagepng($image, $savePath, 9);
    }

    public function testGenerate2()
    {
        $cardFrontPath = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR . 
            'assets' . DIRECTORY_SEPARATOR . 
            'images' . DIRECTORY_SEPARATOR . 
            'card-front.png';
        $capPath = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR . 
            'assets' . DIRECTORY_SEPARATOR . 
            'images' . DIRECTORY_SEPARATOR . 
            'cap.png';
        $ttdPath = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR . 
            'assets' . DIRECTORY_SEPARATOR . 
            'images' . DIRECTORY_SEPARATOR . 
            'ttd2.png';
        $pasFotoPath = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR . 
            'assets' . DIRECTORY_SEPARATOR . 
            'images' . DIRECTORY_SEPARATOR . 
            'pasfotosample.jpeg';
        $savePath = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR . 
            'kartu' . DIRECTORY_SEPARATOR . 
            'test7.png';
        // $resizePath = ROOTPATH . DIRECTORY_SEPARATOR .
        //     'public' . DIRECTORY_SEPARATOR . 
        //     'resize' . DIRECTORY_SEPARATOR . 
        //     'res1.png';
        // $resizePath2 = ROOTPATH . DIRECTORY_SEPARATOR .
        //     'public' . DIRECTORY_SEPARATOR . 
        //     'resize' . DIRECTORY_SEPARATOR . 
        //     'res2.png';
        $resizePath3 = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR . 
            'resize' . DIRECTORY_SEPARATOR . 
            'res3.png';
        $helvetica = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR .
            'assets' . DIRECTORY_SEPARATOR .
            'fonts' . DIRECTORY_SEPARATOR .
            'Helvetica.ttf';
        $helveticaBold = ROOTPATH . DIRECTORY_SEPARATOR .
            'public' . DIRECTORY_SEPARATOR .
            'assets' . DIRECTORY_SEPARATOR .
            'fonts' . DIRECTORY_SEPARATOR .
            'Helvetica-Bold.ttf';
        
        //-- font size
        $regularFz = 16;
        $titleFz = 18;

        //-- text
        $image = imagecreatefrompng($cardFrontPath);
        $color = imagecolorallocate($image, 0, 0, 0);
        
        $areaStart = 135;
        imagettftext($image, $titleFz, 0, imagesx($image)/2+30, $areaStart, $color, $helveticaBold, 'AREA LAPAS KELAS I BATU');
        $start = $areaStart + 50;
        imagettftext($image, $regularFz, 0, imagesx($image)/2-160, $start, $color, $helvetica, 'Nama');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+40, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+60, $start, $color, $helveticaBold, 'Ahmad Jamil Al Rasyid');
        $start += 23;
        imagettftext($image, $regularFz, 0, imagesx($image)/2-160, $start, $color, $helvetica, 'NIK');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+40, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+60, $start, $color, $helvetica, '1234567890123456');
        $start += 23;
        imagettftext($image, $regularFz, 0, imagesx($image)/2-160, $start, $color, $helvetica, 'TTL');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+40, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+60, $start, $color, $helvetica, 'Palu, 07 Oktober 1996');
        $start += 23;
        imagettftext($image, $regularFz, 0, imagesx($image)/2-160, $start, $color, $helvetica, 'Alamat');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+40, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+60, $start, $color, $helvetica, 'Jln. Asam 2, Lorong 6');
        $start += 23;
        imagettftext($image, $regularFz, 0, imagesx($image)/2-160, $start, $color, $helvetica, 'Pekerjaan');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+40, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+60, $start, $color, $helvetica, 'SSO Dev');
        $start += 23;
        imagettftext($image, $regularFz, 0, imagesx($image)/2-160, $start, $color, $helvetica, 'Tempat Tinggal');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+40, $start, $color, $helvetica, ':');
        imagettftext($image, $regularFz, 0, imagesx($image)/2+60, $start, $color, $helvetica, 'Gamping Tengah');
        
        $regularFz = 14;
        $start = imagesy($image) - 140;
        imagettftext($image, $regularFz, 0, imagesx($image)/2+60, $start, $color, $helvetica, 'Nusakembangan, 21 Juni 2022');
        $start += 23;
        imagettftext($image, $regularFz, 0, imagesx($image)/2+60, $start, $color, $helvetica, 'Kalapas Kelas I Batu');
        $start = imagesy($image) - 40;
        imagettftext($image, $regularFz, 0, imagesx($image)/2+60, $start, $color, $helveticaBold, 'JALU YUSWA PANJANG');
        $start += 23;
        imagettftext($image, $regularFz, 0, imagesx($image)/2+60, $start, $color, $helvetica, 'NIP. 197312221998031001');

        //-- masa berlaku
        $regularFz = 12;
        $color = imagecolorallocate($image, 255, 0, 0);
        imagettftext($image, $regularFz, 0, 25, $start, $color, $helveticaBold, 'Berlaku sampai 22-06-2023');

        //-- cap
        $cap = imagecreatefromstring(file_get_contents($capPath));
        imagecopy($image, $cap, imagesx($image)/2-20, imagesy($image)-130, 0, 0, imagesx($cap), imagesy($cap));

        //-- ttd
        $ttd = imagecreatefromstring(file_get_contents($ttdPath));
        imagecopy($image, $ttd, imagesx($image)/2+50, imagesy($image)-120, 0, 0, imagesx($ttd), imagesy($ttd));

        //-- pasFoto
        list($ppw, $pph) = getimagesize($pasFotoPath);
        $npp = imagecreatefromjpeg($pasFotoPath);

        $nppw = 65*2;
        $npph = 95*2;

        $pptc = imagecreatetruecolor($nppw, $npph);
        imagecopyresampled($pptc, $npp, 0, 0, 0, 0, $nppw, $npph, $ppw, $pph);

        imagejpeg($pptc, $resizePath3, 100);

        $pp = imagecreatefromstring(file_get_contents($resizePath3));
        imagecopy($image, $pp, 50, imagesy($image)/2-$npph/2+40, 0, 0, $nppw, $npph);

        //-- qrcode
        $qrcode = imagecreatefrompng('https://qrickit.com/api/qr.php?d=yourdata&qrsize=100');
        imagecopy($image, $qrcode, imagesx($image)/2-imagesx($qrcode)/2-90, imagesy($image)/2+100, 0, 0, imagesx($qrcode), imagesy($qrcode));
        imagesavealpha($image, true);

        imagepng($image, $savePath, 9);
    }

    public function phpinfo()
    {
        echo phpinfo();
    }
}