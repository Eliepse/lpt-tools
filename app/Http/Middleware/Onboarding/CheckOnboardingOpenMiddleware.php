<?php

namespace App\Http\Middleware\Onboarding;

use Closure;
use Illuminate\Support\Facades\Cache;

class CheckOnboardingOpenMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @param string $type
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next, string $type)
	{
		if (! Cache::get("registration.statut:$type", false)) {
			return response(view("onboarding.closed"))->setStatusCode(503);
		}

		return $next($request);
	}
}
