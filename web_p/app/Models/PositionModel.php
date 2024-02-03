<?php

namespace App\Models;

use CodeIgniter\Model;

class PositionModel extends Model
{
    protected $table = 'position';
    protected $allowedFields = [
        'id',
        'name_p'
    ];

    public function getAll()
    {
        $query = $this->db->table('position')
            ->select('*');

        return $query->get()->getResult();
    }
}
