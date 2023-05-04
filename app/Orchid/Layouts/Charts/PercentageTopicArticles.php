<?php

namespace App\Orchid\Layouts\Charts;

use Orchid\Screen\Layouts\Chart;

class PercentageTopicArticles extends Chart
{
    protected $title = 'Статей по разделам';

    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'pie';

    protected $target = 'percentageTopic';

    /**
     * Determines whether to display the export button.
     *
     * @var bool
     */
    protected $export = true;
}
