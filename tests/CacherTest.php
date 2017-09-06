<?php

namespace Incraigulous\PrismicToolkit\Tests;

use Incraigulous\PrismicToolkit\Cachers\LaravelCacher;
use Incraigulous\PrismicToolkit\CacheRules\NoCache;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Models\PrismicEndpoint;

/**
 * @group cache
 * @group laravel-cacher
 *
 * @covers CacherTest
 * Class EmailTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class CacherTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set('prismic.cacher', LaravelCacher::class);
    }

    public function getCacher() 
    {
        $className = config('prismic.cacher');
        return new $className;
    }   

    /**
     * @test
     */
    public function caching_works()
    {
        cache()->put('horse', 'of course', 10);
        $this->assertTrue(cache()->has('horse'));
    }

    /**
     * @test
     */
    public function it_can_has()
    {
        cache()->forever(md5('test'), 'result');
        $cacher = $this->getCacher();
        $this->assertTrue($cacher->has('test'));
    }

    /**
     * @test
     */
    public function it_can_get()
    {
        cache()->forever(md5('test'), 'result');
        $cacher = $this->getCacher();
        $this->assertEquals('result', $cacher->get('test'));
    }

    /**
     * @test
     */
    public function it_stores_keys_in_the_database()
    {
        $url = 'test.access_token';
        $this->assertNull(PrismicEndpoint::where('endpoint', $url)->first());
        $cacher = $this->getCacher();
        $cacher->get($url);
        $this->assertNotNull(PrismicEndpoint::where('endpoint', $url)->first());
        $this->assertEquals($url, PrismicEndpoint::where('endpoint', $url)->first()->endpoint);
    }

    /**
     * @test
     */
    public function it_can_set()
    {
        $key = 'test';
        $result = 'result';
        $cacher = $this->getCacher();
        $cacher->set($key, $result);
        $this->assertEquals(cache()->get(md5($key)), $result);
    }

    /**
     * @test
     */
    public function it_can_set_with_ttl()
    {
        $key = 'test';
        $result = 'result';
        $cacher = $this->getCacher();
        $cacher->set($key, $result, 20);
        $this->assertEquals(cache()->get(md5($key)), $result);
    }

    /**
     * @test
     */
    public function it_can_forget()
    {
        $key = 'test';
        $result = 'result';
        $cacher = $this->getCacher();
        $cacher->set($key, $result);
        $this->assertEquals(cache()->get(md5($key)), $result);
        $cacher->forget($key);
        $this->assertFalse(cache()->has(md5($key)));
    }

    /**
     * @test
     */
    public function it_can_clear()
    {
        $key = 'test';
        $result = 'result';
        $cacher = $this->getCacher();
        $cacher->set($key, $result);
        $this->assertEquals(cache()->get(md5($key)), $result);
        $cacher->clear();
        $this->assertFalse(cache()->has(md5($key)));
    }

    /**
     * @test
     */
    public function it_only_clears_key()
    {
        $key = 'test';
        $result = 'result';
        $tag = 'dontclearme';
        cache()->tags($tag)->forever(md5('test'), 'result');
        $cacher = $this->getCacher();
        $cacher->set($key, $result);
        $cacher->clear();
        $this->assertNotNull(cache()->tags(config($tag))->has(md5($key)));
    }

    /**
     * @test
     */
    public function it_caches_endpoints()
    {
        $history = collect();
        $prismic = $this->getApiWithHistory($history);
        $prismic->getByUID('single', 'test-single');
        $countBefore = $history->count();
        $prismic->getByUID('single', 'test-single');
        $countAfter = $history->count();
        $this->assertEquals($countBefore, $countAfter);
    }

    /**
     * @test
     */
    public function it_does_not_store_the_handshake()
    {
        Prismic::getByUID('single', 'test-single');
        $this->assertEquals(1, PrismicEndpoint::all()->count());
    }

    /**
     * @test
     */
    public function it_does_not_cache_against_the_rules()
    {
        $history = collect();
        $prismic = $this->getApiWithHistory($history);

        $prismic->getByUID('single', 'test-single');
        $countBefore = $history->count();
        $prismic->getByUID('single', 'test-single');
        $countAfter = $history->count();

        $this->assertEquals($countBefore, $countAfter);
        $this->flush();

        config(['prismic.cacheRules' => [
            NoCache::class
        ]]);
        $history = collect();
        $prismic = $this->getApiWithHistory($history);

        $prismic->getByUID('single', 'test-single');
        $countBefore = $history->count();
        $prismic->getByUID('single', 'test-single');
        $countAfter = $history->count();

        $this->assertGreaterThan($countBefore, $countAfter);
    }

    /**
     * @test
     */
    public function it_does_not_precache_for_each_release()
    {
        $cacher = $this->getCacher();
        $cacher->get('ONE.access_token?test=test&ref=OLD&test=test');
        $countBefore = PrismicEndpoint::all()->count();
        $cacher->get('TWO.access_token?test=test&ref=OLD&test=test');
        $countAfter = PrismicEndpoint::all()->count();
        $this->assertGreaterThan($countBefore, $countAfter);

        $this->flush();

        $cacher->get('TWO.access_token?test=test&ref=OLD&test=test');
        $countBefore = PrismicEndpoint::all()->count();
        $cacher->get('TWO.access_token?test=test&ref=NEW&test=test');
        $countAfter = PrismicEndpoint::all()->count();
        $this->assertEquals($countBefore, $countAfter);
    }
}
