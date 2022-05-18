<?php

namespace Modules\Admin\Dashboard\Controllers;

use Modules\Shared\Core\Controllers\BaseWebController;

class DashboardController extends BaseWebController
{

    protected $viewPath = __DIR__;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->renderView('v_index');
    }

}