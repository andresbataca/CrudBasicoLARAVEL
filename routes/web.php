<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

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

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/empleado', function () {
//     return view('empleado.index');
// });

/*acceder mediante el uso de clases, esta clase estara controlada en nuestro controlador 
empleado conntroller usando sus metodos */

/*cuando escribamos la ruta /empleado/create, nos llevar al metodo create */

// Route::get('/empleado/create',[EmpleadoController::class,'create']);

/*para acceder a todas las rutas de los metodos de forma automarizada usamos el resource */

/* al colocar el ->middleware('auth') respetara la autentificacion para poder ingresar al
index de empleado, solo si esta logeado podra acceder a este */

Route::resource('empleado', EmpleadoController::class)->middleware('auth');

/*aqui al autentificador le quito opciones que no se usaran */
Auth::routes(['register'=>false,'reset'=>false]);

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');


/*aqui lo que hacemos es autenticar que si el usuario se logeo, pueda ingresar a
al metodo index de la clase EmpleadoController */

Route::group(['middleware'=>'auth'], function () {

    Route::get('/', [EmpleadoController::class, 'index'])->name('home');
});

