<?php

namespace App\Models;

use CodeIgniter\Model;


class SettlementModel extends Model
{
    protected $table = 'settlement';
    protected $allowedFields = [
        'id',
        'customer_id',
        'room_id',
        'settlement_date',
        'eviction_date',
        'is_settled',
        'notes'
    ];

    public function getSettlements()
    {
        $query = $this->db->table('settlement')
            ->select('*');
        $result = $query->get()->getResult();
        return $result;
    }

    public function addSettlement($room_id, $customer_id, $settlement_date, $eviction_date, $notes)
    {
        $query = $this->db->table('settlement')
            ->insert([
                'room_id' => pg_escape_string($room_id),
                'customer_id' => pg_escape_string($customer_id),
                'settlement_date' => pg_escape_string($settlement_date),
                'eviction_date' => pg_escape_string($eviction_date),
                'notes' => pg_escape_string($notes),
                'is_settled' => false
            ]);
    }
}
