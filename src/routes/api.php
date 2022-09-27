<?php

use Package\ScenariotestSampleApplication\ScenarioSample\Adaptor\RunnSampleController;
use Package\SomeSpecificApplication\CreateApp\Adaptor\CreateAppControllerInterface;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('sample', CreateAppControllerInterface::class)->name('sample');

Route::post('runn', RunnSampleController::class)->name('runn');
