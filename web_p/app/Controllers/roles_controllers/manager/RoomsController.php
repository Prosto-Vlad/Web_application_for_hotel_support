<?php

namespace App\Controllers\roles_controllers\manager;

use App\Controllers\BaseController as CodeIgniterBaseController;
use Codeignite\Controller;
use App\Models\RoomModel;
use App\Models\TypeModel;

class RoomsController extends CodeIgniterBaseController
{

    public function index()
    {
        $res_data = session('user_data');

        helper('hcreate');

        $typeModel = new TypeModel();

        $res_data['room_types'] = $typeModel->getTypes();

        echo view('template/header', header_data(1, $res_data))
            . view('roles_view/manager/rooms', $res_data);
    }

    public function search_room()
    {

        $roomModel = new RoomModel();

        $data = $this->request->getJSON();
        $number = $data->number;
        $type = $data->type;
        $min_price = $data->min_price;
        $max_price = $data->max_price;
        $num_of_beds = $data->beds_num;

        $res_data['search_results'] = $roomModel->searchRooms($number, $type, $min_price, $max_price, $num_of_beds);

        return $this->response->setJSON(['data' => $res_data['search_results']]);
    }

    public function info()
    {
        $roomModel = new RoomModel();

        $data = $this->request->getJSON();
        $number = $data->number;
        $type = $data->type;
        $min_price = $data->min_price;
        $max_price = $data->max_price;
        $num_of_beds = $data->beds_num;

        $res_data['search_results'] = $roomModel->getInfo($number, $type, $min_price, $max_price, $num_of_beds);

        return $this->response->setJSON(['data' => $res_data['search_results']]);
    }

    public function load_upd_view($id)
    {
        $serviceModel = new RoomModel();
        $typeModel = new TypeModel();

        $res_data['room'] = $serviceModel->get_one($id);
        $res_data['room_types'] = $typeModel->getTypes();
        echo view('roles_view/manager/rooms_upd', $res_data);
    }

    public function update_room()
    {
        $roomModel = new RoomModel();
        $data = $this->request->getJSON();
        $id = $data->id;
        $cost_r = $data->cost_r;
        $beds_num = $data->beds_num;
        $number = $data->number;
        $description = $data->description;
        $type_id = $data->type_id;

        $roomModel->update_room($id, $number, $cost_r, $beds_num, $description, $type_id,);

        return $this->response->setJSON(['data' => 'success']);
    }
}
