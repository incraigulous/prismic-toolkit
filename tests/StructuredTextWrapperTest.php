<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 10/2/17
 * Time: 12:13 PM
 */

namespace Incraigulous\PrismicToolkit\Tests;


use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Wrappers\StructuredTextWrapper;

class StructuredTextWrapperTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_resolve()
    {
        $document = Prismic::getByUID('single', 'test-single');
        $this->assertInstanceOf(StructuredTextWrapper::class, $document->rich_text);
    }

    /**
     * @test
     */
    public function it_converts_to_a_string()
    {
        $field = Prismic::getByUID('single', 'test-single')->rich_text;
        $this->assertContains('</p>', 'this should be html' . $field);
    }

    /**
     * @test
     */
    public function it_converts_to_an_array()
    {
        $field = Prismic::getByUID('single', 'test-single')->rich_text;
        $this->assertArrayHasKey('html', $field->toArray());
        $this->assertArrayHasKey('text', $field->toArray());
        $this->assertEquals($field, $field->toArray()['html']);
    }

    /**
     * @test
     */
    public function it_converts_to_json()
    {
        $field = Prismic::getByUID('single', 'test-single')->rich_text;
        $array = json_decode($field->toJson(), true);
        $this->assertArrayHasKey('html', $array);
        $this->assertArrayHasKey('text', $array);
        $this->assertEquals($field, $array['html']);
    }

    /**
     * @test
     */
    public function emptied_fields_are_falsy()
    {
        $single = Prismic::getByUID('single', 'test-single');
        $this->assertNull($single->deleted);
    }
}