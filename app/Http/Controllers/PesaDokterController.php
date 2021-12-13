<?php

namespace App\Http\Controllers;

use App\Models\PesanDokter;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PesaDokterController extends Controller
{
    
    public function index($uid)
    {
        $readpesan = PesanDokter::where('uid',$uid)->orderBy('created_at','DESC')->get();
        $response = [
           'message' => 'List akte order by time',
            'data' => $readpesan
        ];

        return response()->json($response,Response::HTTP_OK);
    }

    
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => ['required'],
            'hari' => ['required'],
            'jam' => ['required'],
            'jenis' => ['required'],
            'uid' => ['required'],
            'keluhan' => ['required']

            
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $checkpesandokter = PesanDokter::where('uid',$request->uid)->where('jenis',$request->jenis)->orderBy('created_at','DESC')->first();
        if($checkpesandokter == null){

            try {
                $register = new PesanDokter();
                $register->nama = $request->nama;
                $register->hari = $request->hari;
                $register->jam = $request->jam;
                $register->jenis = $request->jenis;
                $register->uid = $request->uid;
                $register->antri = rand(1,20);
                $register->keluhan = $request->keluhan;
                $register->save();
                $response = [
                    'message' => 'upload sukses',
                    'data' => 1
                ];
                return response()->json($response, Response::HTTP_CREATED);
    
            } catch (QueryException $e) {
                return response()->json(['message' => "Failed", 'data' => $e->errorInfo],Response::HTTP_UNPROCESSABLE_ENTITY);
            }
      
        }else{
            $response = [
                'message' => 'sudah pernah daftar',
                 'data' => 0
             ];
     
                         return response()->json($response, Response::HTTP_CREATED);     
        }


    }

    
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'jam' => ['required'],
            'keluhan' => ['required'],
            'hari' => ['required'],
            'uid' => ['required'],
            'jenis' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            
            $updatepesanan = DB::table('pesan_dokters')->where('uid',$request->uid)->where('jenis',$request->jenis)->update([
                'jam' => $request->jam,
                'hari' => $request->hari,
                'keluhan' => $request->keluhan,
                'jenis' => $request->jenis
            ]);
            
            if ($updatepesanan > 0 ) {
                $response = [
                    'message' => 'berhasil update',
                    'data' => 1
                ];
                return response()->json($response,Response::HTTP_OK);
            }else{
                $response = [
                    'message' => 'berhasil update',
                    'data' => 0
                ];
                return response()->json($response,Response::HTTP_OK);
            }

        } catch (QueryException $e) {
            return response()->json(['message' => "Failed", 'data' => $e->errorInfo],Response::HTTP_UNPROCESSABLE_ENTITY);

        }
    }

    public function hapus($id)
    {
        $deleteakun = DB::table('pesan_dokters')->where('id',$id)->delete();
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

   
}
