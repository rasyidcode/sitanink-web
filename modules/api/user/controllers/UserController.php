<?php

namespace Modules\Api\User\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\Api\User\Models\UserModel;

class UserController extends BaseController
{

    private $userModel;

    public function __construct()
    {
        $db = \Config\Database::connect();

        $this->userModel = new UserModel($db);
    }

    public function getData()
    {
        $postData   = $this->request->getPost();
        $data       = $this->userModel->getData($postData);
        $num        = $postData['start'];

        $resData = [];
        foreach ($data as $item) {
            $num++;

            $row    = [];
            $row[]  = "<input type=\"hidden\" value=\"" . $item->id . "\">{$num}.";
            $row[]  = $item->username ?? '-';
            $row[]  = $item->email ?? '-';
            $label = '';
            if ($item->level == 'admin') {
                $label = 'success';
            } else if ($item->level == 'reguler') {
                $label = 'info';
            }
            $row[]  = "<span class=\"label label-" . $label . "\">" . $item->level . "</span>";
            $row[]  = $item->last_login ?? '-';
            $row[]  = $item->created_at ?? '-';
            $row[]  = "<div class=\"text-center\">
                            <a href=\"" . route_to('user.change-pass', $item->id) . "\" class=\"btn btn-warning btn-xs mr-2\"><i class=\"fa fa-key\"></i>&nbsp;Ganti Password</a>
                            <a href=\"" . route_to('user.edit', $item->id) . "\" class=\"btn btn-info btn-xs mr-2\"><i class=\"fa fa-pencil-square-o\"></i>&nbsp;Edit</a>
                            <button data-user-id=\"$item->id\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i>&nbsp;Hapus</button>
                        </div>";
            $resData[] = $row;
        }

        return $this->response
            ->setJSON([
                'draw'              => $postData['draw'],
                'recordsTotal'      => $this->userModel->countData(),
                'recordsFiltered'   => $this->userModel->countFilteredData($postData),
                'data'              => $resData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
