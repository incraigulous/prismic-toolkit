<?php

namespace Incraigulous\PrismicToolkit\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A download log.
 *
 * Class PrismicDownload
 * @package Incraigulous\PrismicToolkit\Models
 */
class PrismicDownload extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'asset_url',
    ];


}
