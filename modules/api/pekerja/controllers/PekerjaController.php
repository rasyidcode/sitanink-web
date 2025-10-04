<?php

namespace Modules\Api\Pekerja\Controllers;

use App\Controllers\BaseController;
use Carbon\Carbon;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\Api\Berkas\Models\BerkasModel;
use Modules\Api\Pekerja\Models\PekerjaModel;

class PekerjaController extends BaseController
{

    private $pekerjaModel;
    private $berkasModel;

    public function __construct()
    {
        $db = \Config\Database::connect();

        $this->pekerjaModel = new PekerjaModel($db);
        $this->berkasModel = new BerkasModel($db);
    }

    public function getData()
    {
        $postData   = $this->request->getPost();
        $data       = $this->pekerjaModel->getData($postData);
        $num        = $postData['start'];

        $resData = [];
        foreach ($data as $item) {
            $num++;

            $row    = [];
            $row[]  = "<input type=\"hidden\" value=\"" . $item->id . "\">{$num}.";
            $row[]  = $item->nik ?? '-';
            $row[]  = $item->nama ?? '-';
            $row[]  = $item->tempat_lahir ?? '-';
            $row[]  = $item->tgl_lahir ?? '-';
            $row[]  = !is_null($item->tgl_lahir) ? Carbon::createFromDate($item->tgl_lahir)->age : '-';
            $row[]  = $item->alamat ?? '-';
            $row[]  = $item->pekerjaan ?? '-';
            $row[]  = $item->lokasi_kerja ?? '-';
            $row[]  = $item->jenis_pekerja ?? '-';
            $row[]  = $item->created_at ?? '-';

            $actions = "
                <div class=\"text-center\">
                    <a 
                        style=\"margin-bottom: 2px; margin-right: 2px;\" 
                        href=\"" . route_to('pekerja.get', $item->id) . "\" 
                        class=\"btn btn-success btn-xs\"><i class=\"fa fa-info-circle\"></i>&nbsp;Detail
                    </a>";
            
            if (session()->get('level') === 'admin') {
                $actions .= "<a style=\"margin-bottom: 2px;\" href=\"" . route_to('pekerja.edit', $item->id) . "\" class=\"btn btn-info btn-xs\"><i class=\"fa fa-pencil-square-o\"></i>&nbsp;Edit</a>
                    <button style=\"margin-bottom: 2px;\" data-pekerja-id=\"$item->id\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i>&nbsp;Hapus</button>";
            }
            $actions .= "</div>";
            
            $row[]  = $actions;
            $resData[] = $row;
        }

        return $this->response
            ->setJSON([
                'draw'              => $postData['draw'],
                'recordsTotal'      => $this->pekerjaModel->countData(),
                'recordsFiltered'   => $this->pekerjaModel->countFilteredData($postData),
                'data'              => $resData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function delete($id)
    {
        $this->pekerjaModel->delete($id);

        return $this->response
            ->setJSON([
                'message' => 'Pekerja terhapus!'
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

}