<?php

namespace Modules\Admin\Pekerja\Controllers;

use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\Admin\Berkas\Models\BerkasModel;
use Modules\Admin\Jenispekerja\Models\JenispekerjaModel;
use Modules\Admin\Lokasikerja\Models\LokasikerjaModel;
use Modules\Admin\Pekerja\Models\PekerjaModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class PekerjaController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $pekerjaModel;

    private $berkasModel;

    private $jenisPekerjaModel;

    private $lokasiKerjaModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();

        $this->pekerjaModel         = new PekerjaModel($db);
        $this->berkasModel          = new BerkasModel($db);
        $this->jenisPekerjaModel    = new JenispekerjaModel($db);
        $this->lokasiKerjaModel     = new LokasikerjaModel($db);

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
        $this->viewData['djp'] = $this
            ->jenisPekerjaModel
            ->getAllAsDropdown();
        $this->viewData['dlk'] = $this
            ->lokasiKerjaModel
            ->getAllAsDropdown();

        return $this->renderView('v_add', $this->viewData);
    }

    public function create()
    {
        if (!$this->validate($this->getCreateRules(), $this->getMessages())) {
            session()
                ->setFlashdata('error', $this->validator->getErrors());
            return redirect()
                ->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();
        unset($dataPost['csrf_token_sitanink']);
        unset($dataPost['nik_text']);

        // handle files
        $foto = $this->request->getFile('foto');
        if (!$foto->isValid() && $foto->hasMoved()) {
            session()
                ->setFlashdata('error_files', 'Something went wrong when processing the [foto] file!');
            return redirect()
                ->back()
                ->withInput();
        }

        $ktp = $this->request->getFile('ktp');
        if (!$ktp->isValid() && $ktp->hasMoved()) {
            session()
                ->setFlashdata('error_files', 'Something went wrong when processing the [ktp] file!');
            return redirect()
                ->back()
                ->withInput();
        }

        $kk = $this->request->getFile('kk');
        if (!$kk->isValid() && $kk->hasMoved()) {
            session()
                ->setFlashdata('error_files', 'Something went wrong when processing the [kk] file!');
            return redirect()
                ->back()
                ->withInput();
        }

        $spiu = $this->request->getFile('spiu');
        if (!$spiu->isValid() && $spiu->hasMoved()) {
            session()
                ->setFlashdata('error_files', 'Something went wrong when processing the [spiu] file!');
            return redirect()
                ->back()
                ->withInput();
        }

        $sp = $this->request->getFile('sp');
        if (!$sp->isValid() && $sp->hasMoved()) {
            session()
                ->setFlashdata('error_files', 'Something went wrong when processing the [sp] file!');
            return redirect()
                ->back()
                ->withInput();
        }

        // create new pekerja
        $pekerjaId = $this
            ->pekerjaModel
            ->create($dataPost, true);

        // upload path
        $filePath = $this
            ->path
            ->publicUploadDirectory;

        // insert berkas one by one
        // foto
        $fotoName = $foto->getRandomName();
        $this->berkasModel->create([
            'id_pekerja'        => $pekerjaId,
            'path'              => $filePath,
            'filename'          => $fotoName,
            'size_in_mb'        => $foto->getSizeByUnit('mb'),
            'mime'              => $foto->getMimeType(),
            'ext'               => $foto->getExtension(),
            'berkas_type_id'    => 1
        ]);
        $foto->move($filePath, $fotoName);

        // ktp
        $ktpName = $ktp->getRandomName();
        $this->berkasModel->create([
            'id_pekerja'        => $pekerjaId,
            'path'              => $filePath,
            'filename'          => $ktpName,
            'size_in_mb'        => $ktp->getSizeByUnit('mb'),
            'mime'              => $ktp->getMimeType(),
            'ext'               => $ktp->getExtension(),
            'berkas_type_id'    => 2
        ]);
        $ktp->move($filePath, $ktpName);

        // kk
        $kkName = $kk->getRandomName();
        $this->berkasModel->create([
            'id_pekerja'        => $pekerjaId,
            'path'              => $filePath,
            'filename'          => $kkName,
            'size_in_mb'        => $kk->getSizeByUnit('mb'),
            'mime'              => $kk->getMimeType(),
            'ext'               => $kk->getExtension(),
            'berkas_type_id'    => 3,
        ]);
        $kk->move($filePath, $kkName);

        // spiu
        $spiuName = $spiu->getRandomName();
        $this->berkasModel->create([
            'id_pekerja'        => $pekerjaId,
            'path'              => $filePath,
            'filename'          => $spiuName,
            'size_in_mb'        => $spiu->getSizeByUnit('mb'),
            'mime'              => $spiu->getMimeType(),
            'ext'               => $spiu->getExtension(),
            'berkas_type_id'    => 4,
        ]);
        $spiu->move($filePath, $spiuName);

        // sp
        $spName = $sp->getRandomName();
        $this->berkasModel->create([
            'id_pekerja'        => $pekerjaId,
            'path'              => $filePath,
            'filename'          => $spName,
            'size_in_mb'        => $sp->getSizeByUnit('mb'),
            'mime'              => $sp->getMimeType(),
            'ext'               => $sp->getExtension(),
            'berkas_type_id'    => 5,
        ]);
        $sp->move($filePath, $spName);

        session()->setFlashdata('success', 'Pekerja berhasil ditambahkan!');

        return redirect()
            ->back()
            ->route('pekerja');
    }

    public function get($id)
    {
        $data = $this->pekerjaModel->getDetailWithFoto((int)$id, 1);

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

        $this->viewData['dataEdit'] = $this
            ->pekerjaModel
            ->get($id);
        
        $this->viewData['djp'] = $this
            ->jenisPekerjaModel
            ->getAllAsDropdown();
        $this->viewData['dlk'] = $this
            ->lokasiKerjaModel
            ->getAllAsDropdown();
        
        $berkas = $this
            ->berkasModel
            ->getByPekerjaId($id);

        $berkasEdit = [];
        foreach($berkas as $item) {
            $berkasEdit[$item->berkas_type_id] = $item;
        }

        $this->viewData['berkasEdit'] = $berkasEdit;

        return $this->renderView('v_edit', $this->viewData);
    }

    public function update($id)
    {        
        if (!$this->validate($this->getUpdateRules(), $this->getMessages())) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();

        unset($dataPost['csrf_token_sitanink']);
        unset($dataPost['nik_text']);
        unset($dataPost['foto_edit']);
        unset($dataPost['ktp_edit']);
        unset($dataPost['kk_edit']);
        unset($dataPost['spiu_edit']);
        unset($dataPost['sp_edit']);

        // check if there is a file upload
        $foto = $this->request->getFile('foto');
        if ($foto instanceof UploadedFile && !$foto->isValid() && $foto->hasMoved()) {
            session()->setFlashdata('error_files', 'Something went wrong when processing the [foto] file!');
            return redirect()->back()
                ->withInput();
        }

        $ktp = $this->request->getFile('ktp');
        if ($ktp instanceof UploadedFile && !$ktp->isValid() && $ktp->hasMoved()) {
            session()->setFlashdata('error_files', 'Something went wrong when processing the [ktp] file!');
            return redirect()->back()
                ->withInput();
        }

        $kk = $this->request->getFile('kk');
        if ($kk instanceof UploadedFile && !$kk->isValid() && $kk->hasMoved()) {
            session()->setFlashdata('error_files', 'Something went wrong when processing the [kk] file!');
            return redirect()->back()
                ->withInput();
        }

        $spiu = $this->request->getFile('spiu');
        if ($spiu instanceof UploadedFile && !$spiu->isValid() && $spiu->hasMoved()) {
            session()->setFlashdata('error_files', 'Something went wrong when processing the [spiu] file!');
            return redirect()->back()
                ->withInput();
        }

        $sp = $this->request->getFile('sp');
        if ($sp instanceof UploadedFile && !$sp->isValid() && $sp->hasMoved()) {
            session()->setFlashdata('error_files', 'Something went wrong when processing the [sp] file!');
            return redirect()->back()
                ->withInput();
        }

        $this
            ->pekerjaModel
            ->update($id, $dataPost);

        // foto
        if ($foto->getPath()) {
            $this->berkasUploadHandler($id, 1, $foto);
        }

        // ktp
        if ($ktp->getPath()) {
            $this->berkasUploadHandler($id, 2, $ktp);
        }

        // kk
        if ($kk->getPath()) {
            $this->berkasUploadHandler($id, 3, $kk);
        }

        // spiu
        if ($spiu->getPath()) {
            $this->berkasUploadHandler($id, 4, $spiu);
        }

        // sp
        if ($sp->getPath()) {
            $this->berkasUploadHandler($id, 5, $sp);
        }

        session()
            ->setFlashdata('success', 'Pekerja berhasil diupdate!');

        return redirect()
            ->back()
            ->route('pekerja');
    }

    private function getCreateRules()
    {
        $rules = [
            'nik'               => 'required'
                . '|integer'
                . '|is_unique[pekerja.nik]'
                . '|exact_length[16]',
            'nama'              => 'required',
            'tempat_lahir'      => 'required',
            'tgl_lahir'         => 'required',
            'alamat'            => 'required',
            'pekerjaan'         => 'required',
            'id_lokasi_kerja'   => 'required',
            'id_jenis_pekerja'  => 'required',
            'foto'              => 'uploaded[foto]|'
                . 'max_size[foto,200]'
                . '|is_image[foto]',
            'ktp'               => 'uploaded[ktp]|'
                . 'max_size[ktp,200]'
                . '|is_image[ktp]',
            'kk'                => 'uploaded[kk]|'
                . 'max_size[kk,200]'
                . '|is_image[kk]',
            'spiu'              => 'uploaded[spiu]|'
                . 'max_size[spiu,200]',
            'sp'                => 'uploaded[sp]|'
                . 'max_size[sp,200]',
        ];

        return $rules;
    }

    private function getUpdateRules()
    {
        $fotoEdit   = $this->request->getPost('foto_edit');
        $ktpEdit    = $this->request->getPost('ktp_edit');
        $kkEdit     = $this->request->getPost('kk_edit');
        $spiuEdit   = $this->request->getPost('spiu_edit');
        $spEdit     = $this->request->getPost('sp_edit');

        $rules = [
            'nik'               => 'required'
                . '|integer'
                // . '|is_unique[pekerja.nik]'
                . '|exact_length[16]',
            'nama'              => 'required',
            'tempat_lahir'      => 'required',
            'tgl_lahir'         => 'required',
            'alamat'            => 'required',
            'pekerjaan'         => 'required',
            'id_lokasi_kerja'   => 'required',
            'id_jenis_pekerja'  => 'required',
            'foto'              => ($fotoEdit == 'required' ? 'uploaded[foto]|' : '')
                . 'max_size[foto,200]'
                . '|is_image[foto]',
            'ktp'               => ($ktpEdit == 'required' ? 'uploaded[ktp]|' : '')
                . 'max_size[ktp,200]'
                . '|is_image[ktp]',
            'kk'                => ($kkEdit == 'required' ? 'uploaded[kk]|' : '')
                . 'max_size[kk,200]'
                . '|is_image[kk]',
            'spiu'              => ($spiuEdit == 'required' ? 'uploaded[spiu]|' : '')
                . 'max_size[spiu,200]',
            'sp'                => ($spEdit == 'required' ? 'uploaded[sp]|' : '')
                . 'max_size[sp,200]',
        ];

        return $rules;
    }

    private function getMessages()
    {
        return [
            'nik'  => [
                'required'      => 'NIK harus diisi!',
                'integer'       => 'NIK mengandung karakter yang tidak valid!',
                'is_unique'     => 'NIK sudah terdaftar!',
                'exact_length'  => 'Format NIK tidak valid!',
            ],
            'nama'              => ['required'  => 'Nama harus diisi!'],
            'tempat_lahir'      => ['required'  => 'Tempat lahir harus diisi!'],
            'tgl_lahir'         => ['required'  => 'Tanggal lahir harus diisi!'],
            'alamat'            => ['required'  => 'Alamat harus diisi!'],
            'id_lokasi_kerja'   => ['required'  => 'Pilih salah satu atau tambah baru!'],
            'id_jenis_pekerja'  => ['required'  => 'Pilih salah satu atau tambah baru!'],
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

    private function berkasUploadHandler(int $id, int $tipe, UploadedFile $file)
    {
        // upload path
        $filePath = $this->path->publicUploadDirectory;

        $berkas = $this->berkasModel->getByPekerjaIdWithTypeId($id, $tipe);
        $berkasName = $file->getRandomName();
        $berkasData = [
            'id_pekerja'        => $id,
            'path'              => $filePath,
            'filename'          => $berkasName,
            'size_in_mb'        => $file->getSizeByUnit('mb'),
            'mime'              => $file->getMimeType(),
            'ext'               => $file->getExtension(),
            'berkas_type_id'    => $tipe,
        ];
        if (!is_null($berkas)) {
            // update
            $this->berkasModel->update($berkas->id, $berkasData);
            // check old files, delete if any
            $successDelete = unlink($berkas->path . DIRECTORY_SEPARATOR . $berkas->filename);
            if ($successDelete) {
                $this->berkasModel->delete($berkas->id);
            }
        } else {
            // create new
            $this->berkasModel->create($berkasData);
        }
        $file->move($filePath, $berkasName);
    }
}
