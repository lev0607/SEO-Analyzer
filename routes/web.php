<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'DomainController@create')->name('domains.create');

Route::get('/domains', 'DomainController@index')->name('domains.index');

Route::get('/domains/{id}', 'DomainController@show')->name('domains.show');

Route::post('/', 'DomainController@store')->name('domains.store');

Route::post('/domains/{id}', 'DomainCheckController@store')->name('domain_checks.store');
