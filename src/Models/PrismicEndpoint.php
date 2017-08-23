<?php
namespace Incraigulous\PrismicToolkit\Models;

use Illuminate\Database\Eloquent\Model;

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
