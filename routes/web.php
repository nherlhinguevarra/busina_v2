<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/pending_applications', function () {
    return view('pending_applications');
})->name('pending_applications');

Route::get('/registered_vehicles', function () {
    return view('registed_vehicles');
})->name('registered_vehicles');

Route::get('/reported_violations', function () {
    return view('reported_violations');
})->name('reported_violations');

Route::get('/all_users', function () {
    return view('all_users');
})->name('all_users');

Route::get('/guidelines', function () {
    return view('guidelines');
})->name('guidelines');





