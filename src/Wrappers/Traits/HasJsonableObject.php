<?php
namespace Incraigulous\PrismicToolkit\Wrappers\Traits;

trait HasJsonableObject
{
    /**
     * Convert the object to its JSON representation.
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        $data = $this->toArray();
        return json_encode($data, $options);
    }

    /**
     * Alias for toJson
     *
     * @param int $options
     * @return string
     */
    public function asJson($options = 0)
    {
        return $this->toJson($options);
    }
}