<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

function verificarUsuarioLogado($request)
{
    if(Auth::user()->status == false){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/login');
    }
}
