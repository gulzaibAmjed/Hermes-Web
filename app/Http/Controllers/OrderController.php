<?php

namespace App\Http\Controllers;

use App\JobTime;
use App\Order;
use Berkayk\OneSignal\OneSignalFacade;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = \Auth::user()->role;
        $flag = false;
        if ($role == Config::get('constants.USER_ROLE_CUSTOMER')) {
            $orders = (new \App\Order)->getCustomerOrders();
        } else {
            if ($role == Config::get('constants.USER_ROLE_ADMIN')) {
                $orders = (new \App\Order)->getAllOrders();
                $managers = (new \App\Manager)->getAllManagers(1);
            } else {
                if ($role == Config::get('constants.USER_ROLE_MANAGER')) {
                    $orders = (new \App\Order)->getManagerOrdersWithCustomer();
                }
            }
        }
        if ($orders['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            if (isset($managers)) {
                if ($managers['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
                    $flag = true;
                    $data = ['orders' => $orders['data'], 'role' => $role, 'managers' => $managers['data']];
                }
            } else {
                $flag = true;
                $data = ['orders' => $orders['data'], 'role' => $role];
            }
        }
        if ($flag) {
            if ($request->has('page')) {
                return view('orders.orders_table_partial')->with($data)->render();
            } else {
                return view('orders.index')->with($data)->render();
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
    public function create(Request $request)
    {
        $data = (new \App\StreetsNeighbourhoodAndCities)->getAllCitiesInGroupsWithCities();
        if ($data['response'] == Config::get('constants.RESPONSE_STATUS_ERROR')) {
            $data['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
        } else {
            $request = $request->all();
            if (array_has($request, 'id')) {
                $id = $request['id'];
            } else {
                $id = '';
            }
            $view = view('orders.create')->with('streets', $data['data'])->with('customer_id', $id)->render();
            $data = array_add($data, 'view', $view);
            $data = array_except($data, ['data']);
        }
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            // 'city' => 'required|max:255',
            'street' => 'required',
            'delivery_time' => 'required',
            'payment_method' => 'required',
            'time_plus' => 'required',
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
        } else {
            $order = $request->all();
            $currentTime = strtotime(date('Y-m-d H:i:s')) + (60 * 60 * env('UTC_PLUS'));
            $deliveryTime = $currentTime + (60 * $order['time_plus']);
            $currentPlusTen = $currentTime + (60 * 10);
            if ($deliveryTime < $currentPlusTen) {
                $response['data'] = 'זמן משלוח צריך להיות 10 דקות ומעלה מהזמן הנוכחי';
                $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
                return $response;
            } else {
                $order['delivery_time'] = $deliveryTime;
            }

            $street = $order['street'];
            if (\Auth::user()->role == Config::get('constants.USER_ROLE_ADMIN')) {
                $id = $order['id'];
            } else {
                $id = Hashids::decode($order['id']);
            }
            $order = array_except($order, ['street']);
            $order['status'] = Config::get('constants.ORDER_STATUS_PENDING');
            if (\Auth::user()->role == Config::get('constants.USER_ROLE_ADMIN')) {
                $customer = (new \App\Customer)->where('id', $id)->first();
            } else {
                $customer = \Auth::user()->customer;
            }
            $order = new \App\Order($order);
            $order = $customer->orders()->save($order);
            $order->
            street_id = $street;
            $order->save();
            // $order->date('payment_method',$order['payment_method']);
            if(Auth::user()->role == Config::get('constants.USER_ROLE_CUSTOMER')) {
                OneSignalFacade::sendNotificationToSegment("הזמנה חדשה נוצרה על יד " . Auth::user()->customer->company_name, 'admins');
            }
            $response['data'] = 'הזמנה נוספה בהצלחה.';
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            return $response;
        }
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
        $id = Hashids::decode($id);
        $response = (new \App\Order())->getOrder($id[0]);
        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            $data = (new \App\StreetsNeighbourhoodAndCities)->getAllCitiesInGroupsWithCities();
            if ($data['response'] == Config::get('constants.RESPONSE_STATUS_ERROR')) {
                $data['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
            } else {
                $view = view('orders.edit')->with('order', $response['data'])->with('streets', $data['data'])->render();
                $response['data'] = $view;
            }
        } else {
            $response = array_add($response, 'data', "משהו לא בסדר עם האתר, אנא נסה שוב.");
        }
        return $response;
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
        $validation = \Validator::make($request->all(), [
            'street' => 'required',
            'customer_name' => 'required',
            'payment_method' => 'required',
        ]);

        $id = Hashids::decode($id);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors());
        } else {
            $order = $request->all();
            $street = $order['street'];
            $order = array_except($order, ['street']);
            $response = (new \App\Order())->getOrder($id[0]);
            if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
                $response['data']->update($order);
                $response['data']->update(['street_id' => $street]);
                $return = OneSignalFacade::sendNotificationToSegment(Auth::user()->customer->company_name . " עדכן הזמנה.", 'admins');
                return redirect('/dashboard');
            } else {
                Session::flash('message', "משהו לא בסדר עם האתר, אנא נסה שוב.");
                return Redirect::back();
            }
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
        $id = Hashids::decode($id);
        $response = (new \App\Order())->getOrder($id[0]);
        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            $response['data']->update(['status' => Config::get('constants.ORDER_STATUS_DELETED')]);
            $order = \App\Order::find($id[0]);
            $timeStamp = new \App\JobTime([
                'order_id' => $id[0],
                'time' => \Carbon\Carbon::now(),
                'status' => Config::get('constants.ORDER_STATUS_DELETED')
            ]);
            $order = $order->jobTimes()->save($timeStamp);
            $return = OneSignalFacade::sendNotificationToSegment(Auth::user()->customer->company_name . " מחק הזמנה.", 'admins');
            $response['data'] = "הזמנה נמחקה בהצלחה.";
            return $response;
        } else {
            $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
            return $response;
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function approve(Request $request)
    {
        try{
            $id = Hashids::decode($request->input('id'));
            $plus = $request->get('plus');
            switch($plus){
                case 5:
                    $status = Config::get('constants.ORDER_STATUS_APPROVED+5');
                    $string = "הזמנה אושרה בתוספת 5 דקות.";
                    break;
                case 10:
                    $status = Config::get('constants.ORDER_STATUS_APPROVED+10');
                    $string = "הזמנה אושרה בתוספת 10 דקות.";
                    break;
                case 15:
                    $status = Config::get('constants.ORDER_STATUS_APPROVED+15');
                    $string = "הזמנה אושרה בתוספת 15 דקות.";
                    break;
                default:
                    $status = Config::get('constants.ORDER_STATUS_APPROVED');
                    $string = "הזמנה אושרה.";
            }
            $response = (new \App\Order())->approveOrder($id[0],$status);
            $plus = $request->get('plus');
            $order = \App\Order::find($id[0]);
            $obj = $order;
        $timeStamp = new \App\JobTime([
            'order_id' => $id[0],
            'time' => \Carbon\Carbon::now(),
            'status' => Config::get('constants.ORDER_STATUS_APPROVED')
        ]);

            $order = $order->jobTimes()->save($timeStamp);
            $obj->delivery_time = $obj->delivery_time + (60*$plus);
            $obj->save();

            if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
                if (array_has($response, 'user')) {
                    if(!is_null($response['user'][0]['customer']['user']['one_signal_app_id'])){
                        OneSignalFacade::sendNotificationToUser($string, $response['user'][0]['customer']['user']['one_signal_app_id']);
                    }
                    $response = array_except($response, ['user']);
                }
                return $response;
            } else {
                return $response;
            }
        }catch (\Exception $e){
            $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
            return $response;
        }

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function changeStatus(Request $request)
    {
        try{
            DB::beginTransaction();
            (new \App\Order())->changeStatus($request->all());
            (new \App\JobTime)->addTime($request->all());
            $return = OneSignalFacade::sendNotificationToSegment(Auth::user()->manager->name. " עדכן סטטוס.", 'admins');
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = 'סטטוס שונה בהצלחה.';
            DB::commit();
            return $response;
        }catch(\Exception $e){
            error_log($e);
            DB::rollback();
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
            return $response;
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function acceptJob(Request $request)
    {
        $id = Hashids::decode($request->input('id'));
        $response = (new \App\Order())->acceptJob($id[0]);
        $order = \App\Order::find($id[0]);
        $timeStamp = new \App\JobTime([
            'order_id' => $id[0],
            'time' => \Carbon\Carbon::now(),
            'status' => Config::get('constants.ORDER_STATUS_ACCEPTED_BY_MANAGER')
        ]);
        $order = $order->jobTimes()->save($timeStamp);

        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            if (array_has($response, 'customer_company_name')) {
                $company_name = $response['customer_company_name'];
                $return = OneSignalFacade::sendNotificationToSegment(Auth::user()->manager->name. " אישר משלוח.", 'admins');

                return $response;
            }
        }
        return $response;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function rejectJob(Request $request)
    {
        $id = Hashids::decode($request->input('id'));
        $response = (new \App\Order())->rejectJob($id[0]);
        $order = \App\Order::find($id[0]);
        $timeStamp = new \App\JobTime([
            'order_id' => $id[0],
            'time' => \Carbon\Carbon::now(),
            'status' => Config::get('constants.ORDER_STATUS_REJECTED_BY_MANAGER')
        ]);
        $order = $order->jobTimes()->save($timeStamp);

        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            if (array_has($response, 'customer_company_name')) {
                $return = OneSignalFacade::sendNotificationToSegment(Auth::user()->manager->name. " has rejected job.", 'admins');
                return $response;
            }
        }
        return $response;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function reject(Request $request)
    {
        $id = Hashids::decode($request->input('id'));
        $response = (new \App\Order())->rejectOrder($id[0]);
        $order = \App\Order::find($id[0]);
        $timeStamp = new \App\JobTime([
            'order_id' => $id[0],
            'time' => \Carbon\Carbon::now(),
            'status' => Config::get('constants.ORDER_STATUS_CANCELED')
        ]);
        $order = $order->jobTimes()->save($timeStamp);

        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            if (array_has($response, 'user')) {
                if(!is_null($response['user'][0]['customer']['user']['one_signal_app_id'])) {
                    $return = OneSignalFacade::sendNotificationToUser("הזמנה בוטלה על ידי הרמס.", $response['user'][0]['customer']['user']['one_signal_app_id']);
                }
                $response = array_except($response, ['user']);
            }
            return $response;
        } else {
            return $response;
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function assignManager(Request $request)
    {
        $orderId = Hashids::decode($request->input('order'));
        $managerId = $request->input('manager');
        $response = (new \App\Order())->assignManager($orderId[0], $managerId);
        $order = \App\Order::find($orderId[0]);
        $timeStamp = new \App\JobTime([
            'order_id' => $orderId[0],
            'time' => \Carbon\Carbon::now(),
            'status' => Config::get('constants.ORDER_STATUS_ASSIGNED')
        ]);
        $order = $order->jobTimes()->save($timeStamp);

        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            if (array_has($response, 'user')) {
                $user = $response['user'];
                $return = OneSignalFacade::sendNotificationToUser("קיבלת משלוח חדש .", $response['user']->one_signal_app_id);
                $response = array_except($response, ['user']);
            }
            return $response;
        } else {
            return $response;
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function setPriority(Request $request)
    {
        $orderId = Hashids::decode($request->input('order'));
        $value = $request->input('value');
        $response = (new \App\Order())->setPriority($orderId[0], $value);
        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            if (!is_null($response['order']) && !is_null($response['order']->manager_id)) {
                $user = (new \App\Manager())->getUserOfManager($response['order']->manager_id);
                $response = array_except($response, ['order']);
            }
            return $response;
        } else {
            return $response;
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function setDropPriority(Request $request)
    {
        $orderId = Hashids::decode($request->input('order'));
        $value = $request->input('value');
        $response = (new \App\Order())->setDropPriority($orderId[0], $value);
        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            if (!is_null($response['order']) && !is_null($response['order']->manager_id)) {
                $user = (new \App\Manager())->getUserOfManager($response['order']->manager_id);
                if ($user['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
//                    \Mail::send('emails.order_prioritized', [], function ($mail) use ($user) {
//                        $mail->from('admin@hermes.com', 'HERMES');
//
//                        $mail->to($user['data']['email'], 'Manager')->subject('HERMES::New Priority!');
//                    });
                }
                $response = array_except($response, ['order']);
            }
            return $response;
        } else {
            return $response;
        }
    }

    /**
     * @return mixed
     */
    public function getOrderAdminCreate()
    {
        try {
            $customers = \App\Customer::all();
            $view = view('orders.create_admin')->with('customers', $customers)->render();
            $data['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $data['data'] = $view;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $data['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $data['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        }
        return $data;
    }

    public function cancelStatus(Request $request)
    {
        DB::beginTransaction();
        try {
            $order = Order::find($request->get('id'));
            if($order->status == Config::get('constants.ORDER_STATUS_PROCESS_START')){
                $status = Config::get('constants.ORDER_STATUS_ACCEPTED_BY_MANAGER');
            }else{
                $status = ($order->status - 1);
            }
            (new \App\Order())->changeStatus([
                    'id' => $request->get('id'),
                    'status' => $status
                ]);
            JobTime::where('order_id',$request->get('id'))->orderBy('created_at','DESC')->first()->delete();
            $return = OneSignalFacade::sendNotificationToSegment(Auth::user()->manager->name. " שינה סטטוס.", 'admins');

            $data['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $data['data'] = "סטטוס שונה בהצלחה!";
        } catch (\Exception $e) {
            DB::rollBack();
            error_log($e->getMessage());
            $data['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $data['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        }
        DB::commit();
        return $data;
    }

}
