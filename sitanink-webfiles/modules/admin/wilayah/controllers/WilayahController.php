<?php

namespace Modules\Admin\Wilayah\Controllers;

use Modules\Admin\Wilayah\Models\WilayahModel;
use Modules\Shared\Core\Controllers\BaseWebController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class WilayahController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $wilayahModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();
        $this->wilayahModel = new WilayahModel($db);

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Data Per Wilayah',
            'pageDesc'  => 'Monitor pekerja berdasarkan wilayah'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-wilayah' => [
                'url'       => route_to('wilayah'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_index', $this->viewData);
    }

    public function downloadExcel()
    {
        $data = $this->wilayahModel->getList();
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        foreach(range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', '#')
            ->setCellValue('B1', 'Lokasi')
            ->setCellValue('C1', 'Longitude')
            ->setCellValue('D1', 'Latitude')
            ->setCellValue('E1', 'Jumlah Pekerja')
            ->setCellValue('F1', 'Created At');

        $startColumn = 2;
        foreach ($data as $index => $item) {
            $sheet->setCellValue('A' . $startColumn, $index + 1)
                ->setCellValue('B' . $startColumn, $item->nama)
                ->setCellValue('C' . $startColumn, $item->lon)
                ->setCellValue('D' . $startColumn, $item->lat)
                ->setCellValue('E' . $startColumn, $item->total_pekerja)
                ->setCellValue('F' . $startColumn, $item->created_at);
            $startColumn++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = time() . '_data_perwilayah';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        die();
    }
}
