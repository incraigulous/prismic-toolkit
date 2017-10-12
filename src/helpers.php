<?php

if (! function_exists('is_assoc')) {
    /**
     * Is the array an associative array?
     * @param array $arr
     * @return bool
     */
    function is_assoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}

if (! function_exists('prismic_download_url')) {
    /**
     * Generate an encrypted download URL
     * @param $url
     * @return bool
     */
    function prismic_download_url($url)
    {
        return route('prismic-temporary-download',
            [
                'token' => encrypt($url),
                'expireToken' => encrypt(\Carbon\Carbon::now()->addHour(1)->getTimestamp())
            ]);
    }
}