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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$app->group(['prefix' => 'api'], function () use ($app) {

$app->get('logbonus', 'LogBonusController@index');
$app->get('logbonus/{id}', 'LogBonusController@show');
//$app->get('logbonus/testing/{member_id}/{tgl_bonus}', 'LogBonusController@showmember');
$app->get('logbonus/testing/{member_id}/{tanggal}', 'LogBonusController@showmember');
$app->post('logbonus', 'LogBonusController@store');
$app->put('logbonus/{id}', 'LogBonusController@update');
$app->delete('logbonus/{id}', 'LogBonusController@delete');

$app->get('member', 'MemberController@index');
$app->get('member/{id}', 'MemberController@show');
$app->post('member', 'MemberController@store');
$app->put('member/{id}', 'MemberController@update');
$app->delete('member/{id}', 'MemberController@delete');

$app->get('membertree', 'MemberTreeController@index');
$app->get('membertree/{id}', 'MemberTreeController@show');
$app->get('membertree/testing/{member_id}', 'MemberTreeController@showmember');
$app->post('membertree', 'MemberTreeController@store');
$app->put('membertree/{id}', 'MemberTreeController@update');
$app->delete('membertree/{id}', 'MemberTreeController@delete');
});