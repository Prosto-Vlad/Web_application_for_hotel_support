<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'task';
    protected $allowedFields = [
        'id',
        'is_finish',
        'notes',
        'order_id',
        'service_id',
    ];

    public function get_all()
    {
        $query = $this->db->table('task')
            ->select('task.*, orders.id as order_id, orders.create_date, orders.is_finish as order_is_finish, room.number, customer.first_name, customer.middle_name, customer.last_name, service.name_s as service_name, service.price, service.duration, worker.first_name as worker_first_name, worker.middle_name as worker_middle_name, worker.last_name as worker_last_name')
            ->join('orders', 'task.order_id = orders.id', 'left')
            ->join('settlement', 'orders.room_id = settlement.room_id', 'left')
            ->join('room', 'settlement.room_id = room.id', 'left')
            ->join('customer', 'settlement.customer_id = customer.id', 'left')
            ->join('service', 'task.service_id = service.id', 'left')
            ->join('worker', 'task.worker_id = worker.id', 'left');

        return $query->get()->getResult();
    }

    public function get_by_order($order_id)
    {
        $query = $this->db->table('task')
            ->select('task.*, service.name_s, service.cost_s')
            ->join('orders', 'task.order_id = orders.id')
            ->join('service', 'task.service_id = service.id')
            ->where('task.order_id', $order_id);

        $result = $query->get()->getResult();

        if ($result != null) {
            return $result;
        } else {
            return null;
        }
    }

    public function get_by_id($id)
    {
        $query = $this->db->table('task')
            ->select('task.*, service.name_s, service.cost_s')
            ->join('service', 'task.service_id = service.id')
            ->where('task.id', $id);

        $result = $query->get()->getRow();

        if ($result != null) {
            return $result;
        } else {
            return null;
        }
    }

    public function get_by_worker($worker_id)
    {
        $query = $this->db->table('task')
            ->select('task.*, room.number, customer.first_name, customer.middle_name, customer.last_name, service.name_s, service.details')
            ->join('orders', 'task.order_id = orders.id', 'left')
            ->join('worker', 'orders.worker_id = worker.id', 'left')
            ->join('service', 'task.service_id = service.id', 'left')
            ->join('settlement', 'orders.room_id = settlement.room_id', 'left')
            ->join('customer', 'settlement.customer_id = customer.id', 'left')
            ->join('room', 'settlement.room_id = room.id', 'left')
            ->where('orders.worker_id', $worker_id)
            ->where('orders.is_finish', false)
            ->where('orders.create_date >= settlement.settlement_date')
            ->where('orders.create_date <= settlement.eviction_date');


        return $query->get()->getResult();
    }

    public function create_task($order_id, $service_id, $notes = null)
    {
        $query = $this->db->table('task')
            ->insert([
                'order_id' => $order_id,
                'service_id' => $service_id,
                'notes' => $notes,
                'is_finish' => false,
            ]);

        return $query;
    }

    public function update_task($id, $is_finish, $notes)
    {
        $query = $this->db->table('task')
            ->where('id', $id)
            ->update([
                'is_finish' => $is_finish,
                'notes' => $notes,
            ]);

        return $query;
    }

    public function delete_task($id)
    {
        $query = $this->db->table('task')
            ->where('id', $id)
            ->delete();

        return $query;
    }
}
