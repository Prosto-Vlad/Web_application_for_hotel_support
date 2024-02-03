<?php

namespace App\Controllers\roles_controllers\manager;

use App\Controllers\BaseController as CodeIgniterBaseController;
use Codeignite\Controller;
use App\Models\ServiceModel;

class ServicesController extends CodeIgniterBaseController
{

    public function index()
    {
        $session_data = session('user_data');

        helper('hcreate');

        echo view('template/header', header_data(1, $session_data))
            . view('roles_view/manager/services', $session_data);
    }

    public function search_services()
    {
        $data = $this->request->getJSON();

        $name = $data->name;

        $serviceModel = new ServiceModel();

        $res_data['search_results'] = $serviceModel->search_services($name);

        return $this->response->setJSON(['data' => $res_data['search_results']]);
    }

    public function add_services()
    {
        $data = $this->request->getJSON();
        $name = $data->name;
        $cost = $data->cost;
        $details = $data->details;
        $serviceModel = new ServiceModel();

        $validation =  \Config\Services::validation();
        $data = get_object_vars($data);
        if (!$validation->run($data, 'service')) {
            $errors = $validation->getErrors();
            $res_data['errors'] = $errors;
            $res_data['status'] = 'error';
            return $this->response->setJSON(['data' => $res_data]);
        }

        $serviceModel->add_services($name, $cost, $details);

        return $this->response->setJSON(['data' => 'success']);
    }

    public function load_upd_view($id)
    {
        $serviceModel = new ServiceModel();

        $res_data['service'] = $serviceModel->get_one($id);

        echo view('roles_view/manager/services_upd', $res_data);
    }

    public function update_service()
    {
        $data = $this->request->getJSON();
        $id = $data->id;
        $name = $data->name;
        $cost = $data->cost;
        $details = $data->details;
        $serviceModel = new ServiceModel();

        $serviceModel->update_service($id, $name, $cost, $details);

        return $this->response->setJSON(['data' => 'success']);
    }
}
