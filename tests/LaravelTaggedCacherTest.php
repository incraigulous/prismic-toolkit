<?php
namespace Incraigulous\PrismicToolkit\Tests;

use Incraigulous\PrismicToolkit\Cachers\LaravelTaggedCacher;

/**
 * @group cache
 * @group laravel-tagged-cacher
 *
 * @covers CacherTest
 * Class EmailTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class LaravelTaggedCacherTest extends CacherTest
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set('prismic.cacher', LaravelTaggedCacher::class);
    }

    /**
     * @test
     */
    public function it_can_has()
    {
        cache()->tags(config('prismic.cacheTag'))->forever(md5('test'), 'result');
        $cacher = $this->getCacher();
        $this->assertTrue($cacher->has('test'));
    }

    /**
     * @test
     */
    public function it_can_get()
    {
        cache()->tags(config('prismic.cacheTag'))->forever(md5('test'), 'result');
        $cacher = $this->getCacher();
        $this->assertEquals('result', $cacher->get('test'));
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
        $this->assertEquals(cache()->tags(config('prismic.cacheTag'))->get(md5($key)), $result);
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
        $this->assertEquals(cache()->tags(config('prismic.cacheTag'))->get(md5($key)), $result);
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
        $cacher = $this->getCacher();
        $cacher->set($key, $result);
        $this->assertEquals(cache()->tags(config('prismic.cacheTag'))->get(md5($key)), $result);
        $cacher->clear();
        $this->assertFalse(cache()->tags(config('prismic.cacheTag'))->has(md5($key)));
    }
}
