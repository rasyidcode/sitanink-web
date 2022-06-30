<?php

namespace Modules\Api\Berkas\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\Api\Berkas\Models\BerkasModel;

class BerkasController extends BaseController
{

    private $berkasModel;

    public function __construct()
    {
        $db = \Config\Database::connect();

        $this->berkasModel = new BerkasModel($db);
    }

    public function getByPekerjaAndType($pekerjaId, $berkasTypeId)
    {
        $berkas = $this
            ->berkasModel
            ->getByPekerjaAndType(
                (int) $pekerjaId, 
                (int) $berkasTypeId
            );
        
        if (is_null($berkas)) {
            return $this->response
            ->setJSON([
                'success'   => false,
                'message'   => 'Berkas tidak ditemukan!'
            ])
            ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND);
        }

        return $this->response
            ->setJSON([
                'success'   => true,
                'data'      => $berkas
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function deleteByPekerjaAndType($pekerjaId, $berkasTypeId)
    {
        helper('filesystem');

        $berkas         = $this
            ->berkasModel
            ->getByPekerjaAndType(
                (int)$pekerjaId, 
                (int)$berkasTypeId
            );
        
        $deleteMessage  = '';
        $success        = false;

        $successDelete = unlink($berkas->path . DIRECTORY_SEPARATOR . $berkas->filename);
        if ($successDelete) {
            $success = true;
            $deleteMessage = 'Berhasil menghapus berkas!';
            
            $this
                ->berkasModel
                ->delete($berkas->id);
        } else {
            $deleteMessage = 'Gagal menghapus berkas!';
        }
        
        return $this->response
            ->setJSON([
                'success'   => $success,
                'message'   => $deleteMessage
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

}