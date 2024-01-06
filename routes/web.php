<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('filament.dashboard.auth.login');
});

Route::get('/download', function() {
    $path = storage_path() . '/app/cfdis.xlsx';
    $dir = storage_path() . '/app/livewire-tmp';

    if (file_exists($path)) {
        File::deleteDirectory($dir);

        return response()->download($path);
    } else {
        echo "<h1 style='text-align:center;margin-top: 45vh;'>No se ha generado un excel  <br> 😞</h1>";
    }
})->name('download');
