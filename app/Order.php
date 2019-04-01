<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;


class Order extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['customer_id','street_id', 'manager_id', 'delivery_time', 'customer_name', 'status', 'comments','payment_method', 'address'];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function manager()
    {
        return $this->belongsTo('App\Manager');
    }

    public function street()
    {
        return $this->belongsTo('App\StreetsNeighbourhoodAndCities','street_id');
    }

    public function jobTimes()
    {
        return $this->hasMany('App\JobTime','order_id');
    }

    public function scopeGetCustomerOrders($query)
    {
        try {
            $customer = \Auth::user()->customer;
            $orders = $query->where('customer_id', $customer->id)
            ->where('status', '!=', Config::get('constants.ORDER_STATUS_DELETED'));
            $orders = $orders->whereDate('created_at', '=', Carbon::today()->toDateString())
                ->orderBy('created_at','DESC');
            $orders = $orders->with(['street'=>function($query){
                $query->with('city');
            }])
            ->paginate(10);
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = $orders;
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = $e->getMessage();
            return $response;
        }
    }

    public function scopeGetManagerOrdersWithCustomer($query)
    {
        try {
            $manager = \Auth::user()->manager;
            $orders = $query->where('manager_id', $manager->id)
            ->where('status', '!=', Config::get('constants.ORDER_STATUS_DELETED'))
                ->orderBy('created_at','DESC');
            $orders = $orders->whereDate('created_at', '=', Carbon::today()->toDateString());
            $orders = $orders->with(['street'=>function($query){
                $query->with('city');
            }])
            ->with('customer')
            ->orderBy('created_at','DESC')
            ->paginate(10);
//            echo print_r($orders,true);
//            exit;


            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = $orders;
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = $e->getMessage();
            return $response;
        }
    }

    public function scopeGetAllOrders($query)
    {
        try {
            $orders = $query->orderBy('created_at','DESC');
            $orders = $orders->whereDate('created_at', '=', Carbon::today()->toDateString());
            $orders = $orders->with(['street'=>function($query){
                $query->with('city');
            }])
            ->with(['customer'=>function($query){
                $query->with(['user'=>function($query){
                    $query->select('id','email');
                }]);
            }])
            ->paginate(10);
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = $orders;
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = $e->getMessage();
            return $response;
        }
    }

    public function scopeGetOrder($query, $id)
    {
        try {
            $order = $query->where('id', $id)
            ->with(['street'=>function($query){
                $query->with('city');
            }])
            ->first();
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = $order;
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = $e->getMessage();
            return $response;
        }
    }

    public function scopeApproveOrder($query, $id,$status)
    {
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        $response['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        try {
            $order = $query->where('id', $id)->first();
            if ($order && ($order->status == Config::get('constants.ORDER_STATUS_APPROVED') || $order->status == Config::get('constants.ORDER_STATUS_APPROVED+5') ||$order->status == Config::get('constants.ORDER_STATUS_APPROVED+10') ||$order->status == Config::get('constants.ORDER_STATUS_APPROVED+15'))) {
                $response['data'] = 'כבר אישרת !';
                return $response;
            } else if ($order && $order->status == Config::get('constants.ORDER_STATUS_DELETED')) {
                $response['data'] = 'לקוח ביטל את ההזמנה!';
            } else if ($order) {
                $order->status = $status;
                $order->save();
                $user = $query->where('id',$id)->with(['customer' => function ($query) {
                    $query->with('user');
                }])->get();
                $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
                $response['user'] = $user;
                $response['data'] = 'אושר בהצלחה';
            }
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            $response['data'] = $e->getMessage();
            return $response;
        }
    }

    public function scopeAcceptJob($query, $id='')
    {
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        $response['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        try {
            $order = $query->where('id', $id)->first();
            if ($order && $order->status == Config::get('constants.ORDER_STATUS_ACCEPTED_BY_MANAGER')) {
                $response['data'] = 'כבר התקבל!';
                return $response;
            } else if ($order) {
                $order->status = Config::get('constants.ORDER_STATUS_ACCEPTED_BY_MANAGER');
                $order->save();
                $customer_company_name = $order->customer->company_name;
                $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
                $response['customer_company_name'] = $customer_company_name;
                $return = OneSignalFacade::sendNotificationToSegment(Auth::user()->manager->name. " אישר משלוח.", 'admins');
                $response['data'] = 'התקבל בהצלחה';
            }
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            $response['data'] = $e->getMessage();
            return $response;
        }
    }

    public function scopeRejectJob($query, $id='')
    {
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        $response['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        try {
            $order = $query->where('id', $id)->first();
            if ($order && $order->status == Config::get('constants.ORDER_STATUS_REJECTED_BY_MANAGER')) {
                $response['data'] = 'כבר נדחה!';
                return $response;
            } else if ($order) {
                $order->status = Config::get('constants.ORDER_STATUS_REJECTED_BY_MANAGER');
                $order->save();
                $customer_company_name = $order->customer->company_name;
                $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
                $response['customer_company_name'] = $customer_company_name;
                $response['data'] = 'נדחה בהצלחה';
            }
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            $response['data'] = $e->getMessage();
            return $response;
        }
    }

    public function scopeRejectOrder($query, $id='')
    {
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        $response['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        try {
            $order = $query->where('id', $id)->first();
            if ($order && $order->status == Config::get('constants.ORDER_STATUS_CANCELED')) {
                $response['data'] = 'כבר נדחה!';
                return $response;
            } else if ($order && $order->status == Config::get('constants.ORDER_STATUS_DELETED')) {
                $response['data'] = 'לקוח ביטל את ההזמנה!';
            } else if ($order) {
                $order->status = Config::get('constants.ORDER_STATUS_CANCELED');
                $order->save();
                $user = $query->with(['customer' => function ($query) {
                    $query->with('user');
                }])->get();
                $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
                $response['user'] = $user;
                $response['data'] = 'נדחה בהצלחה';
            }
        } catch (\Illuminate\Database\QueryException $e) {
            $response['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        }
        return $response;
    }

    public function scopeAssignManager($query,$orderId='', $managerId='')
    {
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        $response['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        try {
            $manager = Manager::find($managerId);
            $attendance = $manager->attendances->first();
            if(is_null($attendance) || $attendance->stop!='0000-00-00 00:00:00'){
                $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
                $response['data'] = "שליח לא פעיל.";
                return $response;
            }
            $order = $query->find($orderId);
            $order->manager_id = $managerId;
            $order->status = Config::get('constants.ORDER_STATUS_ASSIGNED');
            $order->save();
            $response['user'] = $manager->user;
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = 'שליח הוסף להזמנה בהצלחה!';
        } catch (\Illuminate\Database\QueryException $e) {
            $response['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
            return $response;
        }
        return $response;
    }

    public function scopeSetPriority($query,$orderId='', $value='')
    {
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        $response['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        try {
            $order = $query->find($orderId);
            $order->priority = $value;
            $order->save();
            $response['order'] = $order;
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = 'סדר איסוף נוסף בהצלחה!';
        } catch (\Illuminate\Database\QueryException $e) {
            $response['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
            return $response;
        }
        return $response;
    }

    public function scopeSetDropPriority($query,$orderId='', $value='')
    {
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        $response['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        try {
            $order = $query->find($orderId);
            $order->drop_priority = $value;
            $order->save();
            $response['order'] = $order;
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = 'סדר הורדה נוסף בהצלחה';
        } catch (\Illuminate\Database\QueryException $e) {
            $response['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
            error_log($e->getMessage());
            return $response;
        }
        return $response;
    }

    public function scopeSearch($query,$data)
    {
        $keyword = $data['search'];
        try {
            //Order
            $queryData = $query->where(function($query) use ($keyword){
                if(\Auth::user()->role==Config::get('constants.SEARCH_TYPE_CUSTOMER')){
                    $customer = \Auth::user()->customer;
                    $query = $query->where('customer_id', $customer->id);                    
                }else if(\Auth::user()->role==Config::get('constants.SEARCH_TYPE_MANAGER')){
                    $manager = \Auth::user()->manager;
                    $query = $query->where('manager_id', $manager->id);
                }
                
                    $query->where('status', '!=', Config::get('constants.ORDER_STATUS_DELETED'))
                    ->where('customer_name','like','%'.$keyword.'%');
            });
            if (array_has($data,'checkboxlist')) {
                $queryData = $queryData->whereIn('status',$data['checkboxlist']);
            }
            $queryData = $queryData->with(['street'=>function($query){
                $query->with('city');
            }])
            ->with(['customer'=>function($query){
                $query->with(['user'=>function($query){
                    $query->select('id','email');
                }]);
            }]);
            $queryData = $queryData->orderBy('created_at','DESC')->paginate(10);
            //Order
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = $queryData;
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
            return $response;
        }
    }

    public function scopeChangeStatus($query,$value='')
    {
            $order = $query->find($value['id']);
            if ($order) {
                $order->status = $value['status'];
                $order->save();
                $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
                $response['data'] = 'סטטוס שונה בהצלחה';
            }
            return $response;
    }
}
