<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class LogoutController extends BaseController
{
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('signin'));
    }
}
