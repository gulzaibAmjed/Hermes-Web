<?php

namespace app\Http\Controllers;

use App\Customer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = (new \App\Customer())->getAllCustomers();
        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            if ($request->has('page')) {
                return view('managers.managers_table_partial')->with('managers', $response['data']);
            } else {
                return view('customers.index')->with('customers', $response['data']);
            }
        } else {
            return "משהו לא בסדר עם האתר, אנא נסה שוב.";
        }
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{

            $user = User::where('id',$id)->with('customer')->first()->toArray();
            $view = view('customers.updateProfile')->with(['id'=>$id,'user'=>$user])->render();
            $data['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $data['data'] = $view;
            return $data;
        }catch (\Exception $e){
            $data['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $data['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
            return $data;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            echo print_r($request->all(),true);
            exit;
            $user = Customer::where('id',$id)->with('customer')->first()->toArray();
            $view = view('customers.updateProfile')->with(['id'=>$id,'user'=>$user])->render();
            $data['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $data['data'] = $view;
            return $data;
        }catch (\Exception $e){
            echo $e;
            exit;
            $data['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $data['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
            return $data;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAll()
    {
        $customers = Customer::select('id', 'name')->get();
        error_log(print_r($customers, true));
    }
}
