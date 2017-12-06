<?php

namespace Mixdinternet\Faqs\Http\Controllers;

use Illuminate\Http\Request;
use Caffeinated\Flash\Facades\Flash;
use Mixdinternet\Faqs\Faq;
use Mixdinternet\Faqs\Http\Requests\CreateEditFaqsRequest;
use Mixdinternet\Admix\Http\Controllers\AdmixController;

class FaqsAdminController extends AdmixController
{
    public function index(Request $request)
    {
        session()->put('backUrl', request()->fullUrl());
        $trash = ($request->segment(3) == 'trash') ? true : false;

        $query = Faq::sort();
        ($trash) ? $query->onlyTrashed() : '';

        $search = [];
        $search['status'] = $request->input('status', '');
        $search['star'] = $request->input('star', '');
        $search['name'] = $request->input('name', '');

        ($search['status']) ? $query->where('status', $search['status']) : '';
        ($search['star'] != '') ? $query->where('star', $search['star']) : '';
        ($search['name']) ? $query->where('name', 'LIKE', '%' . $search['name'] . '%') : '';

        $faqs = $query->paginate(50);

        $view['trash'] = $trash;
        $view['search'] = $search;
        $view['faqs'] = $faqs;

        return view('mixdinternet/faqs::admin.index', $view);
    }

    public function create(Faq $faq)
    {
        $view['faq'] = $faq;

        return view('mixdinternet/faqs::admin.form', $view);
    }

    public function store(CreateEditFaqsRequest $request)
    {
        if (Faq::create($request->all())) {
            Flash::success('Item inserido com sucesso.');
        } else {
            Flash::error('Falha no cadastro.');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admin.faqs.index');
    }

    public function edit(Faq $faq)
    {
        $view['faq'] = $faq;

        return view('mixdinternet/faqs::admin.form', $view);
    }

    public function update(Faq $faq, CreateEditFaqsRequest $request)
    {
        $input = $request->all();

        if (isset($input['remove'])) {
            foreach ($input['remove'] as $k => $v) {
                $faq->{$v}->destroy();
                $faq->{$v} = STAPLER_NULL;
            }
        }

        if ($faq->update($input)) {
            Flash::success('Item atualizado com sucesso.');
        } else {
            Flash::error('Falha na atualização.');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admin.faqs.index');
    }

    public function destroy(Request $request)
    {
        if (Faq::destroy($request->input('id'))) {
            Flash::success('Item removido com sucesso.');
        } else {
            Flash::error('Falha na remoção.');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admin.faqs.index');
    }

    public function restore($id)
    {
        $faq = Faq::onlyTrashed()->find($id);

        if (!$faq) {
            abort(404);
        }

        if ($faq->restore()) {
            Flash::success('Item restaurado com sucesso.');
        } else {
            Flash::error('Falha na restauração.');
        }

        return ($url = session()->get('backUrl')) ? redirect($url) : redirect()->route('admin.faqs.trash');
    }
}
