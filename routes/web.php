<?php

use App\Http\Controllers\AdminPedidosController;
use App\Http\Controllers\CategoriasProductosController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClientesCitasController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProfesionalCitasController;
use App\Http\Controllers\ProfesionalProfesionController;
use App\Http\Controllers\ProfesionalServiciosController;
use App\Http\Controllers\ProfesionesController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\TrabajadoresController;
use App\Http\Controllers\CarritoController;
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

//---- FRONENT CLIENTE ----
Route::get('/', [FrontController::class, 'index'])
    ->name('home');
// Route::get('/', function () {
//     return view('clientes/template'); // Vista para clientes
// })

//Historial de Pedidos
Route::get('/historial/{id}', [FrontController::class, 'historialPedidos'])->name('historial.index');
//FIN - Historial de Pedidos

Route::get('clientes/citas/index', [ClientesCitasController::class, 'index'])->name('clientes.citas.index');
Route::get('clientes/citas/agendar', [ClientesCitasController::class, 'create'])->name('clientes.citas.create');
Route::get('clientes/citas/getProfesionales', [ClientesCitasController::class, 'getProfesionales'])->name('clientes.citas.getProfesionales');
Route::get('clientes/citas/getDisponibilidad', [ClientesCitasController::class, 'getDisponibilidad'])->name('clientes.citas.getDisponibilidad');
Route::post('clientes/citas/store', [ClientesCitasController::class, 'store'])->name('clientes.citas.store');

// carrito
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregarProducto'])->name('carrito.agregar');
Route::get('/carrito/ver', [CarritoController::class, 'verCarrito'])->name('carrito.ver');
Route::post('/carrito/actualizar/{productoId}', [CarritoController::class, 'actualizarCantidad'])->name('carrito.actualizar');
Route::post('/carrito/eliminar/{id}', [CarritoController::class, 'eliminarProducto'])->name('carrito.eliminar');
Route::post('/carrito/confirmar/{id}', [CarritoController::class, 'confirmarPedido'])->name('carrito.confirmar');

//---- FIN FRONENT CLIENTE ----
Auth::routes();

Route::get('/dashboard', [CitaController::class, 'index'])->middleware('role:1')->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('admin.citas.index'); // Cambia a la vista correspondiente
// })->middleware('role:1')->name('dashboard');

//ADMIN 
//PEDIDOS
Route::get('/dashboard/admin/pendientes', [AdminPedidosController::class, 'index'])->middleware('role:1')->name('dashboard.admin.pendientes');
Route::post('/dashboard/admin/entregar/{id}', [AdminPedidosController::class, 'entregar'])->middleware('role:1')->name('dashboard.admin.entregar');
Route::get('/dashboard/admin/entregados', [AdminPedidosController::class, 'entregados'])->middleware('role:1')->name('dashboard.admin.entregados');
Route::get('/dashboard/admin/carritos', [AdminPedidosController::class, 'carritos'])->middleware('role:1')->name('dashboard.admin.carritos');

//FIN-PEDIDOS

//----PROFESION----
Route::get('/dashboard/admin/profesiones', [ProfesionesController::class, 'index'])->middleware('role:1')->name('dashboard.admin.profesiones');
Route::post('/dashboard/admin/profesiones/guardar', [ProfesionesController::class, 'store'])->middleware('role:1')->name('dashboard.admin.profesiones.guardar');
Route::put('/dashboard/admin/profesiones/actualizar/{id}', [ProfesionesController::class, 'update'])->middleware('role:1')->name('dashboard.admin.profesiones.actualizar');
Route::delete('/dashboard/admin/profesiones/{id}', [ProfesionesController::class, 'destroy'])->name('dashboard.admin.profesiones.eliminar');
//----FIN PROFESION----

