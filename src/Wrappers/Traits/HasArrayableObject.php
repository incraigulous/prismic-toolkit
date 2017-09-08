<?php
namespace Incraigulous\PrismicToolkit\Wrappers\Traits;

use Illuminate\Contracts\Support\Arrayable;
use Incraigulous\PrismicToolkit\FluentResponse;

trait HasArrayableObject
{
    /**
     * Recursively convert to an array.
     * @return array
     */
    public function toArray()
    {
        $all = $this->all();
        $array = [];

        foreach($all as $key => $value) {
            $response = FluentResponse::make($value);
            $result = null;
            if (is_object($response)) {
                if ($response instanceof Arrayable) {
                    $result = $response->toArray();
                } else {
                    $result = (array) $response;
                }
            } else {
                $result = $response;
            }
            $array[$this->resolveFieldName($key)] = $result;
        }

        return $array;
    }

    /**
     * Alias of toArray()
     * @return array
     */
    public function asArray()
    {
        return $this->toArray();
    }
}