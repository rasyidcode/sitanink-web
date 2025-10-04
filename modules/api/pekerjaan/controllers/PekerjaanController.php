<?php

namespace Modules\Api\Pekerjaan\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\Api\Pekerjaan\Models\PekerjaanModel;

class PekerjaanController extends BaseController
{

    private $pekerjaanModel;

    public function __construct()
    {
        $db = \Config\Database::connect();

        $this->pekerjaanModel = new PekerjaanModel($db);
    }

    public function getData()
    {
        $postData   = $this->request->getPost();
        $data       = $this->pekerjaanModel->getData($postData);
        $num        = $postData['start'];

        $resData = [];
        foreach ($data as $item) {
            $num++;

            $row    = [];
            $row[]  = "<input type=\"hidden\" value=\"" . $item->id . "\">{$num}.";
            $row[]  = $item->nama ?? '-';
            $row[]  = $item->created_at ?? '-';
            $row[]  = "<div class=\"text-center\">
                            <!--<a onclick=\"javascript:void(0)\" class=\"btn btn-success btn-xs mr-2\"><i class=\"fa fa-info-circle\"></i>&nbsp;Detail</a>-->
                            <a href=\"" . route_to('pekerjaan.edit', $item->id) . "\" class=\"btn btn-info btn-xs mr-2\"><i class=\"fa fa-pencil-square-o\"></i>&nbsp;Edit</a>
                            <button data-pekerjaan-id=\"$item->id\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i>&nbsp;Hapus</button>
                        </div>";
            $resData[] = $row;
        }

        return $this->response
            ->setJSON([
                'draw'              => $postData['draw'],
                'recordsTotal'      => $this->pekerjaanModel->countData(),
                'recordsFiltered'   => $this->pekerjaanModel->countFilteredData($postData),
                'data'              => $resData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
