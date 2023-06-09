<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'article.NewsTitle' => [],
            'article.NewsLead' => [],
            'article.created_at' => [],
            'article.NewsTopicID' => [],
            'article.NewsAuthorID' => [],
            'article.NewsPublisherID' => [],
            'article.NewsAuthor' => [],
            'article.NewsText' => [],
            'article.NewsPublic' => []
        ];
    }
}
