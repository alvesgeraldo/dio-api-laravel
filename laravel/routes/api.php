<?php

use App\Http\Controllers\HelloController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('hello/{name}', function ($name) {
  return 'Hello - '. $name;
});

Route::get('produtos', [ProductController::class, 'buscarTodosProdutos'])->name('produtos.index');
Route::get('produtos/{id}', [ProductController::class, 'buscarProduto'])->name('produtos.show');
Route::post('produtos', [ProductController::class, 'criarProduto'])->name('produtos.create');
Route::put('produtos/{id}', [ProductController::class, 'atualizarProduto'])->name('produtos.update');
Route::delete('produtos/{id}', [ProductController::class, 'deletarProduto'])->name('produtos.delete');

Route::fallback(function () {
    return response()->json(["error" => "Rota não encontrada"], 404);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
