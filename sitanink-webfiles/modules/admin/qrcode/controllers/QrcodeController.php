<?php

namespace Modules\Admin\Qrcode\Controllers;

use Modules\Admin\Qrcode\Models\QrcodeModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class QrcodeController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $qrcodeModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();
        $this->qrcodeModel = new QrcodeModel($db);

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Data QR Code',
            'pageDesc'  => 'List data qrcode pekerja'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-qrcode' => [
                'url'       => route_to('qrcode'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_index', $this->viewData);
    }
}