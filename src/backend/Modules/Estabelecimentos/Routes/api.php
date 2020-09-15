<?php

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('/cadastrarnovoestabelecimento', 'EstabelecimentosController@store');
    Route::get('/listarestabelecimentos', 'EstabelecimentosController@show');
    Route::put('/atualizarestabelecimento', 'EstabelecimentosController@edit');
    Route::delete('/deletarestabelecimento', 'EstabelecimentosController@delete');

    Route::get('/listsearchestabelecimento', 'EstabelecimentosController@searchPorLocale');
});
