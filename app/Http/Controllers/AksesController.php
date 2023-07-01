<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Exception;
use DB;

class AksesController extends Controller
{
    public function index()
    {
        $perusahaan = DB::table('perusahaan')->get();
        
        $data = [
            'perusahaan' => $perusahaan
        ];

        return view('setting.akses.index')->with($data);
    }

    public function datatable()
    {
        $usersRole = DB::table('users_level as a')
                        ->leftJoin('perusahaan as b', 'b.id', '=', 'a.id_perusahaan')
                        ->where('is_active', 1)
                        ->select('a.*', 'b.nama as nama_perusahaan')
                        ->get();

        return Datatables::of($usersRole)
        ->addIndexColumn()
        ->editColumn('nama_perusahaan', function ($usersRole) {
            return ($usersRole->id_perusahaan == 0) ? 'All' : $usersRole->nama_perusahaan;
        })
        ->addColumn('opsi', function ($usersRole) {
            $idEncode = "'".base64_encode($usersRole->id)."'";
            $nama = "'".$usersRole->nama."'";
            // $url = route('kebun-form-edit', [$idEncode]);
            
            $buttonEdit = '<button type="button" class="btn btn-sm btn-primary btn-flat" onclick="setAkses('.$idEncode.', '.$nama.')"><i class="fas fa-edit"></i></button>';
            $buttonDelete = '<button type="button" class="btn btn-sm btn-danger btn-flat" onclick="deleteAkses('.$idEncode.')"><i class="fas fa-trash"></i></button>';
            return $buttonEdit.'&nbsp'.$buttonDelete;
        })
        ->addColumn('fitur', function () {
            return 'fitur';
        })
        ->rawColumns(['opsi'])
        ->make(true);
    }

    public function aksesAdd(Request $req)
    {
        $idFitur = $req->inputIdFitur;
        
        $inputIdPerusahaan = $req->inputIdPerusahaan;
        $inputIdUsersLevel = $req->inputIdUsersLevel;
        $inputUsersLevel = $req->inputUsersLevel;


        if ( $inputUsersLevel ) {
            $dataUsersLevel = [
                                'id_perusahaan' => base64_decode($inputIdPerusahaan),
                                'nama' => $inputUsersLevel,
                                'last_chg_user' => 1,
                                'is_active' => 1
                            ];
           
            $response = [];

            if ( !$inputIdUsersLevel ) {

                $usersLevel = DB::table('users_level')->insertGetId($dataUsersLevel);

                $detailUsersLevel = DB::table('akses_detail')->insert([
                                                                        'id_akses' => $usersLevel,
                                                                        'id_fitur' => base64_decode($idFitur),
                                                                        'flag' => 1
                                                                    ]);
                if ( $usersLevel && $detailUsersLevel ) {
                    $response = [
                            'new' => 'Y',
                            'idAkses' => base64_encode($usersLevel),
                            'code' => 200,
                            'message' => 'Berhasil ditambahkan'
                         ];
                }else {
                    $response = [
                        'idAkses' => base64_encode($usersLevel),
                        'code' => 400,
                        'message' => 'Gagal ditambahkan !'
                    ];
                }

            }elseif ($inputIdUsersLevel) {
                $detailUsersLevel = DB::table('akses_detail')->insert([
                                                                        'id_akses' => base64_decode($inputIdUsersLevel),
                                                                        'id_fitur' => base64_decode($idFitur),
                                                                        'flag' => 1
                                                                    ]);
                if ( $detailUsersLevel ) {
                    $response = [
                                'idAkses' => $inputIdUsersLevel,
                                'code' => 200,
                                'message' => 'Berhasil ditambahkan'
                            ];
                }else {
                    $response = [
                        'idAkses' => $inputIdUsersLevel,
                        'code' => 400,
                        'message' => 'Gagal ditambahkan !'
                    ];
                }
            }
        }

        return response()->json($response);
    }

    public function aksesList(Request $req)
    {
        $idDecodeFitur = base64_decode($req->idFitur);

        $akses = DB::table('akses_detail as a')
                ->where('a.id_akses', $idDecodeFitur)
                ->leftJoin('fitur as b', 'b.id', '=', 'a.id_fitur')
                ->leftJoin('fitur as c', 'c.id', '=', 'b.parent_id')
                ->where(function ($v) {
                    // $v->where('a.flag', '=', NULL);
                    $v->where('a.flag', '!=', 9);
                })
                ->select('a.*', 'b.nama as fitur', 'c.nama as parent')
                ->get();

        return Datatables::of($akses)
        ->addIndexColumn()
        ->addColumn('parent', function ($akses) {
            return $akses->parent;
        })
        ->addColumn('opsi', function ($akses) {
            $idEncode = "'".base64_encode($akses->id)."'";
            // $nama = "'".$akses->nama."'";
            // $route = "'".$akses->route."'";
            // $icon = "'".$akses->icon."'";
            // $parentId = $akses->parent_id; 

            $buttonAdd = '<button type="button" class="btn btn-sm btn-danger 
                            btn-flat" onclick="deleteFitur('.$idEncode.')">
                            <i class="fas fa-trash"></i></button>';
            return $buttonAdd;
        })
        ->rawColumns(['opsi'])
        ->make(true);
    }

    public function aksesListDelete(Request $req)
    {
        $idDecodeAkses = base64_decode($req->idFitur);
        
        $aksesDetail = DB::table('akses_detail')
                        ->where('id', $idDecodeAkses)
                        ->update(['flag' => 9]);

        $response = [];
        
        if ($aksesDetail) {
            $response = [
                'code' => 300,
                'message' => 'Berhasil dihapus !'
            ];
        }else {
            $response = [
                'code' => 400,
                'message' => 'Gagal dihapus !!'
            ];
        }

        return response()->json($response);
    }

    public function fiturListDelete(Request $req)
    {
        $idDecodeAkses = base64_decode($req->idAkses);
        
        $aksesDetail = DB::table('users_level')
                        ->where('id', $idDecodeAkses)
                        ->update(['is_active' => 0]);

        $response = [];
        
        if ($aksesDetail) {
            $response = [
                'code' => 300,
                'message' => 'Berhasil dihapus !'
            ];
        }else {
            $response = [
                'code' => 400,
                'message' => 'Gagal dihapus !!'
            ];
        }

        return response()->json($response);
    }
}
