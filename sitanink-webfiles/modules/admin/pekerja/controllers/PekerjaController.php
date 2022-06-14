<?php

namespace Modules\Admin\Pekerja\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use Modules\Admin\Pekerja\Models\PekerjaModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class PekerjaController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $pekerjaModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $this->pekerjaModel = new PekerjaModel();

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Data Pekerja',
            'pageDesc'  => 'Pusat manajemen data pekerja'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-pekerja' => [
                'url'       => route_to('pekerja'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_index', $this->viewData);
    }

    public function add()
    {
        $dropdownData = $this->pekerjaModel->getDropdownData();

        $this->viewData['pageLinks'] = [
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
        ];
        $this->viewData['ddData'] = $dropdownData;

        return $this->renderView('v_add_v2', $this->viewData);
    }

    public function create()
    {
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
                . '|is_image[foto]',
            'ktp'   => 'uploaded[ktp]'
                . '|max_size[ktp,1024]'
                . '|is_image[foto]',
            'sp'    => 'uploaded[sp]'
                . '|max_size[sp,1024]',
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
            'sp' => [
                'uploaded'  => 'SP harus diupload!',
                'max_size'  => 'Ukuran file tidak boleh lebih dari 1 Mb!',
            ]
        ];

        $nikFormatted = str_replace('_', '', join(explode('-', $_REQUEST['nik'])));
        $_REQUEST['nik']   = $nikFormatted;
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
        $dataPost['nik'] = $nikFormatted;

        if (isset($dataPost['domisili2']) && !empty($dataPost['domisili2'])) {
            $dataPost['domisili'] = ucwords($dataPost['domisili2']);
        }
        if (isset($dataPost['lokasi_kerja2'])  && !empty($dataPost['lokasi_kerja2'])) {
            $dataPost['lokasi_kerja'] = ucwords($dataPost['lokasi_kerja2']);
        }
        if (isset($_REQUEST['jenis_pekerja2'])  && !empty($dataPost['jenis_pekerja2'])) {
            $dataPost['jenis_pekerja'] = ucwords($dataPost['jenis_pekerja2']);
        }
        if (isset($_REQUEST['pekerjaan2']) && !empty($dataPost['pekerjaan2'])) {
            $dataPost['pekerjaan'] = ucwords($dataPost['pekerjaan2']);
        }

        unset($dataPost['csrf_token_sitanink']);
        unset($dataPost['domisili2']);
        unset($dataPost['lokasi_kerja2']);
        unset($dataPost['jenis_pekerja2']);
        unset($dataPost['pekerjaan2']);

        // handle files
        $foto = $this->request->getFile('foto');
        if (!$foto->isValid() && $foto->hasMoved()) {
            session()->setFlashdata('error_files', 'Something went wrong when processing the file!');
            return redirect()->back()
                ->withInput();
        }

        $ktp = $this->request->getFile('ktp');
        if (!$ktp->isValid() && $ktp->hasMoved()) {
            session()->setFlashdata('error_files', 'Something went wrong when processing the file!');
            return redirect()->back()
                ->withInput();
        }

        $sp = $this->request->getFile('sp');
        if (!$sp->isValid() && $sp->hasMoved()) {
            session()->setFlashdata('error_files', 'Something went wrong when processing the file!');
            return redirect()->back()
                ->withInput();
        }

        $tglLahir = explode('/', $dataPost['tgl_lahir']);
        $dataPost['tgl_lahir'] = $tglLahir[2] . '-' . $tglLahir[0] . '-' . $tglLahir[1];

        // create new pekerja_temp
        $reviewId = $this->pekerjaModel->insertToReview($dataPost);

        $filePath = ROOTPATH . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public_html' . DIRECTORY_SEPARATOR . 'uploads';

        // insert berkas one by one
        $fotoName = $foto->getRandomName();
        $fotoId = $this->pekerjaModel->insertBerkas([
            'path'  => $filePath,
            'filename'  => $fotoName,
            'size_in_mb'    => $foto->getSizeByUnit('mb'),
            'mime'    => $foto->getMimeType(),
            'ext'    => $foto->getExtension(),
            'type'    => 'foto',
        ]);
        $foto->move($filePath, $fotoName);

        $ktpName = $ktp->getRandomName();
        $ktpId = $this->pekerjaModel->insertBerkas([
            'path'  => $filePath,
            'filename'  => $ktpName,
            'size_in_mb'    => $ktp->getSizeByUnit('mb'),
            'mime'    => $ktp->getMimeType(),
            'ext'    => $ktp->getExtension(),
            'type'    => 'ktp',
        ]);
        $ktp->move($filePath, $ktpName);

        $spName = $sp->getRandomName();
        $spId = $this->pekerjaModel->insertBerkas([
            'path'  => $filePath,
            'filename'  => $spName,
            'size_in_mb'    => $sp->getSizeByUnit('mb'),
            'mime'    => $sp->getMimeType(),
            'ext'    => $sp->getExtension(),
            'type'    => 'sp',
        ]);
        $sp->move($filePath, $spName);

        // create connection between pekerja_temp to berkas
        $this->pekerjaModel->insertReviewBerkas([
            ['id_pekerja_temp' => $reviewId, 'id_berkas' => $fotoId],
            ['id_pekerja_temp' => $reviewId, 'id_berkas' => $ktpId],
            ['id_pekerja_temp' => $reviewId, 'id_berkas' => $spId],
        ]);

        session()->setFlashdata('success', 'Pekerja telah ditambahkan untuk direview terlebih dahulu!');
        return redirect()->back()
            ->route('review.confirm', [$reviewId]);
    }

    public function createv2()
    {
        $nikFormatted = str_replace('_', '', join(explode('-', $_REQUEST['nik'])));
        $_REQUEST['nik']   = $nikFormatted;

        if (!$this->validate($this->getRules(), $this->getMessages())) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();
        $dataPost['nik'] = $nikFormatted;

        unset($dataPost['csrf_token_sitanink']);

        // handle files
        $foto = $this->request->getFile('foto');
        if (!$foto->isValid() && $foto->hasMoved()) {
            session()->setFlashdata('error_files', 'Something went wrong when processing the [foto] file!');
            return redirect()->back()
                ->withInput();
        }

        $ktp = $this->request->getFile('ktp');
        if (!$ktp->isValid() && $ktp->hasMoved()) {
            session()->setFlashdata('error_files', 'Something went wrong when processing the [ktp] file!');
            return redirect()->back()
                ->withInput();
        }

        $kk = $this->request->getFile('kk');
        if (!$kk->isValid() && $kk->hasMoved()) {
            session()->setFlashdata('error_files', 'Something went wrong when processing the [kk] file!');
            return redirect()->back()
                ->withInput();
        }

        $spiu = $this->request->getFile('spiu');
        if (!$spiu->isValid() && $spiu->hasMoved()) {
            session()->setFlashdata('error_files', 'Something went wrong when processing the [spiu] file!');
            return redirect()->back()
                ->withInput();
        }

        $sp = $this->request->getFile('sp');
        if (!$sp->isValid() && $sp->hasMoved()) {
            session()->setFlashdata('error_files', 'Something went wrong when processing the [sp] file!');
            return redirect()->back()
                ->withInput();
        }

        $tglLahir = explode('/', $dataPost['tgl_lahir']);
        $dataPost['tgl_lahir'] = $tglLahir[2] . '-' . $tglLahir[0] . '-' . $tglLahir[1];

        // create new pekerja
        $pekerjaId = $this->pekerjaModel->insertPekerja($dataPost);

        // upload path
        $filePath = ROOTPATH . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public_html' . DIRECTORY_SEPARATOR . 'uploads';

        // insert berkas one by one
        // foto
        $fotoName = $foto->getRandomName();
        $this->pekerjaModel->insertBerkas([
            'id_pekerja'    => $pekerjaId,
            'path'          => $filePath,
            'filename'      => $fotoName,
            'size_in_mb'    => $foto->getSizeByUnit('mb'),
            'mime'          => $foto->getMimeType(),
            'ext'           => $foto->getExtension(),
            'type'          => 'foto',
        ]);
        $foto->move($filePath, $fotoName);

        // ktp
        $ktpName = $ktp->getRandomName();
        $this->pekerjaModel->insertBerkas([
            'id_pekerja'    => $pekerjaId,
            'path'          => $filePath,
            'filename'      => $ktpName,
            'size_in_mb'    => $ktp->getSizeByUnit('mb'),
            'mime'          => $ktp->getMimeType(),
            'ext'           => $ktp->getExtension(),
            'type'          => 'ktp',
        ]);
        $ktp->move($filePath, $ktpName);

        // kk
        $kkName = $kk->getRandomName();
        $this->pekerjaModel->insertBerkas([
            'id_pekerja'    => $pekerjaId,
            'path'          => $filePath,
            'filename'      => $kkName,
            'size_in_mb'    => $kk->getSizeByUnit('mb'),
            'mime'          => $kk->getMimeType(),
            'ext'           => $kk->getExtension(),
            'type'          => 'kk',
        ]);
        $kk->move($filePath, $kkName);

        // spiu
        $spiuName = $spiu->getRandomName();
        $this->pekerjaModel->insertBerkas([
            'id_pekerja'    => $pekerjaId,
            'path'  => $filePath,
            'filename'  => $spiuName,
            'size_in_mb'    => $spiu->getSizeByUnit('mb'),
            'mime'    => $spiu->getMimeType(),
            'ext'    => $spiu->getExtension(),
            'type'    => 'spiu',
        ]);
        $spiu->move($filePath, $spiuName);

        // sp
        $spName = $sp->getRandomName();
        $this->pekerjaModel->insertBerkas([
            'id_pekerja'    => $pekerjaId,
            'path'          => $filePath,
            'filename'      => $spName,
            'size_in_mb'    => $sp->getSizeByUnit('mb'),
            'mime'          => $sp->getMimeType(),
            'ext'           => $sp->getExtension(),
            'type'          => 'sp',
        ]);
        $sp->move($filePath, $spName);

        session()->setFlashdata('success', 'Pekerja berhasil ditambahkan!');
        return redirect()->back()
                         ->route('pekerja');
    }

    public function delete($id)
    {
        $this->pekerjaModel->deletePekerja($id);

        return $this->response
            ->setJSON([
                'message' => 'Pekerja terhapus!'
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function get($id)
    {
        $data = $this->pekerjaModel->getPekerja((int)$id);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die();
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-pekerja' => [
                'url'       => route_to('pekerja'),
                'active'    => false,
            ],
            'detail-pekerja' => [
                'url'       => route_to('pekerja.get', $id),
                'active'    => true,
            ],
        ];
        $this->viewData['data'] = $data;

        return $this->renderView('v_detail', $this->viewData);
    }

    public function edit($id)
    {
        $data = $this->pekerjaModel->getPekerja($id);
        $berkas = $this->pekerjaModel->getBerkas($id);
        $data->berkas = $berkas;

        $dropdownData = $this->pekerjaModel->getDropdownData();

        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-pekerja' => [
                'url'       => route_to('pekerja'),
                'active'    => false,
            ],
            'edit-pekerja' => [
                'url'       => route_to('pekerja.edit', $id),
                'active'    => true,
            ],
        ];
        $this->viewData['data'] = $data;
        $this->viewData['ddData'] = $dropdownData;
        return $this->renderView('v_edit_v2', $this->viewData);
    }

    public function update($id)
    {
    }

    private function getRules()
    {
        return [
            'nik'           => 'required'
                            . '|integer'
                            . '|is_unique[pekerja.nik]'
                            . '|exact_length[16]',
            'nama'          => 'required',
            'tempat_lahir'  => 'required',
            'tgl_lahir'     => 'required',
            'alamat'        => 'required',
            'id_pekerjaan'      => 'required',
            'id_lokasi_kerja'   => 'required',
            'id_jenis_pekerja'  => 'required',
            'foto'              => 'uploaded[foto]'
                                . '|max_size[foto,200]'
                                . '|is_image[foto]',
            'ktp'               => 'uploaded[ktp]'
                                . '|max_size[ktp,200]'
                                . '|is_image[ktp]',
            'kk'                => 'uploaded[kk]'
                                . '|max_size[kk,200]'
                                . '|is_image[kk]',
            'spiu'              => 'uploaded[spiu]'
                                . '|max_size[spiu,200]',
            'sp'                => 'uploaded[sp]'
                                . '|max_size[sp,200]',
        ];
    }

    private function getMessages()
    {
        return [
            'nik'  => [
                'required'  => 'NIK harus diisi!',
                'integer'  => 'NIK mengandung karakter yang tidak valid!',
                'is_unique'  => 'NIK sudah terdaftar!',
                'exact_length'  => 'Format NIK tidak valid!',
            ],
            'nama'  => ['required'  => 'Nama harus diisi!'],
            'tempat_lahir'    => ['required'  => 'Tempat lahir harus diisi!'],
            'tgl_lahir' => ['required'  => 'Tanggal lahir harus diisi!'],
            'alamat' => ['required'  => 'Alamat harus diisi!'],
            'id_lokasi_kerja' => ['required'  => 'Pilih salah satu atau tambah baru!'],
            'id_jenis_pekerja' => ['required'  => 'Pilih salah satu atau tambah baru!'],
            'id_pekerjaan' => ['required'  => 'Pilih salah satu atau tambah baru!'],
            'foto' => [
                'uploaded'  => 'Foto harus diupload!',
                'max_size'  => 'Ukuran file tidak boleh lebih dari 200 kb!',
                'is_image'  => 'Foto harus berupa gambar!',
            ],
            'ktp' => [
                'uploaded'  => 'KTP harus diupload!',
                'max_size'  => 'Ukuran file tidak boleh lebih dari 200 kb!',
                'is_image'  => 'KTP harus berupa gambar!',
            ],
            'kk' => [
                'uploaded'  => 'KK harus diupload!',
                'max_size'  => 'Ukuran file tidak boleh lebih dari 200 kb!',
                'is_image'  => 'KK harus berupa gambar!',
            ],
            'spiu' => [
                'uploaded'  => 'Surat Perijinan Izin Usaha harus diupload!',
                'max_size'  => 'Ukuran file tidak boleh lebih dari 200 kb!',
                'is_image'  => 'Surat Perijinan Izin Usaha harus berupa gambar!',
            ],
            'sp' => [
                'uploaded'  => 'Surat Pernyataan harus diupload!',
                'max_size'  => 'Ukuran file tidak boleh lebih dari 200 kb!',
                'is_image'  => 'Surat Pernyataan harus berupa gambar!',
            ],
        ];
    }
}
