<?php

namespace Modules\Admin\Domisili\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use Modules\Admin\Domisili\Models\DomisiliModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class DomisiliController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $domisiliModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();

        $this->domisiliModel = new DomisiliModel($db);

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Master Data Domisili',
            'pageDesc'  => 'Halaman manajemen master data domisili'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'master-data-domisili' => [
                'url'       => route_to('domisili'),
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
            'master-data-domisili' => [
                'url'       => route_to('domisili'),
                'active'    => false,
            ],
            'tambah-master-data-domisili' => [
                'url'       => route_to('domisili.add'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_add', $this->viewData);
    }

    public function create()
    {
        $rules = [
            'nama'  => 'required|is_unique[domisili.nama]',
        ];
        $messages = [
            'nama'  => [
                'required'  => 'Nama tidak boleh kosong!',
                'is_unique'  => 'Nama sudah terdaftar!',
            ],
        ];
        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();
        $this->domisiliModel->create($dataPost);

        session()->setFlashdata('success', 'Data berhasil ditambahkan!');
        return redirect()->back()
            ->route('domisili');
    }

    public function edit($id)
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'master-data-jenis-pekerja' => [
                'url'       => route_to('jenis-pekerja'),
                'active'    => false,
            ],
            'tambah-master-data-jenis-pekerja' => [
                'url'       => route_to('jenis-pekerja.add'),
                'active'    => true,
            ],
        ];
        $this->viewData['data'] = $this->domisiliModel->get((int)$id);

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
        $this->domisiliModel->update($dataPost, (int)$id);
        
        session()->setFlashdata('success', 'Data berhasil diupdate!');
        return redirect()->back()
            ->route('domisili');
    }

    public function delete($id)
    {
        $domisili = $this->domisiliModel->get($id);
        if (is_null($domisili)) {
            throw new ApiAccessErrorException(message: 'Data tidak ditemukan', statusCode: ResponseInterface::HTTP_NOT_FOUND);
        }

        $this->domisiliModel->delete($id);

        return $this->response
            ->setJSON([
                'message' => 'Data terhapus!'
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }


}
