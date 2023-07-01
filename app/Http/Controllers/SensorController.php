<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SensorController extends Controller
{
    public function log(Request $req)
    {
        $idPerusahaan = $req->_idPerusahaan;
        $idKebun =$req->_idKebun;
        $tgl = !is_null($req->_tgl) ? explode(' - ', $req->_tgl) : NULL;

        $tglSatu = NULL;
        $tglDua = NULL;

        if ( !is_null($tgl) ) {
            $tglSatu = date('Y-m-d', strtotime($tgl[0]));
            $tglDua = date('Y-m-d', strtotime($tgl[1]));
        }

        // dd($tglSatu, $tglDua);
        $sensorLog = DB::table('sensor_logger as a')
                        ->leftJoin('node as b', 'b.id', '=', 'a.id_node')
                        ->leftJoin('chip as c', 'c.id', '=', 'b.id_chip')
                        ->leftJoin('kebun as d', 'd.id', '=', 'c.id_kebun')
                        ->leftJoin('perusahaan as e', 'e.id', '=', 'd.id_perusahaan')
                        ->where('e.id' ,'like', '%'.$idPerusahaan.'%')
                        ->where('d.id', 'like', '%'.$idKebun.'%')
                        ->whereBetween('a.create', [$tglSatu.' 00:00:00', $tglDua.' 23:59:59'])
                        ->select('a.*', 
                                    'b.nama as nama_node', 'b.keterangan as keterangan_node',
                                        'c.chip', 'c.keterangan as keterangan_chip',
                                            'd.id as id_kebun','d.nama as nama_kebun', 'd.keterangan as keterangan_kebun',
                                                'e.id as id_perusahaan', 'e.nama as nama_perusahaan'
                                )
                        ->get();

        $groupByKebunSensorLog = collect($sensorLog)
                                    ->groupBy('id_kebun')
                                    ->map(function ($val) {
                                        $select = $val->first();
                                        $id_kebun = (!empty($select)) ? $select->id_kebun : '';
                                        $nama_kebun = (!empty($select)) ? $select->nama_kebun : '';
                                        $keterangan_kebun = (!empty($select)) ? $select->keterangan_kebun : '';
                                        $id_perusahaan = (!empty($select)) ? $select->id_perusahaan : '';
                                        $nama_perusahaan = (!empty($select)) ? $select->nama_perusahaan : '';
                                        return (object)[
                                            'id_kebun' => $id_kebun,
                                            'nama' => $nama_kebun,
                                            'keterangan_kebun' => $keterangan_kebun,
                                            'id_perusahaan' => $id_perusahaan,
                                            'nama_perusahaan' => $nama_perusahaan,
                                            'data' => $val->where('id_kebun', $id_kebun)
                                                            ->groupBy('id_node')
                                                            ->map(function ($val) {
                                                                $select = $val->first();
                                                                $id_node = (!empty($select)) ? $select->id_node : '';
                                                                $nama_node = (!empty($select)) ? $select->nama_node : '';
                                                                
                                                                $keterangan_node = (!empty($select)) ? $select->keterangan_node : '';
                                                                $chip = (!empty($select)) ? $select->chip : '';
                                                                $keterangan_chip = (!empty($select)) ? $select->keterangan_chip : '';

                                                                return (object)[
                                                                    'id_node' => $id_node,
                                                                    'nama_node' => $nama_node,
                                                                    'keterangan_node' => $keterangan_node,
                                                                    'chip' => $chip,
                                                                    'keterangan_chip' =>$keterangan_chip,
                                                                    'nilai' => $val->max('nilai'),
                                                                    'data' => $val->where('id_node', $id_node)
                                                                                ->map(function ($val) {
                                                                                  return (object)[
                                                                                        'id_node' => $val->id_node,
                                                                                        'tgl' => $val->create,
                                                                                        'waktu' => date('H:i', strtotime($val->create)),
                                                                                        'nilai' => $val->nilai
                                                                                    ];  
                                                                                })
                                                                ];
                                                            })
                                        ];
                                    })->values();

        // return $sensorLog;
        return $groupByKebunSensorLog;
        // dd($groupByKebunSensorLog);
    }   
    // public function index()
    // {
    //     return view('dashboard.index');
    // }

    // public function tes()
    // {
    //     $arr = [1, 3, 5, 7, 8, 10];

    //     // return $this->mode($arr, 'median');

    //     $sensorLog = DB::table('sensor_logger')->get();

    //     return $sensorLog;
    // }

    public function mode($array, $output)
    {
        switch($output){ 
            case 'mean': 
                $count = count($array); 
                $sum = array_sum($array); 
                $total = $sum / $count; 
            break; 
            case 'median': 
                rsort($array); 
                $middle = round(count($array) / 2); 
                $total = $array[$middle-1]; 
            break; 
            case 'mode': 
                $v = array_count_values($array); 
                arsort($v); 
                foreach($v as $k => $v){$total = $k; break;} 
            break; 
            case 'range': 
                sort($array); 
                $sml = $array[0]; 
                rsort($array); 
                $lrg = $array[0]; 
                $total = $lrg - $sml; 
            break; 
        } 

        return $total;
    }
}
