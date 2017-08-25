<?php

namespace Incraigulous\PrismicToolkit\Tests;

use Incraigulous\PrismicToolkit\DynamicDocument;
use Incraigulous\PrismicToolkit\DynamicGroupDoc;
use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Response;

/**
 * @group responses
 * @group group-docs
 *
 * Class DynamicGroupDocTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class DynamicGroupDocTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_make_dynamic_group_docs()
    {
        $groupDoc = Response::make(Prismic::getByUID('nested', 'nested'))->repeatables->first();
        $this->assertInstanceOf(DynamicGroupDoc::class, $groupDoc);
    }

    /**
     * @test
     */
    public function it_can_resolve_links()
    {
        $groupDoc = Response::make(Prismic::getByUID('nested', 'nested'))->repeatables->first();
        $this->assertInstanceOf(DynamicDocument::class, $groupDoc->repeatable);
    }
}
