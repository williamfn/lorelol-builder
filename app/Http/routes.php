<?php

Route::get('/', function () {
    return \TwigBridge\Facade\Twig::render(
        'index',
        ['regions' => \Illuminate\Support\Facades\Lang::get('system.language_names', [], 'br')]
    );
});

Route::get('/updateallchampions/{region}', 'DataFetchController@populateAllChampionsNewVersion');
Route::get('/specialevents/{region}', 'DataFetchController@readSpecialEvents');

Route::get('/createchampionpages/{region}', 'PageBuilderController@createChampionPages');
Route::get('/createhomepages/{region}', 'PageBuilderController@createHomePages');

Route::get('/template/{champId}/{region}', 'PageBuilderController@template');
