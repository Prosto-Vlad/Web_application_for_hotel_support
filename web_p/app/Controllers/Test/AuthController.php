<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function index()
    {
        // Підключення до бази даних
        $db = \Config\Database::connect();

        // Перевірка статусу підключення
        if ($db->connID !== null) {
            echo 'Підключено до бази даних';
        } else {
            echo 'Не вдалося підключитися до бази даних';
        }

        // Створення запиту SELECT
        $query = $db->table('role'); 

        // Виконання запиту та отримання результатів
        $results = $query->get()->getResult();

        $query->select('id, name_r');

        foreach ($results as $row) {
            echo $row->id . ' - ' . $row->name_r . '<br>';
        }
    }
}