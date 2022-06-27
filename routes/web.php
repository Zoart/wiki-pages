<?php

use App\Http\Controllers\GetArticleController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WordSearchController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [GetArticleController::class, 'index']);

Route::post('/wiki-pages', [GetArticleController::class, 'findPage'])->name('wiki-pages');

Route::get('/result', [GetArticleController::class, 'get_wiki_page']);

Route::post('/word_search_process', [WordSearchController::class, 'word_search_process'])->name('word_search');

Route::get('/word_search', [WordSearchController::class, 'get_word_search_page']);
