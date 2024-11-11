<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use App\Http\Controllers\roadtripecontroler;

use App\Models\Categorie;
use App\Models\Creation;
Route::get('/', function () {
    return view('home', ['creations' => Creation::all()]);
})->name('home');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::get('/admin', function () {
    return view('admin.admin');
})->name('admin');
Route::get('/mescreations', function () {
    return view('mescreations', ['categories' => Categorie::all(), 'creations' => Creation::all()]);
})->name('mescreations');
Route::get('/filter-creations', [adminController::class, 'filterCreations']);

Route::get('/creation/{id}', function ($id) {
    return view('creation', ['creation' => Creation::find($id)]);
})->name('creation');
Route::get('/roadtrip', function () {
    return view('roadtrip');
})->name('roadtrip');

Route::post('/admin.login', [adminController::class, 'login'])->name('login');
Route::post('/admin.updateSite', [adminController::class, 'updateSite'])->name('updateSite');
Route::post('/admin.addCreation', [adminController::class, 'addCreation'])->name('addCreation');
Route::post('/admin.editCreation/{id}', [adminController::class, 'editCreation'])->name('editCreation');
Route::post('/admin.categorie.add', [adminController::class, 'addCategorie'])->name('addCategorie');
Route::post('/admin.categorie.update', [adminController::class, 'updateCategorie'])->name('updateCategorie');
Route::post('/admin.subcategorie.add', [adminController::class, 'addSubCategorie'])->name('addSubCategorie');
Route::post('/admin.subcategorie.update', [adminController::class, 'updateSubCategorie'])->name('updateSubCategorie');

Route::post('/admin.roadtrip', [roadtripecontroler::class, 'createRoadTrip'])->name('createroadtrip');
Route::post('/admin.roadtrip.update/{id}', [roadtripecontroler::class, 'updateRoadTrip'])->name('updateRoadTrip');
Route::post('/upload-image', [roadtripecontroler::class, 'uploadImage'])->name('ckeditor.upload');

use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;

Route::post('/contact', [adminController::class, 'sendContact'])->name('contact.send');
