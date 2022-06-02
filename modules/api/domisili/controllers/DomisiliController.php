<?php

namespace Modules\Api\Lokasikerja\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\Api\Domisili\Models\DomisiliModel;
use Modules\Api\Lokasikerja\Models\LokasikerjaModel;

class LokasikerjaController extends BaseController
{

    private $domisiliModel;

    public function __construct()
    {
        $db = \Config\Database::connect();

        $this->domisiliModel = new DomisiliModel($db);
    }

    public function getData()
    {
        $postData   = $this->request->getPost();
        $data       = $this->domisiliModel->getData($postData);
        $num        = $postData['start'];

        $resData = [];
        foreach ($data as $item) {
            $num++;

            $row    = [];
            $row[]  = "<input type=\"hidden\" value=\"" . $item->id . "\">{$num}.";
            $row[]  = $item->nama ?? '-';
            $row[]  = "<span class=\"label label-info\">" . $item->lat . "</span>";
            $row[]  = "<span class=\"label label-warning\">" . $item->lon . "</span>";
            $row[]  = $item->created_at ?? '-';
            $row[]  = "<div class=\"text-center\">
                            <a onclick=\"javascript:void(0)\" class=\"btn btn-success btn-xs mr-2\"><i class=\"fa fa-info-circle\"></i>&nbsp;Detail</a>
                            <a href=\"" . route_to('lokasi-kerja.edit', $item->id) . "\" class=\"btn btn-info btn-xs mr-2\"><i class=\"fa fa-pencil-square-o\"></i>&nbsp;Edit</a>
                            <button data-lokasi-kerja-id=\"$item->id\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i>&nbsp;Hapus</button>
                        </div>";
            $resData[] = $row;
        }

        return $this->response
            ->setJSON([
                'draw'              => $postData['draw'],
                'recordsTotal'      => $this->domisiliModel->countData(),
                'recordsFiltered'   => $this->domisiliModel->countFilteredData($postData),
                'data'              => $resData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
