<?php

namespace Modules\Admin\Sk\Controllers;

use Modules\Admin\Pekerja\Models\PekerjaModel;
use Modules\Admin\Sk\Models\SkModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class SkController extends BaseWebController
{

    protected $viewPath = __DIR__;

    /**
     * @var SkModel
     */
    private $skModel;

    /**
     * @var PekerjaModel
     */
    private $pekerjaModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();

        $this->skModel = new SkModel($db);
        $this->pekerjaModel = new PekerjaModel($db);

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Data SK',
            'pageDesc'  => 'Halaman manajemen data SK'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-sk' => [
                'url'       => route_to('sk'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_index', $this->viewData);
    }

    public function create()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-sk' => [
                'url'       => route_to('sk'),
                'active'    => false,
            ],
            'buat-sk' => [
                'url'       => route_to('sk.create'),
                'active'    => true,
            ],
        ];
        $this->viewData['listPekerja'] = $this->pekerjaModel->getListPekerjaForSK();

        return $this->renderView('v_create', $this->viewData);
    }

    public function doCreate()
    {
        print_r($this->request->getPost());
    }

}