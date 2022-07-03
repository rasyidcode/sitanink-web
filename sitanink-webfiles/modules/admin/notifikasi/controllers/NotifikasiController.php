<?php

namespace Modules\Admin\Notifikasi\Controllers;

use Carbon\Carbon;
use Modules\Admin\Activities\Models\ActivityModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class NotifikasiController extends BaseWebController
{

    protected $viewPath = __DIR__;

    /**
     * @var ActivityModel
     */
    private $activityModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $db = \Config\Database::connect();

        $this->activityModel = new ActivityModel($db);

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Notifikasi',
            'pageDesc'  => 'Halaman notifikasi'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'notifikasi' => [
                'url'       => route_to('lokasi-kerja'),
                'active'    => true,
            ],
        ];
        $activities = $this->activityModel->allForNotification();
        $newActivities = [];
        foreach ($activities as $activity) {
            $thedate = Carbon::createFromDate($activity->created_at)->format('Y-m-d');
            $activity->time_ago = Carbon::createFromDate($activity->created_at)->diffForHumans();
            $newActivities[convertDate($thedate)][] = $activity;
        }
        $this->viewData['activities'] = $newActivities;
        // echo "<pre>";
        // print_r($newActivities['30 Juli 2022'][0]);
        // echo "</pre>";
        // die();
        return $this->renderView('v_index', $this->viewData);
    }
}
