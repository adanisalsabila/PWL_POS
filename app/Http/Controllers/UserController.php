<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(){

        // $data = [
        //     'nama' => 'Pelanggan Pertama',
        // ];
        // UserModel::where('username','customer-1')->update($data);
        
        // $user = UserModel::all();
        // return view('user',['data' => $user]);
        
        // $data = [
        //     'username' => 'customer-1',
        //     'nama' => 'Pelanggan',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 4
        // ];
        // UserModel::insert($data);
// $data = ['nama' => 'Pelanggan Pertama', ];

// $data =[
//     'level_id' => 2,
//     'username' => 'manager_tiga',
//     'nama' => 'Manager 3',
//     'password' => Hash::make('12345')
// ];
// UserModel::create($data);

// UserModel::where('username', 'customer-1') -> update($data);
        // $user = UserModel::where('username', 'manager9')->firstOrFail();
        // $user = UserModel::where('level_id')->count();
        // dd($user);
        $totalUsers = UserModel::count();
        $users = UserModel::all();
        return view('user',['totalUsers' => $totalUsers, 'users' => $users]);
    }
}