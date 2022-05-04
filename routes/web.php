<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProdutoController;


//Route::post('/cliente/search', [ClienteController::class,'search']);
//ROTAS DAS REQUISIÇÕES showall

Route::get('/',[ClienteController::class, 'showall']); //REQUISIÇÃO INICIAL
Route::get('/produto/showall', [ProdutoController::class, 'showAll']); //Mostrar todos os produtos

/**
 * create -> MÉTODO/ACTION PADRÃO PARA INSERIR OS DADOS NO BANCO
 */
Route::get('/cliente/create', [ClienteController::class, 'create']);
Route::get('/produto/create', [ProdutoController::class, 'create']);

/**
 * store -> MÉTODO/ACTION PADRÃO PARA ADICIONAR OS DADOS NO BANCO
 */
Route::post('cliente/', [ClienteController::class, 'store']);
Route::post('produto/', [ProdutoController::class, 'store']);

/**
 * show -> MÉTODO/ACTION PADRÃO PARA EXIBIR OS DADOS DAS TABELAS
 */
Route::get('/cliente/{id}', [ClienteController::class, 'show']);
Route::get('/produto/{id}', [ProdutoController::class, 'show']); //Monstrar produto por id

/**
 * delete -> MÉTODO/ACTION PADRÃO PARA DELETAR OS DADOS DAS TABELAS
 */
Route::delete('/cliente/{id}', [ClienteController::class, 'destroy']);
Route::delete('/produto/{id}', [ProdutoController::class, 'destroy']); //Delete Produto


/**
 * update -> MÉTODO/ACTION PADRÃO PARA ATUALIZAR OS DADOS DAS TABELAS
 */
Route::put('/produto/update/{id}', [ProdutoController::class, 'update']);
Route::put('/cliente/{id}/update', [ClienteController::class, 'update']);

Route::get('/cliente/{id}/edit', [ClienteController::class, 'edit']);
Route::get('/produto/edit/{id}', [ProdutoController::class, 'edit']);
