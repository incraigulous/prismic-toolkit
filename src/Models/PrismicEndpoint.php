<?php

namespace Incraigulous\PrismicToolkit\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Prismic endpoints to be called by the application to be called later to precache content.
 *
 * Class PrismicEndpoint
 * @package Incraigulous\PrismicToolkit\Models
 */
class PrismicEndpoint extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'endpoint',
    ];
}
