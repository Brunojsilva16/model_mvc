<?php
// app/Controllers/HomeController.php

namespace App\Controllers;

use App\Core\Auth;
// use App\Models\HomeModel;

class HomeController extends BaseController
{
    public function index()
    {
        date_default_timezone_set('America/Sao_Paulo');
        // Auth::init(); 

        // if (!Auth::isLogged()) {
        //     $this->redirect('/login');
        //     return;
        // }

        // $HomeModel = new HomeModel();

        $data = [
            'view' => 'home',
            'title' => 'Assista Conecta - Psicologia Conectada',
            'navbar' => 'navbar_home',
            'header' => 'header_home',
            'footer' => 'footer_home'
            // 'pageStyles' => [
            //     'css/home.css'
            // ]
        ];

        $this->view('pages/home', $data);
    }
}
