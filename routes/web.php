<?php

use App\Http\Controllers\AcademyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SoporteController;
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


Route::post('/suscription/suscribirse', 'App\Http\Controllers\SubscriptionController@suscribirse')->name('suscription.suscribirse');
Route::post('/suscription/desuscribirse', 'App\Http\Controllers\SubscriptionController@desuscribirse')->name('suscription.desuscribirse');


require __DIR__ . '/auth.php';
require __DIR__ . '/academia.php';


Route::get('/usuarios', function () {
    $plans = app(WelcomeController::class)->planes();
    $user = auth()->user(); // Obtener el usuario autenticado
    $suscripcion = ($user->suscripcion === null) ? 0 : $user->suscripcion->suscripcion;
    $codRef = ($user->CodRef === null) ? null : $user->CodRef;
    $user->code = hash('sha256', $user->email);
    //DD($user);
    return view('usuarios', compact('user', 'plans', 'suscripcion', 'codRef'));
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

// Ruta para mostrar el formulario de soporte
//Route::get('/soporte', 'App\Http\Controllers\SoporteController@showSoporteForm')->name('soporte');
Route::get('/soporte', 'App\Http\Controllers\SoporteController@showSoporteForm')->name('soporte');

// Ruta para procesar el formulario de soporte
Route::post('/soporte', 'App\Http\Controllers\SoporteController@store')->name('soporte.store');
Route::get('/soporte/recibidos', [SoporteController::class, 'recibidos'])->name('soporte.recibidos');
Route::get('/soporte/enviados', [SoporteController::class, 'enviados'])->name('soporte.enviados');
Route::get('/soporte/papelera', [SoporteController::class, 'papelera'])->name('soporte.papelera');
//NUEVO
Route::get('/soporte/lectura-ticket/{id}/{origen?}', 'App\Http\Controllers\SoporteController@lecturaTicket')->name('soporte.lectura-ticket');
Route::post('/soporte/lectura-ticket/{id}', 'App\Http\Controllers\SoporteController@lecturaTicket');
Route::post('/soporte/enviar-a-papelera', 'App\Http\Controllers\SoporteController@enviarAPapelera')->name('soporte.enviar-a-papelera');
Route::post('/soporte/recuperar-de-papelera', 'App\Http\Controllers\SoporteController@recuperarDePapelera')->name('soporte.recuperar-de-papelera');

