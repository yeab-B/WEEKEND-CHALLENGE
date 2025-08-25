<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Post extends Model {
    use HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'detail',
    ];

    public $translatable = [
        'title',
        'description',
        'detail',
    ];
}
