<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseBuilder;

class RoomModel extends Model
{
    protected $table = 'room';
    protected $allowedFields = [
        'ID',
        'cost_r',
        'beds_num',
        'number',
        'description',
        'type_id',
    ];

    public function searchRooms($number, $type, $min_price, $max_price, $num_of_beds, $booking_from = null, $booking_to = null, $status = '')
    {
        $query = $this->db->table('room')
            ->select('room.*, type.t_name, settlement.is_settled, settlement.settlement_date, settlement.eviction_date, settlement.id as settlement_id')
            ->join('type', 'room.type_id = type.id')
            ->join('settlement', 'room.id = settlement.room_id', 'left');
        if ($number != null)
            $query->where('room.number', pg_escape_string($number));
        if ($type != 0)
            $query->where('type.t_name', pg_escape_string($type));
        if ($num_of_beds != null)
            $query->where('room.beds_num >=', pg_escape_string($num_of_beds));
        if ($min_price != null)
            $query->where('room.cost_r >=', pg_escape_string($min_price));
        if ($max_price != null)
            $query->where('room.cost_r <=', pg_escape_string($max_price));
        if ($booking_from != null)
            $query->where('settlement.settlement_date >=', pg_escape_string($booking_from));
        if ($booking_to != null)
            $query->where('settlement.eviction_date <=', pg_escape_string($booking_to));
        if ($status != '') {
            switch ($status) {
                case 'settle':
                    $query->where('settlement.is_settled', true);
                    break;
                case 'armor':
                    $query->where('settlement.is_settled', false);
                    break;
                case 'free':
                    $query->where('settlement.room_id', null);
                    break;
            }
        }

        $result = $query->get()->getResult();

        return $result;
    }

    public function searchFreeRoom($type, $min_price, $max_price, $num_of_beds, $booking_from, $booking_to)
    {
        $query = $this->db->table('room')
            ->select('room.*, type.t_name')
            ->join('type', 'room.type_id = type.id');

        if ($type != 0)
            $query->where('type.t_name', pg_escape_string($type));
        if ($min_price != '')
            $query->where('room.price >=', pg_escape_string($min_price));
        if ($max_price != '')
            $query->where('room.price <=', pg_escape_string($max_price));
        if ($num_of_beds != '')
            $query->where('room.beds_num', pg_escape_string($num_of_beds));

        if ($booking_from != null && $booking_to != null) {
            $query->whereNotIn('room.id', function (BaseBuilder $builder) use ($booking_from, $booking_to) {
                return $builder->select('room_id')
                    ->from('settlement')
                    ->where('settlement_date <=', pg_escape_string($booking_to))
                    ->where('eviction_date >=', pg_escape_string($booking_from));
            });
        }

        $result = $query->get()->getResult();

        return $result;
    }

    public function getSettledRoom()
    {
        $query = $this->db->table('room')
            ->select('room.*')
            ->join('settlement', 'room.id = settlement.room_id', 'left')
            ->where('settlement.is_settled', true);

        $result = $query->get()->getResult();

        return $result;
    }

    public function getInfo($number, $type, $min_price, $max_price, $num_of_beds)
    {
        $query = $this->db->table('room')
            ->select('room.*, type.t_name')
            ->join('type', 'room.type_id = type.id');
        if ($number != null)
            $query->where('room.number', pg_escape_string($number));
        if ($type != 0)
            $query->where('type.t_name', pg_escape_string($type));
        if ($num_of_beds != null)
            $query->where('room.beds_num >=', pg_escape_string($num_of_beds));
        if ($min_price != null)
            $query->where('room.cost_r >=', pg_escape_string($min_price));
        if ($max_price != null)
            $query->where('room.cost_r <=', pg_escape_string($max_price));

        $result = $query->get()->getResult();

        return $result;
    }

    public function updateStatus($settlement_id, $status)
    {
        $query = $this->db->table('settlement');

        if ($status == 'free') {
            $query->where('id', $settlement_id);
            $query->delete();
            return $settlement_id;
        };
        if ($status == 'armor') {
            $query->where('id', $settlement_id);
            $query->set('is_settled', false);
            $query->update();
            return true;
        };
        if ($status == 'settle') {
            $query->where('id', $settlement_id);
            $query->set('is_settled', true);
            $query->update();
            return true;
        };

        return false;
    }

    public function get_one($id)
    {
        $query = $this->db->table('room')
            ->select('room.*, type.t_name')
            ->join('type', 'room.type_id = type.id')
            ->where('room.id', pg_escape_string($id));


        $result = $query->get()->getResult();

        return $result;
    }

    public function update_room($id, $number, $cost_r, $beds_num, $description, $type_id)
    {
        $query = $this->db->table('room')
            ->where('id', $id)
            ->update([
                'number' => $number,
                'cost_r' => $cost_r,
                'beds_num' => $beds_num,
                'description' => $description,
                'type_id' => $type_id,
            ]);
    }
}
