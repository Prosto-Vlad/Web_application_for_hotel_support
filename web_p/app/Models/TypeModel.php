<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeModel extends Model
{
    protected $table = 'type';
    protected $allowedFields = ['id', 't_name'];

    public function getTypes()
    {
        $query = $this->db->table('type')
            ->select('type.*');
        $result = $query->get()->getResult();
        return $result;
    }
}
