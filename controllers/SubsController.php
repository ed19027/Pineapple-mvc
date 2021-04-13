<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\Subscription;

class SubsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index()
    {
        return $this->view('list', [
            'subs' => Subscription::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * Store a newly created resource in database.
     *
     * @param  app\core\Request  $request
     * @return 
     */
    public function subscribe(Request $request)
    {
        $sub = new Subscription();
        if ($request->isPost()) {
            $sub->load($request->body());
            if ($sub->validate()) {
                $sub->save();
                return $this->view('subscribed');
            }
            return $this->view('subscription', [
                'sub' => $sub
            ]);
        } 
        return $this->view('subscription', [
            'sub' => $sub
        ]);  

    }

    /**
     * Remove the specified resource from database.
     *
     * @param  app\core\Request  $request
     * @return app\core\Response
     */
    public function destroy(Request $request)
    {
        Subscription::delete($request->body());
        return Response::redirect('/list');
    }
}