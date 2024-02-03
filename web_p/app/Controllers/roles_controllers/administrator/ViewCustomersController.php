<?php

namespace App\Controllers\roles_controllers\administrator;

use App\Controllers\BaseController as CodeIgniterBaseController;
use Codeignite\Controller;
use App\Models\CustomerModel;

class ViewCustomersController extends CodeIgniterBaseController
{

    public function index()
    {
        $session_data = session('user_data');

        helper('hcreate');

        echo view('template/header', header_data(2, $session_data))
            . view('roles_view/administrator/customers', $session_data);
    }

    public function search_customer()
    {
        $data = $this->request->getJSON();
        $first_name = $data->first_name;
        $middle_name = $data->middle_name;
        $last_name = $data->last_name;
        $phone_number = $data->phone_number;

        $customerModel = new CustomerModel();

        $res_data['search_results'] = $customerModel->search_customer($first_name, $middle_name, $last_name, $phone_number);
        return $this->response->setJSON(['data' => $res_data['search_results']]);
    }

    public function add_customer()
    {
        $data = $this->request->getJSON();
        $first_name = $data->first_name;
        $middle_name = $data->middle_name;
        $last_name = $data->last_name;
        $phone_number = $data->phone_number;
        $pseudonym = $data->pseudonym;

        $validation =  \Config\Services::validation();
        $data = get_object_vars($data);
        if (!$validation->run($data, 'customer')) {
            $errors = $validation->getErrors();
            $res_data['errors'] = $errors;
            $res_data['status'] = 'error';
            return $this->response->setJSON(['data' => $res_data]);
        } else {
            $customerModel = new CustomerModel();

            $customerModel->add_customer($first_name, $middle_name, $last_name, $phone_number, $pseudonym);

            return $this->response->setJSON(['data' => 'success']);
        }
    }
}
