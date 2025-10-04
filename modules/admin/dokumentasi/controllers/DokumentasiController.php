<?php

namespace Modules\Admin\Dokumentasi\Controllers;

use Modules\Shared\Core\Controllers\BaseWebController;

class DokumentasiController extends BaseWebController
{

    protected $viewPath = __DIR__;

    public function __construct()
    {
        parent::__construct();

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Dokumentasi',
            'pageDesc'  => 'Halaman dokumentasi penggunaan'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'dokumentasi' => [
                'url'       => route_to('dokumentasi'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_index', $this->viewData);
    }

}