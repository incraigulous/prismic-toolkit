<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 9/7/17
 * Time: 10:43 AM
 */

namespace Incraigulous\PrismicToolkit\Controllers;


use Illuminate\Queue\Jobs\Job;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Jobs\SyncPrismic;
use Carbon\Carbon;

class PrismicCacheController extends Controller
{
    public function sync()
    {
        Artisan::call('prismic:sync');
        return Artisan::output();
    }

    public function queue()
    {
        Prismic::getCache()->set('sync-queued', true, config('prismic.syncDelay'));
        SyncPrismic::dispatch()->onQueue(config('prismic.queueDriver'))->delay(
            Carbon::now()->addMinutes(config('prismic.syncDelay'))
        );
        return ['success' => 'true'];
    }

    public function flush()
    {
        Prismic::getCache()->clear();
        return ['success' => 'true'];
    }
}