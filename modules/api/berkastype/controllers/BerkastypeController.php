<?php

namespace Modules\Api\Berkastype\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\Api\Berkastype\Models\BerkastypeModel;

class BerkastypeController extends BaseController
{

    private $berkastypeModel;

    public function __construct()
    {
        $db = \Config\Database::connect();

        $this->berkastypeModel = new BerkastypeModel($db);
    }

    public function getData()
    {
        $postData   = $this->request->getPost();
        $data       = $this->berkastypeModel->getData($postData);
        $num        = $postData['start'];

        $resData = [];
        foreach ($data as $item) {
            $num++;

            $row    = [];
            $row[]  = "<input type=\"hidden\" value=\"" . $item->id . "\">{$num}.";
            $row[]  = $item->name ?? '-';
            $row[]  = $item->created_at ?? '-';
            $row[]  = "<div class=\"text-center\">
                            <a href=\"" . route_to('tipe-berkas.edit', $item->id) . "\" class=\"btn btn-info btn-xs mr-2\"><i class=\"fa fa-pencil-square-o\"></i>&nbsp;Edit</a>
                            <button data-berkastype-id=\"$item->id\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i>&nbsp;Hapus</button>
                        </div>";
            $resData[] = $row;
        }

        return $this->response
            ->setJSON([
                'draw'              => $postData['draw'],
                'recordsTotal'      => $this->berkastypeModel->countData(),
                'recordsFiltered'   => $this->berkastypeModel->countFilteredData($postData),
                'data'              => $resData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
