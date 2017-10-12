<?php

namespace Incraigulous\PrismicToolkit\Controllers;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Incraigulous\PrismicToolkit\Exceptions\DownloadException;
use Incraigulous\PrismicToolkit\Models\PrismicDownload;

class DownloadController extends Controller
{
    /**
     * Download a file by encrypted URL token that expires.
     * 
     * @param $token
     * @param $expireToken
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws DownloadException
     */
    public function temporary($token, $expireToken)
    {
        $expiration = Carbon::createFromTimestamp(decrypt($expireToken));
        if (Carbon::now()->greaterThan($expiration)) {
            throw new DownloadException('Download expired.');
        }

        return $this->show($token);
    }

    /**
     * Download a file by encrypted URL token.
     *
     * @param Request $request
     * @param $token
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws DownloadException
     */
    public function show($token)
    {
        $url = decrypt($token);
        $filename = basename($url);
        $tempImage = tempnam(sys_get_temp_dir(), $filename);
        copy($url, $tempImage);

        PrismicDownload::create(['asset_url' => $url]);

        return response()->download($tempImage, $filename);
    }
}
