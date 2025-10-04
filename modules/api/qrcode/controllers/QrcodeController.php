<?php

namespace Modules\Api\Qrcode\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\Api\Qrcode\Models\QrcodeModel;

class QrcodeController extends BaseController
{

    private $qrcodeModel;

    public function __construct()
    {
        $db = \Config\Database::connect();

        $this->qrcodeModel = new QrcodeModel($db);
    }

    public function getData()
    {
        $postData   = $this->request->getPost();
        $data       = $this->qrcodeModel->getData($postData);
        $num        = $postData['start'];

        $resData = [];
        foreach ($data as $item) {
            $num++;

            $row    = [];
            $row[]  = "<input type=\"hidden\" value=\"" . $item->id . "\">{$num}.";
            $row[]  = $item->nik ?? '-';
            $row[]  = $item->nama ?? '-';
            $row[]  = is_null($item->qr_secret) ? '<label class="label label-danger">Belum<label>' : '<label class="label label-success">Sudah<label>';
            $row[]  = "<div class=\"text-center\">
                            <button type=\"button\" data-id=\"$item->id\" data-qrsecret=\"$item->qr_secret\" class=\"btn btn-success btn-xs mr-2\" ".(is_null($item->qr_secret) ? 'disabled' : '')."><i class=\"fa fa-info-circle\"></i>&nbsp;Lihat</button>
                            <button type=\"button\" data-id=\"$item->id\" class=\"btn btn-primary btn-xs mr-2\" ".(!is_null($item->qr_secret) ? 'disabled' : '')."><i class=\"ion ion-gear-a\"></i>&nbsp;Generate</button>
                        </div>";
            $resData[] = $row;
        }

        return $this->response
            ->setJSON([
                'draw'              => $postData['draw'],
                'recordsTotal'      => $this->qrcodeModel->countData(),
                'recordsFiltered'   => $this->qrcodeModel->countFilteredData($postData),
                'data'              => $resData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function generate($id)
    {
        $this->qrcodeModel->generate($id);

        return $this->response
            ->setJSON([
                'success'   => true,
                'message'   => 'QRCode generated!'
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
