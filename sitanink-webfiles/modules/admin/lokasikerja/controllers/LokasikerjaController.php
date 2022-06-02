<?php

namespace Modules\Admin\Lokasikerja\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use Modules\Admin\Lokasikerja\Models\LokasikerjaModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class LokasikerjaController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $lokasiKerjaModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();

        $this->lokasiKerjaModel = new LokasikerjaModel($db);

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Master Data Lokasi Kerja',
            'pageDesc'  => 'Halaman manajemen master data lokasi kerja'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'master-data-lokasi-kerja' => [
                'url'       => route_to('lokasi-kerja'),
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
            'master-data-lokasi-kerja' => [
                'url'       => route_to('lokasi-kerja'),
                'active'    => false,
            ],
            'tambah-master-data-lokasi-kerja' => [
                'url'       => route_to('lokasi-kerja.add'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_add', $this->viewData);
    }

    public function create()
    {
        $rules = [
            'nama'  => 'required|is_unique[lokasi_kerja.nama]',
            'lon'   => 'required',
            'lat'   => 'required'
        ];
        $messages = [
            'nama'  => [
                'required'  => 'Nama lokasi tidak boleh kosong!',
                'is_unique'  => 'Nama lokasi sudah terdaftar!',
            ],
            'lon'  => [
                'required'  => 'Lokasi map harus dipilih!',
            ],
            'lat'    => [
                'required'  => 'Lokasi map harus dipilih!',
            ],
        ];
        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();
        $this->lokasiKerjaModel->create($dataPost);

        session()->setFlashdata('success', 'Lokasi kerja berhasil ditambahkan!');
        return redirect()->back()
            ->route('lokasi-kerja');
    }

    public function edit($id)
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'master-data-lokasi-kerja' => [
                'url'       => route_to('lokasi-kerja'),
                'active'    => false,
            ],
            'tambah-master-data-lokasi-kerja' => [
                'url'       => route_to('lokasi-kerja.add'),
                'active'    => true,
            ],
        ];
        $this->viewData['lokasiKerjaData'] = $this->lokasiKerjaModel->get((int)$id);

        return $this->renderView('v_edit', $this->viewData);
    }

    public function update($id)
    {
        $rules = [
            'nama'  => 'required',
            'lon'   => 'required',
            'lat'   => 'required'
        ];
        $messages = [
            'nama'  => [
                'required'  => 'Nama lokasi tidak boleh kosong!',
            ],
            'lon'  => [
                'required'  => 'Lokasi map harus dipilih!',
            ],
            'lat'    => [
                'required'  => 'Lokasi map harus dipilih!',
            ],
        ];
        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();
        $this->lokasiKerjaModel->update($dataPost, (int)$id);
        
        session()->setFlashdata('success', 'Lokasi kerja berhasil diupdate!');
        return redirect()->back()
            ->route('lokasi-kerja');
    }

    public function delete($id)
    {
        $lokasiKerja = $this->lokasiKerjaModel->get($id);
        if (is_null($lokasiKerja)) {
            throw new ApiAccessErrorException(message: 'Lokasi kerja tidak ditemukan', statusCode: ResponseInterface::HTTP_NOT_FOUND);
        }

        $this->lokasiKerjaModel->delete($id);

        return $this->response
            ->setJSON([
                'message' => 'Lokasi kerja terhapus!'
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }


}
