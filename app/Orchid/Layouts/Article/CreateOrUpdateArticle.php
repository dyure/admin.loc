<?php

namespace App\Orchid\Layouts\Article;

use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;

use App\Models\Topic;

class CreateOrUpdateArticle extends Rows
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
            Input::make('article.NewsTitle')
                ->required()
                ->title('Заголовок'),
            Select::make('article.NewsTopicID')
                ->fromQuery(Topic::where('TopicPublic', '=', 1), 'TopicName')
                ->required()
                ->title('Раздел'),
            TextArea::make('article.NewsText')
                //->toolbar(['text', 'color', 'header', 'list', 'format', 'media'])
                ->rows(10)
                ->title('Текст'),
            Select::make('article.NewsPublic')
                ->options([
                    1  => 'Да',
                    0  => 'Нет',
                ])
                ->required()
                ->title('Публиковать?')
        ];
    }
}
