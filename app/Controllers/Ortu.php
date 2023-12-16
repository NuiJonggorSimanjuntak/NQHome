<?php

namespace App\Controllers;

class Ortu extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard'
        ];
        return view('ortu/index', $data);
    }
}
