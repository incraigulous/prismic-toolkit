<?php
Route::namespace('Incraigulous\PrismicToolkit\Controllers')
    ->prefix('prismic')
    ->group(function () {
        Route::any('sync', 'PrismicCacheController@sync');
        Route::any('flush', 'PrismicCacheController@flush');
        Route::any('queue', 'PrismicCacheController@queue');
    });