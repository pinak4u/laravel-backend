<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SanctumController extends Controller
{
    //
    public function login(Request $request)
    {
        $password = $request->input('password');
        $email = $request->input('email');
        $user = User::where('email',$email)->first();
        $checkedPassword = Hash::check($password,$user->password);
        if(!$user || !$checkedPassword){
            throw ValidationException::withMessages([
                'email' => 'Provided Credentials are invalid'
            ]);
        }
        return $user->createToken($request->input('email'))->plainTextToken;

    }
}
