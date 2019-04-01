<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Vinkla\Hashids\Facades\Hashids;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = (new \App\Manager)->getAllManagers();
        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            if ($request->has('page')) {
                return view('managers.managers_table_partial')->with('managers', $response['data']);
            } else {
                return view('managers.index')->with('managers', $response['data']);
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
    public function create()
    {
        $view = view('managers.create');
        return $view;
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
            'name' => 'required|max:60',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
//            'from' => 'required',
//            'to' => 'required',
//            'address' => 'required|max:255',
//            'area' => 'required|max:60',
        ]);
//        $from = str_replace(' ', '', $request->input('from'));
//        $to = str_replace(' ', '', $request->input('to'));
//        $from = Carbon::createFromFormat('H:i', $from)->format('H:i');
//        $to = Carbon::createFromFormat('H:i', $to)->format('H:i');

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
            try {
                $user = \App\User::create([//Creating user against manager...
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                    'role' => Config::get('constants.USER_ROLE_MANAGER'),
                    'is_confirmed' => Config::get('constants.USER_CONFIRMED'),
                ]);
                $manager = new \App\Manager([//Creating manager...
                    'name' => $request->input('name'),
//                    'address' => $request->input('address'),
//                    'from' => $from,
//                    'to' => $to,
//                    'area' => $request->input('area'),
                ]);
                $user->manager()->save($manager);
                $email = $request->input('email');
                $name = $request->input('name');
                \Mail::send('emails.new_manager', ['email' => $email, 'password' => $request->input('password'), ], function ($mail) use ($email, $name) {
                    $mail->from('admin@hermes.com', 'HERMES');

                    $mail->to($email, $name)->subject('HERMES::Account Created!');
                });
            } catch (\Illuminate\Database\QueryException $e) {
                $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
                $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
                return $response;
            }
            $response['data'] = 'Manager Created successfully.';
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
        $response = (new \App\Manager())->getManagerWithUser($id[0]);
        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
            return view('managers.edit')->with('manager', $response['data'])->render();
        } else {
            return "משהו לא בסדר עם האתר, אנא נסה שוב.";
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'name' => 'required|max:60',
        ]);
//        $from = str_replace(' ', '', $request->input('from'));
//        $to = str_replace(' ', '', $request->input('to'));
//        $from = Carbon::createFromFormat('H:i', $from)->format('H:i');
//        $to = Carbon::createFromFormat('H:i', $to)->format('H:i');
        $id = Hashids::decode($request->input('id'));

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
            $manager = $request->all();
            $response = (new \App\Manager())->getManager($id[0]);
            if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
                $response['data']->update($manager);
                $response['data'] = 'Manager Updated successfully.';
                return $response;
            } else {
                $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
                $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
                return $response;
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
        //
    }
}
