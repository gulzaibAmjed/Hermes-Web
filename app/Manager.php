<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Manager extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'managers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'user_id', 'from', 'to', 'address', 'area'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function order()
    {
        return $this->hasMany('App\Order');
    }

    public function attendances(){
            return $this->hasMany('App\Attendance')->orderBy('created_at','DESC');
    }

    //Function to attach locations....
    public function currentLocations()
    {
        return $this->hasMany('App\CurrentLocations');
    }

    public function scopeGetAllManagers($query,$allWithoutPagination=null)
    {
        try {
            if($allWithoutPagination){
                $managers = $query->with(['attendances'=>function($q){
                    $q->where('stop','=','0000-00-00');
                }])->get();
            }else{
                $managers = $query->with(['attendances'=>function($q){
                    $q->where('stop','=','0000-00-00');
                }])->paginate(10);
            }
// error_log(print_r($managers->toArray(),true)); 

            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = $managers;
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = $e->getMessage();
            return $response;
        }
    }

    public function scopeGetManagerWithUser($query, $id)
    {
        try {
            $manager = $query->where('id', $id)->with('user')->first();
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = $manager;
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = $e->getMessage();
            return $response;
        }
    }

    public function scopeGetUserOfManager($query, $id)
    {
        try {
            $manager = $query->find($id);
            $user = $manager->user;
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = $user;
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = $e->getMessage();
            return $response;
        }
    }

    public function scopeGetManager($query, $id)
    {
        try {
            $manager = $query->where('id', $id)->first();
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = $manager;
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = $e->getMessage();
            return $response;
        }
    }
}
