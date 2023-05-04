<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongTo;
use Orchid\Screen\AsSource;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;

class Article extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use Chartable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'NewsTitle',
        'NewsText',
        'NewsTopicID',
        'NewsPublic',
    ];

    /**
     * The attributes that are sortable.
     *
     * @var array
     */
    protected $allowedSorts = [
        'NewsTitle',
        'created_at',
    ];

    /**
     * The attributes that are searchable.
     *
     * @var array
     */
    protected $allowedFilters = [
        'NewsTopicID',
    ];
}
