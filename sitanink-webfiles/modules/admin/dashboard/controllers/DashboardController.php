<?php

namespace Modules\Admin\Dashboard\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use Modules\Admin\Kartu\Models\KartuModel;
use Modules\Admin\Lokasikerja\Models\LokasikerjaModel;
use Modules\Admin\Pekerja\Models\PekerjaModel;
use Modules\Admin\Sk\Models\SkModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class DashboardController extends BaseWebController
{

    protected $viewPath = __DIR__;

    /**
     * @var PekerjaModel
     */
    private $pekerjaModel;

    /**
     * @var LokasikerjaModel
     */
    private $lokasikerjaModel;

    /**
     * @var KartuModel
     */
    private $kartuModel;

    /**
     * @var SkModel
     */
    private $skModel;

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();

        $this->pekerjaModel     = new PekerjaModel($db);
        $this->lokasikerjaModel = new LokasikerjaModel($db);
        $this->kartuModel       = new KartuModel($db);
        $this->skModel          = new SkModel($db);
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
            ],
            'totalPekerja'  => $this->pekerjaModel->countTotal(),
            'totalWilayah'  => $this->lokasikerjaModel->countTotal(),
            'totalKartu'    => $this->kartuModel->countTotal(),
            'totalSk'       => $this->skModel->countTotal(),
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
