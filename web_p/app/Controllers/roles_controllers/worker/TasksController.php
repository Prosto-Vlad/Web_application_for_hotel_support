<?php

namespace App\Controllers\roles_controllers\worker;

use App\Controllers\BaseController as CodeIgniterBaseController;
use Codeignite\Controller;
use App\Models\UserModel;
use App\Models\TaskModel;
use App\Models\OrdersModel;

class TasksController extends CodeIgniterBaseController
{

    public function index()
    {
        $session_data = session('user_data');

        helper('hcreate');

        echo view('template/header', header_data(3, $session_data))
            . view('roles_view/worker/tasks', $session_data);
    }

    public function load()
    {
        $session_data = session('user_data');

        $taskModel = new TaskModel();

        $tasks = $taskModel->get_by_worker($session_data['id']);

        $res_data['tasks'] = $tasks;

        return $this->response->setJSON(['data' => $res_data['tasks']]);
    }

    public function update_task()
    {
        $taskModel = new TaskModel();
        $ordersModel = new OrdersModel();

        $data = $this->request->getJSON();

        $task_id = $data->id;
        $is_finish = $data->is_finished;

        $task = $taskModel->get_by_id($task_id);

        $taskModel->update_task($task_id, $is_finish, $task->notes);

        $is_finished = $ordersModel->check_is_finished($task->order_id);


        $order = $ordersModel->get_by_id($task->order_id);

        if ($is_finished) {
            $ordersModel->update_order($order->id, $order->worker_id, $order->discount, $order->is_payed, true, $order->create_date, $order->room_id);
        }

        return $this->response->setJSON(['data' => 'success']);
    }
}
