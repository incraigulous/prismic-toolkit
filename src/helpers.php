<?php

if (! function_exists('isAssoc')) {
    /**
     * Is the array an associative array?
     * @param array $arr
     * @return bool
     */
    function isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
