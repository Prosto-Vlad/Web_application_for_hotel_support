<?php

namespace App\Controllers;
use Codeignite\Controller;
use App\Models\UserModel;
class ErrorController extends BaseController{
    public function index(){
        return view('errors/404');
    }
}