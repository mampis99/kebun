<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class DashboardController extends Controller
{
    public function index()
    {
        $getSessionIdPerusahaan = Session::get('idPerusahaan');
        $queryPerusahaan = DB::table('perusahaan');
        
        if ($getSessionIdPerusahaan != 1) {
            $queryPerusahaan->where('id', $getSessionIdPerusahaan);
        } 
        
        $resultPerusahaan = $queryPerusahaan->get();

        $data = [
            'perusahaan' => $resultPerusahaan,
            // 'tglNow' => date('d/m/Y').' - '.date('d/m/Y')
        ];

        return view('dashboard.index')->with($data);

    }

    function apiKebun(Request $req) 
    {
        $kebun = DB::table('kebun')->where('id_perusahaan', $req->_id)->get();
        return response()->json($kebun);
    }

    public function tes()
    {
        $arr = [1, 3, 5, 7, 8, 10];

        // return $this->mode($arr, 'median');

        $sensorLog = DB::table('sensor_logger')->get();

        return $sensorLog;
    }

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
