<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        $data = $request->all();
        $role = \Auth::user()->role;
        
        if ($request->input('type') == Config::get('constants.SEARCH_TYPE_ORDER')) {
            $response = (new \App\Order())->search($data);
        } elseif ($request->input('type') == Config::get('constants.SEARCH_TYPE_CUSTOMER')) {
            $response = (new \App\Customer())->search($data);
        } elseif ($request->input('type') == Config::get('constants.SEARCH_TYPE_MANAGER')) {
            $response = (new \App\Manager())->search($data);
        }

        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            try {
                if ($request->input('type') == Config::get('constants.SEARCH_TYPE_ORDER')) {
                    $data = ['orders'=> $response['data'],'role'=>\Auth::user()->role];
                    if ($role == Config::get('constants.USER_ROLE_ADMIN')) {
                        $data = array_add($data, 'managers', (new \App\Manager)->getAllManagers(1)['data']);
                    }
                    $response['data'] = \View::make('orders.orders_table_partial')->with($data)->render();
                } elseif ($request->input('type') == Config::get('constants.SEARCH_TYPE_CUSTOMER')) {
                } elseif ($request->input('type') == Config::get('constants.SEARCH_TYPE_MANAGER')) {
                }
            } catch (\Exception $e) {
                error_log($e->getMessage());
            }
        }
        return $response;
    }

    public function filter($type)
    {
    }
}
