<?php

namespace App\Orchid\Layouts\Article;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;

use App\Models\Topic;
use App\Models\Author;
use App\Models\Publisher;

class ArticleCommonLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        //$isArticleExist = is_null($this->query->getContent('article')) === false;
        return [
            Input::make('article.id')
                ->type('hidden'),
            Group::make([
                DateTimer::make('article.created_at')
                    ->title('Дата создания'),
                DateTimer::make('article.updated_at')
                    ->title('Дата обновления')
                    ->help('Заполняется автоматически'),
            ]),
            Select::make('article.NewsTopicID')
                ->fromQuery(Topic::where('id', '=', 1)
                    ->orWhere('id', '=', 130)
                    ->orWhere('id', '=', 218)
                    ->orWhere('id', '=', 324), 'TopicName')
                ->title('Раздел'),
            Group::make([
                Select::make('article.NewsAuthorID')
                    ->fromQuery(Author::where('AuthorPublic', '=', 1), 'AuthorName')
                    ->title('Автор'),
                Input::make('article.NewsAuthor')
                    ->title('Автор (альт.)'),
            ]),
            Select::make('article.NewsPublisherID')
                ->fromQuery(Publisher::where('PublisherPublic', '=', 1), 'PublisherName')
                ->title('Источник'),
        ];
    }
}
