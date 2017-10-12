<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 10/12/17
 * Time: 9:46 AM
 */

namespace Incraigulous\PrismicToolkit\Tests;


use Carbon\Carbon;

class DownloadTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_generate_tokenized_urls() {
        $url = $this->faker->url;
        $downloadUrl = prismic_download_url($url);
        $parts = explode('/', $downloadUrl);
        $expireToken = array_pop($parts);
        $urlToken = array_pop($parts);
        $decryptedUrl = decrypt($urlToken);
        $expiration = decrypt($expireToken);
        $expiresAt = Carbon::createFromTimestamp($expiration);
        $now = Carbon::now();

        $this->assertStringStartsWith('http', $downloadUrl);
        $this->assertEquals($url, $decryptedUrl);
        $this->assertTrue($expiresAt->greaterThan($now));
        $this->assertTrue($expiresAt->lessThan($now->addHours(2)));
    }
}