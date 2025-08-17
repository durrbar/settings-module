<?php

namespace Modules\Settings\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasUuids;
    
    protected $table = 'settings';

    public $guarded = [];

    protected $casts = [
        'options' => 'json',
    ];

    public static function getData($language = DEFAULT_LANGUAGE)
    {
        $data = static::where('language', $language)->first();

        if (! $data) {
            $data = static::where('language', DEFAULT_LANGUAGE)->first();
        }

        return $data;
    }
}
