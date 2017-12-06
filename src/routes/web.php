<?php

Route::group(['middleware' => ['web'], 'prefix' => config('admin.url'), 'as' => 'admin.faqs'], function () {
    Route::group(['middleware' => ['auth.admin', 'auth.rules']], function () {
        Route::get('faqs/trash', ['uses' => 'FaqsAdminController@index', 'as' => '.trash']);
        Route::post('faqs/restore/{id}', ['uses' => 'FaqsAdminController@restore', 'as' => '.restore']);
        Route::resource('faqs', 'FaqsAdminController', [
            'names' => [
                'index' => '.index',
                'create' => '.create',
                'store' => '.store',
                'edit' => '.edit',
                'update' => '.update',
                'show' => '.show',
            ], 'except' => ['destroy']]);
        Route::delete('faqs/destroy', ['uses' => 'FaqsAdminController@destroy', 'as' => '.destroy']);
    });
});

Route::group(['prefix' => 'api', 'as' => 'api.faqs'], function () {
    Route::get('faqs', ['uses' => 'FaqsController@index', 'as' => '.index']);
    Route::get('faqs/{slug}', ['uses' => 'FaqsController@show', 'as' => '.show']);
});