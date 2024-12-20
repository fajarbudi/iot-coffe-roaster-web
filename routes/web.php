<?php

use App\Http\Controllers\page;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\sensor;

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

Route::get('/', [page::class, 'home'])->name("home");

Route::get('/tugas/{id}', [page::class, 'tugas'])->name("tugas");

Route::get('/listTugas', [page::class, 'listTugas'])->name("listTugas");

Route::get('/hasilTugas/{id}', [page::class, 'hasilTugas'])->name("hasilTugas");

Route::post('/addTugas', [page::class, 'addTugas'])->name("addTugas");

Route::post('/dellTugas/{id}', [page::class, 'dellTugas'])->name("dellTugas");

Route::put('/setting/{id}', [page::class, 'setting'])->name('setting');

Route::get('/sensor_json', [sensor::class, 'sensor_json'])->name('sensor_json');

Route::get('/getData', [sensor::class, 'getData']);

Route::post('/sensor', [sensor::class, 'data']);

Route::post('/project', [page::class, 'project'])->name('project');
