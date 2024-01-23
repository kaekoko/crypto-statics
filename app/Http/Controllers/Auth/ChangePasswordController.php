<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends Controller
{
    public function edit()
    {
        

        return view('auth.passwords.edit');
    }

    public function update(Request $request)
    {

        $id = auth()->user()->id;
        $password= $request->password ? Hash::make($request->password) : $old_password;

            $user = User::findOrFail($id);
         
            $user->password = $password;

            $user->update();


        return redirect()->route('passwordedit')->with('message', __('Change Password success'));
    }
}