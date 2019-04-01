<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class JobTime extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'job_time_stamps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id', 'time', 'hours', 'status', 'longitude', 'latitude', 'manager_id'];

    /**
     * @param $query
     * @param string $value
     * @return array
     */
    public function scopeAddTime($query, $value = '')
    {
        $response = array();
        $order_id = $value['id'];
        $status = $value['status'];
        $order = \App\Order::where('id', $order_id)->first();
        //Getting lonn lats
        $ip = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        $url = "http://ip-api.com/json/$ip";

//         $url = "http://ip-api.com/json/208.80.152.201";
        // $url = "http://freegeoip.net/json/139.190.125.36";
//         $url = "http://freegeoip.net/json/119.63.142.57";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $data = curl_exec($ch);
        curl_close($ch);

            $location = json_decode($data);

            $lat = (float)$location->lat;
            $lon = (float)$location->lon;
            $sun_info = date_sun_info(time(), $lat, $lon);

        //____________________________________________________
        switch ($status) {
            case Config::get('constants.ORDER_STATUS_PROCESS_START'):
                $jobTime = (new \App\JobTime([
                    'time' => \Carbon\Carbon::now(),
                    'hours' => 0,
                    'status' => $status,
                    'longitude' => $lon,
                    'latitude' => $lat,
                    'manager_id' => \Auth::user()->manager->id
                ]));
                $order->jobTimes()->save($jobTime);
                break;
            default:
                $lastAchievement = $order->jobTimes->last();
//                dd($lastAchievement);
                $lastAchievementTime = new Carbon($lastAchievement->time);
                $now = Carbon::now();
                $diff = $now->diffInMinutes($lastAchievementTime, true);
                $jobTime = (new \App\JobTime([
                    'time' => \Carbon\Carbon::now(),
                    'hours' => $diff / 60,
                    'status' => $status,
                    'longitude' => $lon,
                    'latitude' => $lat,
                    'manager_id' => \Auth::user()->manager->id
                ]));
                $order->jobTimes()->save($jobTime);
                break;
        }
        $user_id = Auth::user()->id;
        $current_location = CurrentLocation::firstOrNew(array('user_id' => $user_id));
        $current_location->user_id = $user_id;
        $current_location->longitude = $lon;
        $current_location->latitude = $lat;
        $current_location->save();
        $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
        $response['order_status'] = $status;

        return $response;
    }

    public function removeTime(){

    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function manager()
    {
        return $this->belongsTo('App\Manager', 'manager_id');
    }
}
