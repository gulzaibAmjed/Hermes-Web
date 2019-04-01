<?php

namespace app;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class Attendance extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attendances';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['manager_id','start', 'stop', 'hours'];

    public function manager()
    {
        $this->belongsTo('App\Manager');
    }

    public function scopeStartJob($query, $id='')
    {
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        $response['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        try {
            $manager = Auth::user()->manager;
            Attendance::create([
                'manager_id' => $manager->id,
                'start' => Carbon::now()
            ]);
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = 'הפסקת עבודה נקלטה בהצלחה';
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            return $response;
        }
    }

    public function scopeStopJob($query, $data='')
    {
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        $response['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        try {
            $id = $data['id'];
            $job = $query->where('id', $id)->first();
            $startTime = new Carbon($job->start);
            $now = Carbon::now();
            $diff = $now->diffInMinutes($startTime, true);
            $query->where('id', $id)->update(['stop'=>Carbon::now(), 'hours'=>$diff/60]);
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = 'התחלת עבודה נקלטה בהצלחה';
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            return $response;
        }
    }
}
