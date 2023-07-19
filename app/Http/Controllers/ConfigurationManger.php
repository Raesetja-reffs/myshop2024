<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigurationManger extends Controller
{
    //
    public function index()
    {
        return  view('dims/configuration_file');
    }
    public function editconfig(Request $request)
    {
        //
        $column = $request->get('column');
        $id = $request->get('id');
        $editval = $request->get('editval');

        echo $column.'----'.$editval;

        \Config::set('app.Accounting','TEST');
        echo \Config::get('app.Accounting');
    }
}
