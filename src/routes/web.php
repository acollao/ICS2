<?php

use App\Http\Controllers\AddonsController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('pages.home.index');
// })->middleware('auth');

// Route::get('/home', function () {
//     return view('pages.home.index');
// })->middleware(['auth', 'verified'])->name('home');

// home/dashboard 
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home.index');

// user management
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/editUser/{id}', [UserController::class, 'editUser'])->name('user.editUser');
Route::get('/user/add', [UserController::class, 'add'])->name('user.add');
Route::post('/user/create', [UserController::class, 'store'])->name('user.store');
Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::post('/user/delete/', [UserController::class, 'delete'])->name('user.delete');

// records management

Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/search/export', [SearchController::class, 'export'])->name('search.export');
Route::post('/search/editjobname', [SearchController::class, 'editjobname'])->name('search.editjobname');
Route::post('/search/searchjobname', [SearchController::class, 'searchjobname'])->name('search.searchjobname');
Route::get('/search/searchjobname', [SearchController::class, 'searchjobname'])->name('search.searchjobname');

Route::middleware(['roles:admin,aic'])->group(function () {
    Route::post('/search/update', [SearchController::class, 'update'])->name('search.update');
    Route::get('/search/edit', [SearchController::class, 'edit'])->name('search.edit');
    Route::post('/search/deletejobnameById', [SearchController::class, 'deletejobnameById'])->name('search.deletejobnameById');
    Route::post('/search/deletejobname', [SearchController::class, 'deletejobname'])->name('search.deletejobname');
});

// Route::middleware(['roles:admin,aic'])->group(function () {
//     Route::post('/search/deletejobnameById', [SearchController::class, 'deletejobnameById'])->name('search.deletejobnameById');
//     Route::post('/search/deletejobname', [SearchController::class, 'deletejobname'])->name('search.deletejobname');
// });



// add data
Route::get('/add/data', [DataController::class, 'index'])->name('data.index');
Route::post('/add/showBoxfilename', [DataController::class, 'showBoxfilename'])->name('data.showBoxfilename');
Route::get('/add/dataEntry', [DataController::class, 'dataEntry'])->name('data.dataEntry');

Route::get('/upload/template', [AddonsController::class, 'index'])->name('addons.index');
Route::get('/get-template', [AddonsController::class, 'getTemplate'])->name('addons.get-template');
Route::post('/create-template', [AddonsController::class, 'createTemplate'])->name('addons.create-template');
Route::get('/donwload-template', [AddonsController::class, 'exportTemplate'])->name('addons.donwload-template');
Route::get('/downloadFile', [AddonsController::class, 'downloadFile'])->name('addons.downloadFile');
Route::post('/upload-template', [AddonsController::class, 'upload'])->name('addons.upload-template');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test', [TestController::class, 'test']);
Route::get('/items', [TestController::class, 'index']);
Route::get('/items/fetch', [TestController::class, 'fetch']);

require __DIR__ . '/auth.php';
