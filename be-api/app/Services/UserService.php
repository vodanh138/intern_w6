<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\product_table;

class UserService
{
    public function RegisterUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:Users',
            'password' => 'required',
            'email' => 'required|email|unique:Users',
        ]);

        $user = new User();
        $user->oriname = $request->username;
        $user->username = md5($request->username);
        $user->password = bcrypt($request->input('password'));
        $user->email = $request->email;
        $user->save();
        return $user;
    }

    public function RegisterAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:Users',
            'password' => 'required',
            'email' => 'required|email|unique:Users',
        ]);

        $user = new User();
        $user->oriname = $request->username;
        $user->username = md5($request->username);
        $user->password = bcrypt($request->input('password'));
        $user->email = $request->email;
        $user->admin = true;
        $user->save();
        return $user;
    }
}