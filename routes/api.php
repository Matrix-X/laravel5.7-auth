<?php

use Illuminate\Http\Request;

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

$_OPEN_API_DOMAIN = env('APP_OPEN_API_URL');
$_WHITE_LIST_DOMAIN = env('APP_WHITE_LIST_URL');

$_methodAll = ['options', 'get', 'post', 'put', 'delete'];
$_methodGet = ['options', 'get'];
$_methodPost = ['options', 'post'];
$_methodPut = ['options', 'put'];
$_methodDelete = ['options', 'delete'];

$_namespaceAPI = 'API';




/** Rou **/
Route::match($_methodAll, 'router/', "{$_namespaceAPI}\\RouterAPIController@index");












Route::group(/**
 *
 */
    [
        'namespace' => $_namespaceAPI,
        'domain' => $_WHITE_LIST_DOMAIN,
//	'middleware' => []
    ], function () use ($_methodGet, $_methodPost, $_methodPut, $_methodDelete) {

    Route::match($_methodPost, 'test', 'APIController@apiTest')->name('test');
});


