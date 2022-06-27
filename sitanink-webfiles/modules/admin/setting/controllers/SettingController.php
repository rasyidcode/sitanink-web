<?php

namespace Modules\Admin\Setting\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use Modules\Admin\Setting\Models\SettingModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class SettingController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $settingModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();

        $this->settingModel = new SettingModel($db);

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Setting',
            'pageDesc'  => 'Halaman pengaturan'
        ];
    }

    public function index()
    {
        $this->viewData['pasFotoId'] = $this->settingModel->getSiteConfig('id_pas_foto');
        $this->viewData['berkasTypes'] = $this->settingModel->getListBerkasType();
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'setting' => [
                'url'       => route_to('setting'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_index', $this->viewData);
    }

    public function pasFotoConfig()
    {
        $postData = $this->request->getPost();
        
        $config = $this->settingModel->getSiteConfig($postData['key']);
        if (is_null($config)) {
            $this->settingModel->createConfig($postData);
        } else {
            $this->settingModel->updateConfig($postData);
        }

        return redirect()->back()
            ->route('setting');
    }
}
