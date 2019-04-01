<?php

namespace app\Http\Controllers\Auth;

use App\User;
use App\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Config;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function forgot(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|max:255'
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
            $response = (new \App\User())->resetPassword($request->input('email'));
            $email = $request->input('email');
            if ($response['response'] == Config::get('constants.RESPONSE_STATUS_SUCCESS')) {
                $mail = \Mail::send('emails.forgot_password', ['data' => $response['data']], function ($mail) use ($email) {
                    $mail->from('admin@hermes.com', 'HERMES');
                    $mail->to($email)->subject('HERMES::Password Recovery!');
                });
                $response['data'] = 'Password updated, please check your inbox.';
                $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
                return $response;
            }
        }
    }

    public function confirmAccount($code)
    {
        $response = (new \App\User())->confirmAccount($code);
        error_log($response['response']);
        if ($response['response'] == Config::get('constants.RESPONSE_STATUS_ERROR')) {
            \Session::flash('message', $response['data']);
            return redirect('/');
        } else {
            \Session::flash('message', 'החשבון כבר אושר, אנא כנס למערכת.');
            return redirect('/');
        }
    }

    public function loginCheck(Request $request)
    {
        try {
            $credentials = array('email' => $request->email, 'password' => $request->password);
            if (Auth::validate($credentials)) {
                $user = \App\User::where('email', $request->email)->first();
                $confirmation = $user->is_confirmed;
                if ($confirmation == 1) {
                    $response['status'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
                } else {
                    $response['status'] = Config::get('constants.RESPONSE_STATUS_ERROR');
                    $response['data'] = "אנא אשר אי מייל לפני כניסה למערכת.";
                }
            } else {
                $response['status'] = Config::get('constants.RESPONSE_STATUS_ERROR');
                $response['data'] = "שם וסיסמא לא נכונים.";
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $response['status'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
        }

        return $response;
    }

    public function forgotCheck(Request $request)
    {
        $user = \App\User::where('email', $request->input('email'))->get();
        if (count($user) > 0) {
            return Config::get('constants.RESPONSE_STATUS_SUCCESS');
        } else {
            return Config::get('constants.RESPONSE_STATUS_ERROR');
        }
    }

    // public function checkUser(Request $request)
    // {
    //     error_log(print_r($request->all(),true));
    // }

// Function to confirm account...

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'company_name' => 'required',
            'address' => 'required',
            'contact_number' => 'required',
        ]);
    }

// Function to check user credentials...

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(Request $request)
    {
        $confirmation_code = str_random(30);
        $ip = $_SERVER['REMOTE_ADDR'] ?: ($_SERVER['HTTP_X_FORWARDED_FOR'] ?: $_SERVER['HTTP_CLIENT_IP']);
        try {
            $user = User::create([
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'role' => Config::get('constants.USER_ROLE_CUSTOMER'),
                'is_confirmed' => Config::get('constants.USER_NOT_CONFIRMED'),
                'confirmation_code' => $confirmation_code,
                'ip' => $ip
            ]);
            $directory = Hashids::encode((int)$user->id, strtotime($user->created_at));
            $destinationPath = '../public/assets/uploads/' . $directory;
            $url = '';
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $this->makeDir($destinationPath);
                $file = $request->file('image');
                $thumbnailFileExtension = $file->getClientOriginalExtension();
                $thumbnailFilename = time() . '.' . $thumbnailFileExtension;
                $uploadSuccess = $file->move($destinationPath, $thumbnailFilename);
                $url = '/public/assets/uploads/' . $directory . '/' . $thumbnailFilename;
            }
            $customer = new Customer([
                'company_name' => $request->input('company_name'),
                'address' => $request->input('address'),
                'website' => $request->input('website'),
                'contact_number' => $request->input('contact_number'),
                'is_agree' => '',
                'agree_ip' => $ip,
            ]);
            $user->customer()->save($customer);
            } catch (\Illuminate\Database\QueryException $e) {
            $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            return $response;
        }
        $response['data'] = $confirmation_code;
        $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
        return $response;
    }

    // Function to check user credentials...

    public function makeDir($dirpath)
    {
        return is_dir($dirpath) || mkdir($dirpath);
    }
}
