<?php

namespace App\Controllers\roles_controllers\administrator;

use App\Controllers\BaseController as CodeIgniterBaseController;
use Codeignite\Controller;
use App\Models\ServiceModel;
use App\Models\UserModel;
use App\Models\RoomModel;
use App\Models\OrdersModel;
use App\Models\TaskModel;

class OrderCreateController extends CodeIgniterBaseController
{

    public function index()
    {
        $res_data = session('user_data');

        helper('hcreate');

        $service_model = new ServiceModel();
        $user_model = new UserModel();
        $room_model = new RoomModel();

        $res_data['services'] = $service_model->getAll();
        $res_data['workers'] = $user_model->search_worker('', '', '', '', 3);
        $res_data['rooms'] = $room_model->getSettledRoom();

        echo view('template/header', header_data(2, $res_data))
            . view('roles_view/administrator/orders/create', $res_data);
    }

    public function create_order()
    {
        $validation =  \Config\Services::validation();
        $data = $this->request->getJSON();
        $data = get_object_vars($data);

        if (!$validation->run($data, 'register')) {
            return json_encode([
                'errors' => $validation->getErrors(),
                'status' => 'error',
            ]);
        } else {
            $room_num = $this->request->getJSON()->room_num;
            $worker_id = $this->request->getJSON()->worker_id;
            $services = $this->request->getJSON()->services;

            $room_model = new RoomModel();

            $room = $room_model->getInfo($room_num, 0, null, null, null);

            $order_model = new OrdersModel();
            $task_model = new TaskModel();

            $order_id = $order_model->create_order($room[0]->id, $worker_id);

            foreach ($services as $service) {
                $task_model->create_task($order_id, $service->serv_id, $service->com);
            }

            return json_encode([
                'status' => 'success',
            ]);
        }
    }
}
