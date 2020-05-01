<?php

use App\Http\Controllers\Api\FetchCachedChineseListsController;
use App\Http\Controllers\Api\PrepareGridCNController;
use Illuminate\Support\Facades\Route;

Route::get('/lists/chinese', FetchCachedChineseListsController::class);
Route::post('/grid/chinese', PrepareGridCNController::class);
