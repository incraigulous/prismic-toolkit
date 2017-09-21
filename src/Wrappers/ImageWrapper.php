<?php
namespace Incraigulous\PrismicToolkit\Wrappers;


use Incraigulous\PrismicToolkit\FluentResponse;

class ImageWrapper extends FragmentWrapper
{
    public function toArray()
    {
        $views = $this->getObject()->getViews();
        $array = [];

        //Add all the alternate image sizes
        foreach($views as $viewName => $view) {
            $array[$viewName] = FluentResponse::make($view)->toArray();
        }

        //The main image view wouldn't have been included
        $array['main'] = FluentResponse::make($this->getView('main'))->toArray();

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