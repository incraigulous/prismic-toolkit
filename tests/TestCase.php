<?php
namespace Incraigulous\PrismicToolkit\Tests;

use Faker\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Illuminate\Foundation\Application;
use Incraigulous\PrismicToolkit\Cachers\LaravelTaggedCacher;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Models\PrismicEndpoint;
use Incraigulous\PrismicToolkit\Providers\PrismicServiceProvider;
use Prismic\Api;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->faker = Factory::create();
        parent::__construct($name, $data, $dataName);
    }

    /**
     * Setup the test environment.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->artisan('migrate', ['--database' => 'testing']);
        $this->flush();
    }

    protected function getPackageProviders($app)
    {
        return [PrismicServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Prismic' => Prismic::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('cache.default', 'memcached');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => 'testing',
            'prefix'   => '',
        ]);
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('prismic.endpoint', 'https://prismic-toolkit-sandbox.cdn.prismic.io/api');
        $app['config']->set('prismic.token', 'MC5XWjhnZ0NZQUFHSzZqU3Yx.Ge-_vXrvv73vv73vv71s77-977-977-9A--_vRvvv70d77-9bWIw77-977-977-977-977-9LS3vv70H77-977-977-9aA');
    }

    /**
     * @test
     */
    public function the_app_loads()
    {
        $this->assertInstanceOf(Application::class, app());
    }

    public function flush()
    {
        cache()->flush();
        PrismicEndpoint::truncate();
    }

    public function getApiWithHistory(&$historyContainer = [])
    {
        $history = Middleware::history($historyContainer);
        $stack = HandlerStack::create();
        $stack->push($history);
        $client = new Client(['handler' => $stack]);

        return Api::get(
            config('prismic.endpoint'),
            config('prismic.token'),
            $client,
            (config('prismic.cacher')) ? new LaravelTaggedCacher() : null,
            config('prismic.cacheTime')
        );
    }
}