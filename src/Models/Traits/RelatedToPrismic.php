<?php
namespace Incraigulous\PrismicToolkit\Models\Traits;

use Incraigulous\PrismicToolkit\Facades\Prismic;

trait RelatedToPrismic
{
    public $prismicIdName = 'prismic_id';

    /**
     * Return the prismic ID
     */
    public function getPrismicId() {
        $attribute = $this->prismicIdName;
        return $this->$attribute;
    }


    /**
     * The relationship to prismic
     * @return mixed
     */
    public function prismic()
    {
        return Prismic::getById($this->getPrismicId());
    }

    /**
     * Mutator for prismic
     * @return mixed
     */
    public function getPrismicAttribute()
    {
        return $this->prismic();
    }
}