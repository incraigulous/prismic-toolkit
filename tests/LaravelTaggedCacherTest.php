<?php

namespace Incraigulous\PrismicToolkit\Tests;

use Incraigulous\PrismicToolkit\Cachers\LaravelTaggedCacher;
use Incraigulous\PrismicToolkit\CacheRules\NoCache;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Models\PrismicEndpoint;

/**
 * @group cache
 * @covers Incraigulous\PrismicToolkit\Cachers\LaravelTaggedCacher
 * Class EmailTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class LaravelTaggedCacherTest extends TestCase
{

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
        cache()->tags(config('prismic.cacheTag'))->forever(md5('test'), 'result');
        $cacher = new LaravelTaggedCacher();
        $this->assertTrue($cacher->has('test'));
    }

    /**
     * @test
     */
    public function it_can_get()
    {
        cache()->tags(config('prismic.cacheTag'))->forever(md5('test'), 'result');
        $cacher = new LaravelTaggedCacher();
        $this->assertEquals('result', $cacher->get('test'));
    }

    /**
     * @test
     */
    public function it_stores_keys_in_the_database()
    {
        $key = 'test.access_token';
        $this->assertNull(PrismicEndpoint::where('endpoint', $key)->first());
        $cacher = new LaravelTaggedCacher();
        $cacher->get($key);
        $this->assertNotNull(PrismicEndpoint::where('endpoint', $key)->first());
        $this->assertEquals($key, PrismicEndpoint::where('endpoint', $key)->first()->endpoint);
    }

    /**
     * @test
     */
    public function it_can_set()
    {
        $key = 'test';
        $result = 'result';
        $cacher = new LaravelTaggedCacher();
        $cacher->set($key, $result);
        $this->assertEquals(cache()->tags(config('prismic.cacheTag'))->get(md5($key)), $result);
    }

    /**
     * @test
     */
    public function it_can_set_with_ttl()
    {
        $key = 'test';
        $result = 'result';
        $cacher = new LaravelTaggedCacher();
        $cacher->set($key, $result, 20);
        $this->assertEquals(cache()->tags(config('prismic.cacheTag'))->get(md5($key)), $result);
    }

    /**
     * @test
     */
    public function it_can_forget()
    {
        $key = 'test';
        $result = 'result';
        $cacher = new LaravelTaggedCacher();
        $cacher->set($key, $result);
        $this->assertEquals(cache()->tags(config('prismic.cacheTag'))->get(md5($key)), $result);
        $cacher->forget($key);
        $this->assertFalse(cache()->tags(config('prismic.cacheTag'))->has(md5($key)));
    }

    /**
     * @test
     */
    public function it_can_clear()
    {
        $key = 'test';
        $result = 'result';
        $cacher = new LaravelTaggedCacher();
        $cacher->set($key, $result);
        $this->assertEquals(cache()->tags(config('prismic.cacheTag'))->get(md5($key)), $result);
        $cacher->clear();
        $this->assertFalse(cache()->tags(config('prismic.cacheTag'))->has(md5($key)));
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
        $cacher = new LaravelTaggedCacher();
        $cacher->set($key, $result);
        $cacher->clear();
        $this->assertNotNull(cache()->tags(config($tag))->has(md5($key)));
    }

    /**
     * @test
     */
    public function prismic_is_using_the_cacher_by_default()
    {
        $this->assertInstanceOf(LaravelTaggedCacher::class, Prismic::getCache());
    }

    /**
     * @test
     */
    public function it_caches_endpoints()
    {
        Prismic::getByUID('single', 'test-single');
        $endpoint = PrismicEndpoint::all()->first()->endpoint;
        $cacher = new LaravelTaggedCacher();
        $this->assertTrue($cacher->has($endpoint));
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
        Prismic::getByUID('single', 'test-single');
        $endpoint = PrismicEndpoint::all()->first()->endpoint;
        $cacher = new LaravelTaggedCacher();
        $this->assertTrue($cacher->has($endpoint));
        $this->flush();
        config(['prismic.cacheRules' => [
            NoCache::class
        ]]);
        Prismic::getByUID('single', 'test-single');
        $endpoint = PrismicEndpoint::all()->first()->endpoint;
        $cacher = new LaravelTaggedCacher();
        $this->assertFalse($cacher->has($endpoint));
    }
}
