<?php

namespace Modules\Admin\Setting\Controllers;

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
        $this->viewData['idPasFoto']        = $this->settingModel->getByKey('id_pas_foto');
        $this->viewData['nipKepala']        = $this->settingModel->getByKey('nip_kepala');
        $this->viewData['namaKepala']       = $this->settingModel->getByKey('nama_kepala');
        $this->viewData['jabatanKepala']    = $this->settingModel->getByKey('jabatan_kepala');
        $this->viewData['namaTempat']       = $this->settingModel->getByKey('nama_tempat');
        $this->viewData['berkasTypes']      = $this->settingModel->getListBerkasType();
        $this->viewData['pageLinks']        = [
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

    public function create()
    {
        $postData = $this->request->getPost();
        
        $idPasFoto = $this->settingModel->getByKey('id_pas_foto');
        if (is_null($idPasFoto)) {
            $this->settingModel->create([
                'key'   => 'id_pas_foto',
                'value' => $postData['id_pas_foto']
            ]);
        } else {
            $this->settingModel->update([
                'key'   => 'id_pas_foto',
                'value' => $postData['id_pas_foto']
            ]);
        }

        $nipKepala = $this->settingModel->getByKey('nip_kepala');
        if (is_null($nipKepala)) {
            $this->settingModel->create([
                'key'   => 'nip_kepala',
                'value' => $postData['nip_kepala']
            ]);
        } else {
            $this->settingModel->update([
                'key'   => 'nip_kepala',
                'value' => $postData['nip_kepala']
            ]);
        }

        $namaKepala = $this->settingModel->getByKey('nama_kepala');
        if (is_null($namaKepala)) {
            $this->settingModel->create([
                'key'   => 'nama_kepala',
                'value' => $postData['nama_kepala']
            ]);
        } else {
            $this->settingModel->update([
                'key'   => 'nama_kepala',
                'value' => $postData['nama_kepala']
            ]);
        }

        $jabatanKepala = $this->settingModel->getByKey('jabatan_kepala');
        if (is_null($jabatanKepala)) {
            $this->settingModel->create([
                'key'   => 'jabatan_kepala',
                'value' => $postData['jabatan_kepala']
            ]);
        } else {
            $this->settingModel->update([
                'key'   => 'jabatan_kepala',
                'value' => $postData['jabatan_kepala']
            ]);
        }

        $namaTempat = $this->settingModel->getByKey('nama_tempat');
        if (is_null($namaTempat)) {
            $this->settingModel->create([
                'key'   => 'nama_tempat',
                'value' => $postData['nama_tempat']
            ]);
        } else {
            $this->settingModel->update([
                'key'   => 'nama_tempat',
                'value' => $postData['nama_tempat']
            ]);
        }

        session()
            ->setFlashdata('success', 'Berhasil menyimpan konfigurasi!');
        
        return redirect()
            ->back()
            ->route('setting');
    }
}
