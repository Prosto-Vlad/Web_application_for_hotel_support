<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ScheduleModel;
use App\Models\UserModel;

class ScheduleController extends BaseController
{
    public function index()
    {
        $res_data = session('user_data');
        $scheduleModel = new ScheduleModel();
        $userModel = new UserModel();

        helper('hcreate');

        $schedule_id = $userModel->get_schedule_id($res_data['id']);

        $schedule = $scheduleModel->get_schedule($schedule_id);
        $res_data['schedule'] = $schedule;

        echo view('template/header', header_data($res_data['role_id'], $res_data))
            . view('schedule', $res_data);
    }
}
