<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 8/23/17
 * Time: 3:30 PM
 */

namespace Incraigulous\PrismicToolkit;

use Prismic\Api;

/**
 * A stand in for the Prismic APIs form class that takes a full URL instead of an action.
 *
 * Can be passed to Prismic\Api::submit
 *
 * Class Form
 * @package Incraigulous\PrismicToolkit
 */

class Form
{
    private $url;

    /**
     * Form constructor.
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function url()
    {
        return $this->url;
    }
}