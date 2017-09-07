<?php

namespace Incraigulous\PrismicToolkit\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class VerifyPrismicWebhook
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $postData = json_decode($request->getContent());
        $secret = (isset($postData->secret)) ? $postData->secret : null;

        if (config('prismic.webhookSecret') && ($secret != config('prismic.webhookSecret'))) {
            throw new UnauthorizedException('invalid secret');
        }

        return $next($request);
    }

}