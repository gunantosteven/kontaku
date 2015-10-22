<?php namespace App\Http\Middleware;

use Closure;
use View;

class AdminMiddleware {

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
		if ($user && $user->role == 'ADMIN')
		{
			return $next($request);
		}
		else if ($user && $user->role == 'USER')
		{
			return View::make('errors.404');
		}

		return redirect('/');
	}

}
