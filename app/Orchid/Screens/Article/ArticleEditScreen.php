<?php

namespace App\Orchid\Screens\Article;

use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;

use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;

use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Alert;

use App\Models\Article;
use App\Models\Topic;

use App\Orchid\Layouts\Article\ArticleListTable;
use App\Orchid\Layouts\Article\ArticleCommonLayout;
use App\Orchid\Layouts\Article\ArticleTitleLayout;
use App\Orchid\Layouts\Article\ArticleRelationLayout;
use App\Orchid\Layouts\Article\ArticleAdditionalLayout;
use App\Orchid\Layouts\Article\ArticleParagraphLayout;

// use App\Orchid\Screens\AsSource;

class ArticleEditScreen extends Screen
{
    /**
     * @var Article
     */
    public $article;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param Article $article
     *
     * @return array
     */
    public function query(Article $article): iterable
    {
        //$article->load(['roles']);

        return [
            'article'       => $article,
            //'permission' => $article->getStatusPermission(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->article->exists ? 'Редактирование' : 'Создание';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Заполните поля, такие как заголовок, лид и т.д.';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            //'platform.articles',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->icon('check')
                ->method('createOrUpdateArticle'),
            Link::make('Выйти')
                ->icon('close')
                ->route('platform.articles'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::block(ArticleCommonLayout::class)
                ->title('Служебная информация')
                ->description('Дата создания, дата обновления, раздел, автор и источник публикации.'),
            Layout::block(ArticleTitleLayout::class)
                ->title('Основная информация')
                ->description('Заголовок, лид и текст публикации.'),
            Layout::block(ArticleRelationLayout::class)
                ->title('Привязки')
                ->description('Привязки к депутатам, заседаниям комитетов или сессий, фотографии, фоторепортажа и видеокомментария.'),
            Layout::block(ArticleAdditionalLayout::class)
                ->title('Дополнительная информация')
                ->description('Жанр темы и контракты.'),
            Layout::block(ArticleParagraphLayout::class)
                ->title('Параграфы')
                ->description('Создайте параграф.'),
        ];
    }

    public function createOrUpdateArticle(ArticleRequest $request)
    {
        $articleId = $request->input('article.id');
        //dd($request->all());
        Article::updateOrCreate([
            'id' => $articleId
        ], array_merge($request->validated()['article'], []));
        is_null($articleId) ? Toast::info('Статья создана') : Toast::info('Статья обновлена');
        //return redirect()->route('platform.articles');
    }
}
