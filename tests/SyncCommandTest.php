<?php

namespace Incraigulous\PrismicToolkit\Tests;

use Illuminate\Support\Facades\Artisan;
use Incraigulous\PrismicToolkit\Cachers\LaravelTaggedCacher;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Models\PrismicEndpoint;

/**
 * @group sync
 *
 * Class SyncCommandTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class SyncCommandTest extends TestCase
{

    /**
     * @test
     */
    public function it_caches_endpoints()
    {
        Prismic::getByUID('single', 'test-single');
        $endpoint = PrismicEndpoint::all()->first()->endpoint;
        Artisan::call('prismic:sync');
        $output = Artisan::output();
        $this->assertContains('Content Synced', $output);
        $this->assertContains($endpoint . ' cached.', $output);
        $this->assertTrue((new LaravelTaggedCacher())->has($endpoint));
        $this->flush();
        $this->assertFalse((new LaravelTaggedCacher())->has($endpoint));
    }

    /**
     * @test
     */
    public function it_deletes_invalid_endpoints()
    {
        $endpoint = new PrismicEndpoint();
        $endpoint->endpoint = 'wrong';
        $endpoint->save();
        Artisan::call('prismic:sync');
        $output = Artisan::output();
        $this->assertContains('Endpoint deleted', $output);
        $this->assertNull(PrismicEndpoint::where('endpoint', 'wrong')->first());
    }
}
