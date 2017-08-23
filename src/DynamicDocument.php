<?php
namespace Incraigulous\PrismicToolkit;

use Prismic\Document;
use Prismic\Fragment\GroupDoc;
use Prismic\Fragment\Link\DocumentLink;

class DynamicDocument
{
    public $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * Overload methods to the document.
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
        return call_user_func_array([$this->document, $name], $arguments);
    }

    public function __get($name)
    {
        return $this->resolveField($name);
    }

    public function resolveField($name)
    {
        if (!$this->exists($name)) {
            return new StructuredTextDummy();
        }
        $object = $this->document->getFragments()[$this->resolveFieldName($name)];
        return (new ResponseAdapter())->handle($object);
    }

    public function exists($name)
    {
        $fragments = $this->document->getFragments();
        return array_key_exists($this->resolveFieldName($name), $fragments);
    }

    public function resolveFieldName($name)
    {
        return $this->document->getType() . '.' . $name;
    }
}