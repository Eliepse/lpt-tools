<?php

use App\Http\Controllers\Api\FetchCachedChineseListsController;
use Illuminate\Support\Facades\Route;

Route::get('/lists/chinese', FetchCachedChineseListsController::class);
