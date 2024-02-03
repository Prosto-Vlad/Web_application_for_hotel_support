<?php

namespace App\Models;

use CodeIgniter\Model;


class ServiceModel extends Model
{
    protected $table = 'service';
    protected $allowedFields = ['name_s', 'cost_s', 'details'];

    public function getAll()
    {
        $query = $this->db->table('service')
            ->select('*');

        return $query->get()->getResult();
    }

    public function get_one($id)
    {
        $query = $this->db->table('service')
            ->select('*')
            ->where('id', $id);

        return $query->get()->getResult();
    }

    public function search_services($name)
    {
        $query = $this->db->table('service')
            ->select('*');
        if ($name != '') {
            $query->like('name_s', $name);
        }

        return $query->get()->getResult();
    }

    public function add_services($name, $cost, $details)
    {
        $query = $this->db->table('service')
            ->insert([
                'name_s' => $name,
                'cost_s' => $cost,
                'details' => $details,
            ]);
    }

    public function update_service($id, $name, $cost, $details)
    {
        $query = $this->db->table('service')
            ->where('id', $id)
            ->update([
                'name_s' => $name,
                'cost_s' => $cost,
                'details' => $details,
            ]);
    }
}
