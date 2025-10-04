<?php

namespace Modules\Admin\User\Controllers;

use App\Exceptions\ApiAccessErrorException;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\Admin\User\Models\UserModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class UserController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $userModel;

    private $viewData = [];

    public function __construct()
    {
        parent::__construct();

        $this->userModel = new UserModel();

        $this->__initViewData();
    }

    private function __initViewData()
    {
        $this->viewData = [
            'pageTitle' => 'Data User',
            'pageDesc'  => 'Halaman manajemen data user'
        ];
    }

    public function index()
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-user' => [
                'url'       => route_to('user'),
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
            'data-user' => [
                'url'       => route_to('user'),
                'active'    => false,
            ],
            'tambah-user' => [
                'url'       => route_to('user.add'),
                'active'    => true,
            ],
        ];

        return $this->renderView('v_add', $this->viewData);
    }

    public function create()
    {
        $rules = [
            'username'  => 'required|is_unique[users.username]|min_length[3]',
            'password'  => 'required|min_length[5]',
            'repassword'    => 'required|min_length[5]|matches[password]',
            'email'     => 'required|valid_email|is_unique[users.email]',
            'level'     => 'required|in_list[admin,reguler]'
        ];
        $messages = [
            'username'  => [
                'required'  => 'Username tidak boleh kosong!',
                'is_unique'  => 'Username telah dipakai!',
                'min_length'  => 'Username minimal harus memiliki 3 karakter!',
            ],
            'password'  => [
                'required'  => 'Password tidak boleh kosong!',
                'min_length'    => 'Tidak boleh kurang dari 8 karakter',
            ],
            'repassword'    => [
                'required'  => 'Konfirmasi password tidak boleh kosong!',
                'min_length'    => 'Tidak boleh kurang dari 5 karakter',
                'matches'   => 'Harus sama dengan kolom password'
            ],
            'email' => [
                'required'  => 'Email tidak boleh kosong!',
                'valid_email'   => 'Email tidak valid',
                'is_unique'  => 'Email telah dipakai!',
            ],
            'level' => [
                'required'  => 'Pilih salah satu level',
                'in_list'   => 'Hanya boleh admin dan reguler'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();
        unset($dataPost['repassword']);
        $dataPost['password'] = password_hash($dataPost['password'], PASSWORD_BCRYPT);
        $this->userModel->create($dataPost);

        session()->setFlashdata('success', 'User berhasil ditambahkan!');
        return redirect()->back()
            ->route('user');
    }

    public function changePass($id)
    {
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-user' => [
                'url'       => route_to('user'),
                'active'    => false,
            ],
            'reset-password-user' => [
                'url'       => route_to('user.change-pass', $id),
                'active'    => true,
            ],
        ];
        $this->viewData['userId'] = $id;

        return $this->renderView('v_change_pass', $this->viewData);
    }

    public function doChangePass($id)
    {
        $rules = [
            'password'  => 'required|min_length[5]',
            'repassword'    => 'required|min_length[5]|matches[password]',
        ];
        $messages = [
            'password'  => [
                'required'  => 'Password tidak boleh kosong!',
                'min_length'    => 'Tidak boleh kurang dari 8 karakter',
            ],
            'repassword'    => [
                'required'  => 'Konfirmasi password tidak boleh kosong!',
                'min_length'    => 'Tidak boleh kurang dari 5 karakter',
                'matches'   => 'Harus sama dengan kolom password'
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back();
        }

        $dataPost = $this->request->getPost();
        $newPassword = password_hash($dataPost['password'], PASSWORD_BCRYPT);
        $this->userModel->updatePassword($id, $newPassword);

        session()->setFlashdata('success', 'Password telah diubah!');
        return redirect()->back()
            ->route('user');
    }

    public function edit($id)
    {
        $this->viewData['userdata'] = $this->userModel->get($id);
        $this->viewData['pageLinks'] = [
            'dashboard' => [
                'url'       => route_to('admin'),
                'active'    => false,
            ],
            'data-user' => [
                'url'       => route_to('user'),
                'active'    => false,
            ],
            'edit-user' => [
                'url'       => route_to('user.edit', $id),
                'active'    => true,
            ],
        ];
        return $this->renderView('v_edit', $this->viewData);
    }

    public function update($id)
    {
        $rules = [
            'username'  => 'required|min_length[3]',
            'email'     => 'required|valid_email',
            'level'     => 'required|in_list[admin,reguler]'
        ];
        $messages = [
            'username'  => [
                'required'  => 'Username tidak boleh kosong!',
                'is_unique'  => 'Username telah dipakai!',
                'min_length'  => 'Username minimal harus memiliki 3 karakter!',
            ],
            'email' => [
                'required'  => 'Email tidak boleh kosong!',
                'is_unique'  => 'Email telah dipakai!',
                'valid_email'   => 'Email tidak valid'
            ],
            'level' => [
                'required'  => 'Pilih salah satu level',
                'in_list'   => 'Hanya boleh admin dan reguler'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            session()->setFlashdata('error', $this->validator->getErrors());
            return redirect()->back()
                ->withInput();
        }

        $dataPost = $this->request->getPost();
        unset($dataPost['csrf_token_sitanink']);

        $currData = $this->userModel->get((int)$id);

        $getByUser = $this->userModel->getByUsername($dataPost['username']);
        if (!is_null($getByUser)) {
            if ($currData->username != $getByUser->username) {
                session()->setFlashdata('error', [
                    'username'  => 'Username telah dipakai!'
                ]);
                return redirect()->back()
                    ->withInput();
            }
        }

        $getByEmail = $this->userModel->getByEmail($dataPost['email']);
        if (!is_null($getByEmail)) {
            if ($currData->email != $getByEmail->email) {
                session()->setFlashdata('error', [
                    'email'  => 'Email telah dipakai!'
                ]);
                return redirect()->back()
                    ->withInput();
            }
        }

        $this->userModel->updateUser($dataPost, (int) $id);

        session()->setFlashdata('success', 'Data user telah diperbaharui!');
        return redirect()->back()
            ->route('user');
    }

    public function delete($id)
    {
        $user = $this->userModel->get($id);
        if (is_null($user)) {
            throw new ApiAccessErrorException(message: 'User not found', statusCode: ResponseInterface::HTTP_NOT_FOUND);
        }

        $this->userModel->deleteUser($id);

        return $this->response
            ->setJSON([
                'message' => 'User terhapus!'
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }
}
