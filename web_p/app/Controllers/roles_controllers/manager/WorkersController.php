<?php

namespace App\Controllers\roles_controllers\manager;

use App\Controllers\BaseController as CodeIgniterBaseController;
use Codeignite\Controller;
use App\Models\UserModel;
use App\Models\ScheduleModel;
use App\Models\PositionModel;

class WorkersController extends CodeIgniterBaseController
{

    public function index()
    {
        $res_data = session('user_data');

        helper('hcreate');

        $scheduleModel = new ScheduleModel();
        $positionModel = new PositionModel();

        $res_data['schedules'] = $scheduleModel->getAll();
        $res_data['positions'] = $positionModel->getAll();

        echo view('template/header', header_data(1, $res_data))
            . view('roles_view/manager/workers', $res_data);
    }

    public function search_worker()
    {
        $userModel = new UserModel();


        $data = $this->request->getJSON();
        $first_name = $data->first_name;
        $middle_name = $data->middle_name;
        $last_name = $data->last_name;
        $position = $data->position;
        $role_id = $data->role;

        $res_data['search_results'] = $userModel->search_worker($first_name, $middle_name, $last_name, $position, $role_id);

        return $this->response->setJSON(['data' => $res_data['search_results']]);
    }

    public function add_worker()
    {
        $userModel = new UserModel();

        $data = $this->request->getJSON();
        $first_name = $data->first_name;
        $middle_name = $data->middle_name;
        $last_name = $data->last_name;
        $phone_number = $data->phone_number;
        $login_w = $data->login;
        $password_w = md5($data->password);
        $position_id = $data->position;
        $role_id = $data->role;
        $schedule_id = $data->schedule_id;

        $validation =  \Config\Services::validation();
        $data = get_object_vars($data);

        if (!$validation->run($data, 'worker')) {
            $errors = $validation->getErrors();
            $res_data['errors'] = $errors;
            $res_data['status'] = 'error';
            return $this->response->setJSON(['data' => $res_data]);
        }

        $userModel->insert([
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'phone_number' => $phone_number,
            'login_w' => $login_w,
            'password_w' => $password_w,
            'position_id' => $position_id,
            'role_id' => $role_id,
            'schedule_id' => $schedule_id
        ]);

        return $this->response->setJSON(['data' => 'success']);
    }

    public function load_upd_view($id)
    {
        $userModel = new UserModel();
        $scheduleModel = new ScheduleModel();
        $positionModel = new PositionModel();

        $res_data['worker'] = $userModel->get_one($id);
        $res_data['schedules'] = $scheduleModel->getAll();
        $res_data['positions'] = $positionModel->getAll();

        echo view('roles_view/manager/workers_upd', $res_data);
    }

    public function update_worker()
    {
        $userModel = new UserModel();

        $data = $this->request->getJSON();
        $id = $data->id;
        $first_name = $data->first_name;
        $middle_name = $data->middle_name;
        $last_name = $data->last_name;
        $phone_number = $data->phone_number;
        $login_w = $data->login_w;
        $password_w = md5($data->password_w);
        $position_id = $data->position_id;
        $role_id = $data->role_id;
        $schedule_id = $data->schedule_id;

        $validation =  \Config\Services::validation();
        $data = get_object_vars($data);

        if (!$validation->run($data, 'worker')) {
            $errors = $validation->getErrors();
            $res_data['errors'] = $errors;
            $res_data['status'] = 'error';
            return $this->response->setJSON(['data' => $res_data]);
        }

        $userModel->update_worker($id, $first_name, $middle_name, $last_name, $phone_number, $login_w, $password_w, $position_id, $role_id, $schedule_id);

        return $this->response->setJSON(['data' => 'success']);
    }
}
