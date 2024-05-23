<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GRVController extends Controller
{
    /**
     * This function is used for show the dashboard data
     */
    public function dashboard()
    {
        $notReceivedPOs = 0;

        return view('grv.dashboard', compact('notReceivedPOs'));
    }

    /**
     * This function is used for list not received pos
     */
    public function notReceivedPOs()
    {
        $pos = [
            [
                'customer_name' => 'Test1',
                'type' => 1
            ],
            [
                'customer_name' => 'Test2',
                'type' => 2
            ],
            [
                'customer_name' => 'Test1',
                'type' => 1
            ],
            [
                'customer_name' => 'Test2',
                'type' => 2
            ],
        ];

        return view('grv.not-received-pos', compact('pos'));
    }

    /**
     * This function is used for list awaiting auth pos
     */
    public function awaitingAuth()
    {
        return view('grv.awaiting-auth');
    }

    /**
     * This function is used for list received pos
     */
    public function received()
    {
        return view('grv.awaiting-auth');
    }

    /**
     * This function is used for list queries
     */
    public function queries()
    {
        return view('grv.queries');
    }

    /**
     * This function is used for list issues
     */
    public function issues()
    {
        return view('grv.issues');
    }
}
