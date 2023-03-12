<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    function registration(Request $request)
    {
        $validator = validator::make($request->all(), [
            'first_name' => 'required|regex:/^[A-Za-z,]+$/|max:10',
            'last_name' => 'required|regex:/^[A-Za-z,]+$/|max:10',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'address' => 'required|string',
            'contact' => 'required|regex:/(01)[0-9]{9}/',
            'department' => 'required|regex:/^[A-Za-z,]+$/',
            'designation'=>'required|regex:/^[A-Za-z,]+$/',
            'type' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'=>$request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'contact' => $request->contact,
            'department'=>$request->department,
            'designation'=>$request->designation,
            'type' => $request->type

        ]);

        return response()->json([
            'message' => "Registration successful",
            // 'user' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

        //    return response($user);
            if($user){
                if($user->type == "User")
                {
                    $data = [
                    'status' => true,
                    'message' => 'User Logged In Successfully',
                    'token' =>$user->createToken('API TOKEN')->plainTextToken,
                    'status code' => 200,
                    'user name' => $user->first_name." ".$user->last_name,
                    'designation'=>$user->designation,
                    'department'=>$user->department,
                    'type'=>$user->type
                    ];

                    return response()->json([$data]);

                }

                else if($user->type == "Admin")
                {

                    $data = [
                    'status' => true,
                    'message' => 'Admin Logged In Successfully',
                    'token' => $user->createToken('API TOKEN')->plainTextToken,
                    'status code' => 200,
                    'user name' => $user->first_name." ".$user->last_name,
                    'designation'=>$user->designation,
                    'department'=>$user->department,
                    'type'=>$user->type
                    ];

                    return response()->json([$data]);

                }



            }

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
           'Logout Successful'
        ]);

    }

    // public function forgot(Request $request){
    //     $user=($query=User::query());
    //     $user=$user->where($query->qualifyColumn('email'),$request->input('email'))->first();

    //     if(!$user||!$user->email){
    //         return response()->error('No record found','your email is incorrect',400);
    //     }

    //     $resetPasswordToken=str_pad(random_int(1,9999),4,'0',STR_PAD_LEFT);

    //     if(!$userPassReset=PasswordReset::where('email',$user->email)->first()){
    //         PasswordReset::create([
    //             'email'=>$user->email,
    //             'token'=>$resetPasswordToken,
    //         ]);
    //     }else{
    //          $userPassReset->update([
    //             'email'=>$user->email,
    //             'token'=>$resetPasswordToken,
    //          ]);
    //     }
    //     $user->notify(
    //         new PasswordResetNotification(
    //             $user,
    //             $resetPasswordToken
    //         )
    //         );
    //         return response()->json([
    //            'Code is sent your email'
    //         ]);
    // }







}
