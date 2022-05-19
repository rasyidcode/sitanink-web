<?php

namespace Modules\Admin\Dashboard\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use Modules\Shared\Core\Controllers\BaseWebController;

class DashboardController extends BaseWebController
{

    protected $viewPath = __DIR__;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->renderView('v_index', [
            'pageTitle' => 'Dashboard',
            'pageDesc'  => 'Informasi ringkas',
            'pageLinks' => [
                'dashboard' => [
                    'url'       => route_to('admin'),
                    'active'    => true,
                ]
            ]
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return $this->response
            ->setJSON([
                'success'    => true,
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
