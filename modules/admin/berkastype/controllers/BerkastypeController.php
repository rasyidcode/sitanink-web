<?php

namespace Modules\Admin\Berkastype\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use Modules\Admin\Berkastype\Models\BerkastypeModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class BerkastypeController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $berkastypeModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();

        $this->berkastypeModel = new BerkastypeModel($db);

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Master Data Tipe Berkas',
            'pageDesc'  => 'Halaman manajemen master data tipe berkas'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'master-data-tipe-berkas' => [
                'url'       => route_to('tipe-berkas'),
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
            'master-data-tipe-berkas' => [
                'url'       => route_to('tipe-berkas'),
                'active'    => false,
            ],
            'tambah-master-data-tipe-berkas' => [
                'url'       => route_to('tipe-berkas.add'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_add', $this->viewData);
    }

    public function create()
    {
        $rules = [
            'name'  => 'required|is_unique[berkas_types.name]',
        ];
        $messages = [
            'name'  => [
                'required'  => 'Nama tipe berkas tidak boleh kosong!',
                'is_unique'  => 'Nama tipe berkas sudah terdaftar!',
            ],
        ];
        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();
        $this->berkastypeModel->create($dataPost);

        session()->setFlashdata('success', 'Data berhasil ditambahkan!');
        return redirect()->back()
            ->route('tipe-berkas');
    }

    public function edit($id)
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'master-data-tipe-berkas' => [
                'url'       => route_to('tipe-berkas'),
                'active'    => false,
            ],
            'tambah-master-data-tipe-berkas' => [
                'url'       => route_to('tipe-berkas.add'),
                'active'    => true,
            ],
        ];
        $this->viewData['data'] = $this->berkastypeModel->get((int)$id);

        return $this->renderView('v_edit', $this->viewData);
    }

    public function update($id)
    {
        $rules = [
            'name'  => 'required'
        ];
        $messages = [
            'name'  => [
                'required'  => 'Nama tipe tidak boleh kosong!',
            ],
        ];
        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();
        $this->berkastypeModel->update($dataPost, (int)$id);
        
        session()->setFlashdata('success', 'Data berhasil diupdate!');
        return redirect()->back()
            ->route('tipe-berkas');
    }

    public function delete($id)
    {
        $this->berkastypeModel->delete($id);

        return $this->response
            ->setJSON([
                'message' => 'Data terhapus!'
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }


}
