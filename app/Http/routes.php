<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Update
Route::get('/updateallchampions/{region}', 'DataFetchController@populateAllChampionsNewVersion');
Route::get('/specialevents/{region}', 'DataFetchController@readSpecialEvents');

Route::get('/template/{champId}/{region}', 'PageBuilderController@template');

Route::get('/createchampionpages/{region}', 'PageBuilderController@createChampionPages');

Route::get('/{region?}', function($region = false) {

    if (!$region) {
        $region = 'na';
    }

    App::setLocale($region);

    return \TwigBridge\Facade\Twig::render('home', ['region' => $region]);
});
