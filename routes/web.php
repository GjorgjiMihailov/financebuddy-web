<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('under-construction');
});

// TODO: активирај кога ќе се лансира сајтот
// Route::get('/', function () {
//     return Inertia::render('Home');
// });

Route::get('/za-nas', function () {
    return Inertia::render('ZaNas');
});

Route::get('/uslugi', function () {
    return Inertia::render('Uslugi');
});
