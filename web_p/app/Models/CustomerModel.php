<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customer';
    protected $allowedFields = [
        'id',
        'first_name',
        'middle_name',
        'last_name',
        'phone_number',
        'pseudonym',
    ];

    public function search_customer($first_name, $middle_name, $last_name, $phone_number)
    {
        $query = $this->db->table('customer')
            ->select('customer.*');

        if ($first_name != '')
            $query->like('customer.first_name', pg_escape_string($first_name));
        if ($middle_name != '')
            $query->like('customer.middle_name', pg_escape_string($middle_name));
        if ($last_name != '')
            $query->like('customer.last_name', pg_escape_string($last_name));
        if ($phone_number != '')
            $query->where('customer.phone_number', pg_escape_string($phone_number));

        $result1 = $query->get()->getResult();

        $sub_query = $this->db->table('settlement')
            ->select('settlement.customer_id, settlement.is_settled, room.number')
            ->join('room', 'room.id = settlement.room_id')
            ->where('settlement.is_settled', true);

        $result2 = $sub_query->get()->getResult();

        foreach ($result1 as $customer) {
            foreach ($result2 as $settlement) {
                if ($customer->id == $settlement->customer_id) {
                    $customer->is_settled = $settlement->is_settled;
                    $customer->room_number = $settlement->number;
                    break;
                }
            }
        }

        return $result1;
    }

    public function get_all()
    {
        $query = $this->db->table('customer')
            ->select('customer.*');

        return $query->get()->getResult();
    }

    public function get_one($id)
    {
        $query = $this->db->table('customer')
            ->select('customer.*')
            ->where('customer.id', $id);

        return $query->get()->getResult();
    }

    public function add_customer($first_name, $middle_name, $last_name, $phone_number, $pseudonym = null)
    {
        $query = $this->db->table('customer')
            ->insert([
                'first_name' => pg_escape_string($first_name),
                'middle_name' => pg_escape_string($middle_name),
                'last_name' => pg_escape_string($last_name),
                'phone_number' => pg_escape_string($phone_number),
                'pseudonym' => pg_escape_string($pseudonym),
            ]);
    }

    public function update_customer($id, $first_name, $middle_name, $last_name, $phone_number, $pseudonym)
    {
        $query = $this->db->table('customer')
            ->where('customer.id', $id)
            ->update([
                'first_name' => pg_escape_string($first_name),
                'middle_name' => pg_escape_string($middle_name),
                'last_name' => pg_escape_string($last_name),
                'phone_number' => pg_escape_string($phone_number),
                'pseudonym' => pg_escape_string($pseudonym),
            ]);
    }
}