//----PROFESIONALES----
Route::get('/dashboard/admin/profesionales', [TrabajadoresController::class, 'index'])->middleware('role:1')->name('dashboard.admin.profesionales');
Route::get('/dashboard/admin/profesionales/create', [TrabajadoresController::class, 'create'])->middleware('role:1')->name('dashboard.admin.profesionales.create');
Route::post('/dashboard/admin/profesionales/store', [TrabajadoresController::class, 'store'])->middleware('role:1')->name('dashboard.admin.profesionales.store');
Route::get('/dashboard/admin/profesionales/edit/{id}', [TrabajadoresController::class, 'edit'])->middleware('role:1')->name('dashboard.admin.profesionales.edit');
Route::put('/dashboard/admin/profesionales/update/{id}', [TrabajadoresController::class, 'update'])->middleware('role:1')->name('dashboard.admin.profesionales.update');
Route::delete('/dashboard/admin/profesionales/delete/{id}', [TrabajadoresController::class, 'destroy'])->name('dashboard.admin.profesionales.delete');
//----FIN PROFESIONALES----

//----PROFESION-PROFESIONAL----
Route::get('/dashboard/profesion/profesional/{id}', [ProfesionalProfesionController::class, 'index'])->middleware('role:1')->name('dashboard.profesion.profesional');
Route::post('/dashboard/profesion/profesional/store', [ProfesionalProfesionController::class, 'store'])->middleware('role:1')->name('dashboard.profesion.profesional.store');
Route::delete('/dashboard/profesion/profesional/destroy/{id}', [ProfesionalProfesionController::class, 'destroy'])->middleware('role:1')->name('dashboard.admin.profesiones.destroy');
//----FIN PROFESION-PROFESIONAL----

//----SERVICIOS----
Route::get('/dashboard/admin/servicios', [ServiciosController::class, 'index'])->middleware('role:1')->name('dashboard.admin.servicios');
Route::get('/dashboard/admin/servicios/create', [ServiciosController::class, 'create'])->middleware('role:1')->name('dashboard.admin.servicios.create');
Route::post('/dashboard/admin/servicios/store', [ServiciosController::class, 'store'])->middleware('role:1')->name('dashboard.admin.servicios.store');
Route::get('/dashboard/admin/servicios/edit/{id}', [ServiciosController::class, 'edit'])->middleware('role:1')->name('dashboard.admin.servicios.edit');
Route::put('/dashboard/admin/servicios/update/{id}', [ServiciosController::class, 'update'])->middleware('role:1')->name('dashboard.admin.servicios.update');
Route::delete('/dashboard/admin/servicios/destroy/{id}', [ServiciosController::class, 'destroy'])->middleware('role:1')->name('dashboard.admin.servicios.destroy');
//----FIN SERVICIOS----

//----SERVICIOS-PROFESIONAL----
Route::get('/dashboard/servicios/profesional/{id}', [ProfesionalServiciosController::class, 'index'])->middleware('role:1')->name('dashboard.profesion.servicios');
Route::post('/dashboard/servicios/profesional/store', [ProfesionalServiciosController::class, 'store'])->middleware('role:1')->name('dashboard.profesion.servicios.store');
Route::delete('/dashboard/servicios/profesional/destroy/{id}', [ProfesionalServiciosController::class, 'destroy'])->middleware('role:1')->name('dashboard.profesion.servicios.destroy');
//----FIN SERVICIOS-PROFESIONAL----

//----CITAS----
// Route::resource('citas', CitaController::class);
Route::get('citas', [CitaController::class, 'index'])->name('citas.index');
Route::get('citas/canceldas', [CitaController::class, 'canceladas'])->name('citas.canceladas');
Route::get('citas/create', [CitaController::class, 'create'])->name('citas.create');
Route::get('citas/realizadas', [CitaController::class, 'realizadas'])->name('citas.realizadas');
Route::post('citas/store', [CitaController::class, 'store'])->name('citas.store');
Route::post('citas', [CitaController::class, 'confirmar'])->name('citas.confirmar');
Route::delete('/citas/{id}', [CitaController::class, 'destroy'])->name('citas.destroy');



