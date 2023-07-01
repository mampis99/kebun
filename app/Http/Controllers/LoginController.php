<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use DB;
use Hash;
use Session;
// use Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function postLogin(Request $req)
    {
        $email = $req->inputEmail;
        $password = $req->inputPassword;
        // dd(Hash::make($password));

        $users = DB::table('users as a')
                    ->where('a.email', $email)
                    ->where('a.flag_active', 1)
                    ->leftJoin('users_level as b', 'b.id', '=', 'a.id_level')
                    ->leftJoin('perusahaan as c', 'c.id', '=', 'a.id_perusahaan')
                    ->select('a.id', 'a.id_level', 'a.id_perusahaan', 'a.username', 'a.email', 'a.fullname', 'a.pwd', 'a.flag_active',
                                'b.nama as user_level',
                                    'c.nama as nama_perusahaan')
                    ->first();


        if ( $users && Hash::check($password, $users->pwd)) {

            Session::put('email',$email);
            Session::put('username',$users->username);
            Session::put('password',$password);
            Session::put('fullname',$users->fullname);
            Session::put('idLevel',$users->id_level);
            Session::put('userLevel',$users->user_level);
            Session::put('idPerusahaan',$users->id_perusahaan);
            Session::put('namaPerusahaan',$users->nama_perusahaan);

            return redirect()->route('dashboard');
        }else {
            Session::flush();

            return redirect()->route('login');
        }
    }

    public function logout()
    {
        Session::flush();
        // Auth::logout();
        return redirect()->route('login');
    }

    public function authGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $auth = Socialite::driver('google')->stateless()->user();
        $email = $auth->email;

        $users = DB::table('users as a')
                    ->where('a.email', $email)
                    ->where('a.flag_active', 1)
                    ->leftJoin('users_level as b', 'b.id', '=', 'a.id_level')
                    ->leftJoin('perusahaan as c', 'c.id', '=', 'a.id_perusahaan')
                    ->select('a.id', 'a.id_level', 'a.id_perusahaan', 'a.username', 'a.email', 'a.fullname', 'a.pwd', 'a.flag_active',
                                'b.nama as user_level',
                                    'c.nama as nama_perusahaan')
                    ->first();

        if ( $auth && $users ) {
            Session::put('email',$email);
            Session::put('username',$users->username);
            // Session::put('password',$password);
            Session::put('fullname',$users->fullname);
            Session::put('idLevel',$users->id_level);
            Session::put('userLevel',$users->user_level);
            Session::put('idPerusahaan',$users->id_perusahaan);
            Session::put('namaPerusahaan',$users->nama_perusahaan);

            return redirect()->route('dashboard');
        }else {
            Session::flush();

            return redirect()->route('login');
        }
    }
}
