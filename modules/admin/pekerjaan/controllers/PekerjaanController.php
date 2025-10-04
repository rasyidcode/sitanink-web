<?php

namespace Modules\Admin\Pekerjaan\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use Modules\Admin\Pekerjaan\Models\PekerjaanModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class PekerjaanController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $pekerjaanModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();

        $this->pekerjaanModel = new PekerjaanModel($db);

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Master Data Pekerjaan',
            'pageDesc'  => 'Halaman manajemen master data pekerjaan'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'master-data-pekerjaan' => [
                'url'       => route_to('pekerjaan'),
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
            'master-data-pekerjaan' => [
                'url'       => route_to('pekerjaan'),
                'active'    => false,
            ],
            'tambah-master-data-pekerjaan' => [
                'url'       => route_to('pekerjaan.add'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_add', $this->viewData);
    }

    public function create()
    {
        $rules = [
            'nama'  => 'required|is_unique[pekerjaan.nama]',
        ];
        $messages = [
            'nama'  => [
                'required'  => 'Nama pekerjaan tidak boleh kosong!',
                'is_unique'  => 'Nama pekerjaan sudah terdaftar!',
            ],
        ];
        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();
        $this->pekerjaanModel->create($dataPost);

        session()->setFlashdata('success', 'Data berhasil ditambahkan!');
        return redirect()->back()
            ->route('pekerjaan');
    }

    public function edit($id)
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'master-data-pekerjaan' => [
                'url'       => route_to('pekerjaan'),
                'active'    => false,
            ],
            'tambah-master-data-pekerjaan' => [
                'url'       => route_to('pekerjaan.add'),
                'active'    => true,
            ],
        ];
        $this->viewData['data'] = $this->pekerjaanModel->get((int)$id);

        return $this->renderView('v_edit', $this->viewData);
    }

    public function update($id)
    {
        $rules = [
            'nama'  => 'required'
        ];
        $messages = [
            'nama'  => [
                'required'  => 'Nama tidak boleh kosong!',
            ],
        ];
        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();
        $this->pekerjaanModel->update($dataPost, (int)$id);
        
        session()->setFlashdata('success', 'Data berhasil diupdate!');
        return redirect()->back()
            ->route('pekerjaan');
    }

    public function delete($id)
    {
        $pekerjaan = $this->pekerjaanModel->get($id);
        if (is_null($pekerjaan)) {
            throw new ApiAccessErrorException(message: 'Data tidak ditemukan', statusCode: ResponseInterface::HTTP_NOT_FOUND);
        }

        $this->pekerjaanModel->delete($id);

        return $this->response
            ->setJSON([
                'message' => 'Data terhapus!'
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }


}
