<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\TrafficControlPanel;
use App\Livewire\OperatorPanel;

Route::get('/', TrafficControlPanel::class)->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/operator', OperatorPanel::class)->middleware(['auth', 'verified'])->name('operator');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
