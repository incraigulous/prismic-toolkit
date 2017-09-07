<?php
Route::middleware(['verifyPrismicWebhook'])
    ->namespace('Incraigulous\PrismicToolkit\Controllers')
    ->prefix('hooks')
    ->group(function () {
        Route::post('prismic', 'PrismicCacheController@queueSync');
});