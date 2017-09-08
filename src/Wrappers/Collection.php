<?php

namespace Incraigulous\PrismicToolkit\Wrappers;

use Incraigulous\PrismicToolkit\FluentResponse;

class Collection extends \Illuminate\Support\Collection
{
    public function __construct($items = [])
    {
        $items = $this->collect($items);
        parent::__construct($items);
    }

    protected function collect($data)
    {
        $result = [];

        foreach($data as $key => $record) {
            $result[$key] = FluentResponse::handle($record);
        }

        return $result;
    }
}