//----PROFUCTOS----
Route::get('/dashboard/admin/productos', [ProductosController::class, 'index'])->middleware('role:1')->name('dashboard.admin.productos');
Route::get('/dashboard/admin/productos/create', [ProductosController::class, 'create'])->middleware('role:1')->name('dashboard.admin.productos.create');
Route::post('/dashboard/admin/productos/store', [ProductosController::class, 'store'])->middleware('role:1')->name('dashboard.admin.productos.store');
Route::get('/dashboard/admin/productos/edit/{id}', [ProductosController::class, 'edit'])->middleware('role:1')->name('dashboard.admin.productos.edit');
Route::put('/dashboard/admin/productos/update/{id}', [ProductosController::class, 'update'])->middleware('role:1')->name('dashboard.admin.productos.update');
Route::delete('/dashboard/admin/productos/destroy/{id}', [ProductosController::class, 'destroy'])->middleware('role:1')->name('dashboard.admin.productos.destroy');
Route::put('/dashboard/admin/productos/status/{id}', [ProductosController::class, 'status'])->middleware('role:1')->name('dashboard.admin.productos.status');

//----FIN PROFUCTOS----

//----CAREGORIAS----
Route::get('/dashboard/admin/categorias', [CategoriasProductosController::class, 'index'])->middleware('role:1')->name('dashboard.admin.categorias');
Route::get('/dashboard/admin/categorias/create', [CategoriasProductosController::class, 'create'])->middleware('role:1')->name('dashboard.admin.categorias.create');
Route::post('/dashboard/admin/categorias/store', [CategoriasProductosController::class, 'store'])->middleware('role:1')->name('dashboard.admin.categorias.store');
Route::get('/dashboard/admin/categorias/edit/{id}', [CategoriasProductosController::class, 'edit'])->middleware('role:1')->name('dashboard.admin.categorias.edit');
Route::put('/dashboard/admin/categorias/update/{id}', [CategoriasProductosController::class, 'update'])->middleware('role:1')->name('dashboard.admin.categorias.update');
Route::delete('/dashboard/admin/categorias/destroy/{id}', [CategoriasProductosController::class, 'destroy'])->middleware('role:1')->name('dashboard.admin.categorias.destroy');
//----FIN CAREGORIAS----


//FIN ADMIN


//RUTAS DEL PROFESIONAL
Route::get('/profesional', [ProfesionalCitasController::class, 'index'])->middleware('role:2')->name('profesional.dashboard');
Route::get('/profesional/create', [ProfesionalCitasController::class, 'create'])->middleware('role:2')->name('profesional.create');
Route::post('/profesional/store', [ProfesionalCitasController::class, 'store'])->middleware('role:2')->name('profesional.store');
Route::post('/profesional/citas', [ProfesionalCitasController::class, 'confirmar'])->middleware('role:2')->name('profesional.citas');
Route::get('/profesional/canceldas', [ProfesionalCitasController::class, 'canceladas'])->middleware('role:2')->name('profesional.canceldas');
Route::put('/profesional/realizada/{id}', [ProfesionalCitasController::class, 'marcarComoRealizada'])->middleware('role:2')->name('profesional.marcarComoRealizada');
Route::delete('/profesional/citas/{id}', [ProfesionalCitasController::class, 'destroy'])->middleware('role:2')->name('profesional.destroy');
Route::get('/profesional/realizadas', [ProfesionalCitasController::class, 'realizadas'])->middleware('role:2')->name('profesional.realizadas');
Route::get('/profesional/{cita}/edit', [ProfesionalCitasController::class, 'edit'])->middleware('role:2')->name('profesional.edit');
Route::put('/profesional/{cita}', [ProfesionalCitasController::class, 'update'])->middleware('role:2')->name('profesional.update');




//FUN RUTAS PROFESIONAL