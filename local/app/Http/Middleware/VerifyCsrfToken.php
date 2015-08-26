<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

use BrowserDetect;

class VerifyCsrfToken extends BaseVerifier {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// security one
		if(BrowserDetect::isMobile() || BrowserDetect::isTablet())
		{
			// security two
			if(BrowserDetect::osFamily() == "AndroidOS")
			{
				return $next($request);
			}
		}


		return parent::handle($request, $next);
	}

}
