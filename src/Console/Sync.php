<?php

namespace Incraigulous\PrismicToolkit\Console;

use Incraigulous\PrismicToolkit\Endpoint;
use \Exception;
use Incraigulous\PrismicToolkit\LaravelTaggedCacher;
use Illuminate\Console\Command;
use Incraigulous\PrismicToolkit\Models\PrismicEndpoint;
use Incraigulous\PrismicToolkit\Facades\Prismic;

/**
 * Lookup all the prismic endpoints that have been called, and call them.
 * Calling them will utilize Prismic's auto caching feature to precache all prismic calls.
 *
 * Class Sync
 * @package Incraigulous\PrismicToolkit\Console
 */
class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prismic:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch previously called Prismic data and cache it.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Get the cacher implantation from the prismic SDK.
        $cache = Prismic::getCache();

        //Get all the endpoints the app has called from mysql
        $endpoints = PrismicEndpoint::all();

        // Clear the cache
        $cache->flush();

        //Loop through the endpoints and call them so SDK will cache them.
        foreach ($endpoints as $endpoint) {
            $this->info('Caching ' . $endpoint->endpoint);
            try {
                Prismic::submit(new Endpoint($endpoint->endpoint));
                $this->info($endpoint->endpoint . ' cached.');
            } catch (Exception $ex) {
                //A request failed. We'll assume the endpoint is no longer valid and delete it.
                $this->error("Request failed: " . $endpoint->endpoint);
                $this->error($ex->getMessage());
                $this->info('Deleting stored endpoint.');
                $endpoint->delete();
                $this->info('Endpoint deleted.');
            }
        }

        $this->info('Content Synced');
    }
}
