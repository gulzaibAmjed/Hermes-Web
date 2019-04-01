<?php

namespace app\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        $role = $user->role;
        $params = array();
        if ($role == Config::get('constants.USER_ROLE_CUSTOMER')) {
            $params['company'] = $user->customer->company_name;
            $params['role'] = $role;
        } elseif ($role == Config::get('constants.USER_ROLE_ADMIN')) {
            $params['role'] = $role;
        } elseif ($role == Config::get('constants.USER_ROLE_MANAGER')) {
            $params['manager'] = $user->manager;
            $params['role'] = $role;
        }
        return view('dashboard')->with($params);
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
        //
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
        //
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

    public function getProfile(Request $request)
    {
        $user = \App\User::where('id', \Auth::user()->id)->with('customer')->first();
        $view = view('customers.updateProfile')->with('user', $user)->render();
        return $view;
    }

    public function updateProfile(Request $request)
    {
        if(Auth::user()->role == 1){
            $validation = \Validator::make($request->all(), [
                // 'email' => 'required|email|max:255',
                'company_name' => 'required',
                'address' => 'required',
                'contact_number' => 'required',
                'old_password' => 'required|min:6',
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ]);
        }else{
            $validation = \Validator::make($request->all(), [
                // 'email' => 'required|email|max:255',
                'company_name' => 'required',
                'address' => 'required',
                'contact_number' => 'required',
            ]);
        }


        if ($validation->fails()) {
            $errors = '<ol>';
            foreach ($validation->errors()->all() as $key => $value) {
                $errors .= "<li>$value</li>";
            }
            $errors .= '</ol>';
            $response['data'] = $errors;
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            return $response;
        } else {
            if(Auth::user()->role == 1){
                $id = \Auth::user()->id;
                $user = \App\User::where('id', $id)->with('customer')->get();
                if (\Hash::check($request->Input('old_password'), $user[0]->password)) {
                    \DB::table('users')
                        ->where('id', $id)
                        ->update(['password' => bcrypt($request->Input('password'))]);
                    \DB::table('customers')
                        ->where('id', \Auth::user()->customer->id)
                        ->update(['company_name' => $request->Input('company_name'),'address' => $request->Input('address'), 'contact_number' => $request->Input('contact_number')]);
                    $response['data'] = "Profile updated successfully.";
                    $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
                    return $response;
                } else {
                    $response['data'] = "You old password didn't match with our record.";
                    $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
                    return $response;
                }
            }else{
                $id = $request->get('id');
                \DB::table('customers')
                    ->where('id', $id)
                    ->update(['company_name' => $request->Input('company_name'),'address' => $request->Input('address'), 'contact_number' => $request->Input('contact_number')]);
                $response['data'] = "Profile updated successfully.";
                $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
                return $response;
            }

        }
    }

    public function startJobView(Request $request)
    {
        $flag = false;
        $attendances = Auth::user()->manager->attendances;
        if (count($attendances)>0) {
            $first = $attendances->first();
            if ($first->stop=='0000-00-00 00:00:00') {
                $flag = true;
                return view('jobs.startJob')->with(['flag' => $flag, 'id' => $attendances->first()->id])->render();
            } else {
                return view('jobs.startJob')->with(['flag'=>$flag])->render();
            }
        } else {
            return view('jobs.startJob')->with(['flag'=>$flag])->render();
        }
    }

    public function getStreets(Request $request)
    {
        $response = (new \App\StreetsNeighbourhoodAndCities())->getStreetsWithCitiesAndNeighbourhood($request->all());
        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            $streets = array();
            foreach ($response['data'] as $data) {
                $streets[] = $data->name."-".$data->city->name;
            }
            $streets = array_flatten($streets);
            $response['data'] = $streets;
        }
        return $response;
    }

    public function getLocations(Request $request)
    {
    }

    public function employeeReport()
    {
        try {
            $managers = \App\Manager::all();
            $view = view('reports.employees')->with('managers', $managers)->render();
            $data['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $data['data'] = $view;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $data['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $data['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        }
        return $data;
    }

    public function employeesReport(Request $request)
    {
        try {
            $start_date = date('Y-m-d h:i:s',strtotime($request->input('start_date').' 00:00:00') - (60*60*env('UTC_PLUS')));
            $end_date = date('Y-m-d h:i:s',strtotime($request->input('end_date').' 23:59:59') - (60*60*env('UTC_PLUS')));
            if ($request->input('all') == 1) {
                $validation = Validator::make($request->all(), [
                    'start_date' => 'required',
                    'end_date' => 'required'
                ]);
                if ($validation->fails()) {
                    $errors = '<ol>';
                    foreach ($validation->errors()->all() as $key => $value) {
                        $errors .= "<li>$value</li>";
                    }
                    $errors .= '</ol>';
                    $response['data'] = $errors;
                    $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
                    return $response;
                }
                $employees = \App\Manager::with(['attendances'=>function ($query) use ($request,$start_date,$end_date) {
                    $query->where('created_at', '>=', $start_date)
                    ->Where('created_at', '<=', $end_date);
                }])->get();
            } else {
                $validation = Validator::make($request->all(), [
                    'id' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required'
                ], [
                    'id.required'=>' שם לקוח הכרחי'
                ]);
                if ($validation->fails()) {
                    $errors = '<ol>';
                    foreach ($validation->errors()->all() as $key => $value) {
                        $errors .= "<li>$value</li>";
                    }
                    $errors .= '</ol>';
                    $response['data'] = $errors;
                    $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
                    return $response;
                }

                $employees = \App\Manager::where('id', $request->input('id'))
                    ->with(['attendances'=>function ($query) use ($request, $start_date, $end_date) {
                    $query->where('created_at', '>=', $start_date)
                    ->Where('created_at', '<=', $end_date);
                }])->get();
            }
            $start = new \Carbon\Carbon($request->input('start_date').' 00:00:00');
            $end = new \Carbon\Carbon($request->input('end_date').' 23:59:59');
            $diff = $start->diffInDays($end);
            if ($diff == 0) {
                $diff =1;
            }
            $view = view('reports.employees_report_partial')->with(['employees'=>$employees, 'diff'=>$diff])->render();
            $data['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $data['data'] = $view;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $data['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $data['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        }
        return $data;
    }

    public function getOrdersReport()
    {
        try {
            $customers = \App\Customer::all();
            $view = view('reports.orders')->with('customers', $customers)->render();
            $data['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $data['data'] = $view;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $data['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $data['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        }
        return $data;
    }

    public function postOrdersReport(Request $request)
    {
        try {
            $start_date = date('Y-m-d h:i:s',strtotime($request->input('start_date').' 00:00:00') - (60*60*env('UTC_PLUS')));
            $end_date = date('Y-m-d h:i:s',strtotime($request->input('end_date').' 23:59:59') - (60*60*env('UTC_PLUS')));
            if ($request->input('all') == 1) {
                $validation = Validator::make($request->all(), [
                    'start_date' => 'required',
                    'end_date' => 'required'
                ]);
                if ($validation->fails()) {
                    $errors = '<ol>';
                    foreach ($validation->errors()->all() as $key => $value) {
                        $errors .= "<li>$value</li>";
                    }
                    $errors .= '</ol>';
                    $response['data'] = $errors;
                    $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
                    return $response;
                }
                $orders = \App\Order::where(function ($query) use ($request,$start_date,$end_date) {
                        $query->where('created_at', '>=', $start_date)
                            ->Where('created_at', '<=', $end_date);
                    })->with(['street'=>function ($query) use ($request) {
                        $query->with('price');
                    }])->with(['customer'])
                    ->with('jobTimes')
                    ->get();
                    // error_log(print_r($orders->toArray(),true));
                    // exit();
            } else {
                $validation = Validator::make($request->all(), [
                    'id' => 'required',
                    'start_date' => 'required',
                    'end_date' => 'required'
                ], [
                    'id.required'=>' שם עובד הכרחי'
                ]);
                if ($validation->fails()) {
                    $errors = '<ol>';
                    foreach ($validation->errors()->all() as $key => $value) {
                        $errors .= "<li>$value</li>";
                    }
                    $errors .= '</ol>';
                    $response['data'] = $errors;
                    $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
                    return $response;
                }
                $orders = \App\Order::where('customer_id', $request->input('id'))
                    ->where(function ($query) use ($request,$start_date,$end_date) {
                        $query->where('created_at', '>=', $start_date)
                            ->Where('created_at', '<=', $end_date);
                    })->with(['street'=>function ($query) use ($request) {
                        $query->with('price');
                    }])->with(['customer'])->get();
                $customer = \App\Customer::find($request->input('id'));
                $customer_name = $customer->company_name;
            }
            $view = view('reports.orders_report_partial')->with(['orders'=>$orders])->render();
            $data['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $data['data'] = $view;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $data['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $data['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        }
        return $data;
    }

    public function createSessionVariable(Request $request){
        try{
            Session::put($request->get('variable'),$request->get('value'));
        }catch (\Exception $e){
            error_log($e);
        }
    }

    public function notificationSubscription(Request $request){
        try{
            $app_user_id = $request->get('id');
            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['one_signal_app_id' => $app_user_id]);
            return response()->json(['status'=>true]);
        }catch (\Exception $e){
            return response()->json(['status'=>false]);
        }

    }

    public function contact(Request $request){
        $data = $request->all();
        \Mail::send('emails.contact', ['data' => $request->all()], function ($mail) use ($data) {
            $mail->from($data['email'], 'HERMES');
            $mail->to('support@hermesdelivery.co.il')->subject('HERMES::Contact Form!');
        });
        return redirect('/');
    }
}
