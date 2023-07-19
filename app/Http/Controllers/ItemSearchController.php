<?php
/**
 * Created by PhpStorm.
 * User: Reginald
 * Date: 23/06/2017
 * Time: 04:26 PM
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Products;

class ItemSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('search')){
            $items = Products::search($request->input('search'))->toArray();
        }
        return view('ItemSearch',compact('tblProducts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
        ]);

        $item = Products::create($request->all());
        $item->addToIndex();

        return redirect()->back();
    }
}