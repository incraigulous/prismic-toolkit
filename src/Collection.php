<?php

namespace Incraigulous\PrismicToolkit;

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
            $result[$key] = (new ResponseAdapter())->handle($record);
        }

        return $result;
    }
}