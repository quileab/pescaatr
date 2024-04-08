<?php
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Users will be redirected to this route if not logged in
Volt::route('/login', 'login')->name('login');
//Volt::route('/register', 'register'); 

Volt::route('/inscriptions', 'inscriptions.create');

// Define the logout
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
 
    return redirect('/');
});

Route::get('/clear', function () {
    $logs = [];
    $maintenance=[
        //'DebugBar'=>'debugbar:clear',
        //'Storage Link'=>'storage:link',
        'Config'=>'config:clear',
        'Optimize Clear'=>'optimize:clear',
        'Optimize'=>'optimize',
        'Route Clear'=>'route:clear',
        'Cache'=>'cache:clear',
    ];
    foreach ($maintenance as $key => $value) {
        try {
            Artisan::call($value);
            $logs[$key]='✔️';
        } catch (\Exception $e) {
            $logs[$key]='❌';
        }
    }
    return "<pre>".print_r($logs,true)."</pre><hr />";
    //.Artisan::output();
});

// Protected routes here
Route::middleware('auth')->group(function () {
    Volt::route('/', 'home');
    Volt::route('/teams', 'teamsList');
    Volt::route('/users', 'users.index');
    Volt::route('/users/create', 'users.create');
    Volt::route('/users/{user}/edit', 'users.edit');
});