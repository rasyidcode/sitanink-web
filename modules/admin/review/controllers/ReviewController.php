<?php

namespace Modules\Admin\Review\Controllers;

use Modules\Admin\Review\Models\ReviewModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class ReviewController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $reviewModel;

    public function __construct()
    {
        parent::__construct();

        $this->reviewModel = new ReviewModel();
    }

    public function index()
    {
        $dataReview = $this->reviewModel->getData();

        return $this->renderView('v_review', [
            'pageTitle' => 'Review Data Pekerja',
            'pageDesc'  => 'Halaman List Data Pekerja Yang Harus Direview',
            'pageLinks' => [
                'dashboard' => [
                    'url'       => route_to('admin'),
                    'active'    => false,
                ],
                'data-review' => [
                    'url'       => route_to('review'),
                    'active'    => true,
                ],
            ],
            'dataReview'    => $dataReview
        ]);
    }

    public function confirm($id)
    {
        $reviewData = $this->reviewModel->getPekerja($id);
        $berkasData = $this->reviewModel->getBerkasPekerja($id);

        $foto = null;
        $ktp = null;
        $sp = null;

        foreach ($berkasData as $berkasDataItem) {
            if ($berkasDataItem->type === 'foto') {
                $foto = $berkasDataItem;
            } else if ($berkasDataItem->type === 'ktp') {
                $ktp = $berkasDataItem;
            } else if ($berkasDataItem->type === 'sp') {
                $sp = $berkasDataItem;
            }
        }

        return $this->renderView('v_review_confirm', [
            'pageTitle' => 'Verifikasi Pekerja',
            'pageDesc'  => 'Halaman untuk memverifikasi data pekerja yang baru diinput',
            'pageLinks' => [
                'dashboard' => [
                    'url'       => route_to('admin'),
                    'active'    => false,
                ],
                'data-review' => [
                    'url'       => route_to('pekerja.review'),
                    'active'    => false,
                ],
                'review-pekerja' => [
                    'url'       => route_to('pekerja.review-confirm', $id),
                    'active'    => true,
                ],
            ],
            'reviewData'  => $reviewData,
            'berkasData'  => [
                'foto'  => $foto,
                'ktp'   => $ktp,
                'sp'    => $sp
            ],
        ]);
    }

    public function doConfirm($id)
    {
        // get data pekerja_temp by id
        $data = $this->reviewModel->getOne($id);
        unset($data->deleted_at);
        unset($data->id);
        unset($data->created_at);
        unset($data->updated_at);

        // insert to data pekerja
        $lastId = $this->reviewModel->insertNew((array)$data);

        // insert all the berkas
        $dataBerkas = $this->reviewModel->getBerkasPekerjaTemp($id);
        if (!empty($dataBerkas)) {
            $newData = [];
            $ids = [];
            foreach ($dataBerkas as $dataBerkasItem) {
                $ids[] = $dataBerkasItem->id;
                $newData[] = [
                    'id_pekerja'    => $lastId,
                    'id_berkas' => $dataBerkasItem->id_berkas
                ];
                $this->reviewModel->insertBerkas($newData);
            }

            // remove the old data (pekerja_temp_berkas)
            $this->reviewModel->removePekerjaBerkasTemp($ids);
        }

        // remove the old data (pekerja_temp)
        $this->reviewModel->removePekerjaTemp($id);

        session()->setFlashdata('success', 'Pekerja telah ditambahkan!');
        return redirect()->back()
            ->route('pekerja');
    }

    public function cancel($id)
    {
        $this->reviewModel->removePekerjaTempSd($id);

        return redirect()->back()
            ->route('review');
    }
}
