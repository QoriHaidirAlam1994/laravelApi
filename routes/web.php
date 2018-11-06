<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () {
    return view('uploadfile');
});

$app->group(['prefix' => 'api'], function () use ($app) {

    $app->post('register','MemberUserController@create');

    $app->post('authorize','MemberUserController@auth');

    $app->post('accesstoken','MemberUserController@accesstoken');

    $app->post('refresh','MemberUserController@refresh');

    $app->get('me','MemberUserController@me');

    $app->get('logout','MemberUserController@logout');

    $app->put('users/{id}','MemberUserController@update');

    $app->get('users/{id}','MemberUserController@view');

    $app->delete('users/{id}','MemberUserController@deleteRecord');

    $app->get('users','MemberUserController@index');
     
    $app->get('logbonus', 'LogBonusController@index');
    $app->get('logbonus/{id}', 'LogBonusController@show');
    //$app->get('logbonus/testing/{member_id}/{tgl_bonus}', 'LogBonusController@showmember');
    $app->get('logbonus/testing/{tanggal}', 'LogBonusController@showmember');
    //$app->post('logbonus', 'LogBonusController@store');
    $app->post('logbonus/testing', 'LogBonusController@store');
    $app->put('logbonus/{id}', 'LogBonusController@update');
    $app->delete('logbonus/{id}', 'LogBonusController@delete');

    $app->get('member', 'MemberController@index');
    $app->get('member/{id}', 'MemberController@show');
    $app->post('member', 'MemberController@store');
    $app->post('member/updatephoto', 'MemberController@updatephoto');
    $app->put('member/{id}', 'MemberController@update');
    $app->delete('member/{id}', 'MemberController@delete');

    $app->get('membertree', 'MemberTreeController@index');
    $app->get('membertree/{id}', 'MemberTreeController@show');
    $app->get('membertree/testing', 'MemberTreeController@showmember');
    $app->post('membertree', 'MemberTreeController@store');
    $app->put('membertree/{id}', 'MemberTreeController@update');
    $app->delete('membertree/{id}', 'MemberTreeController@delete');
    });

    // Route::redirect('/', 'file/index');

    // Route::get('file/upload', 'FileController@form')->name('file.form');
    // Route::get('file/index', 'FileController@index')->name('file.index');
    // Route::post('file/upload', 'FileController@upload')->name('file.upload');
    // Route::get('file/{file}/download', 'FileController@download')->name('file.download');
    // Route::get('file/{file}/response', 'FileController@response')->name('file.response');

    // // multiple upload
    // Route::get('file/multiple/upload', 'MultipleFileController@form')->name('multiple.form');
    // Route::post('file/multiple/upload', 'MultipleFileController@upload')->name('multiple.upload');

    // Auth::routes();

    // Route::get('/home', 'HomeController@index')->name('home');