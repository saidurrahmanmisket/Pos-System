<?php

namespace App\Http\Controllers;

use Exception;
use App\Helper\JWTToken;
use App\Mail\UserOTP;
use App\Models\Users;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function userRegistration(Request $request)
    {
        try {
            // checking already exist 
            $email = $request->input('email');
            $find = User::where('email', '=', $email)->count();
            if($find >= 1){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'email already exist'
                ]);
            }
            Users::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'mobile' => $request->input('mobile'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User Registration successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()

                // 'message' => 'User Registration unsuccessful'
            ]);
        }
    }
    public function userLogin(Request $request)
    {
        try {

            $count = User::where('email', '=', $request->input('email'))
                ->where('password', '=', $request->input('password'))->count();

            if ($count == 1) {
                $token  = JWTToken::createToken($request->input('email'));
                return response()->json([
                    'status' => 'success',
                    'message' => 'User Login successfully'
                ])->cookie('token' , $token);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'User unauthorize'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User login failed'
            ]);
        }
    }

    function userSentOTP(Request $request)
    {

        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email', '=', $email)->count();

        if ($count == 1) {
            //sent otp to email
            Mail::to($email)->send(new UserOTP($otp));
            //store otp in database
            User::where('email', '=', $email)->update(['otp' => $otp]);
            return response()->json([
                'status' => 'success',
                'message' => 'Otp Sent successfully',
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User Not Found'
            ]);
        }
    }

    function userVerifyOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)->where('otp', '=', $otp)->count();

        if ($count == 1) {
            //update otp
            User::where('email', '=', $email)->update(['otp' => '0']);
            //pass rest token issue
            $token  = JWTToken::createTokenForSetPassword($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'User Login successfully'
            ])->cookie('token', $token);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'Email or OTP Not Match'
            ]);
        }
    }

    function restPassword(Request $request)
    {
        try {
            $email = $request->cookie('email');
            $password = $request->input('password');
            User::where('email', '=', $email)->update(['password' => $password]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password Reset successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong'
            ]);
        }
    }


    function ProfilePage()
    {
        return view('pages.dashboard.profile-page');
    }

    function LoginPage()
    {
        return view('pages.auth.login-page');
    }

    function RegistrationPage()
    {
        return view('pages.auth.registration-page');
    }
    function SendOtpPage()
    {
        return view('pages.auth.send-otp-page');
    }
    function VerifyOTPPage()
    {
        return view('pages.auth.verify-otp-page');
    }

    function ResetPasswordPage()
    {
        return view('pages.auth.reset-pass-page');
    }


}
