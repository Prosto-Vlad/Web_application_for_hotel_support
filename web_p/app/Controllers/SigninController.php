<?php

namespace App\Controllers;

use Codeignite\Controller;
use App\Models\UserModel;

class SigninController extends BaseController
{

    public function index()
    {
        helper(['form']);

        $session = session();

        $session->set('user_data', []);
        $session->set('logged_in', false);

        if ($session->get('logged_in')) {
            switch ($session->get('role_id')) {
                case '1':
                    return redirect()->to(base_url('manager/workers'));
                    break;
                case '2':
                    return redirect()->to(base_url('administrator/rooms/search'));
                    break;
                case '3':
                    return redirect()->to(base_url('worker/tasks'));
                    break;
                default:
                    $session->setFlashdata('msg', 'Error. Role not found');
                    return redirect()->to(base_url('signin'));
                    break;
            }
        } else {
            echo view('signin');
        }
    }

    public function signin()
    {
        $session = session();

        $userModel = new UserModel();

        $login = $this->request->getVar('login');
        $password = $this->request->getVar('password');

        $data = $userModel->where('login_w', $login)->first();

        if ($data) {

            $hashedPassword = md5($password);

            if ($hashedPassword == $data['password_w']) {
                $ses_data = [
                    'id' => $data['id'],
                    'role_id' => $data['role_id'],
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'login_w' => $data['login_w'],
                    'password_w' => $data['password_w'],
                ];

                $session->set('user_data', $ses_data);
                $session->set('logged_in', true);

                switch ($data['role_id']) {
                    case '1':
                        return redirect()->to(base_url('manager/workers'));
                        break;
                    case '2':
                        return redirect()->to(base_url('administrator/rooms/search'));
                        break;
                    case '3':
                        return redirect()->to(base_url('worker/tasks'));
                        break;
                    default:
                        $session->setFlashdata('msg', 'Error. Role not found');
                        return redirect()->to(base_url('signin'));
                        break;
                }
            } else {
                $session->setFlashdata('msg', 'Невірний пароль');
                echo view('signin');
            }
        } else {
            $session->setFlashdata('msg', 'Логін не знайдений');
            echo view('signin');
        }
    }
}
