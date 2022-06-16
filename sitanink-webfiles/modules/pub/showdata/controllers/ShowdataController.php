<?php

namespace Modules\Pub\Showdata\Controllers;

use Modules\Pub\Showdata\Models\ShowdataModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class ShowdataController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $showdataModel;

    public function __construct()
    {
        parent::__construct();

        $this->showdataModel = new ShowdataModel();
    }

    public function index()
    {
        $qrsecret = $this->request->getGet('qrsecret');
        if (!$qrsecret) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Nothing here');
        }

        $data = $this->showdataModel->getDataPekerja($qrsecret);
        if (is_null($data)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data not found!');
        }

        return $this->renderView('v_index', [
            'data'  => $data
        ]);
    }
}
