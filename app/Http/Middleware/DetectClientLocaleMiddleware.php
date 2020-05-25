<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DetectClientLocaleMiddleware
{
	/**
	 * @param Request $request
	 * @param Closure $next
	 *
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next)
	{
		$accepted_language = mb_split("[,;]", $request->server('HTTP_ACCEPT_LANGUAGE'));
		$accepted_locales = array_filter($accepted_language, fn($val) => mb_strstr($val, "q=") === false);
		$available_locales = config('app.available_locales', []);

		foreach ($accepted_locales as $locale) {
			$locale = mb_substr($locale, 0, 2);
			if (in_array($locale, $available_locales)) {
				App::setLocale($locale);
				break;
			}
		}

		return $next($request);
	}
}
