<?php

namespace Modules\Admin\Kartu\Controllers;

use Modules\Admin\Kartu\Models\KartuModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class KartuController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $kartuModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();
        $this->kartuModel = new KartuModel($db);

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Data Kartu',
            'pageDesc'  => 'List data kartu'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-kartu' => [
                'url'       => route_to('kartu'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_index', $this->viewData);
    }

    public function add()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-kartu' => [
                'url'       => route_to('kartu'),
                'active'    => false,
            ],
            'tamba-data-kartu' => [
                'url'       => route_to('kartu.add'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_add', $this->viewData);
    }
}