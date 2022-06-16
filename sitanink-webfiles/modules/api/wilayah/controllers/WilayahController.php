<?php

namespace Modules\Api\Wilayah\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\Api\Wilayah\Models\WilayahModel;

class WilayahController extends BaseController
{

    private $wilayahModel;

    public function __construct()
    {
        $db = \Config\Database::connect();

        $this->wilayahModel = new WilayahModel($db);
    }

    public function getData()
    {
        $postData   = $this->request->getPost();
        $data       = $this->wilayahModel->getData($postData);
        $num        = $postData['start'];

        $resData = [];
        foreach ($data as $item) {
            $num++;

            $row    = [];
            $row[]  = "<input type=\"hidden\" value=\"" . $item->id . "\">{$num}.";
            $row[]  = $item->nama ?? '-';
            $row[]  = $item->lat ?? '-';
            $row[]  = $item->lon ?? '-';
            $row[]  = $item->total_pekerja ?? '-';
            $row[]  = $item->created_at ?? '-';
            $row[]  = "<div class=\"text-center\">
                            <button type=\"button\" data-id=\"$item->id\" class=\"btn btn-success btn-xs mr-2\"><i class=\"fa fa-info-circle\"></i>&nbsp;List Pekerja</button>
                            <button type=\"button\" data-lat=\"$item->lat\" data-lon=\"$item->lon\" class=\"btn btn-info btn-xs mr-2\"><i class=\"fa fa-pencil-square-o\"></i>&nbsp;Lihat Map</a>
                        </div>";
            $resData[] = $row;
        }

        return $this->response
            ->setJSON([
                'draw'              => $postData['draw'],
                'recordsTotal'      => $this->wilayahModel->countData(),
                'recordsFiltered'   => $this->wilayahModel->countFilteredData($postData),
                'data'              => $resData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function getListPekerja($id)
    {
        return $this->response
            ->setJSON([
                'success'   => true,
                'data'      => $this->wilayahModel->getListPekerja((int)$id)
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
