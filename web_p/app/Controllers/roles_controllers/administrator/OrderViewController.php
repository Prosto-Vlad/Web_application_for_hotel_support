<?php

namespace App\Controllers\roles_controllers\administrator;

use App\Controllers\BaseController as CodeIgniterBaseController;
use Codeignite\Controller;
use App\Models\OrdersModel;
use App\Models\TaskModel;

class OrderViewController extends CodeIgniterBaseController
{

    public function index()
    {
        $session_data = session('user_data');

        helper('hcreate');

        echo view('template/header', header_data(2, $session_data))
            . view('roles_view/administrator/orders/view', $session_data);
    }

    public function search_order()
    {
        $ordersModel = new OrdersModel();

        $data = $this->request->getJSON();

        $number = $data->number;
        $create_date = $data->create_date;

        $res_data['orders'] = $ordersModel->search_order($number, $create_date);

        return $this->response->setJSON(['data' => $res_data['orders']]);
    }

    public function load_upd_view($id)
    {
        $ordersModel = new OrdersModel();
        $taskModel = new TaskModel();

        $res_data['order'] = $ordersModel->get_by_id($id);
        $res_data['tasks'] = $taskModel->get_by_order($res_data['order']->id);

        echo view('roles_view/administrator/orders/view_upd', $res_data);
    }

    public function update_order()
    {
        $ordersModel = new OrdersModel();

        $data = $this->request->getJSON();

        $order_id = $data->id;
        $worker_id = $data->worker_id;
        $is_payed = $data->is_payed;
        $is_finish = $data->is_finish;
        $create_date = $data->create_date;
        $room_id = $data->room_id;

        $data->is_payed = $is_payed ? 'true' : 'false';
        $data->is_finish = $is_finish ? 'true' : 'false';
        $validation =  \Config\Services::validation();

        $data = get_object_vars($data);
        var_dump($data);
        if (!$validation->run($data, 'order')) {
            $errors = $validation->getErrors();
            $res_data['errors'] = $errors;
            $res_data['status'] = 'error';
            return $this->response->setJSON(['data' => $res_data]);
        }

        $ordersModel->update_order($order_id, $worker_id, $is_payed, $is_finish, $create_date, $room_id);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete_task()
    {
        $taskModel = new TaskModel();

        $ordersModel = new OrdersModel();

        $check = false;

        $data = $this->request->getJSON();

        $task_id = $data->id;
        $order_id = $data->order_id;

        $taskModel->delete_task($task_id);

        if ($taskModel->get_by_order($order_id) == null) {
            $ordersModel->delete_order($order_id);
            $check = true;
        }

        if ($check) {
            return $this->response->setJSON(['status' => 'success_end']);
        } else {
            return $this->response->setJSON(['status' => 'success']);
        }
    }
}
