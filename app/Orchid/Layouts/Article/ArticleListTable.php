<?php

namespace App\Orchid\Layouts\Article;

use App\Models\Article;
use App\Models\Topic;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ArticleListTable extends Table
{
    protected $target = 'articles';

    protected function columns(): array
    {
        return [
            TD::make('NewsTitle', 'Заголовок')
                ->width('35%')
                ->cantHide()
                ->sort(),
            TD::make('created_at', 'Дата создания')
                ->render(fn (Article $article) => $article->created_at->toDateTimeString())
                ->defaultHidden()
                ->width('15%')
                ->sort(),
            TD::make('updated_at', 'Дата обновления')
                ->render(fn (Article $article) => $article->updated_at->toDateTimeString())
                ->defaultHidden()
                ->width('15%'),
            TD::make('NewsTopicID', 'Раздел')
                ->width('15%')
                ->popover('1 - новости Собрания 130 - новости фракций, 218 - новости депутатов и 234 - памятные даты')
                ->render(fn (Article $article) =>
                    Topic::where('id', '=', $article->NewsTopicID)->value('TopicName')
                )
                //->filter(TD::FILTER_NUMERIC)
                ->defaultHidden(),
            TD::make('NewsPublic', 'Опубликовано')
                ->align(TD::ALIGN_CENTER)
                ->render(fn (Article $article) =>
                    Button::make($article->NewsPublic === 1 ? 'Да' : 'Нет')
                    ->method('yesNo', [
                        'id' => $article->id,
                    ])
                )
                ->width('10%'),
            TD::make('Действия')
                ->render(fn (Article $article) => DropDown::make()
                ->icon('options-vertical')
                ->align(TD::ALIGN_CENTER)
                ->list([
                    Link::make('Изменить')
                    ->icon('pencil')
                    ->route('platform.articles.edit', $article->id),
                    // ModalToggle::make('Изменить')
                    //     ->icon('pencil')
                    //     ->modal('editArticle')
                    //     ->method('createOrUpdateArticle')
                    //     ->modalTitle('Редактирование: ' . $article->NewsTitle)
                    //     ->asyncParameters([
                    //         'article' => $article->id
                    //     ]),
                    Button::make('Копировать')
                        ->icon('paste')
                        ->method('copyArticle', [
                            'id' => $article->id,
                        ]),
                    Button::make('Удалить')
                        ->icon('trash')
                        ->confirm('Статья ' . $article->NewsTitle . ' будет удалена')
                        ->method('removeArticle', [
                            'id' => $article->id,
                        ]),
                    ]))
                ->width('5%')
        ];
    }
}
