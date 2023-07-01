<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Exception;
use DB;
use Session;


class KebunController extends Controller
{
    public function index()
    {
        $idPerusahaam = Session::get('idPerusahaan');
        $perusahaan = DB::table('perusahaan')->where('id', $idPerusahaam)->get();

        $data = [
            'idPerusahaan' => base64_encode($idPerusahaam),
            'perusahaan' => $perusahaan,
        ];

        return view('kebun.index')->with($data);
    }

    public function indexNode()
    {
        $chip = DB::table('chip')->where('flag', '!=', 9)->get();

        $data = [
            'chip' => $chip,
        ];

        return view('node.index')->with($data);
    }

    public function data()
    {
        $data = [
            ['aa'=> 'op'],
            ['av'=>'qwe']
        ];

        return Datatables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function add(Request $req)
    {
        $idPerusahaanDecode = base64_decode($req->_id);
        $kebun = $req->kebun;
        $keterangan = $req->keterangan;
        $apiKey = $req->apiKey;

        if ( $idPerusahaanDecode && $kebun && $keterangan ) {
            $inputData = [
                            'id_perusahaan' => $idPerusahaanDecode,
                            'nama' => $kebun,
                            'keterangan' => $keterangan,
                            'apikey' => $apiKey,
                            'flag' => 1
                        ];
            DB::beginTransaction();
            try {
                $save = DB::table('kebun')->insert($inputData);
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
                'message' => 'Harap isi Nama Kebun dan Keterangan !'
            ];
        }

        return response()->json($response);
    }

    public function datatableKebun(Request $req)
    {
        $idPerusahaanDecode = base64_decode($req->_id);
        $term =  ($req->_nama != NULL) ? $req->_nama : NULL;

        $kebun = DB::table('kebun')
                    ->where('id_perusahaan', $idPerusahaanDecode)
                    ->where('nama', 'LIKE', '%'.$term.'%')
                    ->get();

        return Datatables::of($kebun)
        ->addIndexColumn()
        ->addColumn('opsi', function ($kebun) {
            // $idEncode = base64_encode($kebun->id);
            // $url = route('kebun-form-edit', [$idEncode]);
            $buttonEdit = '<a href="" class="btn btn-sm btn-primary btn-flat"><i class="fas fa-edit"></i></a>';
            $buttonDelete = '<button class="btn btn-sm btn-danger btn-flat"><i class="fas fa-trash"></i></button>';
            return $buttonEdit.'&nbsp'.$buttonDelete;
        })
        ->rawColumns(['opsi'])
        ->make(true);
    }

    public function nodeAdd(Request $req)
    {
        $inputIdNodeSetting = $req->inputIdNodeSetting;
        $inputChip = $req->inputChip;
        $inputNoSensor = $req->inputNoSensor;
        $inputSensor = $req->inputSensor;
        $inputKeterangan = $req->inputKeterangan;

        if ( $inputChip && $inputSensor ) {
            $inputData = [
                            'id_chip' => $inputChip,
                            'sub_node' => $inputNoSensor,
                            'nama' => $inputSensor,
                            'keterangan' => $inputSensor.' '.$inputKeterangan,
                            'flag' => 1
                        ];
            DB::beginTransaction();
            try {
                if ( is_null($inputIdNodeSetting) ) {
                    $save = DB::table('node')->insert($inputData);
                }else {
                    $save = DB::table('node')
                                ->where('id', base64_decode($inputIdNodeSetting))
                                ->update($inputData);
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
                    'message' => 'Gagal ditambahkan !'
                    // 'message' => $e
                ];
            }
        }else {
            $response = [
                'code' => 300,
                'message' => 'Harap isi dengan lengkap !'
            ];
        }

        return response()->json($response);
    }

    public function nodeDatatable(Request $req)
    {
        $idPerusahaanDecode = base64_decode($req->_id);

        $node = DB::table('node as a')
                    ->leftJoin('chip as b', 'b.id', '=', 'a.id_chip')
                    ->leftJoin('kebun as c', 'c.id', '=', 'b.id_kebun')
                    ->leftJoin('tipe as d', 'd.id', '=', 'b.id_tipe')
                    ->where('c.id_perusahaan', $idPerusahaanDecode)
                    ->where('a.flag', '!=', 9)
                    ->select('a.*',
                                'b.chip', 'b.id_tipe', 'b.keterangan as keterangan_chip', 'b.versi', 'b.build',
                                    'c.nama as nama_kebun', 'c.keterangan as keterangan_kebun',
                                        'd.nama as nama_tipe')
                    ->get();

        return Datatables::of($node)
        ->addIndexColumn()
        ->addColumn('opsi', function ($node) {
            $idEncode = "'".base64_encode($node->id)."'";
            $idChip = $node->id_chip;
            $namaChip = "'".$node->chip.' / '.$node->keterangan_chip."'";
            $subNode = $node->sub_node;
            $namaNode = "'".$node->nama."'";
            $keterangan = "'".$node->keterangan."'";

            // $url = route('kebun-form-edit', [$idEncode]);
            $buttonEdit = '<button type="button" class="btn btn-sm btn-primary btn-flat" onclick="setNode('.$idEncode.', '.$namaChip.','.$idChip.','.$subNode.','.$namaNode.','.$keterangan.')"><i class="fas fa-edit"></i></button>';
            $buttonDelete = '<button type="button" class="btn btn-sm btn-danger btn-flat" onclick="deleteNode('.$idEncode.')"><i class="fas fa-trash"></i></button>';
            return $buttonEdit.'&nbsp'.$buttonDelete;
        })
        ->rawColumns(['opsi'])
        ->make(true);
    }

    function deleteNode(Request $req) {
        $idNode = base64_decode($req->_id);
        $delete = DB::table('node')->where('id', $idNode)->update(['flag' => 9]);

        $response = [];
        if ($delete) {
            $response = [
                'code' => 200,
                'message' => 'Berhasil dihapus !'
            ];
        }else {
            $response = [
                'code' => 300,
                'message' => 'Gagal hapus !'
            ];
        }

        return response()->json($response); 
    }
    
    public function getNode($data, $idNode, $no=NULL)
    {
        $result = $data->where('id', $idNode)->first();
        $adt = '';
        if ( !is_null($no) ) {
            $adt = ' : MEDIA '.$no;
        }
        return ( !is_null($result) ) ? $result->chip.$adt : NULL;
    }    
    
    public function nodeRoleSettingDatatable()
    {
        // $node = DB::table('node')->get();

        // $nodeRole = DB::table('node_role')
        //                 ->get();

        // $nodeRoleSettingDatatable = [];
        // foreach ($nodeRole as $k => $v) {
        //     $_chipNode = $this->getNode($node, $v->id_node);
        //     $nodeRoleSettingDatatable[] = (object)[
        //         'id'=> $v->id, 
        //         'id_node'=> $v->id_node,
        //         'chip_node' => $_chipNode.' : '.$v->keterangan,
        //         'flag'=> $v->flag,
        //         'waktu'=> $v->waktu, 
        //         'sleeptime'=> $v->sleeptime,
        //         'exetime'=> $v->exetime,
        //         'reff_node'=> $v->reff_node,
        //         'chip_reff_node'=> $this->getNode($node, $v->reff_node, 1),
        //         'reff_node2'=> $v->reff_node2,
        //         'chip_reff_node2'=> $this->getNode($node, $v->reff_node2, 2),
        //         'reff_node3'=> $v->reff_node3,
        //         'chip_reff_node3'=> $this->getNode($node, $v->reff_node3, 3),
        //         'reff_node4'=> $v->reff_node4,
        //         'chip_reff_node4'=> $this->getNode($node, $v->reff_node4, 4),
        //         'reff_node5'=> $v->reff_node5,
        //         'chip_reff_node5'=> $this->getNode($node, $v->reff_node5, 5),
        //         'reff_node6'=> $v->reff_node6,
        //         'chip_reff_node6'=> $this->getNode($node, $v->reff_node6, 6),
        //         'relay'=> $v->relay,
        //         'repeater'=> $v->repeater,
        //         'time0'=> $v->time0,
        //         'time1'=> $v->time1,
        //         'limval0'=> $v->limval0,
        //         'limval1'=> $v->limval1,
        //         'keterangan'=> $v->keterangan,
        //         'tanggal'=>$v->tanggal
        //     ];
        // }

        // // dd($nodeRoleSettingDatatable);

        // return Datatables::of($nodeRoleSettingDatatable)
        // ->addIndexColumn()
        // ->addColumn('opsi', function ($nodeRoleSettingDatatable) {
        //     // $idEncode = base64_encode($kebun->id);
        //     // $url = route('kebun-form-edit', [$idEncode]);
        //     $buttonEdit = '<a href="" class="btn btn-sm btn-primary btn-flat"><i class="fas fa-edit"></i></a>';
        //     $buttonDelete = '<button class="btn btn-sm btn-danger btn-flat"><i class="fas fa-trash"></i></button>';
        //     return $buttonEdit.'&nbsp'.$buttonDelete;
        // })
        // ->rawColumns(['opsi'])
        // ->make(true);
    }

    public function mapSettingDatatable(Request $req)
    {
        $idPerusahaanDecode = (!is_null($req->_id)) ? base64_decode($req->_id) : NULL;

        $mapSettingDatatable = DB::table('value_map as a')
                                ->leftJoin('node as b', 'b.id', '=', 'a.id_node')
                                ->leftJoin('chip as c', 'c.id', '=', 'b.id_chip')
                                ->leftJoin('kebun as d', 'd.id', '=', 'c.id_kebun')
                                ->where('d.id_perusahaan', '=', $idPerusahaanDecode)
                                ->select('a.*', 'b.nama as nama_node',
                                            'c.chip',
                                                'd.nama as kebun')
                                ->get();

        return Datatables::of($mapSettingDatatable)
        ->addIndexColumn()
        ->addColumn('opsi', function ($mapSettingDatatable) {
            $idEncode = $mapSettingDatatable->id_node;
            $namaNode = "'".$mapSettingDatatable->nama_node."'";
            $raw_nol = $mapSettingDatatable->raw_nol; 
            $raw_satu = $mapSettingDatatable->raw_satu;
            $raw_dua = $mapSettingDatatable->raw_dua;
            $val_nol = $mapSettingDatatable->val_nol;
            $val_satu = $mapSettingDatatable->val_satu;
            $val_dua = $mapSettingDatatable->val_dua;
            $min = $mapSettingDatatable->min;
            $max = $mapSettingDatatable->max;

            // $url = route('kebun-form-edit', [$idEncode]);
            $buttonEdit = '<button type="button" class="btn btn-sm btn-primary btn-flat ok" onclick="setMap('.$idEncode.', '.$namaNode.','.$raw_nol.', '.$raw_satu.', '.$raw_dua.', '.$val_nol.', '.$val_satu.', '.$val_dua.', '.$min.', '.$max.')"><i class="fas fa-edit"></i></button>';
            $buttonDelete = '<button type="button" class="btn btn-sm btn-danger btn-flat" onclick="deleteMap('.$idEncode.')"><i class="fas fa-trash"></i></button>';
            return $buttonEdit.'&nbsp'.$buttonDelete;
        })
        ->rawColumns(['opsi'])
        ->make(true);
    }

    function listNode(Request $req) {
        $idPerusahaanDecode = (!is_null($req->_id)) ? base64_decode($req->_id) : NULL;

        $listNode = DB::table('node as a')
                    ->leftJoin('chip as b', 'b.id', '=', 'a.id_chip')
                    ->leftJoin('kebun as c', 'c.id', '=', 'b.id_kebun')
                    ->where('c.id_perusahaan', '=', $idPerusahaanDecode)
                    ->select('a.*')
                    ->get();

        return response()->json($listNode);
    }

    function listChip(Request $req) {
        $idPerusahaanDecode = (!is_null($req->_id)) ? base64_decode($req->_id) : NULL;

        $listChip = DB::table('chip as a')
                    ->leftJoin('kebun as c', 'c.id', '=', 'a.id_kebun')
                    ->where('c.id_perusahaan', '=', $idPerusahaanDecode)
                    ->select('a.*')
                    ->get();

        return response()->json($listChip);            
    }

    function saveMapSettingDatatable(Request $req) {
        $inputIdNodeMap = $req->inputIdNodeMap;
        $inputVal0 = $req->inputVal0;
        $inputMap0 = $req->inputMap0;
        $inputVal1 = $req->inputVal1;
        $inputVal2 = $req->inputVal2;
        $inputMap1 = $req->inputMap1;
        $inputMap2 = $req->inputMap2;
        $inputMin = $req->inputMin;
        $inputMax = $req->inputMax;

        if ( $inputIdNodeMap ) {
            $inputData = [
                            'id_node' => $inputIdNodeMap,
                            'raw_nol' => $inputVal0,
                            'raw_satu' => $inputVal1,
                            'raw_dua' => $inputVal2,
                            'val_nol' => $inputMap0,
                            'val_satu' => $inputMap1,
                            'val_dua' => $inputMap2,
                            'min' => $inputMin,
                            'max' => $inputMax
                        ];
            
            $mapData = DB::table('value_map')->where('id_node', $inputIdNodeMap)->first();

            DB::beginTransaction();
            try {
                if ( is_null($mapData) ) {
                    $save = DB::table('value_map')->insert($inputData);
                }else {
                    $save = DB::table('value_map')->where('id_node', $inputIdNodeMap)->update([
                                                                                                'raw_nol' => $inputVal0,
                                                                                                'raw_satu' => $inputVal1,
                                                                                                'raw_dua' => $inputVal2,
                                                                                                'val_nol' => $inputMap0,
                                                                                                'val_satu' => $inputMap1,
                                                                                                'val_dua' => $inputMap2,
                                                                                                'min' => $inputMin,
                                                                                                'max' => $inputMax
                                                                                            ]);
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
                    'message' => 'Gagal ditambahkan !'
                    // 'message' => $e
                ];
            }
        }else {
            $response = [
                'code' => 300,
                'message' => 'Harap pilih Node !'
            ];
        }

        return response()->json($response);
    }

    function deleteMapSettingDatatable(Request $req) {
        $idNodeDecode = (!is_null($req->_id)) ? base64_decode($req->_id) : NULL;

        $delete = DB::table('value_map')->where('id_node', $idNodeDecode)->delete();

        $response = [];

        if ($delete) {
            $response = [
                'code' => 200,
                'message' => 'Berhasil dihapus !'
            ];
        }else {
            $response = [
                'code' => 300,
                'message' => 'Gagal hapus !'
            ];
        }

        return response()->json($response);        
    }

    function chipDatatable(Request $req) {
        $idPerusahaanDecode = (!is_null($req->_id)) ? base64_decode($req->_id) : NULL;

        $chip = DB::table('chip as a')
                    ->leftJoin('kebun as b', 'b.id', '=', 'a.id_kebun')
                    ->leftJoin('tipe as c', 'c.id', '=', 'a.id_tipe')
                    ->where('a.flag', '!=', 9)
                    ->where('b.id_perusahaan', '=', $idPerusahaanDecode)
                    ->select('a.*',
                                'b.nama as nama_kebun',
                                    'c.nama as nama_tipe')
                    ->get();
        
        return Datatables::of($chip)
        ->addIndexColumn()
        ->editColumn('flag', function ($chip) {
            return $chip->flag;
        })
        ->addColumn('opsi', function ($chip) {
            $idEncode = "'".base64_encode($chip->id)."'";
            $namaChip = "'".$chip->chip."'";
            $idKebun = $chip->id_kebun;
            $namaKebun = "'".$chip->nama_kebun."'";
            $idTipe = $chip->id_tipe;
            $keterangan = "'".$chip->keterangan."'";
            $versi = $chip->versi;
            $build = $chip->build;

            $buttonEdit = '<button type="button" class="btn btn-sm btn-primary btn-flat" onclick="setChip('.$idEncode.', '.$namaChip.', '.$idKebun.', '.$namaKebun.', '.$idTipe.', '.$keterangan.', '.$versi.', '.$build.')"><i class="fas fa-edit"></i></button>';
            $buttonDelete = '<button type="button" class="btn btn-sm btn-danger btn-flat" onclick="deleteChip('.$idEncode.')"><i class="fas fa-trash"></i></button>';
            return $buttonEdit.'&nbsp'.$buttonDelete;
        })
        ->rawColumns(['opsi'])
        ->make(true);
    }

    function chipAdd(Request $req) {
        $idChip = base64_decode($req->idChip);
        $inputIdKebun = $req->inputIdKebun;
        $inputNamaChip = $req->inputNamaChip;
        $inputIdTipe = $req->inputIdTipe;
        $inputVersi = $req->inputVersi;
        $inputBuild = $req->inputBuild;
        $inputKeteranganChip = $req->inputKeteranganChip;

        if ( $inputNamaChip ) {
            $inputData = [
                            'id_kebun' => $inputIdKebun,
                            'chip' => $inputNamaChip,
                            'id_tipe' => $inputIdTipe,
                            'keterangan' => $inputKeteranganChip,
                            'versi' => $inputVersi,
                            'build' => $inputBuild,
                            'flag' => 0,
                        ];
            
            $chip = DB::table('chip')->where('id', $idChip)->first();

            DB::beginTransaction();
            try {
                if ( is_null($chip) ) {
                    $save = DB::table('chip')->insert($inputData);
                }else {
                    $save = DB::table('chip')->where('id', $idChip)->update($inputData);
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
                    'message' => 'Gagal ditambahkan !'
                    // 'message' => $e
                ];
            }
        }else {
            $response = [
                'code' => 300,
                'message' => 'Harap lengkapi data !'
            ];
        }

        return response()->json($response);
    }

    function chipDelete(Request $req) {
        $idChipDecode = (!is_null($req->_id)) ? base64_decode($req->_id) : NULL;

        $delete = DB::table('chip')->where('id', $idChipDecode)->update(['flag' => 9]);

        $response = [];

        if ($delete) {
            $response = [
                'code' => 200,
                'message' => 'Berhasil dihapus !'
            ];
        }else {
            $response = [
                'code' => 300,
                'message' => 'Gagal hapus !'
            ];
        }

        return response()->json($response);   
    }

}
