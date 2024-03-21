<?php

use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Route;


Route::view('{any}', 'welcome')->where('any','.*')->name('any');
