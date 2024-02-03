<?php

namespace App\Controllers\roles_controllers\administrator;

use App\Controllers\BaseController as CodeIgniterBaseController;
use Codeignite\Controller;
use App\Models\CustomerModel;
use App\Models\TypeModel;
use App\Models\RoomModel;
use App\Models\SettlementModel;

class RoomsRegisterController extends CodeIgniterBaseController
{

    public function index()
    {
        $res_data = session('user_data');

        helper('hcreate');

        $typeModel = new TypeModel();

        $res_data['room_types'] = $typeModel->getTypes();

        echo view('template/header', header_data(2, $res_data))
            . view('roles_view/administrator/rooms/register', $res_data);
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

    public function phone_search()
    {
        $data = $this->request->getJSON();

        $customerModel = new CustomerModel();

        $res_data['search_results'] = $customerModel->search_customer('', '', '', $data->phone_number);
        return $this->response->setJSON(['data' => $res_data['search_results']]);
    }

    public function search_room()
    {
        $data = $this->request->getJSON();

        $roomModel = new RoomModel();

        $res_data['search_results'] = $roomModel->searchFreeRoom($data->type, $data->min_price, $data->max_price, $data->beds_num, $data->booking_from, $data->booking_to);

        return $this->response->setJSON(['data' => $res_data['search_results']]);
    }

    public function add_settlement()
    {
        $data = $this->request->getJSON();

        $settlementModel = new SettlementModel();
        $customerModel = new CustomerModel();

        $cust_id = $customerModel->search_customer('', '', '', $data->phone_number)[0]->id;

        $settlementModel->addSettlement($data->room_id, $cust_id, $data->date_from, $data->date_to, $data->description);

        return $this->response->setJSON(['data' => 'success']);
    }
}
