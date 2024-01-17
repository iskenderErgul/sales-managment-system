<?php

use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Route;



//Route::any('/{any}', function () {
//    return redirect('/login');
//})->where('any', '.*')->where('any', '^(?!login).*$');

Route::get('/sys',function (){
   return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
