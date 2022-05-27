<?php

namespace Modules\Admin\Inputdata\Controllers;

use Modules\Admin\Pekerja\Models\PekerjaModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class InputDataController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $pekerjaModel;

    public function __construct()
    {
        parent::__construct();

        $this->pekerjaModel = new PekerjaModel();
    }

    public function index()
    {
        $listDomisili = $this->pekerjaModel->getListDomisili();
        $listLokasiKerja = $this->pekerjaModel->getListLokasiKerja();
        $listPekerjaan = $this->pekerjaModel->getListPekerjaan();
        $listJenisPekerja = $this->pekerjaModel->getListJenisPekerja();

        return $this->renderView('v_index', [
            'pageTitle' => 'Input Data Pekerja',
            'pageDesc'  => 'Form penambahan data pekerja baru',
            'pageLinks' => [
                'dashboard' => [
                    'url'       => route_to('admin'),
                    'active'    => false,
                ],
                'data-pekerja' => [
                    'url'       => route_to('pekerja'),
                    'active'    => false,
                ],
                'tambah-pekerja' => [
                    'url'       => route_to('pekerja.add'),
                    'active'    => true,
                ],
            ],
            'listDomisili'  => $listDomisili,
            'listLokasiKerja'  => $listLokasiKerja,
            'listPekerjaan'  => $listPekerjaan,
            'listJenisPekerja'  => $listJenisPekerja,
        ]);
    }
}
