<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\front\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::with('traderIds','transactions','level','withdrawals')->get();
        //dd($users);
        return view('admin.users.index',compact('users'));
    }
}
