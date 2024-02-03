<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdersModel extends Model
{
    protected $table = 'orders';
    protected $allowedFields = [
        'id',
        'room_id',
        'worker_id',
        'is_payed',
        'is_finish',
        'create_date',
    ];

    public function get_all()
    {
        $query = $this->db->table('orders')
            ->select('orders.*, room.number, customer.first_name, customer.middle_name, customer.last_name')
            ->join('settlement', 'orders.room_id = settlement.room_id', 'left')
            ->join('room', 'settlement.room_id = room.id', 'left')
            ->join('customer', 'settlement.customer_id = customer.id', 'left');

        return $query->get()->getResult();
    }
    public function get_by_id($id)
    {
        $query = $this->db->table('orders')
            ->select('orders.*,
            room.number, room.id as room_id,
            customer.first_name as cust_first_name, customer.middle_name as cust_middle_name, customer.last_name as cust_last_name, customer.id as cust_id, 
            worker.first_name as worker_first_name, worker.middle_name as worker_middle_name, worker.last_name as worker_last_name, worker.id as worker_id')
            ->join('settlement', 'orders.room_id = settlement.room_id', 'left')
            ->join('worker', 'orders.worker_id = worker.id', 'left')
            ->join('customer', 'settlement.customer_id = customer.id', 'left')
            ->join('room', 'orders.room_id = room.id', 'left')
            ->where('orders.id', $id);


        return $query->get()->getRow();
    }

    public function search_order($number, $create_date)
    {
        $query = $this->db->table('orders')
            ->select('orders.*, room.number, customer.first_name, customer.middle_name, customer.last_name')
            ->join('settlement', 'orders.room_id = settlement.room_id', 'left')
            ->join('customer', 'settlement.customer_id = customer.id', 'left')
            ->join('room', 'orders.room_id = room.id', 'left')
            ->where('orders.is_finish', false)
            ->where('orders.create_date >= settlement.settlement_date')
            ->where('orders.create_date <= settlement.eviction_date');

        if ($number != '') {
            $query->where('room.number', $number);
        }
        if ($create_date != null) {
            $query->where('orders.create_date', $create_date);
        }

        return $query->get()->getResult();
    }

    public function check_is_finished($order_id)
    {
        $query = $this->db->table('orders')
            ->select('orders.*, task.*')
            ->join('task', 'orders.id = task.order_id', 'left')
            ->where('orders.is_finish', false)
            ->where('task.is_finish', false)
            ->where('orders.id', $order_id);

        if ($query->get()->getResult() == null) {
            return true;
        } else {
            return false;
        }

        return $query->get()->getResult();
    }

    public function create_order($room_id, $worker_id)
    {

        $this->db->table('orders')->insert([
            'room_id' => $room_id,
            'worker_id' => $worker_id,
            'is_payed' => false,
            'is_finish' => false,
            'create_date' => date('Y-m-d'),
        ]);

        return $this->db->insertID();
    }

    public function update_order($order_id, $worker_id, $is_payed, $is_finish, $create_date, $room_id)
    {
        $this->db->table('orders')
            ->where('id', $order_id)
            ->update([
                'worker_id' => $worker_id,
                'is_payed' => $is_payed,
                'create_date' => $create_date,
                'room_id' => $room_id,
                'is_finish' => $is_finish,
            ]);
    }

    public function delete_order($id)
    {
        $this->db->table('orders')
            ->where('id', $id)
            ->delete();
    }
}
