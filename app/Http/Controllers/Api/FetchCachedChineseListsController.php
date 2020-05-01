<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

/**
 * Class FetchCachedChineseListsController
 *
 * @package App\Http\Controllers\Api
 */
final class FetchCachedChineseListsController
{
	/**
	 * Fetch the previously generated lists of words form the cache and return them.
	 *
	 * @return JsonResponse
	 */
	public function __invoke(): JsonResponse
	{
		return response()->json(Cache::get("exercice.previous-lists", []));
	}
}