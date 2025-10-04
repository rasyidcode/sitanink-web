<?php

namespace Modules\Admin\Jenispekerja\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use Modules\Admin\Jenispekerja\Models\JenispekerjaModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class JenispekerjaController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $jenispekerjaModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();

        $this->jenispekerjaModel = new JenispekerjaModel($db);

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Master Data Jenis Pekerja',
            'pageDesc'  => 'Halaman manajemen master data pekerja'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'master-data-jenis-pekerja' => [
                'url'       => route_to('jenis-pekerja'),
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
            'master-data-jenis-pekerja' => [
                'url'       => route_to('jenis-pekerja'),
                'active'    => false,
            ],
            'tambah-master-data-jenis-pekerja' => [
                'url'       => route_to('jenis-pekerja.add'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_add', $this->viewData);
    }

    public function create()
    {
        $rules = [
            'nama'  => 'required|is_unique[jenis_pekerja.nama]',
        ];
        $messages = [
            'nama'  => [
                'required'  => 'Nama lokasi tidak boleh kosong!',
                'is_unique'  => 'Nama lokasi sudah terdaftar!',
            ],
        ];
        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();
        $this->jenispekerjaModel->create($dataPost);

        session()->setFlashdata('success', 'Data berhasil ditambahkan!');
        return redirect()->back()
            ->route('jenis-pekerja');
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
        $this->viewData['data'] = $this->jenispekerjaModel->get((int)$id);

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
        $this->jenispekerjaModel->update($dataPost, (int)$id);
        
        session()->setFlashdata('success', 'Data berhasil diupdate!');
        return redirect()->back()
            ->route('jenis-pekerja');
    }

    public function delete($id)
    {
        $lokasiKerja = $this->jenispekerjaModel->get($id);
        if (is_null($lokasiKerja)) {
            throw new ApiAccessErrorException(message: 'Data tidak ditemukan', statusCode: ResponseInterface::HTTP_NOT_FOUND);
        }

        $this->jenispekerjaModel->delete($id);

        return $this->response
            ->setJSON([
                'message' => 'Data terhapus!'
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }


}
