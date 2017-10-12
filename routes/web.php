<?php
Route::namespace('Incraigulous\PrismicToolkit\Controllers')
    ->prefix('prismic')
    ->group(function () {
        Route::any('sync', 'CacheController@sync');
        Route::any('flush', 'CacheController@flush');
        Route::any('queue', 'CacheController@queue');
        Route::get('download/{token}', 'DownloadController@show')
            ->name('prismic-download');
        Route::get('download/{token}/{expireToken}', 'DownloadController@temporary')
            ->name('prismic-temporary-download');
    });