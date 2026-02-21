<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscribeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/subscribe/plans', [SubscribeController::class, 'showplans'])->name('subscribe.plans');
