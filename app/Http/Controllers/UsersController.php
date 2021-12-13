<?php

namespace App\Http\Controllers;

use App\Models\UsersModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $readuser = UsersModel::orderBy('created_at','DESC')->get();
        $response = [
           'message' => 'List akte order by time',
            'data' => $readuser
        ];

        return response()->json($response,Response::HTTP_OK);
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'uid' => ['required'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'nohp' => ['required']
            
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $register = UsersModel::create($request->all());
            $response = [
                'message' => 'register  berhasil',
                'data' => 1
            ];

            return response()->json($response, Response::HTTP_CREATED);

        } catch (QueryException $e) {
            return response()->json(['message' => "Failed", 'data' => $e->errorInfo],Response::HTTP_UNPROCESSABLE_ENTITY);
        }


    }

    public function destroy($uid)
    {
        $deleteakun = DB::table('users_models')->where('uid',$uid)->delete();
        if ($deleteakun > 0) {
            $response = [
                'message' => 'berhasil dihapus',
                'data' => $deleteakun
            ];
            return response()->json($response,Response::HTTP_CREATED);
        }else{
            $response = [
                'message' => 'gagal hapus',
                'data' => $deleteakun
            ];
            return response()->json($response,Response::HTTP_OK);

        }


    }

    public function updatefoto(Request $request, $uid)
    {
        $validator = Validator::make($request->all(),[
            'foto' => ' required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

          //get data barang
          $foto = UsersModel::where('uid',$uid)->first();
          if ($foto == null) {
              $response = [
                  'message' => 'tidak ada data',
                  'data' => 0
              ];
              return response()->json($response,Response::HTTP_CREATED);
          }

          //seleksi jika foto ada
        if ($request->foto!=null) {
              //hapus foto lama
              File::delete($foto->foto);
          
              $file = $request->file('foto');
              $file->getMimeType();
              //tujuan upload
              $tujuanupload = 'img';
              //upload file
              try {
                $file->move($tujuanupload,$file->getClientOriginalName());
                $path = $tujuanupload.'/'.$file->getClientOriginalName();

                $updateakun = DB::table('users_models')->where('uid',$request->uid)->update([
                    'foto'=> $path
                ]);
    
                $response = [
                    'message' => $path,
                    'data' => 1
                ];
                return response()->json($response,Response::HTTP_OK);   
            } catch (QueryException $e) {
                return response()->json(['message' => "Failed", 'data' => $e->errorInfo],Response::HTTP_UNPROCESSABLE_ENTITY);
            }

        }

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'uid' => ['required'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'nohp' => ['required'],
            'password' => ['required']]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            
            $updateakun = DB::table('users_models')->where('uid',$request->uid)->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'password' => $request->password,
                'nohp' => $request->nohp
            ]);

            $response = [
                'message' => 'berhasil update',
                'data' => $updateakun
            ];

            return response()->json($response,Response::HTTP_OK);

        } catch (QueryException $e) {
            return response()->json(['message' => "Failed", 'data' => $e->errorInfo],Response::HTTP_UNPROCESSABLE_ENTITY);

        }
    }

    public function show(Request $request)
    {
        $detailakun = DB::table('users_models')->where('uid',$request->input('uid'))->first();
        $response = [
            'message' => 'detail akun',
            'data' => $detailakun
        ];

        if($detailakun==null){
            $response = [
                'message' => 'detail akun',
                'data' => 'akun tidak terdaftar'
            ];
            return response()->json($response,Response::HTTP_OK);   
        }
        return response()->json($response,Response::HTTP_OK);   
    }

}
