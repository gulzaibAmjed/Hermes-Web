<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
class StreetsNeighbourhoodAndCities extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'streets_neighbourhood_and_cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'name', 'grand_parent_id', 'type', 'is_active'];

    public function city()
    {
        return $this->belongsTo('\App\StreetsNeighbourhoodAndCities','grand_parent_id','id');
    }

    public function neighbourhood()
    {
        return $this->belongsTo('\App\StreetsNeighbourhoodAndCities','parent_id','id');
    }

    public function pricing()
    {
        return $this->hasOne('App\Pricing','location_id','id');
    }

    public function price()
    {
        return $this->belongsTo('App\Pricing','parent_id','location_id');
    }

    public function getStreetsWithCitiesAndNeighbourhood($data)
    {
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
         try {
            $streets = $this->where('name','like',"%".$data['keyword']."%")
            ->where('type',Config::get('constants.ADDRESS_TYPE_STREET'))
            ->where('is_active',1)
            ->groupBy('grand_parent_id')
            ->with('city')
            ->get();
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = $streets;
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            return $response;
        }
    }

    // public function scopeGetStreetsAndCities($query,$type)
    // {
    // 	$response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
    // 	$response['data'] = "There is something wrong, please try again.";
    // 	 try {
    //         $customer = $query->where('type',)->get();
    //         $orders = $query->where('customer_id', $customer->id)->where('status', '!=', Config::get('constants.ORDER_STATUS_DELETED'))->paginate(10);
    //         $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
    //         $response['data'] = $orders;
    //         return $response;
    //     } catch (\Illuminate\Database\QueryException $e) {
    //         return $response;
    //     }
    // }

    public function getLocations()
    {
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
         try {
            $streets = $this->where('type',Config::get('constants.ADDRESS_TYPE_STREET'))
            ->where('is_active',1)
            // ->groupBy('grand_parent_id')
            ->with(['city','neighbourhood'])
            ->paginate(10);
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = $streets;
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            return $response;
        }
    }

    public function getNeighboursWithPrices()
    {
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
         try {
            $streets = $this->where('type',Config::get('constants.ADDRESS_TYPE_STREET'))
            ->where('is_active',1)
            // ->groupBy('grand_parent_id')
            ->with(['city','neighbourhood'])
            ->paginate(10);
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = $streets;
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            return $response;
        }
    }

    public function getLocationWithCityAndNeighbourhood($id)
    {
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
         try {
            $street = $this->where('id',$id)->with('neighbourhood')->with('city')
            ->first();
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = $street;
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            return $response;
        }
    }

    public function getLocation($id)
    {
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
         try {
            $street = $this->where('id',$id)->first();
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = $street;
            return $response;
        } catch (\Illuminate\Database\QueryException $e) {
            return $response;
        }
    }

    public function getAllCitiesInGroupsWithCities()
     {
        try{
            $streets=\DB::table('streets_neighbourhood_and_cities as t1')
            ->select('t1.id as parent_id','t1.name as parent_name','t2.id as child_id','t2.name as child_category')
            ->join('streets_neighbourhood_and_cities AS t2', 't1.id', '=', 't2.grand_parent_id')
            ->get();
         $data = array();
         foreach ($streets as $member) 
         {
           /* $groupid = $member->parent_id;*/
            $groupid = $member->parent_name;
            if (isset($data[$groupid])) 
            {
                $data[$groupid][] = $member;
            } 
            else 
            {
                $data[$groupid] = array($member);
             }
         }
        $response['data'] = $data;
        }catch(\Illuminate\Database\QueryException $e){
            $response['response'] = \Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = $e->getMessage();
        }
        $response['response'] = \Config::get('constants.RESPONSE_STATUS_SUCCESS');
        return $response;
     }

     public function isCityExist($city)
     {
        try{
            $response['data'] = $this->where('name',$city)->first();
            $response['response'] = \Config::get('constants.RESPONSE_STATUS_SUCCESS');
        }catch(\Illuminate\Database\QueryException $e){
            $response['response'] = \Config::get('constants.RESPONSE_STATUS_ERROR');
        }
        return $response;
     }

     public function isNeighbourhoodExist($neighbourhood)
     {
        try{
            $response['data'] = $this->where('name',$neighbourhood)->first();
            $response['response'] = \Config::get('constants.RESPONSE_STATUS_SUCCESS');
        }catch(\Illuminate\Database\QueryException $e){
            $response['response'] = \Config::get('constants.RESPONSE_STATUS_ERROR');
        }
        return $response;
     }

      public function isStreetExist($street)
     {
        try{
            $response['data'] = $this->where('name',$street)->first();
            $response['response'] = \Config::get('constants.RESPONSE_STATUS_SUCCESS');
        }catch(\Illuminate\Database\QueryException $e){
            $response['response'] = \Config::get('constants.RESPONSE_STATUS_ERROR');
        }
        return $response;
     }

     public function addCity($city)
     {
        try{
            $this->create(['name'=>$city]);
            $response['response'] = \Config::get('constants.RESPONSE_STATUS_SUCCESS');
        }catch(\Illuminate\Database\QueryException $e){
            $response['response'] = \Config::get('constants.RESPONSE_STATUS_ERROR');
        }
        return $response;
     }
}
