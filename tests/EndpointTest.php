<?php

namespace Incraigulous\PrismicToolkit\Tests;

use Incraigulous\PrismicToolkit\CacheRules\NoCache;
use Incraigulous\PrismicToolkit\Endpoint;

/**
 * @group endpoints
 *
 * Class EndpointTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class EndpointTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_urls()
    {
        $url = $this->faker->url();
        $endpoint = new Endpoint($url);
        $this->assertEquals($url, $endpoint->url());
    }

    /**
     * @test
     */
    public function it_makes_cache_keys()
    {
        $url = $this->faker->url();
        $endpoint = new Endpoint($url);
        $this->assertEquals(md5($url), $endpoint->makeCacheKey());
    }

    /**
     * @test
     */
    public function its_cache_keys_do_not_change()
    {
        $url = $this->faker->url();
        $endpoint = new Endpoint($url);
        $key = $endpoint->makeCacheKey();
        $endpoint2 = new Endpoint($url);
        $key2 = $endpoint2->makeCacheKey();
        $this->assertEquals($key, $key2);
    }

    /**
     * @test
     */
    public function it_follows_cache_rules()
    {
        $url = $this->faker->url();
        $endpoint = new Endpoint($url);
        $this->assertTrue($endpoint->shouldCache());

        config(['prismic.cacheRules' => [
            NoCache::class
        ]]);
        $endpoint = new Endpoint($url);
        $this->assertFalse($endpoint->shouldCache());
    }

    /**
     * @test
     */
    public function it_follows_precache_rules()
    {
        $url = $this->faker->url();
        $endpoint = new Endpoint($url);
        $this->assertTrue($endpoint->shouldPreCache());

        $endpoint = new Endpoint($url . '/api#');
        $this->assertFalse($endpoint->shouldPreCache());
    }

    /**
     * @test
     */
    public function it_removes_refs_from_urls()
    {
        $endpoint = new Endpoint('http://www.google.com/api#?plant=flower&ref=3030303&cat=true');
        $this->assertEquals('http://www.google.com/api#?plant=flower&cat=true', $endpoint->urlWithoutRelease());
    }

    /**
     * @test
     */
    public function it_removes_refs_from_with_ref_at_end()
    {
        $endpoint = new Endpoint('http://www.google.com/api#?plant=flower&cat=true&ref=3030303');
        $this->assertEquals('http://www.google.com/api#?plant=flower&cat=true', $endpoint->urlWithoutRelease());
    }
}
