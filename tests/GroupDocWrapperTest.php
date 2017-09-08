<?php

namespace Incraigulous\PrismicToolkit\Tests;

use Incraigulous\PrismicToolkit\Wrappers\DocumentWrapper;
use Incraigulous\PrismicToolkit\Wrappers\GroupDocWrapper;
use Incraigulous\PrismicToolkit\Facades\Prismic;

/**
 * @group responses
 * @group group-docs
 *
 * Class DynamicGroupDocTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class GroupDocWrapperTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_make_dynamic_group_docs()
    {
        $groupDoc = Prismic::getByUID('nested', 'nested')->repeatables->first();
        $this->assertInstanceOf(GroupDocWrapper::class, $groupDoc);
    }

    /**
     * @test
     */
    public function it_can_resolve_links()
    {
        $groupDoc = Prismic::getByUID('nested', 'nested')->repeatables->first();
        $this->assertInstanceOf(DocumentWrapper::class, $groupDoc->repeatable);
    }

    /**
     * @test
     *
     */
    public function it_is_jsonable()
    {
        $groupDoc = Prismic::getByUID('nested', 'nested')->repeatables->first();
        $json = $groupDoc->toJson();
        $std = json_decode($json);
        $this->assertTrue(is_string($json));
        $this->assertTrue(is_string($std->repeatable->title));
    }

    /**
     * @test
     *
     */
    public function it_is_arrayable()
    {
        $groupDoc = Prismic::getByUID('nested', 'nested')->repeatables->first();
        $std = $groupDoc->toArray();

        $this->assertTrue(is_array($std));
        $this->assertTrue(is_string($std['repeatable']['title']));
    }
}
