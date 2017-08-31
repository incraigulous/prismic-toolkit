<?php
namespace Incraigulous\PrismicToolkit\Wrappers\Traits;

use Illuminate\Contracts\Support\Arrayable;
use Incraigulous\PrismicToolkit\Response;

trait HasArrayableObject
{
    public function toArray()
    {
        $all = $this->all();
        $array = [];

        foreach($all as $key => $value) {
            $response = Response::make($value);

            if (is_object($response) && $response instanceof Arrayable) {
                $array[$this->resolveFieldName($key)] = $response->toArray();
            } else {
                $array[$this->resolveFieldName($key)] = $response;
            }
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