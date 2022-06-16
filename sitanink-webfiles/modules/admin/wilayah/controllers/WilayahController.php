<?php

namespace Modules\Admin\Wilayah\Controllers;

use Modules\Admin\Wilayah\Models\WilayahModel;
use Modules\Shared\Core\Controllers\BaseWebController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class WilayahController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $wilayahModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();
        $this->wilayahModel = new WilayahModel($db);

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Data Per Wilayah',
            'pageDesc'  => 'Monitor pekerja berdasarkan wilayah'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-wilayah' => [
                'url'       => route_to('wilayah'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_index', $this->viewData);
    }

    public function downloadExcel()
    {
        $data = $this->wilayahModel->getList();
        $spreadsheet = new Spreadsheet();
        print_r($spreadsheet);die();
    }

}