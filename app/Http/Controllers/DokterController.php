<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class DokterController extends Controller
{

    public function index()
    {
        $getdokter = Dokter::orderBy('created_at','DESC')->get();
        $response = [
           'message' => 'List versi order by time',
            'data' => $getdokter
        ];

        return response()->json($response,Response::HTTP_OK);
    }

    
    public function getjenis()
    {
        // $getjenis = DB::table('dokters')->distinct('jenis')->get(['jenis']);
        $destination = Dokter::select('nama','jenis')->groupBy('jenis')->get();
        $response = [
           'message' => 'List versi order by time',
            'data' => $destination
        ];

        return response()->json($response,Response::HTTP_OK);
    }

 
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => ['required'],
            'jenis' => ['required'],
            'hari' => ['required'],
            'jam' => ['required'],
            'foto' => ['required'],
            'cp' => ['required']
            
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //menyimpan data
        $file = $request->file('foto');

        $file->getMimeType();
        //tujuan upload
        $tujuanupload = 'img';

        //upload file
        try {
            $file->move($tujuanupload,$file->getClientOriginalName());
            $path = $tujuanupload.'/'.$file->getClientOriginalName();

            $register = new Dokter();
            $register->foto = $path;
            $register->nama = $request->nama;
            $register->jenis = $request->jenis;
            $register->hari = $request->hari;
            $register->jam = $request->jam;
            $register->cp = $request->cp;
            $register->save();
            $response = [
                'message' => 'upload sukses',
                'data' => 1
            ];
            return response()->json($response,Response::HTTP_OK);   
        } catch (QueryException $e) {
            return response()->json(['message' => "Failed", 'data' => $e->errorInfo],Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }

    public function updatedokter(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama' => ['required'],
            'hari' => ['required'],
            'jenis' => ['required'],
            'jam' => ['required'],
            'cp' => ['required'],
            'id' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        

        $foto = $request->file('foto');
        if($foto!=null){
            $hapusfoto = Dokter::where('id',$request->id)->first();
            if($hapusfoto!=null){
                File::delete($hapusfoto->foto);
            }
            $tujuanupload = 'img';
            $foto->move($tujuanupload,$foto->getClientOriginalName());
            $path = $tujuanupload.'/'.$foto->getClientOriginalName();
            $updatedokter = DB::table('dokters')->where('id',$request->id)->update([
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'hari' => $request->hari,
                'jam' => $request->jam,
                'cp' => $request->cp,
                'foto' => $path
            ]);
            $response = [
                'message' => 'berhasil update',
                'data' => 1
            ];
                return response()->json($response,Response::HTTP_OK);

    
        }else {
            $updatedokter = DB::table('dokters')->where('id',$request->id)->update([
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'hari' => $request->hari,
                'jam' => $request->jam,
                'cp' => $request->cp
            ]);
    
            $response = [
                'message' => 'berhasil update',
                'data' => 1
            ];
                return response()->json($response,Response::HTTP_OK);
    
        }

    }

    public function deletedokter(Request $request)
    {
        $deletedokter = DB::table('dokters')->where('id',$request->id)->delete();
        if ($deletedokter > 0) {
            $foto = Dokter::where('id',$request->id)->first();
            if($foto!=null){
                File::delete($foto->foto);
            }
            $response = [
                'message' => 'berhasil dihapus',
                'data' => 1
            ];
            return response()->json($response,Response::HTTP_CREATED);
        }else{
            $response = [
                'message' => 'gagal hapus',
                'data' => 0
            ];
            return response()->json($response,Response::HTTP_OK);

        }

    }

   
}
