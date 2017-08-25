<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 8/2/17
 * Time: 11:30 AM
 */

namespace Incraigulous\PrismicToolkit;

use Prismic\Fragment\CompositeSlice;

/**
 * A dynamic wrapper for prismic slices to give a clearer and simpler API.
 *
 * Extends Laravel collections.
 *
 * Class DynamicSlice
 * @package Incraigulous\PrismicToolkit
 */
class DynamicSlice extends \Illuminate\Support\Collection
{
    public $slice;

    public function __construct(CompositeSlice $slice)
    {
        $this->slice = $slice;
        $items = $this->collect($slice->getItems()->getArray());
        parent::__construct($items);
    }

    /**
     * Build the collection.
     *
     * @param $data
     * @return array
     */
    protected function collect($data)
    {
        $result = [];

        foreach($data as $key => $record) {
            $result[$key] = (new Response())->handle($record);
        }

        return $result;
    }

    /**
     * Overload methods to the slice.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }
        return call_user_func_array([$this->slice, $name], $arguments);
    }
}