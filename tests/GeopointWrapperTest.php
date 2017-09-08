<?php
namespace Incraigulous\PrismicToolkit\Tests;

use Incraigulous\PrismicToolkit\Facades\Prismic;
use Incraigulous\PrismicToolkit\Wrappers\GeoPointwrapper;


/**
 * @group geo
 *
 * Class GeopointWrapperTest
 * @package Incraigulous\PrismicToolkit\Tests
 */
class GeopointWrapperTest extends TestCase
{

    /**
     * @test
     */
    public function it_can_resolve_color_wrappers()
    {
        $document = Prismic::getByUID('single', 'test-single');
        $this->assertInstanceOf(GeoPointwrapper::class, $document->geopoint);
    }

    /**
     * @test
     */
    public function it_can_resolve_color_wrapper_content()
    {
        $geopoint = Prismic::getByUID('single', 'test-single')->geopoint;
        $this->assertTrue(str_contains($geopoint->getLatitude(), '.'));
    }

    /**
     * @test
     */
    public function it_is_arrayable()
    {
        $geopoint = Prismic::getByUID('single', 'test-single')->geopoint;
        $array = $geopoint->toArray();
        $this->assertTrue(str_contains($array['latitude'], '.'));
    }

    /**
     * @test
     */
    public function it_is_jsonable()
    {
        $geopoint = Prismic::getByUID('single', 'test-single')->geopoint;
        $json = $geopoint->toJson();
        $this->assertTrue(is_string($json));
        $array = json_decode($json, 1);
        $this->assertTrue(str_contains($array['latitude'], '.'));
    }
}