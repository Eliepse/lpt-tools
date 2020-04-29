<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Cache;

final class FetchCachedChineseListsController
{
	public function __invoke()
	{
		return response()->json(Cache::get("list.chinese", []));
	}
}