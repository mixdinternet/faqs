@extends('admin.form')

@section('title')
    Gerenciar {{ strtolower(config('mfaqs.name', 'Faqs')) }}
@endsection

@section('form')
    {!! BootForm::horizontal(['model' => $faq, 'store' => 'admin.faqs.store', 'update' => 'admin.faqs.update'
        , 'id' => 'form-model', 'class' => 'form-horizontal form-rocket jq-form-validate jq-form-save'
        , 'files' => true ]) !!}
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Geral</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                @if ($faq['id'])
                    {!! BootForm::text('id', 'Código', null, ['disabled' => true]) !!}
                @endif

                {!! BootForm::select('status', 'Status', ['active' => 'Ativo', 'inactive' => 'Inativo'], null
                    , ['class' => 'jq-select2', 'data-rule-required' => true]) !!}

                {!! BootForm::select('star', 'Destaque', ['0' => 'Não', '1' => 'Sim'], null
                    , ['class' => 'jq-select2', 'data-rule-required' => true]) !!}

                {!! BootForm::text('name', 'Nome', null, ['data-rule-required' => true, 'maxlength' => '150']) !!}

                {!! BootForm::textarea('description', 'Descrição', null, ['class' => 'jq-summernote', 'data-rule-required' => true]) !!}

                {!! BootForm::text('order', 'Ordem', null, ['maxlength' => '3']) !!}
            </div>
        </div>
    </div>
    {!! BootForm::close() !!}
@endsection