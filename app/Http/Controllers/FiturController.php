<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Yajra\Datatables\Datatables;
use Exception;
use DB;

class FiturController extends Controller
{
    public function index()
    {
        $fitur = DB::table('fitur')
                ->where(function ($v) {
                    $v->where('flag', '=', NULL);
                    $v->orWhere('flag', '!=', 9);
                })
                ->get();

        $route = Route::getRoutes()->getRoutes();
        // dd($route);
        $listRoute = [];
        if ( !empty($route) ) {
            foreach ($route as $v) {
                foreach ($v->action as $key => $v) {
                    if ( $key == 'as' ) 
                    $listRoute[] = $v;
                }
            }    
        }
        $data = [
            'fitur' => $fitur,
            'route' => $listRoute
        ];


        return view('setting.fitur.index')->with($data);
    }

    public function datatable()
    {
        $fitur = DB::table('fitur as a')
                ->where(function ($v) {
                    $v->where('a.flag', '=', NULL);
                    $v->orWhere('a.flag', '!=', 9);
                })
                ->leftJoin('fitur as b', 'a.parent_id', '=', 'b.id')
                ->select('a.*', 'b.nama as parent')
                ->get();

        return Datatables::of($fitur)
        ->addIndexColumn()
        ->addColumn('parent', function ($fitur) {
            return $fitur->parent;
        })
        ->addColumn('opsi', function ($fitur) {
            $idEncode = "'".base64_encode($fitur->id)."'";
            $nama = "'".$fitur->nama."'";
            $route = "'".$fitur->route."'";
            $icon = "'".$fitur->icon."'";
            $parentId = $fitur->parent_id; 

            // $url = route('kebun-form-edit', [$idEncode]);
            // , "'.$route.'", "'.$icon.'", "'.$parentId.'"
            $buttonEdit = '<button type="button" class="btn btn-sm btn-primary 
                            btn-flat" onclick="setFitur('.$idEncode.', '.$nama.','.$route.', '.$icon.', '.$parentId.')">
                            <i class="fas fa-edit"></i></button>';
            $buttonDelete = '<button type="button" class="btn btn-sm btn-danger btn-flat" onclick="deleteFitur('.$idEncode.')"><i class="fas fa-trash"></i></button>';
            return $buttonEdit.'&nbsp'.$buttonDelete;
        })
        ->rawColumns(['opsi'])
        ->make(true);
    }

    public function listFitur()
    {
        $fitur = DB::table('fitur as a')
                ->where(function ($v) {
                    $v->where('a.flag', '=', NULL);
                    $v->orWhere('a.flag', '!=', 9);
                })
                ->leftJoin('fitur as b', 'a.parent_id', '=', 'b.id')
                ->select('a.*', 'b.nama as parent')
                ->get();

        return Datatables::of($fitur)
        ->addIndexColumn()
        ->addColumn('parent', function ($fitur) {
            return $fitur->parent;
        })
        ->addColumn('opsi', function ($fitur) {
            $idEncode = "'".base64_encode($fitur->id)."'";
            $nama = "'".$fitur->nama."'";
            $route = "'".$fitur->route."'";
            $icon = "'".$fitur->icon."'";
            $parentId = $fitur->parent_id; 

            // $url = route('kebun-form-edit', [$idEncode]);
            // , "'.$route.'", "'.$icon.'", "'.$parentId.'"
            $buttonAdd = '<button type="button" class="btn btn-sm btn-success 
                            btn-flat" onclick="addFitur('.$idEncode.')">
                            <i class="fas fa-plus"></i></button>';
            return $buttonAdd;
        })
        ->rawColumns(['opsi'])
        ->make(true);
    }

    public function add(Request $req)
    {
        $inputIdFitur = base64_decode($req->inputIdFitur);
        $inputFitur = $req->inputFitur;
        $inputRoute = $req->inputRoute;
        $inputIcon = $req->inputIcon;
        $inputIdParent = $req->inputIdParent;

        if ( $inputFitur ) {
            $inputData = [
                            'nama' => $inputFitur,
                            'route' => $inputRoute,
                            'icon' => !is_null($inputIcon) ? $inputIcon: 'fas fa-file',
                            'parent_id' => $inputIdParent,
                            'flag' => 1
                        ];

            DB::beginTransaction();
            try {
                if ( empty($inputIdFitur) ) {
                    $save = DB::table('fitur')->insert($inputData);
                }else {
                    $save = DB::table('fitur')->where('id', $inputIdFitur)->update($inputData);
                }

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
                'message' => 'Harap isi Nama Fitur !'
            ];
        }

        return response()->json($response);
    }

    public function delete(Request $req)
    {
        $inputIdFitur = base64_decode($req->inputIdFitur);
        $delete = DB::table('fitur')->where('id', $inputIdFitur)->update(['flag' => 9]);
        $response = [];

        if ($delete) {
            $response = [
                'code' => 200,
                'message' => 'Berhasil dihapus !'
            ];
        }else {
            $response = [
                'code' => 300,
                'message' => 'Gagal Hapus !'
            ];
        }

        return response()->json($response);
    }

    public function tes()
    {
        // dd('a');
        $a = Route::getRoutes();

        $data = [];
        if ( !empty($a) ) {
            foreach ($a as $v) {
                $data[] = $v->uri;
            }    
        }
        return $data;
    }
    
}
