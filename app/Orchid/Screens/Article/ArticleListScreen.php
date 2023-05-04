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
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Quill;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Alert;
use App\Models\Article;
use App\Models\Topic;
use App\Orchid\Layouts\Article\ArticleListTable;
use App\Orchid\Layouts\Article\CreateOrUpdateArticle;
// use App\Orchid\Screens\AsSource;

class ArticleListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        //dd($this->query->getContent());
        return [
            'articles' => Article::filters()
                ->where('NewsTopicID', '=', 1)
                ->orWhere('NewsTopicID', '=', 218)
                ->orWhere('NewsTopicID', '=', 130)
                ->orWhere('NewsTopicID', '=', 324)
                ->defaultSort('created_at', 'desc')
                ->paginate(10),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Пресс-релизы';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Новая статья')
                ->modal('createArticle')
                ->method('createOrUpdateArticle'),
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
            ArticleListTable::class,
            Layout::modal('createArticle', CreateOrUpdateArticle::class)
                ->title('Новая статья')
                ->size(Modal::SIZE_LG)
                ->applyButton('Создать'),
            Layout::modal('editArticle', CreateOrUpdateArticle::class)
                ->title('Редактирование статьи')
                ->size(Modal::SIZE_LG)
                ->async('asyncGetArticle')
        ];
    }

    public function asyncGetArticle(Article $article): array
    {
        return [
            'article' => $article
        ];
    }

    public function createOrUpdateArticle(ArticleRequest $request): void
    {
        $articleId = $request->input('article.id');
        //dd($request->all());
        Article::updateOrCreate([
            'id' => $articleId
        ], array_merge($request->validated()['article'], []));

        is_null($articleId) ? Toast::info('Статья создана') : Toast::info('Статья обновлена');
    }

    public function yesNo(Request $request): void
    {
        $id = $request->get('id');
        $status = Article::where('id', '=', $id)->value('NewsPublic');
        if ($status == 1) { $status = 0; } else { $status = 1; }
        Article::where('id', '=', $id)->update(['NewsPublic' => $status]);
    }

    public function copyArticle(Request $request): void
    {
        Article::findOrFail($request->get('id'));

        Toast::info('Статья была скопирована');
    }

    public function removeArticle(Request $request): void
    {
        Article::findOrFail($request->get('id'))->delete();

        Toast::info('Статья была удалена');
    }
}
