<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        //comprueba que el usuario sea Administrador
        if (\Auth::user()->id_tb_tipo_empleados == 1)
        {
            return $next($request);
        }
        //usuarios no admitidos son redireccionados a la vista home
        return redirect()->guest('/home');
    }
}
