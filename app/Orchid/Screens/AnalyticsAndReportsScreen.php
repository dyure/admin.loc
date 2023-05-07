<?php

namespace App\Orchid\Screens;

use App\Models\Article;
use Carbon\Carbon;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use App\Orchid\Layouts\Charts\PercentageTopicArticles;
use App\Orchid\Layouts\Charts\DynamicArticles;

class AnalyticsAndReportsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $start = Carbon::now()->subDay(30);
        $end = Carbon::now()->subDay(25);
        //dd($start);
        return [
            'percentageTopic' => Article::where([
                    ['NewsPublic', '=', 1],
                    ['NewsTopicID', '=', 1],
                ])
                ->orWhere('NewsTopicID', '=', 130)
                ->orWhere('NewsTopicID', '=', 218)
                ->orWhere('NewsTopicID', '=', 324)
                //->whereYear('created_at', '2023')
                ->countForGroup('NewsTopicID')
                ->toChart(fn () =>
                    [
                        1 => 'Пресс-релизы',
                        218 => 'Депутаты',
                        130 => 'Фракции',
                        324 => 'Поздравления'
                    ]
                ),
            'lineArticles' => [
                Article::where('NewsTopicID', '=', 1)
                    //->countByDays($start, $end, 'created_at')
                    ->countByDays(NULL, NULL, 'created_at')
                    ->toChart('Пресс-релизы'),
                Article::where('NewsTopicID', '=', 218)
                    //->countByDays($start, $end, 'created_at')
                    ->countByDays(NULL, NULL, 'created_at')
                    ->toChart('Депутаты'),
                Article::where('NewsTopicID', '=', 130)
                    //->countByDays($start, $end, 'created_at')
                    ->countByDays(NULL, NULL, 'created_at')
                    ->toChart('Фракции'),
                Article::where('NewsTopicID', '=', 324)
                    //->countByDays($start, $end, 'created_at')
                    ->countByDays(NULL, NULL, 'created_at')
                    ->toChart('Поздравления')
            ]
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Отчеты и графики';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::columns([
                PercentageTopicArticles::class,
                DynamicArticles::class
            ])
        ];
    }
}
