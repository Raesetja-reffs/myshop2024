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
        $countData = [
            'notReceivedPOs' => 8,
            'awaitingAuth' => 15,
            'received' => 10,
            'queries' => 2,
            'issues' => 3,
        ];

        return view('grv.dashboard', compact('countData'));
    }

    /**
     * This function is used for list not received pos
     */
    public function notReceivedPOs()
    {
        $pos = [];
        for ($i=1; $i<=30; $i++) {
            for ($j=1; $j<=40; $j++) {
                $pos[] = [
                    'customer_name' => 'Supplier ' . $i,
                    'item_code' => 'Item' . $j,
                    'item_name' => 'Item Desc' . $j,
                    'quantity' => rand(0, 50)
                ];
            }
        }

        return view('grv.not-received-pos', compact('pos'));
    }

    /**
     * This function is used for list awaiting auth pos
     */
    public function awaitingAuth()
    {
        $pos = [];
        for ($i=1; $i<=10; $i++) {
            $items = [];
            for ($j=1; $j<=30; $j++) {
                $items[] = [
                    'item_code' => 'Item' . $j,
                    'receiver_a_qty' => rand(0, 50),
                    'receiver_b_qty' => rand(0, 50),
                    'final' => rand(0, 50),
                    'variance' => rand(0, 50),
                ];
            }
            $pos[] = [
                'name' => 'POS ' . $i,
                'items' => $items,
            ];
        }

        return view('grv.awaiting-auth', compact('pos'));
    }

    /**
     * This function is used for list received pos
     */
    public function received()
    {
        $pos = [];
        for ($i=1; $i<=10; $i++) {
            $items = [];
            for ($j=1; $j<=30; $j++) {
                $items[] = [
                    'item_code' => 'Item' . $j,
                    'item_name' => 'Item Desc' . $j,
                    'quantity' => rand(0, 50)
                ];
            }
            $pos[] = [
                'customer_name' => 'Supplier ' . $i,
                'po' => 'PO' . $i,
                'datetime' => date('Y-m-d'),
                'items' => $items,
            ];
        }

        return view('grv.received', compact('pos'));
    }

    /**
     * This function is used for list queries
     */
    public function queries()
    {
        $issues = [];
        for ($i=1; $i<=10; $i++) {
            $issues[] = [
                'name' => 'Query no ' . $i
            ];
        }

        return view('grv.queries', compact('issues'));
    }

    /**
     * This function is used for list issues
     */
    public function issues()
    {
        $issues = [];
        for ($i=1; $i<=10; $i++) {
            $issues[] = [
                'name' => 'Issue no ' . $i
            ];
        }

        return view('grv.issues', compact('issues'));
    }
}
