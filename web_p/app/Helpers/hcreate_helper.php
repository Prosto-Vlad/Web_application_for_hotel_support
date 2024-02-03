<?php
if (!function_exists('header_data')) {
    function header_data($role_id, $data)
    {
        switch ($role_id) {
            case 1:
                return [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'links' => [
                        ['url' => base_url('manager/workers'), 'text' => 'Працівники'],
                        ['url' => base_url('manager/customers'), 'text' => 'Клієнти'],
                        ['url' => base_url('manager/services'), 'text' => 'Послуги'],
                        ['url' => base_url('manager/orders'), 'text' => 'Замовлення'],
                        ['url' => base_url('manager/rooms'), 'text' => 'Номера'],
                        ['url' => base_url('manager/schedule'), 'text' => 'Графік'],

                    ],
                ];
                break;
            case 2:
                return [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'links' => [
                        ['url' => base_url('administrator/rooms/search'), 'text' => 'Номера'],
                        ['url' => base_url('administrator/customers'), 'text' => 'Клієнти'],
                        ['url' => base_url('administrator/orders/view'), 'text' => 'Замовлення'],
                        ['url' => base_url('administrator/schedule'), 'text' => 'Графік'],
                    ],
                ];
                break;
            case 3:
                return [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'links' => [
                        ['url' => base_url('worker/tasks'), 'text' => 'Замовлення'],
                        ['url' => base_url('worker/schedule'), 'text' => 'Графік'],
                    ],
                ];
                break;
            default:

                break;
        }
    }
}
