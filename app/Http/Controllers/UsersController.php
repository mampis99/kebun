<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use DB;
use Hash;

class UsersController extends Controller
{
    public function index()
    {
        $perusahaan = DB::table('perusahaan')->get();
        $usersLevel = DB::table('users_level')->get();

        $data = [
            'perusahaan' => $perusahaan,
            'users_level' => $usersLevel
        ];

        return view('users.index')->with($data);
    }

    public function data()
    {
       $users = DB::table('users')
                    ->where('flag_active', '!=', 9)
                    ->select('id', 'id_level', 'id_perusahaan', 'username', 'email', 'fullname', 'flag_active')
                    ->get();

       return Datatables::of($users)
        ->addIndexColumn()
        ->addColumn('opsi', function ($users) {
            $idEncode = "'".base64_encode($users->id)."'";
            
            $buttonEdit = '<button class="btn btn-sm btn-primary btn-flat"><i class="fas fa-edit"></i></button>';
            $buttonDelete = '<button type="button" class="btn btn-sm btn-danger btn-flat" onclick="deleteUser('.$idEncode.')"><i class="fas fa-trash"></i></button>';
            return $buttonEdit.'&nbsp'.$buttonDelete;
        })
        ->rawColumns(['opsi'])
        ->make(true);
    }

    public function add(Request $req)
    {
        $inputName = $req->inputName;
        $inputUsername = $req->inputUsername;
        $inputEmail = $req->inputEmail;
        $inputPassword = $req->inputPassword;
        $inputPerusahaan = $req->inputPerusahaan;
        $inputUserLevel = $req->inputUserLevel;
        $inputStatus = $req->inputStatus;

        if ( $inputName && $inputEmail && $inputPassword ) {
            $inputData = [
                            'id_level' => $inputUserLevel,
                            'id_perusahaan' => $inputPerusahaan,
                            'username' => $inputUsername,
                            'email' => $inputEmail,
                            'fullname' => $inputName,
                            'pwd' => Hash::make($inputPassword),
                            'flag_active' => 1
                        ];

            DB::beginTransaction();
            try {
                $save = DB::table('users')->insert($inputData);
                DB::commit();
                $response = [
                    'code' => 200,
                    'message' => 'Berhasil ditambahkan'
                ];
            } catch (Exception $e) {
                DB::rollback();
                $response = [
                    'code' => 400,
                    // 'message' => 'Gagal ditambahkan !'
                    'message' => $e
                ];
            }
        }else {
            $response = [
                'code' => 300,
                'message' => 'Harap isi Nama Perusahaan, Dirut, & Alamat !'
            ];
        }

        return response()->json($response);
    }

    public function delete(Request $req)
    {
        $idUserEncode = base64_decode($req->inputIdUser);
        $delete = DB::table('users')
                    ->where('id', $idUserEncode)
                    ->update(['flag_active' => 9]);
        
        $response = [];

        if ($delete) {
            $response = [
                    'code' => 200,
                    'message' => 'Berhasil dihapus'
                ];
        }else {
            $response = [
                    'code' => 200,
                    'message' => 'Gagal dihapus !'
                ];
        }

        return response()->json($response);
    }

}
