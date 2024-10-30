<?php

namespace App\Http\Controllers\Api;

use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'username' =>'required',
            'nama' =>'required',
            'password' => 'required|min:6|confirmed',
            'level_id' => 'required'
        ]);

        //jika validations fails
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        //create user
        $user = UserModel::create([
            'username' =>$request->username,
            'nama' =>$request->nama,
            'password' =>bcrypt($request->password),
            'level_id' => $request->level_id
        ]);

        //return response JSON user is created
        if($user) {
            return response()->json([
                'success' => true,
                'user' => $user,
            ], 201);
        }

        //return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    }
}
