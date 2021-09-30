<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAccessPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
		$controlArray = explode("\\",$request->route()->action['controller']);
		$module = strtoupper($controlArray[4]);
		$hakses = json_decode(auth('api')->user()->hak_akses, true);
		if (!$hakses) {
			return $next($request);
		}
		$method = $request->method();
		if (str_contains('delete',$request->route()->uri)) {
			$method = 'delete';
		}
		// return $hakses;
		$nal['Access Denied']='Anda tidak bisa mengakses fungsi ini';
		if (array_key_exists(strtoupper($module), $hakses)) {
			if ($hakses[strtoupper($module)][strtolower($method)]) {
				return $next($request);
			}
			return response()->json($nal, 400);
		}
		return response()->json($nal, 400);
    }
}
