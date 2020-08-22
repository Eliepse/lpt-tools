<?php

namespace App\Http\Middleware;

use Closure;

class SessionLanguageMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 *
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// We first check if we have a parameter that force the locale
		if (in_array($locale = substr($request->get("locale"), 0, 2), config("app.available_locales"))) {
			session()->put("locale", $locale);
			app()->setLocale($locale);
			return $next($request);
		}

		// If locale has not been forced, we simply check if we have it in the session
		if (in_array($locale = substr(session("locale"), 0, 2), config("app.available_locales"))) {
			app()->setLocale($locale);
			return $next($request);
		}

		// If locale not in session, we decide according to client's preffered language according headers
		app()->setLocale($request->getPreferredLanguage(config("app.available_locales")));
		return $next($request);
	}
}
