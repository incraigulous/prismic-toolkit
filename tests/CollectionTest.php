<?php

namespace Incraigulous\PrismicToolkit\Tests;
use Incraigulous\PrismicToolkit\Collection;
use Incraigulous\PrismicToolkit\DynamicDocument;
use Incraigulous\PrismicToolkit\DynamicGroupDoc;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Prismic\Fragment\StructuredText;
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
        $collection = new Collection($result->getResults());
        $this->assertGreaterThan(0, $collection->count());
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $collection);
        $this->assertInstanceOf(DynamicDocument::class, $collection->first());
    }

    /**
     * @test
     */
    public function it_handles_nested_collections()
    {
        $result = Prismic::query(
            Predicates::at('document.type', 'nested')
        );
        $collection = new Collection($result->getResults());
        $this->assertGreaterThan(0, $collection->count());
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $collection);
        $this->assertGreaterThan(0, $collection->first()->repeatables->count());
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $collection->first()->repeatables);
        $this->assertInstanceOf(DynamicGroupDoc::class, $collection->first()->repeatables->first());
        $this->assertInstanceOf(StructuredText::class, $collection->first()->repeatables->first()->repeatable->title);
    }
}
