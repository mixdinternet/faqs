<?php

namespace Mixdinternet\Faqs\Http\Controllers;

use App\Http\Controllers\Controller;
use Mixdinternet\Faqs\Faq;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    protected $fields = ['id', 'star', 'name', 'description', 'slug'];

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
