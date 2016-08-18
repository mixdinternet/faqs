<?php

namespace Mixdinternet\Faqs\Http\Controllers;

use App\Http\Controllers\FrontendController;
use Mixdinternet\Faqs\Faq;
use Illuminate\Http\Request;

class FaqsController extends FrontendController
{
    protected $fields = ['id', 'star', 'name', 'description', 'published_at', 'slug', 'image_file_name'];

    public function index(Request $request)
    {
        $limit = $request->get('limit', 5);

        return Faq::active()->paginate($limit, $this->fields)
            ->addQuery('limit', $limit);
    }

    public function show($slug)
    {
        return Faq::select($this->fields)->with(['seo', 'galleries.images'])->active()->where('slug', $slug)->first();
    }
}
