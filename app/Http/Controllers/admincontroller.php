<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class admincontroller extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => ['required'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        try {
            $hash = Hash::make($request->password);
            $register = Admin::create([
                'username' => $request->username,
                'password' => $hash
            ]);

            $response = [
                'message' => 'register berhasil',
                'data' => 1
            ];

            return response()->json($response, Response::HTTP_CREATED);

        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }

    }

    public function readadmin()
    {
        $admin = Admin::orderBy('created_at','DESC')->get();
        $response = [
           'message' => 'List akte order by time',
            'data' => $admin

        ];

        return response()->json($response,Response::HTTP_OK);
    }

    public function loginadmin(Request $request)
    {    
        $login = DB::table('admins')->where('username',$request->username)->first();
        $hashed = $login->password;
        if (password_verify($request->password, $hashed)) {
            $response = [
                'message' => 'berhasil',
                'data' => 1
            ];
    
            return response()->json($response,Response::HTTP_OK);
        } else {
            $response = [
                'message' => 'gagal',
                'data' => 0
            ];
    
            return response()->json($response,Response::HTTP_OK);

        }
       

    }

}
