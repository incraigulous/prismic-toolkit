<?php

namespace Incraigulous\PrismicToolkit\Observers;

use Incraigulous\PrismicToolkit\Endpoint;
use Incraigulous\PrismicToolkit\Models\PrismicEndpoint;
use Spatie\Regex\Regex;

class PrismicEndpointObserver
{
    public function saving(PrismicEndpoint $prismicEndpoint)
    {
        $endpoint = new Endpoint($prismicEndpoint->endpoint);
        $prismicEndpoint->endpoint = $endpoint->urlWithoutRelease();
    }
}