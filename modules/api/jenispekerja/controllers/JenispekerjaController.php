<?php

namespace Modules\Api\Jenispekerja\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\Api\Jenispekerja\Models\JenispekerjaModel;

class JenispekerjaController extends BaseController
{

    private $jenispekerjaModel;

    public function __construct()
    {
        $db = \Config\Database::connect();

        $this->jenispekerjaModel = new JenispekerjaModel($db);
    }

    public function getData()
    {
        $postData   = $this->request->getPost();
        $data       = $this->jenispekerjaModel->getData($postData);
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
                            <a href=\"" . route_to('jenis-pekerja.edit', $item->id) . "\" class=\"btn btn-info btn-xs mr-2\"><i class=\"fa fa-pencil-square-o\"></i>&nbsp;Edit</a>
                            <button data-jenis-pekerja-id=\"$item->id\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i>&nbsp;Hapus</button>
                        </div>";
            $resData[] = $row;
        }

        return $this->response
            ->setJSON([
                'draw'              => $postData['draw'],
                'recordsTotal'      => $this->jenispekerjaModel->countData(),
                'recordsFiltered'   => $this->jenispekerjaModel->countFilteredData($postData),
                'data'              => $resData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
