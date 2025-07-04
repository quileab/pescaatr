<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

// Define the login route

// Users will be redirected to this route if not logged in
Volt::route('/login', 'login')->name('login');
//Volt::route('/register', 'register'); 

Volt::route('/inscriptions', 'inscriptions.create');

// Define the logout
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
});

Route::get('/cache', function () {
    return Cache::flush();
    //return redirect('/');
});

Route::get('/clear', function () {
    $logs = [];
    $maintenance = [
        'DebugBar' => 'debugbar:clear',
        'Storage Link' => 'storage:link',
        'Optimize Clear' => 'optimize:clear',
        'Config Cache' => 'config:cache',
        'Config Clear' => 'config:clear',
        'Route Clear' => 'route:clear',
        'Cache' => 'cache:clear',
        'View' => 'view:clear',
        'Event' => 'event:clear',
        'Optimize' => 'optimize',
    ];
    foreach ($maintenance as $key => $value) {
        try {
            Artisan::call($value);
            $logs[$key] = '✔️';
        } catch (\Exception $e) {
            $logs[$key] = '❌' . $e->getMessage();
        }
    }
    return "<pre>" . print_r($logs, true) . "</pre><hr />";
    //    return var_dump($maintenance,true);
    //.Artisan::output();
});

Route::get('/artisan/{command}', function ($command) {
    return Artisan::call($command);
});

Route::get('/test_mail_welcome/{id}', function ($id) {
    Illuminate\Support\Facades\Mail::send(new App\Mail\Welcome($id));
    //return redirect('/');
});

// Route to reportTeamsFish in ReportsController
Route::get('/reportTeamsFish', [App\Http\Controllers\ReportsController::class, 'reportTeamsFish']);
// Route to reportTeamsHP embarcations in ReportsController
Route::get('/reportTeamsHP', [App\Http\Controllers\ReportsController::class, 'reportTeamsHP']);
// Route to reportTeamsDebts in ReportsController
Route::get('/reportTeamsDebts', [App\Http\Controllers\ReportsController::class, 'reportTeamsDebts']);


// Protected routes here
Route::middleware('auth')->group(function () {
    Volt::route('/', 'home');
    Volt::route('/teams', 'teamsList');
    Volt::route('/team/{id}/players', 'teamPlayers');
    Volt::route('/team/{id}/payments', 'paymentsmanage');
    Volt::route('/player/{id}/edit', 'playerEdit');
    Volt::route('/species', 'speciesList');
    Volt::route('/species/{id}/edit', 'speciesEdit');
    Volt::route('/debts', 'teamsDebts');
    Volt::route('/captures', 'captures');
    Volt::route('/users', 'users.index');
    Volt::route('/users/create', 'users.create');
    Volt::route('/users/{user}/edit', 'users.edit');
});
