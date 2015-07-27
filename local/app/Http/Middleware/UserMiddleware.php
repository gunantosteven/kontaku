<?php namespace App\Http\Middleware;

use Closure;

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
		if ($user && $user->role == 'USER')
		{
			return $next($request);
		}
		else if ($user && $user->role -= 'ADMIN')
		{
			return redirect('admin/home');
		}

		return redirect('/');
	}

}
