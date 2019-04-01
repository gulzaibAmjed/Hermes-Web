<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role', 'is_confirmed', 'confirmation_code', 'ip'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

//Function to attach customer....
    public function customer()
    {
        return $this->hasOne('App\Customer');
    }

//Function to attach manager....
    public function manager()
    {
        return $this->hasOne('App\Manager');
    }

//Function to confirm account....
    public function scopeConfirmAccount($query, $code)
    {
        $user = $query->where('confirmation_code', $code)->first();
        if (!is_null($user)) {
            if ($user->is_confirmed == 1) {
                $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
                $response['data'] = "החשבון כבר אושר, אנא כנס למערכת.";
                return $response;
            }
            try {
                $user->is_confirmed = 1;
                $user->save();
                $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
                return $response;
            } catch (\Illuminate\Database\QueryException $e) {
                $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
                $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
                return $response;
            }
        } else {
            $response['data'] = "לא נמצא חשבון במערכת, אנא אשר אי מייל";
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            return $response;
        }

    }

    // Function to varify if user is confirmed or not...
    public function scopeIsConfirmed($query, $email)
    {
        $user = $query->where('email', $email)->first();
        if (!is_null($user) && $user->is_confirmed == 1) {
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
        } else if (!is_null($user) && $user->is_confirmed == 0) {
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = "אנא אשר אי מייל לפני כניסה למערכת.";
        } else {
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            $response['data'] = "שם וסיסמא לא נכונים.";
        }
        return $response;
    }

    public function scopeResetPassword($query, $email)
    {
        try {
            $user = $query->where('email', $email)->first();
            $password = md5(Carbon::now());
            $user->password = bcrypt($password);
            $user->save();
        } catch (\Illuminate\Database\QueryException $e) {
            $response['data'] = "משהו לא בסדר עם האתר, אנא נסה שוב.";
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            return $response;
        }
        $response['data'] = ['email' => $email, 'password' => $password];
        $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
        return $response;
    }
}
