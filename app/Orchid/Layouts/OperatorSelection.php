<?php

namespace App\Orchid\Layouts;

use Orchid\Filters\Filter;
use App\Orchid\Filters\TopicFilter;
use Orchid\Screen\Layouts\Selection;

class OperatorSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            TopicFilter::class
        ];
    }
}
