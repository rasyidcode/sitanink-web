<?php

namespace Modules\Admin\Pekerja\Controllers;

use Modules\Admin\Pekerja\Models\ReviewModel;
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
        return $this->renderView('v_review', [
            'pageTitle' => 'Review Data Pekerja',
            'pageDesc'  => 'Halaman List Data Pekerja Yang Harus Direview',
            'pageLinks' => [
                'dashboard' => [
                    'url'       => route_to('admin'),
                    'active'    => false,
                ],
                'data-review' => [
                    'url'       => route_to('pekerja.review'),
                    'active'    => true,
                ],
            ]
        ]);
    }

    public function confirm($id)
    {
        $reviewData = $this->reviewModel->getPekerja($id);
        $berkasData = $this->reviewModel->getBerkasPekerja($id);

        $foto = null;
        $ktp = null;
        $sp = null;

        foreach($berkasData as $berkasDataItem) {
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

}