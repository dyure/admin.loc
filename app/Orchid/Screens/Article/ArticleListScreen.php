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
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Alert;
use App\Models\Article;
use App\Models\Topic;
use App\Orchid\Layouts\Article\ArticleListTable;
use App\Orchid\Layouts\OperatorSelection;
use App\Orchid\Filters\TopicFilter;
//use App\Orchid\Layouts\Article\CreateOrUpdateArticle;
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
            'articles' => Article::filtersApply([TopicFilter::class])->filters()
                // ->where('NewsTopicID', '=', 1)
                // ->orWhere('NewsTopicID', '=', 218)
                // ->orWhere('NewsTopicID', '=', 130)
                // ->orWhere('NewsTopicID', '=', 324)
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
        return 'Статьи';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Новая статья')
                ->route('platform.articles.create')
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
            OperatorSelection::class,
            ArticleListTable::class
        ];
    }

    public function asyncGetArticle(Article $article): array
    {
        return [
            'article' => $article
        ];
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
