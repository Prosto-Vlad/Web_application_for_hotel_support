<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'worker';
    protected $allowedFields = [
        'ID',
        'first_name',
        'middle_name',
        'last_name',
        'salary',
        'phone_number',
        'login_w',
        'password_w',
        'position_id',
        'role_id',
        'schedule_id'
    ];

    public function search_worker($first_name, $middle_name, $last_name, $position, $role_id)
    {
        $query = $this->db->table('worker')
            ->select('worker.*, position.name_p, role.name_r, schedule.s_name')
            ->join('position', 'worker.position_id = position.id')
            ->join('role', 'worker.role_id = role.id')
            ->join('schedule', 'worker.schedule_id = schedule.id');

        if ($first_name != null)
            $query->like('worker.first_name', pg_escape_string($first_name));
        if ($middle_name != null)
            $query->like('worker.middle_name', pg_escape_string($middle_name));
        if ($last_name != null)
            $query->like('worker.last_name', pg_escape_string($last_name));
        if ($position != null)
            $query->like('position.p_name', pg_escape_string($position));
        if ($role_id != null)
            $query->where('role.id', pg_escape_string($role_id));

        $result = $query->get()->getResult();

        return $result;
    }

    public function get_one($id)
    {
        $query = $this->db->table('worker')
            ->select('worker.*, position.name_p, role.name_r, schedule.s_name')
            ->join('position', 'worker.position_id = position.id')
            ->join('role', 'worker.role_id = role.id')
            ->join('schedule', 'worker.schedule_id = schedule.id')
            ->where('worker.id', $id);


        return $query->get()->getResult();
    }

    public function get_schedule_id($id)
    {
        $query = $this->db->table('worker')
            ->select('schedule_id')
            ->where('id', $id);

        return $query->get()->getResult()[0]->schedule_id;
    }

    public function update_worker($id, $first_name, $middle_name, $last_name, $phone_number, $login_w, $password_w, $position_id, $role_id, $schedule_id)
    {
        if ($password_w == '') {
            $query = $this->db->table('worker')
                ->where('id', $id)
                ->update([
                    'first_name' => $first_name,
                    'middle_name' => $middle_name,
                    'last_name' => $last_name,
                    'phone_number' => $phone_number,
                    'login_w' => $login_w,
                    'position_id' => $position_id,
                    'role_id' => $role_id,
                    'schedule_id' => $schedule_id
                ]);
        } else {
            $query = $this->db->table('worker')
                ->where('id', $id)
                ->update([
                    'first_name' => $first_name,
                    'middle_name' => $middle_name,
                    'last_name' => $last_name,
                    'phone_number' => $phone_number,
                    'login_w' => $login_w,
                    'password_w' => $password_w,
                    'position_id' => $position_id,
                    'role_id' => $role_id,
                    'schedule_id' => $schedule_id
                ]);
        }
    }
}
