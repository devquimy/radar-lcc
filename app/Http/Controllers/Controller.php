<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;

abstract class Controller  extends BaseController
{
    public function __construct()
    {        
        $this->middleware(function ($request, $next) {
            if(Auth::check() && Auth::user()->status == false){
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();
        
                return redirect('/login');
            }

            return $next($request);
        });
    }
}
