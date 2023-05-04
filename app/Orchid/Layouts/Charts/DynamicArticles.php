<?php

namespace App\Orchid\Layouts\Charts;

use Orchid\Screen\Layouts\Chart;

class DynamicArticles extends Chart
{
    protected $title = 'Динамика публикаций';

    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'line';

    protected $target = 'lineArticles';

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;
}
