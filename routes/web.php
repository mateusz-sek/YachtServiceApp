<?php

use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShipsController;
use App\Http\Controllers\RepairsController;


Route::get('/', [HomeController::class, 'home']);
Route::get('/searchNameClientsJson', [HomeController::class, 'searchNameClientsJson']);
Route::get('/searchNameCityJson', [HomeController::class, 'searchNameCityJson']);

Route::post('/clients/searchClients', [HomeController::class, 'searchClients']);
Route::get('/clients/create', [HomeController::class, 'create']);
Route::post('/clients/store', [HomeController::class, 'store']);
Route::get('/clients/edit/{id}', [HomeController::class, 'edit']);
Route::post('/clients/update/{id}', [HomeController::class, 'update']);
Route::get('/clients/destroy/{id}', [HomeController::class, 'destroy']);

//----------------------
//STATKI
Route::get('/ships', [ShipsController::class, 'index']);
Route::get('/ships/create/{id}', [ShipsController::class, 'create']);

Route::post('/ships/store', [ShipsController::class, 'store']);
Route::get('/ships/edit/{id}', [ShipsController::class, 'edit']);
Route::post('/ships/update/{id}', [ShipsController::class, 'update']);
Route::get('/ships/destroy/{id}', [ShipsController::class, 'destroy']);

// WYSZUKIWANIE STATKU (GET zamiast POST, żeby paginacja działała)
Route::get('/ships/searchShip', [ShipsController::class, 'searchShip']);

// AUTOUZUPELNIANIE NAZWY STATKU
Route::get('/ships/autocompleteNameShip', [ShipsController::class, 'autocompleteNameShip']);

// AUTOUZUPELNIANIE NAZWY CLIENTA
Route::get('/ships/autocompleteClientsShip', [ShipsController::class, 'autocompleteClientsShip']);


// POKAZYWANIE STATKOW UZYTKOWNIKA
Route::get('/ships/clients/{id}', [ShipsController::class, 'show']);






Route::get('/repairs', [RepairsController::class, 'index']);
Route::get('/repairs/showByShip/{id}', [RepairsController::class, 'showByShip']);
Route::get('/repairs/create/{id}', [RepairsController::class, 'create']);
Route::get('/repairs/showByUser/{id}', [RepairsController::class, 'showByUser']);




Route::get('/repairs/changeStatus/{id}/{column}', [RepairsController::class, 'changeStatus']);
Route::post('/repairs/store/{id}', [RepairsController::class, 'store']);
Route::get('/repairs/payments', [RepairsController::class, 'payments']);
Route::get('/repairs/autocompleteNameRepairs', [RepairsController::class, 'autocompleteNameRepairs']);
Route::get('/repairs/autocompleteNameShipRepairs', [RepairsController::class, 'autocompleteNameShipRepairs']);
Route::get('/repairs/searchRepair', [RepairsController::class, 'searchRepair']);
Route::get('/repairs/changeStatusPayment/{id}', [RepairsController::class, 'changeStatusPayment']);
Route::get('/repairs/edit/{id}', [RepairsController::class, 'edit']);
Route::post('/repairs/update/{id}', [RepairsController::class, 'update']);
Route::get('/repairs/destroy/{id}', [RepairsController::class, 'destroy']);
Route::get('/repairs/show/{id}', [RepairsController::class, 'show']);



Route::get('/repairs/history', [HistoryController::class, 'index']);
Route::get('/repairs/history/autocompleteNameRepairsHistory', [HistoryController::class, 'autocompleteNameRepairsHistory']);
Route::get('/repairs/history/autocompleteNameShipRepairsHistory', [HistoryController::class, 'autocompleteNameShipRepairsHistory']);
Route::get('/repairs/history/searchRepairHistory', [HistoryController::class, 'searchRepairHistory']);


Route::get('/dashboard', [HistoryController::class, 'dashboard'])->name('dashboard');;





