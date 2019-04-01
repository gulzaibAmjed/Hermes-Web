<?php

namespace app\Http\Controllers;

use App\CurrentLocation;
use App\Manager;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function makeDir($dirpath)
    {
        return is_dir($dirpath) || mkdir($dirpath);
    }

    public function index(Request $request)
    {
        $response = (new \App\StreetsNeighbourhoodAndCities())->getLocations();
        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            if ($request->has('page')) {
                $view = view('locations.locations_table_partial')->with('data', $response['data'])->render();
            } else {
                $view = view('locations.index')->with('data', $response['data'])->render();
            }
            $response['data'] = $view;
        }
        return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $view = view('locations.create');
        return $view;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'street' => 'required',
            'city' => 'required',
            'neighbourhood' => 'required'
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
            $location = $request->all();
            $city = (new \App\StreetsNeighbourhoodAndCities())->isCityExist($location['city']);
            $neighbourhood = (new \App\StreetsNeighbourhoodAndCities())->isNeighbourhoodExist($location['neighbourhood']);
            $street = (new \App\StreetsNeighbourhoodAndCities())->isStreetExist($location['street']);
            if ($city['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS') && $neighbourhood['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS') && $street['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
                if (count($city['data'])>0) {
                    $grand_parent_id = $city['data']['id'];
                } else {
                    $city = (new \App\StreetsNeighbourhoodAndCities())->create(['name'=>$location['city'], 'type'=>Config::get('constants.ADDRESS_TYPE_CITY'), 'is_active'=>Config::get('constants.ADDRESS_IS_ACTIVE')]);
                    $grand_parent_id = $city->id;
                }
                if (count($neighbourhood['data'])>0 && $neighbourhood['data']['parent_id']==$grand_parent_id) {
                    $parent_id = $neighbourhood['data']['id'];
                } else {
                    $neighbourhood = (new \App\StreetsNeighbourhoodAndCities())->create(['name'=>$location['neighbourhood'], 'type'=>Config::get('constants.ADDRESS_TYPE_NEIGHBOURHOOD'), 'is_active'=>Config::get('constants.ADDRESS_IS_ACTIVE'), 'parent_id'=>$grand_parent_id]);
                    $parent_id = $neighbourhood['id'];
                }
                if (count($street['data'])>0 && $street['data']['grand_parent_id']==$grand_parent_id && $street['data']['parent_id']==$parent_id) {
                    $id = $street['data']['id'];
                } else {
                    $street = (new \App\StreetsNeighbourhoodAndCities())->create(['name'=>$location['street'], 'type'=>Config::get('constants.ADDRESS_TYPE_STREET'), 'is_active'=>Config::get('constants.ADDRESS_IS_ACTIVE'), 'parent_id'=>$parent_id, 'grand_parent_id'=>$grand_parent_id]);
                    $id = $street['id'];
                }
            }

            // $order->update('payment_method',$order['payment_method']);
            $response['data'] = 'Location added successfully.';
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            return $response;
        }
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
        $response = (new \App\StreetsNeighbourhoodAndCities)->getLocationWithCityAndNeighbourhood($id);
        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            $view = view('locations.edit')->with('street', $response['data'])->render();
            $response['data'] = $view;
        }
        return $response;
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
        $validation = \Validator::make($request->all(), [
            'street' => 'required',
            'city' => 'required',
            'neighbourhood' => 'required'
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
            $location = $request->all();
            error_log(print_r($location, true));
            $cityObj = (new \App\StreetsNeighbourhoodAndCities())->getLocation($location['city_id']);
            if ($cityObj['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
                $cityObj['data']->update(['name'=>$location['city']]);
            }
            $neighbourhoodObj = (new \App\StreetsNeighbourhoodAndCities())->getLocation($location['neighbourhood_id']);
            if ($neighbourhoodObj['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
                $neighbourhoodObj['data']->update(['name'=>$location['neighbourhood']]);
            }
            $streetObj = (new \App\StreetsNeighbourhoodAndCities())->getLocation($location['street_id']);
            if ($neighbourhoodObj['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
                $streetObj['data']->update(['name'=>$location['street']]);
            }

            // $order->update('payment_method',$order['payment_method']);
            $response['data'] = 'Location edited successfully.';
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
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

    public function bulkLocationsView()
    {
        $view = view('locations.bulk');
        return $view;
    }

    public function bulkLocationsUpload(Request $request)
    {
        try {
            $destinationPath = '../public/temp';
            if ($request->hasFile('bulkFile') && $request->file('bulkFile')->isValid()) {
                $this->makeDir($destinationPath);
                $file = $request->file('bulkFile');
                $thumbnailFileExtension = $file->getClientOriginalExtension();
                $thumbnailFilename = 'cities.xlsx';
                $uploadSuccess = $file->move($destinationPath, $thumbnailFilename);
                $url = '/public/temp/'. $thumbnailFilename;
            }

            if (\Storage::disk('temp')->has('cities.xlsx')) {
                \Excel::load(public_path() . '/temp/cities.xlsx', function ($reader) {
                    $results = $reader->get();
                    $cities = $results[0];
                    foreach ($results[0] as $city) {
                        $cityObj = \App\StreetsNeighbourhoodAndCities::create([
                            'name'=>$city->name,
                            'type'=>Config::get('constants.ADDRESS_TYPE_CITY'),
                            'is_active'=>Config::get('constants.ADDRESS_IS_ACTIVE'),
                        ]);
                        $neighbours = $results[1]->where('city_id', $city['id']);
                        foreach ($neighbours as $neighbour) {
                            $neighbourObj = \App\StreetsNeighbourhoodAndCities::create([
                                'name'=>$neighbour->name,
                                'type'=>Config::get('constants.ADDRESS_TYPE_NEIGHBOURHOOD'),
                                'is_active'=>Config::get('constants.ADDRESS_IS_ACTIVE'),
                                'parent_id'=>$cityObj->id
                            ]);
                            $streets = $results[2]->where('neighbourhood_id', $neighbour['id']);
                            foreach ($streets as $street) {
                                $streetObj = \App\StreetsNeighbourhoodAndCities::create([
                                    'name'=>$street->name,
                                    'type'=>Config::get('constants.ADDRESS_TYPE_STREET'),
                                    'is_active'=>Config::get('constants.ADDRESS_IS_ACTIVE'),
                                    'parent_id'=>$neighbourObj->id,
                                    'grand_parent_id'=>$cityObj->id
                                ]);
                            }
                        }
                    }
                });
            }
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $response['data'] = "Locations added successfully.";
        } catch (\Illuminate\Database\QueryException $e) {
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
        }
        return $response;
    }

    public function priceList(Request $request)
    {
        $response = (new \App\StreetsNeighbourhoodAndCities())->getLocations();
        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            if ($request->has('page')) {
                $view = view('locations.locations_table_partial')->with('data', $response['data'])->render();
            } else {
                $view = view('locations.index')->with('data', $response['data'])->render();
            }
            $response['data'] = $view;
        }
        return $response;
    }

    public function getManagerLocation()
    {
        try {
            $managers = \App\Manager::all();
            $view = view('locations.track_location')->with('managers', $managers)->render();
            $data['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            $data['data'] = $view;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $data['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $data['data'] = 'משהו לא בסדר עם האתר, אנא נסה שוב.';
        }
        return $data;
    }

    public function findLocation(Request $request)
    {
        $manager_id = $request->input('id');

        if ($manager_id == 'all') {
            $timestamp = CurrentLocation::with(['user'=>function($query){
                $query->with('manager');
            }])->get();
//
//            echo print_r($locations);
//            exit;

        } else {
            $manager = Manager::find($manager_id);
            $user = $manager->user;
            $timestamp = CurrentLocation::where('user_id', $user->id)
                ->with(['user'=>function($query){
                $query->with('manager');
            }])->first();
        }
        $ip = !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        $url = "http://freegeoip.net/json/$ip";
//        $url = "http://freegeoip.net/json/182.185.174.115";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $data = curl_exec($ch);
        curl_close($ch);

        if ($data) {
            $location = json_decode($data);

            $lat = (float)$location->latitude;
            $lon = (float)$location->longitude;
        } else {
            $lat = 51.500152;
            $lon = -0.126236;
        }

        $data = array();
        $view = view('locations.track_location_partial')->with(['timeStamps'=>$timestamp, 'lat'=>$lat, 'lon'=>$lon,'manager_id'=>$manager_id])->render();
        $data['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
        $data['data'] = $view;
        return $data;
        // $stamp = 
    }
}
