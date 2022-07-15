<?php

namespace Modules\Pub\Showdata\Controllers;

use Modules\Admin\Pekerja\Models\PekerjaModel;
use Modules\Pub\Showdata\Models\ShowdataModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class ShowdataController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $showdataModel;

    private $pekerjaModel;

    public function __construct()
    {
        parent::__construct();
        $db = \Config\Database::connect();

        $this->showdataModel = new ShowdataModel();
        $this->pekerjaModel = new PekerjaModel($db);
    }

    public function index()
    {
        $qrsecret = $this->request->getGet('qrsecret');
        $pekerjaId = null;
        if (!$qrsecret) {
            $pekerjaId = $this->request->getGet('id');
            if (!$pekerjaId) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Nothing here');
            }

            $qrsecret = null;
        }

        $data = null;
        if (!is_null($qrsecret)) {
            $data = $this->pekerjaModel->getDetailWithBerkasByQR($qrsecret, 1);
        }

        if (!is_null($pekerjaId)) {
            $data = $this->pekerjaModel->getDetailWithBerkasById($pekerjaId, 1);
        }
        
        if (is_null($data)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data not found!');
        }

        return $this->renderView('v_index', [
            'data'  => $data
        ]);
    }
}
