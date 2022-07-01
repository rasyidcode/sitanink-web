<?php

namespace Modules\Api\Sk\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\Api\Sk\Models\SkModel;

class SkController extends BaseController
{

    private $skModel;

    public function __construct()
    {
        $db = \Config\Database::connect();

        $this->skModel = new SkModel($db);
    }

    public function getData()
    {
        $postData   = $this->request->getPost();
        $data       = $this->skModel->getData($postData);
        $num        = $postData['start'];

        $resData = [];
        foreach ($data as $item) {
            $num++;

            $row    = [];
            $row[]  = "<input type=\"hidden\" value=\"" . $item->id . "\">{$num}.";
            $row[]  = $item->number ?? '-';
            $row[]  = $item->year ?? '-';
            $row[]  = $item->valid_until ?? '-';
            $row[]  = $item->set_date ?? '-';
            $row[]  = $item->boss_nip ?? '-';
            $row[]  = $item->boss_name ?? '-';
            $row[]  = $item->created_at ?? '-';
            $row[]  = "<div class=\"text-center\">
                            <a href=\"" . route_to('sk.download', $item->id) . "\" class=\"btn btn-warning btn-xs mr-2\"><i class=\"fa fa-download\"></i>&nbsp;Download SK</a>
                            <a href=\"" . route_to('sk.lampiran', $item->id) . "\" class=\"btn btn-success btn-xs mr-2\"><i class=\"fa fa-file\"></i>&nbsp;Lihat Lampiran</a>
                            <a href=\"" . route_to('sk.edit', $item->id) . "\" class=\"btn btn-info btn-xs mr-2\"><i class=\"fa fa-pencil-square-o\"></i>&nbsp;Edit</a>
                            <button data-domisili-id=\"$item->id\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i>&nbsp;Hapus</button>
                        </div>";
            $resData[] = $row;
        }

        return $this->response
            ->setJSON([
                'draw'              => $postData['draw'],
                'recordsTotal'      => $this->skModel->countData(),
                'recordsFiltered'   => $this->skModel->countFilteredData($postData),
                'data'              => $resData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
