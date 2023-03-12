<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profile_update(Request $request){
        $validator = validator::make($request->all(), [
            'first_name' => 'required|regex:/^[A-Za-z,]+$/|max:10',
            'last_name' => 'required|regex:/^[A-Za-z,]+$/|max:10',
            'email' => 'required|email|max:255',
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

        $user=$request->user();
        $user->update([
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
            'message'=>"profile sucessfully updated"
        ],200);

    }
}
