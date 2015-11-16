<?php namespace App\Http\Middleware;

use Closure;

use BrowserDetect;

class UserMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$user = $request->user();
		if (!\DB::table('sessions')->where('sessionId', \Session::getId())->first())
		{
			\Auth::logout();
			return redirect()->guest('auth/login');
		}
		if ($user && $user->role == 'USER')
		{
			return $next($request);
		}
		else if ($user && $user->role == 'ADMIN')
		{
			return $next($request);
		}

		return redirect('/');
	}

}
