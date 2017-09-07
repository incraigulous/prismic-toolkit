<?php
Route::namespace('Incraigulous\PrismicToolkit\Controllers')
    ->prefix('prismic')
    ->group(function () {
        Route::get('sync', 'PrismicCacheController@sync');
        Route::get('flush', 'PrismicCacheController@flush');
        Route::get('queue', 'PrismicCacheController@queue');
    });