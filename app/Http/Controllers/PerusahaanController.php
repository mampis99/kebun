<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Exception;
use DB;

class PerusahaanController extends Controller
{
    public function index()
    {
        return view('perusahaan.index');
    }

    public function add(Request $req)
    {
        $response = [];

        $nama = $req->nama;
        $singkatan = $req->singkatan;
        $dirut = $req->dirut;
        $alamat = $req->alamat;
        $kota = $req->kota;
        $telp = $req->telp;
        // $status = $req->status;

        if ( $nama && $dirut && $alamat ) {
            $inputData = [
                            'nama' => $nama,
                            'singkatan' => $singkatan,
                            'dirut' => $dirut,
                            'alamat' => $alamat,
                            'kota' => $kota,
                            'telp' => $telp,
                            'flag' => 1
                        ];
            DB::beginTransaction();
            try {
                $save = DB::table('perusahaan')->insert($inputData);
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

    public function datatable()
    {
        $perusahaan = DB::table('perusahaan')->get();

        return Datatables::of($perusahaan)
        ->addIndexColumn()
        ->addColumn('opsi', function ($perusahaan) {
            $idEncode = base64_encode($perusahaan->id);
            $url = route('perusahaan-form-edit', [$idEncode]);

            $buttonEdit = '<a href="'.$url.'" class="btn btn-sm btn-primary btn-flat"><i class="fas fa-edit"></i></a>';
            $buttonDelete = '<button class="btn btn-sm btn-danger btn-flat"><i class="fas fa-trash"></i></button>';
            return $buttonEdit.'&nbsp'.$buttonDelete;
        })
        ->rawColumns(['opsi'])
        ->make(true);
    }

    public function formEdit($id)
    {
        $idDecode = base64_decode($id);
        $perusahaan = DB::table('perusahaan')
                        ->where('id', $idDecode)
                        ->first();

        $tipe = DB::table('tipe')->get();

        $data['perusahaan'] = [
            'id' => $id,
            'nama' => (!is_null($perusahaan)) ? $perusahaan->nama : NULL,
            'singkatan' => (!is_null($perusahaan)) ? $perusahaan->singkatan : NULL,
            'alamat' => (!is_null($perusahaan)) ? $perusahaan->alamat : NULL,
            'telp' => (!is_null($perusahaan)) ? $perusahaan->telp : NULL,
            'dirut' => (!is_null($perusahaan)) ? $perusahaan->dirut : NULL,
            'kota' => (!is_null($perusahaan)) ? $perusahaan->kota : NULL,
            'flag' => (!is_null($perusahaan)) ? $perusahaan->flag : NULL,
            'tipe' => $tipe
        ];

        return view('perusahaan.form-edit')->with($data);
    }

    public function update(Request $req)
    {
        $response = [];

        $idDecode = base64_decode($req->_id);
        $nama = $req->nama;
        $singkatan = $req->singkatan;
        $dirut = $req->dirut;
        $alamat = $req->alamat;
        $kota = $req->kota;
        $telp = $req->telp;
        $status = (!$req->status) ? 0 : 1;

        if ( $nama && $dirut && $alamat ) {
            $inputData = [
                            'nama' => $nama,
                            'singkatan' => $singkatan,
                            'dirut' => $dirut,
                            'alamat' => $alamat,
                            'kota' => $kota,
                            'telp' => $telp,
                            'flag' => $status
                        ];
            DB::beginTransaction();
            try {
                $save = DB::table('perusahaan')
                            ->where('id', $idDecode)
                            ->update($inputData);

                DB::commit();
                $response = [
                    'code' => 200,
                    'message' => 'Berhasil dirubah'
                ];
            } catch (Exception $e) {
                DB::rollback();
                $response = [
                    'code' => 400,
                    'message' => 'Gagal dirubah !'
                    // 'message' => $e
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
}
