<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Models\RegisterCandidate;
use App\Models\RegistrationOTP;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Validator::extend('check_captcha', function ($attribute, $value, $parameters, $validator) {
            $inputs = $validator->getData();
            $security_code = $inputs['security_code'];
            $captcha_code = (!empty($parameters)) ? head($parameters) : null;
            $status = false;
            //echo "captcha_code: ".$captcha_code."-- security_code: ".$security_code;
            //exit;
            if(!empty($captcha_code) && ($captcha_code == $security_code)) {
                $status = true;
            }
            //echo $status;exit;
            return $status;
        });

        Validator::extend('check_unique_registration', function ($attribute, $value, $parameters, $validator) {
            $inputs = $validator->getData();
            $mobile_no = trim($inputs['mobile_no']);
            $email_id = strtolower(trim((!empty($parameters)) ? head($parameters) : null));
            $status = false;
            if(!empty($mobile_no) && !empty($email_id)) {
                $data = RegisterCandidate::where('email_id', $email_id)
                                           ->where('mobile_no', $mobile_no) 
                                           ->where('status','!=', 3)
                                           ->limit(1)
                                           ->get(['id'])
                                           ->toArray();

                if(empty($data)){        
                    $status = true;
                }
            }
            return $status;
        });

        Validator::extend('check_email_otp', function ($attribute, $value, $parameters, $validator) {
            $inputs = $validator->getData();
            $email_otp = $inputs['email_otp'];
            $email_id = $inputs['email_id'];
            $status = false;
            $otpDetails = RegistrationOTP::orderBy('id','desc')
                                        ->where('email_id',$email_id)
                                        ->limit(1)
                                        ->get(['otp'])
                                        ->toArray(); 
            //print_r($otpDetails);exit;
            if(!empty($otpDetails) && ($otpDetails[0]['otp'] == $email_otp)) {
                $status = true;
            }
            //echo $status;exit;
            return $status;
        });


    }
}
