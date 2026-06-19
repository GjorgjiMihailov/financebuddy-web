<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('under-construction');
});

// TODO: откачи ги по завршување на редизајнот
// Route::get('/', function () {
//     return Inertia::render('Home');
// });
