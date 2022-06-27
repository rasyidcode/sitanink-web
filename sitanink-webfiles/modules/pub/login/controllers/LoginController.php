<?php

namespace Modules\Pub\Login\Controllers;

use Modules\Pub\Login\Models\LoginModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class LoginController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $loginModel;

    public function __construct()
    {
        parent::__construct();

        $this->loginModel = new LoginModel();
    }

    public function index()
    {
        return $this->renderView('v_login');
    }

    public function login()
    {
        $rules = [
            'username'  => 'required',
            'password'  => 'required'
        ];
        $message = [
            'username'  => [
                'required'  => 'Username tidak boleh kosong!'
            ],
            'password'  => [
                'required'  => 'Password tidak boleh kosong!'
            ],
        ];
        if (!$this->validate($rules, $message)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $dataPost = (object) $this->request->getPost();
        $userdata = $this->loginModel->getUser($dataPost->username);
        if (is_null($userdata)) {
            session()->setFlashdata('error', 'User tidak ditemukan!');
            return redirect()->back()->withInput();
        }

        if (!password_verify($dataPost->password, $userdata->password)) {
            session()->setFlashdata('error', 'Password salah!');
            return redirect()->back()->withInput();
        }

        session()->set([
            'logged_in' => true,
            'username'  => $userdata->username,
            'level'     => $userdata->level,
            'user_id'   => $userdata->id,
        ]);

        return redirect()->route('admin');
    }
}
