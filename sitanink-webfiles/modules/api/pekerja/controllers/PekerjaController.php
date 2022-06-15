<?php

namespace Modules\Api\Pekerja\Controllers;

use App\Controllers\BaseController;
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
            $row[]  = $item->ttl ?? '-';
            $row[]  = $item->alamat ?? '-';
            $row[]  = $item->pekerjaan ?? '-';
            $row[]  = $item->lokasi_kerja ?? '-';
            $row[]  = $item->jenis_pekerja ?? '-';
            $row[]  = $item->created_at ?? '-';
            $row[]  = "<div class=\"text-center\">
                            <a style=\"margin-bottom: 2px;\" href=\"" . route_to('pekerja.get', $item->id) . "\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-info-circle\"></i>&nbsp;Detail</a>
                            <a style=\"margin-bottom: 2px;\" href=\"" . route_to('pekerja.edit', $item->id) . "\" class=\"btn btn-info btn-xs\"><i class=\"fa fa-pencil-square-o\"></i>&nbsp;Edit</a>
                            <button style=\"margin-bottom: 2px;\" data-pekerja-id=\"$item->id\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i>&nbsp;Hapus</button>
                        </div>";
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

    public function getBerkas($id)
    {
        $tipe = $this->request->getGet('tipe');
        $berkas = $this->pekerjaModel->getBerkas($id, $tipe);
        return $this->response
            ->setJSON([
                'data'  => $berkas
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function deleteBerkas($id)
    {
        helper('filesystem');

        $tipe           = $this->request->getGet('tipe');
        $berkas         = $this->pekerjaModel->getBerkas($id, $tipe ?? null);
        $deleteMessage  = '';
        $success        = false;

        if (!is_array($berkas)) {
            $successDelete = unlink($berkas->path . DIRECTORY_SEPARATOR . $berkas->filename);
            if ($successDelete) {
                $success = true;
                $deleteMessage = 'Berhasil menghapus berkas!';
                $this->berkasModel->delete($berkas->id);
            } else {
                $deleteMessage = 'Gagal menghapus berkas dengan tipe ['.$tipe.'] !';
            }
        } else {
            // $this->pekerjaModel->deleteBerkas($id);
            $deleteMessage = 'Belum support hapus beberapa berkas!';
            $success = false;
        }
        
        return $this->response
            ->setJSON([
                'success'   => $success,
                'message'   => $deleteMessage
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

}