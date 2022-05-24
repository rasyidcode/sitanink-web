<?php

namespace Modules\Admin\Pekerja\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use Modules\Admin\Pekerja\Models\PekerjaModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class PekerjaController extends BaseWebController
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
        return $this->renderView('v_index', [
            'pageTitle' => 'Data Pekerja',
            'pageDesc'  => 'Halaman List Data Pekerja',
            'pageLinks' => [
                'dashboard' => [
                    'url'       => route_to('admin'),
                    'active'    => false,
                ],
                'data-pekerja' => [
                    'url'       => route_to('pekerja'),
                    'active'    => true,
                ],
            ]
        ]);
    }

    public function getData()
    {
        $postData   = $this->request->getPost();
        $data       = $this->pekerjaModel->getData($postData);
        $num        = $postData['start'];

        $resData = [];
        foreach ($data as $item) {
            $num++;

            $row    = [];
            $row[]  = "<input type=\"hidden\" value=\"" . $item->id . "\">{$num}.";
            $row[]  = $item->nik ?? '-';
            $row[]  = $item->nama ?? '-';
            $row[]  = $item->ttl ?? '-';
            $row[]  = $item->alamat ?? '-';
            $row[]  = $item->jenis_pekerja ?? '-';
            $row[]  = $item->lokasi_kerja ?? '-';
            $row[]  = $item->created_at ?? '-';
            $row[]  = "<div class=\"text-center\">
                            <a style=\"margin-bottom: 2px;\" href=\"" . base_url(). "\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-info-circle\"></i>&nbsp;Detail</a>
                            <a style=\"margin-bottom: 2px;\" href=\"" . base_url() . "\" class=\"btn btn-info btn-xs\"><i class=\"fa fa-pencil-square-o\"></i>&nbsp;Edit</a>
                            <button style=\"margin-bottom: 2px;\" data-pekerja-id=\"$item->id\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i>&nbsp;Hapus</button>
                        </div>";
            $resData[] = $row;
        }

        return $this->response
            ->setJSON([
                'draw'              => $postData['draw'],
                'recordsTotal'      => $this->pekerjaModel->countData(),
                'recordsFiltered'   => $this->pekerjaModel->countFilteredData($postData),
                'data'              => $resData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function add()
    {
        $listDomisili = $this->pekerjaModel->getListDomisili();
        $listLokasiKerja = $this->pekerjaModel->getListLokasiKerja();
        $listPekerjaan = $this->pekerjaModel->getListPekerjaan();
        $listJenisPekerja = $this->pekerjaModel->getListJenisPekerja();

        return $this->renderView('v_add', [
            'pageTitle' => 'Tambah Pekerja',
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

    public function create()
    {
        // print_r($_REQUEST);die();
        $rules = [
            'nik'   => 'required'
                . '|integer'
                . '|is_unique[pekerja.nik]'
                . '|exact_length[16]',
            'nama'  => 'required',
            'tempat_lahir'  => 'required',
            'tgl_lahir' => 'required',
            'alamat'    => 'required',
            'domisili'  => 'required',
            'lokasi_kerja'  => 'required',
            'jenis_pekerja' => 'required',
            'pekerjaan' => 'required',
            'foto'  => 'uploaded[foto]'
                . '|max_size[foto,512]'
                . '|is_image',
            'ktp'   => 'uploaded[ktp]'
                . '|max_size[ktp,1024]'
                . '|is_image',
            'sk'    => 'uploaded[sk]'
                . '|max_size[sk,1024]',
        ];
        $messages = [
            'nik'  => [
                'required'  => 'NIK harus diisi!',
                'integer'  => 'NIK mengandung karakter yang tidak valid!',
                'is_unique'  => 'NIK sudah terdaftar!',
                'exact_length'  => 'Format NIK tidak valid!',
            ],
            'nama'  => [
                'required'  => 'Nama harus diisi!',
            ],
            'tempat_lahir'    => [
                'required'  => 'Tempat lahir harus diisi!',
            ],
            'tgl_lahir' => [
                'required'  => 'Tanggal lahir harus diisi!',
            ],
            'alamat' => [
                'required'  => 'Alamat harus diisi!',
            ],
            'domisili' => [
                'required'  => 'Pilih salah satu atau tambah baru!',
            ],
            'lokasi_kerja' => [
                'required'  => 'Pilih salah satu atau tambah baru!',
            ],
            'jenis_pekerja' => [
                'required'  => 'Pilih salah satu atau tambah baru!',
            ],
            'pekerjaan' => [
                'required'  => 'Pilih salah satu atau tambah baru!',
            ],
            'foto' => [
                'uploaded'  => 'Foto harus diupload!',
                'max_size'  => 'Ukuran file tidak boleh lebih dari 500 kb!',
                'is_image'  => 'Foto harus berupa gambar!',
            ],
            'ktp' => [
                'uploaded'  => 'Ktp harus diupload!',
                'max_size'  => 'Ukuran file tidak boleh lebih dari 1 Mb!',
                'is_image'  => 'Foto harus berupa gambar!',
            ],
            'sk' => [
                'uploaded'  => 'SK harus diupload!',
                'max_size'  => 'Ukuran file tidak boleh lebih dari 1 Mb!',
            ]
        ];

        $_REQUEST['nik']   = str_replace('_', '', join(explode('-', $_REQUEST['nik'])));
        if (isset($_REQUEST['domisili2']) && !empty($_REQUEST['domisili2'])) {
            $_REQUEST['domisili'] = $_REQUEST['domisili2'];
        }
        if (isset($_REQUEST['lokasi_kerja2'])  && !empty($_REQUEST['lokasi_kerja2'])) {
            $_REQUEST['lokasi_kerja'] = $_REQUEST['lokasi_kerja2'];
        }
        if (isset($_REQUEST['jenis_pekerja2'])  && !empty($_REQUEST['jenis_pekerja2'])) {
            $_REQUEST['jenis_pekerja'] = $_REQUEST['jenis_pekerja2'];
        }
        if (isset($_REQUEST['pekerjaan2']) && !empty($_REQUEST['pekerjaan2'])) {
            $_REQUEST['pekerjaan'] = $_REQUEST['pekerjaan2'];
        }

        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();
        print_r($dataPost);die();

        return redirect()->back()
                    ->route('pekerja');
    }

}