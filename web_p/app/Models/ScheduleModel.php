<?php

namespace App\Models;

use CodeIgniter\Model;


class ScheduleModel extends Model
{
    protected $table = 'schedule';
    protected $allowedFields = [
        'id',
        'schedule',
        'name'
    ];

    public function getAll()
    {
        $query = $this->db->table('schedule')
            ->select('*');

        return $query->get()->getResult();
    }

    public function get_schedule($id)
    {
        $query = $this->db->table('schedule')
            ->select('*')
            ->where('id', $id);

        return $query->get()->getResult()[0]->schedule;
    }
}
