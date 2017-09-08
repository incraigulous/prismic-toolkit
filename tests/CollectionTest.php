<?php

namespace Incraigulous\PrismicToolkit\Tests;

use Incraigulous\PrismicToolkit\Wrappers\DocumentWrapper;
use Incraigulous\PrismicToolkit\Wrappers\GroupDocWrapper;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Prismic\Predicates;

/**
 * @group collections
 * @group responses
 *
 * Class CollectionTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class CollectionTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_make_collection()
    {
        $result = Prismic::query(
            Predicates::at('document.type', 'repeatable')
        );
        $collection = $result->getResults();
        $this->assertGreaterThan(0, $collection->count());
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $collection);
        $this->assertInstanceOf(DocumentWrapper::class, $collection->first());
    }

    /**
     * @test
     */
    public function it_handles_nested_collections()
    {
        $result = Prismic::query(
            Predicates::at('document.type', 'nested')
        );
        $collection = $result->getResults();
        $this->assertGreaterThan(0, $collection->count());
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $collection);
        $this->assertGreaterThan(0, $collection->first()->repeatables->count());
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $collection->first()->repeatables);
        $this->assertInstanceOf(GroupDocWrapper::class, $collection->first()->repeatables->first());
        $this->stringContains('<', $collection->first()->repeatables->first()->repeatable->title);
    }

    /**
     * @test
     *
     */
    public function it_is_jsonable()
    {
        $result = Prismic::query(
            Predicates::at('document.type', 'nested')
        );

        $collection = $result->getResults();

        $json = $collection->toJson();

        $array = json_decode($json);
        $this->assertTrue(is_string($json));
        $this->assertGreaterThan(0, $this->count($array));
        $this->assertTrue(is_string($array[0]->repeatable->image->main->url));
    }

    /**
     * @test
     *
     */
    public function it_is_arrayable()
    {
        $result = Prismic::query(
            Predicates::at('document.type', 'nested')
        );

        $collection = $result->getResults();

        $array = $collection->toArray();

        $this->assertTrue(is_array($array));
        $this->assertGreaterThan(0, $this->count($array));
        $this->assertTrue(is_string($array[0]['repeatable']['image']['main']['url']));
    }
}
