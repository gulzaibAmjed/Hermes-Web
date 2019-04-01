<?php

namespace app;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Customer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_name', 'authrize_name', 'address', 'website', 'contact_number', 'image_url', 'is_agree', 'agree_ip', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function scopeGetAllCustomers($query)
    {
        try {
            $customers = $query->with(['user' => function ($query) {
                $query->select('id', 'email');
            }])->paginate(10);
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = $customers;
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = $e->getMessage();
            return $response;
        }
    }

    public function scopeSearch($query, $data)
    {
        $keyword = $data['search'];
        try {
        } catch (\Illuminate\Database\QueryException $e) {
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
            return $response;
        }
    }
}
