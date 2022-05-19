<?php

namespace Modules\Admin\User\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use Modules\Admin\User\Models\UserModel;
use Modules\Shared\Core\Controllers\BaseWebController;

class UserController extends BaseWebController
{

    protected $viewPath = __DIR__;

    private $userModel;

    public function __construct()
    {
        parent::__construct();

        $this->userModel = new UserModel();
    }

    public function index()
    {
        return $this->renderView('v_index', [
            'pageTitle' => 'Data User',
            'pageDesc'  => 'Halaman Managemen Data User',
            'pageLinks' => [
                'dashboard' => [
                    'url'       => route_to('admin'),
                    'active'    => false,
                ],
                'data-user' => [
                    'url'       => route_to('user'),
                    'active'    => true,
                ],
            ]
        ]);
    }

    public function getData()
    {
        $postData   = $this->request->getPost();
        $data       = $this->userModel->getData($postData);
        $num        = $postData['start'];

        $resData = [];
        foreach ($data as $item) {
            $num++;

            $row    = [];
            $row[]  = "<input type=\"hidden\" value=\"" . $item->id . "\">{$num}.";
            $row[]  = $item->username ?? '-';
            $row[]  = $item->email ?? '-';
            $badge = '';
            if ($item->level == 'admin') {
                $badge = 'success';
            } else if ($item->level == 'reguler') {
                $badge = 'info';
            }
            $row[]  = "<span class=\"badge btn-" . $badge . "\">" . $item->level . "</span>";
            $row[]  = $item->last_login ?? '-';
            $row[]  = $item->created_at ?? '-';
            $row[]  = "<div class=\"text-center\">
                            <a href=\"" . route_to('user.reset-pass', $item->id). "\" class=\"btn btn-warning btn-xs mr-2\"><i class=\"fa fa-key\"></i>&nbsp;Reset Password</a>
                            <a href=\"" . base_url() . "\" class=\"btn btn-info btn-xs mr-2\"><i class=\"fa fa-pencil-square-o\"></i>&nbsp;Edit</a>
                            <a id=\"delete-user\" href=\"javascript:void(0)\" data-user-id=\".$item->id.\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i>&nbsp;Hapus</a>
                        </div>";
            $resData[] = $row;
        }

        return $this->response
            ->setJSON([
                'draw'              => $postData['draw'],
                'recordsTotal'      => $this->userModel->countData(),
                'recordsFiltered'   => $this->userModel->countFilteredData($postData),
                'data'              => $resData
            ])
            ->setStatusCode(ResponseInterface::HTTP_OK);
    }

    public function add()
    {
        return $this->renderView('v_add', [
            'pageTitle' => 'Tambah User',
            'pageDesc'  => 'Form penambahan user baru',
            'pageLinks' => [
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
            ]
        ]);
    }

    public function create()
    {
        $rules = [
            'username'  => 'required|is_unique[users.username]|min_length[3]',
            'password'  => 'required|min_length[8]',
            'repassword'    => 'required|min_length[8]|matches[password]',
            'email'     => 'required|valid_email|is_unique[users.email]',
            'level'     => 'required|in_list[admin,reguler]'
        ];
        $messages = [
            'username'  => [
                'required'  => 'Username tidak boleh kosong!',
                'is_unique'  => 'Username harus unik!',
                'min_length'  => 'Username minimal harus memiliki 3 karakter!',
            ],
            'password'  => [
                'required'  => 'Password tidak boleh kosong!',
                'min_length'    => 'Tidak boleh kurang dari 8 karakter',
            ],
            'repassword'    => [
                'required'  => 'Konfirmasi password tidak boleh kosong!',
                'min_length'    => 'Tidak boleh kurang dari 8 karakter',
                'matches'   => 'Harus sama dengan kolom password'
            ],
            'email' => [
                'required'  => 'Email tidak boleh kosong!',
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
        unset($dataPost['repassword']);
        $dataPost['password'] = password_hash($dataPost['password'], PASSWORD_BCRYPT);
        $this->userModel->create($dataPost);

        session()->setFlashdata('success', 'User berhasil ditambahkan!');
        return redirect()->back()
                    ->route('user');
    }

    public function resetPass($id)
    {
        return $this->renderView('v_reset_pass', [
            'pageTitle' => 'Reset Password User',
            'pageDesc'  => 'Form mereset password user',
            'pageLinks' => [
                'dashboard' => [
                    'url'       => route_to('admin'),
                    'active'    => false,
                ],
                'data-user' => [
                    'url'       => route_to('user'),
                    'active'    => false,
                ],
                'reset-password-user' => [
                    'url'       => route_to('user.reset-pass', $id),
                    'active'    => true,
                ],
            ]
        ]);
    }
}
