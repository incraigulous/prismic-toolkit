<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 9/7/17
 * Time: 10:43 AM
 */

namespace Incraigulous\PrismicToolkit\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Jobs\SyncPrismic;
use Carbon\Carbon;

class CacheController extends Controller
{
    public function sync()
    {
        Artisan::call('prismic:sync');
        return Artisan::output();
    }

    public function queue()
    {
        $cacheKey = 'prismic:sync:queued';

        if (!Prismic::getCache()->has($cacheKey)) {
            Prismic::getCache()->set($cacheKey, true, config('prismic.syncDelay'));
            SyncPrismic::dispatch()->onQueue(config('prismic.queueDriver'))->delay(
                Carbon::now()->addMinutes(config('prismic.syncDelay'))
            );
        }

        return ['success' => 'true'];
    }

    public function flush()
    {
        Prismic::getCache()->clear();
        return ['success' => 'true'];
    }
}