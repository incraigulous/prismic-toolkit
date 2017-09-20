<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 9/20/17
 * Time: 2:19 PM
 */

namespace Incraigulous\PrismicToolkit\Models\Traits;

use Incraigulous\PrismicToolkit\Facades\Prismic;

trait RelatedToPrismic
{

    public $prismicFieldName = 'prismic';
    public $prismicIdName = 'prismic_id';

    /**
     * Return the prismic ID
     */
    public function getPrismicId() {
        $attribute = $this->prismicIdName;
        $this->$attribute;
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
        $this->appends = array_unique(array_merge($this->appends, [$this->prismicFieldName]));
        return $this->prismic();
    }
}
