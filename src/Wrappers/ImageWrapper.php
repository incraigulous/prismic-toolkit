<?php
namespace Incraigulous\PrismicToolkit\Wrappers;


use Incraigulous\PrismicToolkit\FluentResponse;

class ImageWrapper extends FragmentWrapper
{
    public function toArray()
    {
        $views = $this->getViews();
        $array = [];
        if (!count($views)) {
            $array['main'] = FluentResponse::make($this->getView('main'))->toArray();
        } else {
            foreach($views as $view) {
                $array['main'] = FluentResponse::make($view)->toArray();
            }
        }
        return $array;
    }

    /**
     * Overload properties to main image view and then to image view keys
     *
     * @param $name
     * @return DynamicSlice|StructuredTextDummy|static
     */
    public function getRaw($name)
    {
        return $this->getObject()->getView($name);
    }
}