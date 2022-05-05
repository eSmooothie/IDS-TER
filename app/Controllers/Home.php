<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {

        $data = [
            'sys_msg' => $this->session->getFlashdata("sys_response_msg"),
        ];
        return view('landing', $data);
    }
}
