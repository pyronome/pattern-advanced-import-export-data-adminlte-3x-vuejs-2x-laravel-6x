<?php

/*
|--------------------------------------------------------------------------
| Admin Advanced Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "adminlte" middleware group. Now create something great!
|
*/

/*Route::any('/', 'GrafanaController@index');
Route::any('/{path}', 'GrafanaController@index')
        ->where('path', '([A-z0-9-\/_.]+)?');*/


Route::namespace('API')
    ->middleware(\App\Http\Middleware\AdminLTEAPIMiddleware::class)
    ->prefix('api')
    ->group(function () {
    	Route::prefix('adminlteadvied')->group(function () {
        Route::get('/get_template/{id}', 'AdvancedImportExportDataController@get_template');
        Route::get('/get_template_list/{type}', 'AdvancedImportExportDataController@get_template_list');
        Route::post('/post_template', 'AdvancedImportExportDataController@post_template');
        Route::post('/delete_template', 'AdvancedImportExportDataController@delete_template');
        Route::get('/get_database_list', 'AdvancedImportExportDataController@get_database_list');
        Route::post('/post_database', 'AdvancedImportExportDataController@post_database');
        Route::post('/delete_database', 'AdvancedImportExportDataController@delete_database');
        Route::get('/get_databasetype_list', 'AdvancedImportExportDataController@get_databasetype_list');
        Route::get('/get_actionlist/{template_id}', 'AdvancedImportExportDataController@get_actionlist');
        Route::get('/get_variable_option_list', 'AdvancedImportExportDataController@get_variable_option_list');
        Route::get('/get_result_option_list', 'AdvancedImportExportDataController@get_result_option_list');
        Route::post('/post_action', 'AdvancedImportExportDataController@post_action');
        Route::post('/delete_action', 'AdvancedImportExportDataController@delete_action');
        Route::get('/get_validationlist/{template_id}', 'AdvancedImportExportDataController@get_validationlist');
        Route::post('/post_validation', 'AdvancedImportExportDataController@post_validation');
        Route::post('/delete_validation', 'AdvancedImportExportDataController@delete_validation');
        Route::get('/get_querylist/{template_id}', 'AdvancedImportExportDataController@get_querylist');
        Route::post('/post_query', 'AdvancedImportExportDataController@post_query');
        Route::post('/delete_query', 'AdvancedImportExportDataController@delete_query');
        Route::get('/get_database_option_list', 'AdvancedImportExportDataController@get_database_option_list');
        Route::get('/get_import_form', 'AdvancedImportExportDataController@get_import_form');
        Route::post('/post_import_form', 'AdvancedImportExportDataController@post_import_form');
        Route::get('/get_template_option_list/{type}', 'AdvancedImportExportDataController@get_template_option_list');
        Route::get('/get_parameterlist/{template_id}', 'AdvancedImportExportDataController@get_parameterlist');
        Route::post('/post_parameter', 'AdvancedImportExportDataController@post_parameter');
        Route::post('/delete_parameter', 'AdvancedImportExportDataController@delete_parameter');
        Route::get('/get_export_form', 'AdvancedImportExportDataController@get_export_form');
        Route::post('/post_export_form', 'AdvancedImportExportDataController@post_export_form');
        Route::get('/get_export_table/{template_id}', 'AdvancedImportExportDataController@get_export_table');
    });
});