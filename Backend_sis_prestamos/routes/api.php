<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\usersController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\clienteController;
use App\Http\Controllers\Api\contratoController;
use App\Http\Controllers\Api\PrendaController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//rutas publicas
Route::post('/login', [LoginController::class, 'login']); // loguear

//rutas protegidas
Route::prefix('users')->group(function(){
    Route::middleware(['auth:sanctum','checkAdmin'])->group(function () {
        // Rutas protegidas para usuarios autenticados con token y rol "Admin"
        Route::get('/', [usersController::class, 'obtener']);
        Route::post('/', [usersController::class, 'createUser']);
        Route::get('/{id}', [usersController::class, 'buscarUsuario']);
        Route::put('/{id}', [usersController::class, 'edit']);
        Route::delete('/{id}', [usersController::class, 'delete']);
        Route::post('/users/asignarUnRol/{id}/{Role}', [usersController::class, 'asignarRol']);

        //Route::post('/logout', [loginController::class, 'logout']);
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [loginController::class, 'logout']);
    });
});

Route::prefix('cliente')->group(function(){
    Route::get('/', [clienteController::class, 'obtenerCliente']); //obtener
    Route::post('/', [clienteController::class, 'createCliente']); // insertar
    Route::put('/{CI}', [clienteController::class, 'editCliente']); // actualizar
    Route::delete('/{CI}', [clienteController::class, 'deleteCliente']); // eliminar
    Route::get('/{CI}', [clienteController::class, 'obtenerClienteCI']); //obtener
});

Route::prefix('contrato')->group(function(){
    Route::get('/', [contratoController::class, 'obtenerContrato']); //obtener
    Route::post('/', [contratoController::class, 'createContrato']); // insertar
    Route::put('/{contrato_id}', [contratoController::class, 'editContrato']); // actualizar
    Route::delete('/{contrato_id}', [contratoController::class, 'deleteContrato']); // eliminar
    Route::get('/{contrato_id}', [contratoController::class, 'obtenerContratoid']); //obtener
});

Route::prefix('prenda')->group(function(){
    Route::get('/', [PrendaController::class, 'obtenerPrenda']); //obtener
    Route::post('/', [PrendaController::class, 'createPrenda']); // insertar
    Route::put('/{prenda_id}', [PrendaController::class, 'editPrenda']); // actualizar
    Route::delete('/{prenda_id}', [PrendaController::class, 'deletePrenda']); // eliminar
    Route::get('/{prenda_id}', [PrendaController::class, 'obtenerPrendaid']); //obtener
});
/* --------------------------------Roles---------------------------------------------
Route::prefix('roles')->group(function(){
    Route::get('/', [rolesController::class, 'obtener']); //obtener
    Route::post('/', [rolesController::class, 'createRol']); // insertar
    Route::put('/{id}', [rolesController::class, 'edit']); // actualizar
    Route::delete('/{id}', [rolesController::class, 'delete']); // eliminar
});*/

/* --------------------------------Usuarios---------------------------------------------
Route::prefix('users')->group(function(){
    Route::get('/', [usersController::class, 'obtener']); //obtener
    Route::post('/', [usersController::class, 'createUser']); // insertar
    Route::get('/{id}', [usersController::class, 'buscarUsuario']); //obtener por id
    Route::put('/{id}', [usersController::class, 'edit']); // actualizar
    //Route::put('/gerente/{id}', [usersController::class, 'editGerente']); // actualizar gerente
    Route::delete('/{id}', [usersController::class, 'delete']); // eliminar
    Route::post('/logout', [usersController::class, 'logout']); // cerrar sesión
});

Route::post('/login', [usersController::class, 'login']); // loguear*/
