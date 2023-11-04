<?php

use App\Http\Controllers\AcademyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
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



Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::get('/usuarios', function () {
    $user = auth()->user();
    return view('usuarios', compact('user'));
})
    ->middleware('verified')
    ->name('usuarios');

Route::get('/home', [AcademyController::class, 'mostrarAcademia'])
    ->middleware(['verified'])
    ->name('home');

Route::get('/academy/{ruta_categoria}', [AcademyController::class, 'mostrarCategorias'])
    ->middleware(['verified'])
    ->name('academy');


Route::get('/plan', function () {
    return view('plan');
})->middleware(['verified'])
    ->name('plan');


// Auth::routes(['verify' => true]); ERROR MALDITO

// Route::resource('/crud', [CrudController::class]);
// Route::get('/xxx', [XController::class]); //solo si tienes un metodo para no especificar
