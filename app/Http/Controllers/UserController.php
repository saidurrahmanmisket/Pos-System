<?php

namespace App\Http\Controllers;

use Exception;
use App\Helper\JWTToken;
use App\Mail\UserOTP;
use App\Models\Customer;
use App\Models\Users;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function userRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'mobile' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->first(),
            ]);
        }
        try {
            // checking already exist 
            $email = $request->input('email');
            $find = User::where('email', '=', $email)->count();
            if ($find >= 1) {
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
                'password' => Hash::make($request->input('password')),
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
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->first(),
            ]);
        }
        try {

            $user = User::where('email', '=', $request->input('email'))->first();

            if ($user && Hash::check($request->input('password'), $user->password)) {
                $token  = JWTToken::createToken($request->input('email'), $user->id);
                return response()->json([
                    'status' => 'success',
                    'message' => 'User Login successfully'
                ])->cookie('token', $token, 60 * 24 * 30);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'unauthorize'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Somthing went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function userLogOut(Request $request)
    {
        return redirect('/userLogin')->cookie('token', '', -1);
    }

    function userSentOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->first(),
            ]);
        }
        try {

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
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Somthing went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    function userVerifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'otp' => 'required|min:4|max:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->first(),
            ]);
        }

        try {

            $email = $request->email;
            $otp = $request->input('otp');
            $user = User::where('email', '=', $email)->where('otp', '=', $otp)->first();

            if ($user == null) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Email or OTP Not Match'
                ]);
            }

            if ($user) {
                //pass rest token issue
                $token  = JWTToken::createToken($request->input('email'), $user->id);
                //update otp
                User::where('email', '=', $email)->update(['otp' => '0']);
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
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Somthing went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }

    function restPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->first(),
            ]);
        }

        try {
            $email = $request->header('email');
            if ($email == "Expired token") {
                return response()->json([
                    'status' => 'expired',
                    'message' => "5min end, try again "
                ]);
            }

            $password = Hash::make($request->input('password'));
            User::where('email', '=', $email)->update(['password' => $password]);

            return response()->json([
                'status' => 'success',
                'message' => "Password change successful"
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ]);
        }
    }
    function userProfile(Request $request)
    {
        $email = $request->header('email');
        $user = User::where('email', '=', $email)->first();

        return response()->json([
            'status' => 'success',
            'message' => "Request successful",
            'user' => $user
        ]);
    }
    function userUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'mobile' => 'required|numeric|digits:11',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->first(),
            ]);
        }
        $email = $request->input('email');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $mobile = $request->input('mobile');
        $user = User::where('email', '=', $email)->first();
        $user->firstName = $firstName;
        $user->lastName = $lastName;
        $user->mobile = $mobile;
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => "Profile Update successful",
        ]);
    }
    function userName(Request $request)
    {
        try {
            $user_id = $request->header('id');
            $data = Customer::where('user_id', '=', $user_id)->select('id', 'name')->first();
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }












    // page index ////

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
