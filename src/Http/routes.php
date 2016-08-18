<?php

Route::group(['prefix' => config('admin.url')], function () {
    Route::group(['middleware' => ['auth.admin', 'auth.rules']], function () {
        Route::get('faqs/trash', ['uses' => 'FaqsAdminController@index', 'as' => 'admin.faqs.trash']);
        Route::post('faqs/restore/{id}', ['uses' => 'FaqsAdminController@restore', 'as' => 'admin.faqs.restore']);
        Route::resource('faqs', 'FaqsAdminController', [
            'names' => [
                'index' => 'admin.faqs.index',
                'create' => 'admin.faqs.create',
                'store' => 'admin.faqs.store',
                'edit' => 'admin.faqs.edit',
                'update' => 'admin.faqs.update',
                'show' => 'admin.faqs.show',
            ], 'except' => ['destroy']]);
        Route::delete('faqs/destroy', ['uses' => 'FaqsAdminController@destroy', 'as' => 'admin.faqs.destroy']);
    });
});

Route::group(['prefix' => 'api'], function () {
    Route::get('faqs', ['uses' => 'FaqsController@index', 'as' => 'api.faqs.index']);
    Route::get('faqs/{slug}', ['uses' => 'FaqsController@show', 'as' => 'api.faqs.show']);
});