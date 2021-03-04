<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\Subscription;

class SubsController extends Controller
{
    public function index()
    {
        return $this->view('subscription');
    }
    public function store(Request $request)
    {
        $sub = new Subscription();
        if ($request->isPost()) {
            $sub->load($request->input()); //loads input in model
            if ($sub->validate() && $sub->subscribe()) {
                return $this->view('subscribed');
            }
            var_dump($sub->errors);
            return $this->view('subscription', );
        } 
        return $this->view('subscription');  
    }
}