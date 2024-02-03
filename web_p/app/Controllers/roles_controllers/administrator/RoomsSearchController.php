<?php

namespace App\Controllers\roles_controllers\administrator;

use App\Controllers\BaseController as CodeIgniterBaseController;
use Codeignite\Controller;
use App\Models\RoomModel;
use App\Models\TypeModel;

class RoomsSearchController extends CodeIgniterBaseController
{

    public function index()
    {
        $res_data = session('user_data');

        helper('hcreate');

        $typeModel = new TypeModel();

        $res_data['room_types'] = $typeModel->getTypes();

        echo view('template/header', header_data(2, $res_data))
            . view('roles_view/administrator/rooms/search', $res_data);
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
        $booking_from = $data->booking_from;
        $booking_to = $data->booking_to;
        $status = $data->status;


        $res_data['search_results'] = $roomModel->searchRooms($number, $type, $min_price, $max_price, $num_of_beds, $booking_from, $booking_to, $status);

        return $this->response->setJSON(['data' => $res_data['search_results']]);
    }

    public function update_room_status()
    {
        $roomModel = new RoomModel();

        $data = $this->request->getGetPost();
        $settlement_id = $data['settlement_id'];
        $status = $data['status'];

        return $roomModel->updateStatus($settlement_id, $status);
    }
}
