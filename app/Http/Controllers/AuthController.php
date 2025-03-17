<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Método para mostrar o formulário de registro
    public function showRegisterForm()
    {

        if (Auth::check()) {
            return view('auth.register'); 
        }

        return redirect()->route('login'); 
    }
}
