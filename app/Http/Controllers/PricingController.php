<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class PricingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $managers = \App\Customer::all();
            $view = view('pricings.index')->with('managers', $managers)->render();
            $data['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $data['data'] = $view;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $data['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $data['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        }
        return $data;
    }

    public function prices($id)
    {
        try {
            $pricings = \App\StreetsNeighbourhoodAndCities::where('type', Config::get('constants.ADDRESS_TYPE_NEIGHBOURHOOD'))
                ->with(['pricing'=>function ($query) use ($id) {
                    $query->where('customer_id', $id);
                }])
                ->get();
            $view = view('pricings.pricings_table_partial')->with(['prices'=>$pricings, 'customer_id'=>$id])->render();
            $data['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $data['data'] = $view;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $data['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $data['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        }
        return $data;
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
    public function update(Request $request)
    {
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        $response['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        try {
            $id = $request->all()['id'];
            $value = $request->all()['value'];
            $lid = $request->all()['lid'];
            $mid = $request->all()['mid'];
//            error_log('id:'.$id.'=value:'.$value.'=lid:'.$lid.'=mid:'.$mid);
            if ($id == 0) {
                $pricing = \App\Pricing::create(['location_id'=>$lid, 'price'=>$value, 'customer_id'=>$mid]);
                $id = $pricing->id;
//                error_log('new price:'.$id);
            } else {
                $pricing = \App\Pricing::find($id)->update(['price'=>$value]);
                $id = $id;
            }
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['id'] = $id;
            return $response;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return $response;
        }
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
}
