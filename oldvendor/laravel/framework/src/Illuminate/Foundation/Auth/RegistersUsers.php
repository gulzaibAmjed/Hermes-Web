<?php

namespace Illuminate\Foundation\Auth;

use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;


trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $errors = '<ol>';
            foreach ($validator->errors()->all() as $key => $value) {
                $errors .= "<li>$value</li>";
            }
            $errors .= '</ol>';
            $response['data'] = $errors;
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            return $response;
            $this->throwValidationException(
                $request, $validator
            );
        }

        $getResponse = $this->create($request);
        if($getResponse['response'] == Config::get('constants.RESPONSE_STATUS_ERROR')){
            $response['data'] = "There is some thing wrong, please try again.";
            $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
            return $response;
        }else{
            // Auth::login($response['data']);
            $email = $request->input('email');
            $company = $request->input('company_name');
            try{
                Mail::send('emails.account_confirmation', ['code' => $getResponse['data']], function ($mail) use ($email,$company) {
                    $mail->from('admin@hermes.com', 'HERMES');

                    $mail->to($email, $company)->subject('HERMES::Account Confirmation!');
                });
            }catch(\Exception $e){
                error_log($e->getMessage());
            }
            $response['data'] = 'User created successfully.';
            $response['response'] = Config::get('constants.RESPONSE_STATUS_SUCCESS');
            return $response;
        }
        $response['data'] = "There is some thing wrong, please try again.";
        $response['response'] = Config::get('constants.RESPONSE_STATUS_ERROR');
        return $response;

        // return redirect($this->redirectPath());
    }
}
