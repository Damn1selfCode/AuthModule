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
    Route::delete('/profile/deactivate/{user}', 'App\Http\Controllers\ProfileController@deactivate')->name('profile.deactivate');
});


Route::post('/suscription/suscribirse', 'App\Http\Controllers\SubscriptionController@suscribirse')->name('suscription.suscribirse');
Route::post('/suscription/desuscribirse', 'App\Http\Controllers\SubscriptionController@desuscribirse')->name('suscription.desuscribirse');

require __DIR__ . '/auth.php';
require __DIR__ . '/academia.php';


Route::get('/usuarios', function () {
    $plans = app(WelcomeController::class)->planes();
    $user = auth()->user(); // Obtener el usuario autenticado
    $suscripcion = ($user->suscripcion === null) ? 0 : $user->suscripcion->suscripcion;
    $user->code = hash('sha256', $user->email);
    return view('usuarios', compact('user', 'plans', 'suscripcion'));
})->middleware('verified')
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

//material de promocion
Route::get('/material', function () {
    return view('promocion');
});

//soporte

Route::get('/soporte', function () {
    return view('soporte');
});
Route::get('/soporte', 'App\Http\Controllers\SoporteController@index');
Route::post('/soporte', 'App\Http\Controllers\SoporteController@store')->name('soporte.store');


// Auth::routes(['verify' => true]); ERROR MALDITO

// Route::resource('/crud', [CrudController::class]);
// Route::get('/xxx', [XController::class]); //solo si tienes un metodo para no especificar
