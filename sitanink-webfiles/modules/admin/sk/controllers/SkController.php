<?php

namespace Modules\Admin\Sk\Controllers;

use Modules\Admin\Pekerja\Models\PekerjaModel;
use Modules\Admin\Sk\Models\SkModel;
use Modules\Shared\Core\Controllers\BaseWebController;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\TemplateProcessor;

class SkController extends BaseWebController
{

    protected $viewPath = __DIR__;

    /**
     * @var SkModel
     */
    private $skModel;

    /**
     * @var PekerjaModel
     */
    private $pekerjaModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();

        $this->skModel = new SkModel($db);
        $this->pekerjaModel = new PekerjaModel($db);

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Data SK',
            'pageDesc'  => 'Halaman manajemen data SK'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-sk' => [
                'url'       => route_to('sk'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_index', $this->viewData);
    }

    public function create()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-sk' => [
                'url'       => route_to('sk'),
                'active'    => false,
            ],
            'buat-sk' => [
                'url'       => route_to('sk.create'),
                'active'    => true,
            ],
        ];
        $this->viewData['listPekerja'] = $this->pekerjaModel->getListPekerjaForSK();

        return $this->renderView('v_create', $this->viewData);
    }

    public function doCreate()
    {
        if (!$this->validate([
            'number'        => 'required|is_unique[generated_docs.number]',
            'year'          => 'required',
            'valid_until'   => 'required',
            'set_date'      => 'required',
            'boss_name'     => 'required',
            'boss_nip'      => 'required',
            'attachments'   => 'required',
        ])) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()
                ->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();
        
        $templateProcessor = new TemplateProcessor($this->path->publicDocsDirectory . '/sk_petani.docx');
        $templateProcessor->setValues([
            'nomor' => $dataPost['number'],
            'tahun' => $dataPost['year'],
            'berlaku_sampai' => convertDate($dataPost['valid_until']),
            'tanggal_terbit' => convertDate($dataPost['set_date']),
            'nama_kepala' => $dataPost['boss_name'],
            'nip_kepala' => $dataPost['boss_nip'],
        ]);

        $listPekerja = $this->pekerjaModel->getListPekerjaAsAttachments(explode(',', $dataPost['attachments']));

        $table = new Table([
            'borderSize' => 2,
            'unit' => TblWidth::PERCENT,
            'width' => 100 * 50,
        ]);

        // header
        $table->addRow();
        $table->addCell(150)->addText('No.');
        $table->addCell(150)->addText('NIK');
        $table->addCell(150)->addText('Nama');
        $table->addCell(150)->addText('Tempat Lahir');
        $table->addCell(150)->addText('Tanggal Lahir');
        $table->addCell(150)->addText('Alamat');
        $table->addCell(150)->addText('Pekerjaan');
        $table->addCell(150)->addText('Jenis Pekerja');
        $table->addCell(150)->addText('Lokasi Kerja');

        foreach ($listPekerja as $index => $itemPekerja) {
            $table->addRow();

            $table->addCell(150)->addText($index + 1);
            $table->addCell(150)->addText($itemPekerja->nik);
            $table->addCell(150)->addText($itemPekerja->nama);
            $table->addCell(150)->addText($itemPekerja->tempat_lahir);
            $table->addCell(150)->addText($itemPekerja->tgl_lahir);
            $table->addCell(150)->addText($itemPekerja->alamat);
            $table->addCell(150)->addText($itemPekerja->pekerjaan);
            $table->addCell(150)->addText($itemPekerja->jenis_pekerja);
            $table->addCell(150)->addText($itemPekerja->lokasi_kerja);
        }

        $templateProcessor->setComplexBlock('table', $table);

        $skFilename = time() . '_sk_petani.docx';

        $templateProcessor->saveAs($this->path->publicDocsGenDirectory . '/' . $skFilename);

        session()
            ->setFlashdata('success', 'Berkas berhasil dibuat!');

        return redirect()
            ->back()
            ->route('sk');
    }

    public function doCreate2()
    {
        if (!$this->validate([
            'number'        => 'required|is_unique[generated_docs.number]',
            'year'          => 'required',
            'valid_until'   => 'required',
            'set_date'      => 'required',
            'boss_name'     => 'required',
            'boss_nip'      => 'required',
            'attachments'   => 'required',
        ])) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()
                ->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();

        $templateProcessor = new TemplateProcessor($this->path->publicDocsDirectory . '/sk_petani.docx');

        $templateProcessor->setValues([
            'nomor' => $dataPost['number'],
            'tahun' => $dataPost['year'],
            'berlaku_sampai' => convertDate($dataPost['valid_until']),
            'tanggal_terbit' => convertDate($dataPost['set_date']),
            'nama_kepala' => $dataPost['boss_name'],
            'nip_kepala' => $dataPost['boss_nip'],
        ]);

        $listPekerja = $this->pekerjaModel->getListPekerjaAsAttachments(explode(',', $dataPost['attachments']));

        $table = new Table([
            'borderSize' => 2,
            'unit' => TblWidth::PERCENT,
            'width' => 100 * 50,
        ]);

        // header
        $table->addRow();
        $table->addCell(150)->addText('No.');
        $table->addCell(150)->addText('NIK');
        $table->addCell(150)->addText('Nama');
        $table->addCell(150)->addText('Tempat Lahir');
        $table->addCell(150)->addText('Tanggal Lahir');
        $table->addCell(150)->addText('Alamat');
        $table->addCell(150)->addText('Pekerjaan');
        $table->addCell(150)->addText('Jenis Pekerja');
        $table->addCell(150)->addText('Lokasi Kerja');

        foreach ($listPekerja as $index => $itemPekerja) {
            $table->addRow();

            $table->addCell(150)->addText($index + 1);
            $table->addCell(150)->addText($itemPekerja->nik);
            $table->addCell(150)->addText($itemPekerja->nama);
            $table->addCell(150)->addText($itemPekerja->tempat_lahir);
            $table->addCell(150)->addText($itemPekerja->tgl_lahir);
            $table->addCell(150)->addText($itemPekerja->alamat);
            $table->addCell(150)->addText($itemPekerja->pekerjaan);
            $table->addCell(150)->addText($itemPekerja->jenis_pekerja);
            $table->addCell(150)->addText($itemPekerja->lokasi_kerja);
        }

        $templateProcessor->setComplexBlock('table', $table);

        header("Content-Disposition: attachment; filename=template3.docx");

        $templateProcessor->saveAs('php://output');
        exit;
    }
}
