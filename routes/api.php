<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\PlacementController;
use App\Http\Controllers\Api\PurchaseController;

Route::resource('clients', ClientController::class);

Route::resource('items', ItemController::class);

Route::apiResource('placements', PlacementController::class);

Route::apiResource('purchases', PurchaseController::class);