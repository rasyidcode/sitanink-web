<?php

namespace Modules\Public\Login\Controllers;

use Modules\Shared\Core\Controllers\BaseWebController;

class LoginController extends BaseWebController
{

    protected $viewPath = __DIR__;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->renderView('v_login');
    }

    public function login()
    {
        
    }
}
