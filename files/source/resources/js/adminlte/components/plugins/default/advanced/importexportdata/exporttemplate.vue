<template>
    <div class="content-wrapper">
        <server-error v-if="page.has_server_error" ></server-error>
        <permission-error v-else-if="!page.is_authorized" :type="page.unauthorized_type"></permission-error>
        <div v-else>
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{TemplateForm.title}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><router-link :to="'/' + main_folder + '/home'">{{ $t('Home') }}</router-link></li>
                            <li class="breadcrumb-item"><router-link :to="'/' + main_folder + '/adminlteadvied_export'">{{ $t("Export") }}</router-link></li>
                            <li class="breadcrumb-item active">{{ $t("Template Detail") }}</li>
                        </ol>
                    </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12 ">
                            <div class="card">
                                <div class="action-buttons-container sbp-item" advied-permission-token="advied_admin">
                                    <button type="button"
                                        class="btn btn-danger btn-md btn-on-card btn-card-default text-white float-right"
                                        @click="deleteObject(id)">
                                        <i class="fas fa-times" aria-hidden="true"></i> <span>{{ $t('Delete') }}</span>
                                    </button>
                                    <button type="button"
                                        @click="showTemplateEdit()"
                                        class="btn btn-warning btn-sm text-white btn-on-table">
                                        <i class="fas fa-pencil-alt"></i>&nbsp;{{ $t('Edit') }}
                                    </button>
                                </div>
                            </div>

                            <div class="card recordlist-card">
                                <div class="card-header">
                                    <h4 class="mb-0">{{  $t('Parameters') }}</h4>
                                    <button type="button"
                                        @click="showParameterEdit(0)"
                                        class="btn btn-primary btn-sm text-white float-right"
                                        style="position: absolute;right:1.25rem;top:0.75rem;">
                                        <i class="fas fa-plus"></i>&nbsp;{{ $t('Add') }}
                                    </button>
                                </div>
                                <div class="card-body" v-show="parameter_list.length > 0">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th><span>{{ $t('Title') }}</span></th>
                                                    <th><span>{{ $t('Type') }}</span></th>
                                                    <th style="width:100px;text-align:center;"><span>{{ $t('Enabled') }}</span></th>
                                                    <th class="text-center th-btn-1">
                                                        <span></span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodyUMDParameterRecordList">
                                                <tr v-for="row in parameter_list" :key="row.id">
                                                    <td v-html="row.title">
                                                    </td>
                                                    <td v-html="row.type">
                                                    </td>
                                                    <td class="text-center">
                                                        <span :class="'text-success spanIcon spanIconEnabled' + row.enabled">
                                                            <i class="far fa-check-circle"></i>
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            @click="showParameterEdit(row.id)"
                                                            class="btn iconic-btn">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                        <button type="button"
                                                            @click="deleteParameter(row.id)"
                                                            class="btn iconic-btn delete-btn">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card recordlist-card">
                                <div class="card-header">
                                    <h4 class="mb-0">{{  $t('Database SQL Commands') }}</h4>
                                    <button type="button"
                                        @click="showQueryEdit(0)"
                                        class="btn btn-primary btn-sm text-white float-right"
                                        style="position: absolute;right:1.25rem;top:0.75rem;">
                                        <i class="fas fa-plus"></i>&nbsp;{{ $t('Add') }}
                                    </button>
                                </div>
                                <div class="card-body" v-show="querylist.length > 0">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th><span>{{ $t('Query') }}</span></th>
                                                    <th style="width:100px;text-align:center;"><span>{{ $t('Enabled') }}</span></th>
                                                    <th class="text-center th-btn-1">
                                                        <span></span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodyQueryRecordList">
                                                <tr v-for="row in querylist" :key="row.id">
                                                    <td v-html="row.query">
                                                    </td>
                                                    <td class="text-center">
                                                        <span :class="'text-success spanIcon spanIconEnabled' + row.enabled">
                                                            <i class="far fa-check-circle"></i>
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            @click="showQueryEdit(row.id)"
                                                            class="btn iconic-btn">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                        <button type="button"
                                                            @click="deleteQuery(row.id)"
                                                            class="btn iconic-btn delete-btn">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <div class="modal fade" id="modal-editTemplate" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $t('Export Template') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="min-height:350px;">
                        <form id="TemplateForm"
                            class=""
                            @submit.prevent="submitForm"
                            @keydown="TemplateForm.onKeydown($event)">
                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="col-lg-12">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox"
                                                id="TemplateForm_enabled"
                                                name="TemplateForm_enabled"
                                                class=""
                                                v-model="TemplateForm.enabled"/>
                                            <label for="TemplateForm_enabled" class="detail-label">
                                                {{ $t('Enabled') }}  
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="TemplateForm_title" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Title') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text"
                                            v-model="TemplateForm.title"
                                            class="form-control "
                                            id="TemplateForm_title"
                                            name="TemplateForm_title"
                                            :class="{ 'is-invalid': TemplateForm.errors.has('title') }">
                                        <has-error :form="TemplateForm" field="title"></has-error>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="TemplateForm_description" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Description') }}  </label>
                                    <div class="col-lg-12">
                                        <textarea id="TemplateForm_description"
                                            name="TemplateForm_description"
                                            v-model="TemplateForm.description"
                                            class="textarea vue-editor"
                                            rows="5" style="outline: none;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modalfooter justify-content-between sbp-item" advied-permission-token="advied_admin">
                        <div class="row">
                            <div class="col-md-12">
                                <button @click="saveTemplate"
                                    :disabled="TemplateForm.busy"
                                    type="button"
                                    class="btn btn-success btn-md btn-card-default btn-on-card float-right">
                                    {{ $t('Save') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary float-left" data-dismiss="modal" style="margin-right:10px;">{{ $t('Close') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="divParameterEditDialog" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $t('Parameter') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="ParameterForm" @submit.prevent="saveParameter" @keydown="ParameterForm.onKeydown($event)">
                            <input type="hidden"
                                id="ParameterForm_id"
                                name="ParameterForm_id"
                                class=""
                                v-model="ParameterForm.id"/>
                            <input type="hidden"
                                id="ParameterForm_template_id"
                                name="ParameterForm_template_id"
                                class=""
                                v-model="ParameterForm.template_id"/>

                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="col-lg-12">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox"
                                                id="ParameterForm_enabled"
                                                name="ParameterForm_enabled"
                                                class=""
                                                v-model="ParameterForm.enabled"/>
                                            <label for="ParameterForm_enabled" class="detail-label">
                                                {{ $t('Enabled') }}  
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="ParameterForm___order" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Order') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text"
                                            v-model="ParameterForm.__order"
                                            class="form-control "
                                            id="ParameterForm___order"
                                            name="ParameterForm___order"
                                            :class="{ 'is-invalid': ParameterForm.errors.has('__order') }">
                                        <has-error :form="ParameterForm" field="__order"></has-error>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="ParameterForm_title" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Title') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text"
                                            v-model="ParameterForm.title"
                                            class="form-control "
                                            id="ParameterForm_title"
                                            name="ParameterForm_title"
                                            :class="{ 'is-invalid': ParameterForm.errors.has('title') }">
                                        <has-error :form="ParameterForm" field="title"></has-error>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="ParameterForm_name" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Name') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text"
                                            v-model="ParameterForm.name"
                                            class="form-control "
                                            id="ParameterForm_name"
                                            name="ParameterForm_name"
                                            :class="{ 'is-invalid': ParameterForm.errors.has('name') }">
                                        <has-error :form="ParameterForm" field="name"></has-error>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="ParameterForm_type" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Type') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <select id="ParameterForm_type"
                                            name="ParameterForm_type"
                                            v-model="ParameterForm.type"
                                            class="form-control htmldb-select">
                                            <option value="">Please Select</option>
                                            <option value="shorttext">Short Text</option>
                                            <option value="number">Number</option>
                                            <option value="selection">Selection</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12"  id="inputSelectionOptions" style="display:none;">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="formParameterEdit-option_titles"><strong>Option Titles</strong></label>
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="formParameterEdit-option_values"><strong>Option Values</strong></label>
                                        </div>

                                        <div class="col-lg-6">
                                            <textarea rows="2"
                                                v-model="ParameterForm.option_titles"
                                                id="ParameterForm_option_titles"
                                                name="ParameterForm_option_titles"
                                                class="form-control  auto-size"
                                                :class="{ 'is-invalid': ParameterForm.errors.has('option_titles') }"
                                                style="overflow: hidden; overflow-wrap: break-word;"></textarea>
                                        </div>
                                        <div class="col-lg-6">
                                            <textarea rows="2"
                                                v-model="ParameterForm.option_values"
                                                id="ParameterForm_option_values"
                                                name="ParameterForm_option_values"
                                                class="form-control  auto-size"
                                                :class="{ 'is-invalid': ParameterForm.errors.has('option_values') }"
                                                style="overflow: hidden; overflow-wrap: break-word;"></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="ParameterForm_default" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Default Value') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text"
                                            v-model="ParameterForm.default"
                                            class="form-control "
                                            id="ParameterForm_default"
                                            name="ParameterForm_default"
                                            :class="{ 'is-invalid': ParameterForm.errors.has('default') }">
                                        <has-error :form="ParameterForm" field="default"></has-error>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modalfooter justify-content-between show_by_permission_must_update">
                        <div class="row">
                            <div class="col-md-12">
                                <button
                                    @click="saveParameter"
                                    :disabled="ParameterForm.busy"
                                    type="button"
                                    class="btn btn-success btn-md btn-card-default btn-on-card float-right">
                                    {{ $t('Save') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary float-left" data-dismiss="modal" style="margin-right:10px;">{{ $t('Close') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="divQueryEditDialog" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $t('Query') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="QueryForm" @submit.prevent="saveQuery" @keydown="QueryForm.onKeydown($event)">
                            <input type="hidden"
                                id="QueryForm_id"
                                name="QueryForm_id"
                                class=""
                                v-model="QueryForm.id"/>
                            <input type="hidden"
                                id="QueryForm_template_id"
                                name="QueryForm_template_id"
                                class=""
                                v-model="QueryForm.template_id"/>

                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="col-lg-12">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox"
                                                id="QueryForm_enabled"
                                                name="QueryForm_enabled"
                                                class=""
                                                v-model="QueryForm.enabled"/>
                                            <label for="QueryForm_enabled" class="detail-label">
                                                {{ $t('Enabled') }}  
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="QueryForm___order" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Order') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text"
                                            v-model="QueryForm.__order"
                                            class="form-control "
                                            id="QueryForm___order"
                                            name="QueryForm___order"
                                            :class="{ 'is-invalid': QueryForm.errors.has('__order') }">
                                        <has-error :form="QueryForm" field="__order"></has-error>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="QueryForm_database_id" class="detail-label col-form-label col-lg-12" style="height:45px;">
                                        <div style="display: inline-block;margin-top: 10px;">
                                            {{  $t('Database') }}  <span class="required">*</span>
                                        </div>
                                        <button v-show="!database_editable" type="button"
                                            @click="showDatabaseEdit"
                                            class="btn btn-primary btn-sm text-white float-right"
                                            style="">
                                            <i class="fas fa-plus"></i>&nbsp;{{ $t('Add Database') }}
                                        </button>
                                        <button v-show="database_editable" type="button"
                                            @click="showDatabaseEdit"
                                            class="btn btn-warning btn-sm text-white float-right"
                                            style="">
                                            <i class="fas fa-pencil-alt"></i>&nbsp;{{ $t('Edit Database') }}
                                        </button>
                                    </label>
                                    <div class="col-lg-12">
                                        <select2-element class="select2-element"
                                            data-placeholder=""
                                            id="QueryForm_database_id"
                                            name="QueryForm_database_id"
                                            :options="databaselist"
                                            v-model="QueryForm.database_id">
                                            <option></option>
                                        </select2-element>
                                        <input type="hidden" :class="{ 'is-invalid': QueryForm.errors.has('database_id') }">
                                        <has-error :form="QueryForm" field="database_id"></has-error>
                                    </div>
                                </div>
                               
                                <div class="col-lg-12 col-md-12 col-xs-12">
                                    <div class="card card-outline card-primary shadow-sm">
                                        <div class="card-header">
                                            <h3 class="card-title">{{ $t('Conditions') }}</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body p-2" style="display: block;">
                                            <div class="jsquerybuilder-container" id="processQueryConditionBuilderContainer"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="query" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('SQL Query') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <textarea rows="5"
                                            v-model="QueryForm.query"
                                            id="QueryForm_query"
                                            name="QueryForm_query"
                                            class="form-control"
                                            :class="{ 'is-invalid': QueryForm.errors.has('query') }"
                                            style="font-family: monospace;font-size: 15px;"></textarea>
                                        <has-error :form="QueryForm" field="query"></has-error>
                                    </div>
                                    <div class="col-lg-12" style="margin-top: 10px;">
                                        <div class="text-muted" style="font-size:14px;" v-pre>
                                            - Variables must be written in double curly braces (e.g. {{variable_name}}).<br>
                                            - Excel columns must be written in double curly braces (e.g. {{column_a}} for the column A).<br>
                                            - Template variables must be written in double curly braces (e.g. {{temp_1}} for Temp Variable 1).<br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modalfooter justify-content-between show_by_permission_must_update">
                        <div class="row">
                            <div class="col-md-12">
                                <button
                                    @click="saveQuery"
                                    :disabled="QueryForm.busy"
                                    type="button"
                                    class="btn-success btn-md btn-card-default btn-on-card float-right">
                                    {{ $t('Save') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary float-left" data-dismiss="modal" style="margin-right:10px;">{{ $t('Close') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-editDatabase" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $t('Database') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="min-height:350px;">
                        <form id="DatabaseForm"
                            class=""
                            @submit.prevent="submitForm"
                            @keydown="DatabaseForm.onKeydown($event)">
                            <div class="row">
                                <input type="hidden" v-model="DatabaseForm.type" id="type" name="type">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="col-lg-12">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox"
                                                id="DatabaseForm_enabled"
                                                name="DatabaseForm_enabled"
                                                class=""
                                                v-model="DatabaseForm.enabled"/>
                                            <label for="DatabaseForm_enabled" class="detail-label">
                                                {{ $t('Enabled') }}  
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="DatabaseForm_title" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">
                                        {{ $t('Title') }}  <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-12">
                                        <input type="text"
                                            v-model="DatabaseForm.title"
                                            class="form-control "
                                            id="DatabaseForm_title"
                                            name="DatabaseForm_title"
                                            :class="{ 'is-invalid': DatabaseForm.errors.has('title') }">
                                        <has-error :form="DatabaseForm" field="title"></has-error>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="DatabaseForm_database_type" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">
                                        {{  $t('Database Type') }}  <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-12">
                                        <select2-element class="select2-element"
                                            data-placeholder=""
                                            id="DatabaseForm_database_type"
                                            name="DatabaseForm_database_type"
                                            :options="database_type_options"
                                            v-model="DatabaseForm.database_type">
                                            <option></option>
                                        </select2-element>
                                        <input type="hidden" :class="{ 'is-invalid': DatabaseForm.errors.has('database_type') }">
                                        <has-error :form="DatabaseForm" field="database_type"></has-error>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="DatabaseForm_host" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Host') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text"
                                            v-model="DatabaseForm.host"
                                            class="form-control "
                                            id="DatabaseForm_host"
                                            name="DatabaseForm_host"
                                            :class="{ 'is-invalid': DatabaseForm.errors.has('host') }">
                                        <has-error :form="DatabaseForm" field="host"></has-error>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="DatabaseForm_database_name" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Database Name') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text"
                                            v-model="DatabaseForm.database_name"
                                            class="form-control "
                                            id="DatabaseForm_database_name"
                                            name="DatabaseForm_database_name"
                                            :class="{ 'is-invalid': DatabaseForm.errors.has('database_name') }">
                                        <has-error :form="DatabaseForm" field="database_name"></has-error>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="DatabaseForm_username" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Username') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text"
                                            v-model="DatabaseForm.username"
                                            class="form-control "
                                            id="DatabaseForm_username"
                                            name="DatabaseForm_username"
                                            :class="{ 'is-invalid': DatabaseForm.errors.has('username') }">
                                        <has-error :form="DatabaseForm" field="username"></has-error>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="DatabaseForm_password" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Password') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="password"
                                            v-model="DatabaseForm.password"
                                            class="form-control "
                                            id="DatabaseForm_password"
                                            name="DatabaseForm_password"
                                            :class="{ 'is-invalid': DatabaseForm.errors.has('password') }">
                                        <has-error :form="DatabaseForm" field="password"></has-error>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="DatabaseForm_port" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Port') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text"
                                            v-model="DatabaseForm.port"
                                            class="form-control "
                                            id="DatabaseForm_port"
                                            name="DatabaseForm_port"
                                            :class="{ 'is-invalid': DatabaseForm.errors.has('port') }">
                                        <has-error :form="DatabaseForm" field="port"></has-error>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                    <div class="modalfooter justify-content-between show_by_permission_must_update">
                        <div class="row">
                            <div class="col-md-12">
                                <button v-if="0 != selected_database_id"
                                    type="button"
                                    class="btn btn-danger btn-md btn-on-card btn-card-default text-white float-left"
                                    @click="deleteDatabase">
                                    <i class="fas fa-times" aria-hidden="true"></i> <span>{{ $t('Delete') }}</span>
                                </button>
                                <button
                                    @click="saveDatabase"
                                    :disabled="DatabaseForm.busy"
                                    type="button"
                                    class="btn btn-success btn-md btn-card-default btn-on-card float-right">
                                    {{ $t('Save') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary float-left" data-dismiss="modal" style="margin-right:10px;">{{ $t('Close') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <body-loader :body_loader_active="body_loader_active" class="content-wrapper bodyLoader"></body-loader>
        <script id="action-operation-condition-rule-template-header" type="text/html">
            <select class="form-control action-operation-condition-rule-type" id="%id%_type" data-rule-name="%id%">
                <option value="1" selected>Constant</option>
                <option value="2">Variable</option>
            </select>
            <select class="form-control d-none action-operation-condition-rule-variable"
                    id="%id%_variable"
                    data-rule-name="%id%">
        </script>
        <script id="action-operation-condition-rule-template-footer" type="text/html">
            </select>
            <input class="form-control action-operation-condition-rule-constant"
                    type="text"
                    id="%id%_constant"
                    data-rule-name="%id%" />
        </script>
        <script id="action-operation-list-item-template" type="text/html">
            <span class="action-operation-title">%title%</span><br>
            <span class="action-operation-result">%result%</span>
            <span class="action-operation-parameters">%parameters%</span>
        </script>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                main_folder: '',
                data: {},
                id: 0,
                TemplateForm: new Form({
                    'debug_mode': false,
                    'id': 0,
                    'enabled': false,
                    'title': '',
                    'description': '',
                    'type': 0
                }),
                formDelete: new Form({
                    'selected_ids': []
                }),
                delete_form: {
                    has_error: false,
                    error_msg: ''
                },
                ParameterForm: new Form({
                    'debug_mode': false,
                    'id': 0,
                    'template_id': 0,
                    'enabled': false,
                    'title': '',
                    'name': '',
                    'type': '',
                    'option_titles': '',
                    'option_values': '',
                    'default': '',
                    '__order': ''
                }),
                formParameterDelete: new Form({
                    'selected_ids': []
                }),
                parameter_list: [],
                variable_option_list: [],
                result_option_list: [],
                QueryForm: new Form({
                    'debug_mode': false,
                    'id': 0,
                    'template_id': 0,
                    'database_id': 0,
                    'enabled': false,
                    'query': '',
                    'condition_json': '',
                    '__order': ''
                }),
                formQueryDelete: new Form({
                    'selected_ids': []
                }),
                querylist: [],
                databaselist: [],
                database_type_options: [],
                database_editable: false,
                selected_database_id: 0,
                DatabaseForm: new Form({
                    'debug_mode': false,
                    'id': 0,
                    'enabled': false,
                    'title': '',
                    'database_type': '',
                    'host': '',
                    'database_name': '',
                    'username': '',
                    'password': '',
                    'port': ''
                }),
                formDatabaseDelete: new Form({
                    'selected_ids': []
                }),
                page: {
                    is_ready: false,
                    has_server_error: false,
                    variables: [],
                    is_authorized: true,
                    unauthorized_type: '',
                    is_variables_loading: false,
                    is_variables_loaded: false,
                    is_parameter_list_loading: false,
                    is_parameter_list_loaded: false,
                    is_variable_option_list_loading: false,
                    is_variable_option_list_loaded: false,
                    is_querylist_loading: false,
                    is_querylist_loaded: false,
                    is_database_type_options_loading: false,
                    is_database_type_options_loaded: false,
                    is_databaselist_loading: false,
                    is_databaselist_loaded: false,
                    is_result_option_list_loading: false,
                    is_result_option_list_loaded: false,
                    is_data_loading: false,
                    is_data_loaded: false,
                    external_files: [
                        ("/js/adminlte/jsquerybuilder/css/query-builder.default.min-custom.css"),
                        ("/js/adminlte/jsquerybuilder/js/query-builder.standalone.min.js")
                    ],
                },
                body_loader_active: false,
                action_function_index_by_id: [],
                action_variable_list_options: [],
                action_variable_index_by_id: [],
            };
        },
        methods: {
            renderDatabaseButton: function(selected_database_id) {
                if ("" == selected_database_id || 0 == selected_database_id) {
                    this.selected_database_id = 0;
                    this.database_editable = false;
                    return false;
                }

                this.selected_database_id = selected_database_id;
                this.database_editable = true;
                return true;
            },
            showDatabaseEdit: function () {
                var selected_id = this.selected_database_id;

                this.DatabaseForm.id = 0;
                this.DatabaseForm.enabled = 0;
                this.DatabaseForm.title = "";

                if (selected_id > 0) {
                    var object = this.getDatabaseById(selected_id);
                    this.DatabaseForm.fill(object);
                }

                $('#modal-editDatabase').modal();
            },
            getDatabaseById: function(id) {
                var object = null;
                this.databaselist.forEach(element => {
                    if (id == element.id) {
                        object = element;
                    } 
                });

                return object;
            },
            saveDatabase: function () {
                var self = this;
                self.$Progress.start();
                self.DatabaseForm.post(AdminLTEHelper.getAPIURL("adminlteadvied/post_database"))
                    .then(({ data }) => {
                    self.$Progress.finish();
                    self.id = data.id;
                    self.page.has_post_error = data.has_error;
                    self.page.post_error_msg = data.error_msg;
                    self.page.has_server_error = false;
                }).catch(({ data }) => {
                        self.$Progress.fail();
                        let errors = (self.DatabaseForm.errors.errors);
                        if (undefined !== errors.error) {
                            self.page.has_server_error = true;
                        } else {
                            self.page.has_post_error = true;
                            self.page.post_error_msg = self.DatabaseForm.errors.errors.parameter_error;
                        }
                    }).finally(function() {
                        if (!self.page.has_server_error) {
                            if (!self.page.has_post_error) {
                                Vue.swal.fire({
                                    position: 'top-end',
                                    title: self.$t("Your changes have been saved!"),
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    onClose: () => {
                                        self.load_databaselist();
                                        $('#modal-editDatabase').modal("hide");
                                    }
                                });
                            } else {
                                Vue.swal.fire({
                                    position: 'top-end',
                                    title: self.page.post_error_msg,
                                    icon: 'error',
                                    showConfirmButton: false,
                                    timer: 10000,
                                    timerProgressBar: true
                                });
                            }
                        }
                    });
            },
            deleteDatabase: function() {
                var self = this;
                Vue.swal.fire({
                    title: self.$t("Bu kayıt silinecektir."),
                    text: self.$t("Do you confirm?"),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: self.$t("Continue"),
                    cancelButtonText: self.$t("Cancel")
                }).then((result) => {
                    if (result.isConfirmed) {
                        self.formDatabaseDelete.selected_ids.push(self.selected_database_id);
                        self.submitDatabaseDeleteForm();
                    }
                });
            },
            submitDatabaseDeleteForm: function () {
                var self = this;
                self.$Progress.start();
                self.formDatabaseDelete.post(AdminLTEHelper.getAPIURL("adminlteadvied/delete_database"))
                    .then(({ data }) => {
                        self.$Progress.finish();
                        self.delete_form.has_error = data.has_error;
                        self.delete_form.error_msg = data.error_msg;
                    }).catch(({ data }) => {
                        self.$Progress.fail();
                    }).finally(function(){
                        if (!self.delete_form.has_error) {
                            Vue.swal.fire({
                                position: 'top-end',
                                title: self.$t("Bu kayıt silinmiştir."),
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                onClose: () => {
                                    self.load_databaselist();
                                    $('#modal-editDatabase').modal("hide");
                                }                            
                            }); 
                        } else {
                            Vue.swal.fire({
                                position: 'top-end',
                                title: self.delete_form.error_msg,
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 10000,
                                timerProgressBar: true
                            });
                        }
                    });
            },
            load_database_type_options: function () {
                if (this.page.is_database_type_options_loading) {
                    return;
                }

                this.page.is_database_type_options_loading = true;
                
                axios.get(AdminLTEHelper.getAPIURL("adminlteadvied/get_databasetype_list"))
                    .then(({ data }) => {
                        this.page.is_database_type_options_loaded = true;
                        this.page.is_database_type_options_loading = false;
                        this.database_type_options = data.list;
                        this.processLoadQueue();
                    }).catch(({ data }) => {
                        this.page.is_database_type_options_loaded = true;
                        this.page.is_database_type_options_loading = false;
                        this.$Progress.fail();
                        this.processLoadQueue();
                    });
            },
            saveTemplate: function () {
                var self = this;
                self.$Progress.start();
                self.TemplateForm.post(AdminLTEHelper.getAPIURL("adminlteadvied/post_template"))
                    .then(({ data }) => {
                    self.$Progress.finish();
                    self.id = data.id;
                    self.page.has_post_error = data.has_error;
                    self.page.has_server_error = false;
                }).catch(({ data }) => {
                        self.$Progress.fail();
                        let errors = (self.TemplateForm.errors.errors);
                        if (undefined !== errors.error) {
                            self.page.has_server_error = true;
                        } else {
                            self.page.has_post_error = true;
                            self.page.post_error_msg = self.$t("Your changes could not be saved. Please check your details and try again.");
                        }
                    }).finally(function() {
                        if (!self.page.has_server_error) {
                            if (!self.page.has_post_error) {
                                Vue.swal.fire({
                                    position: 'top-end',
                                    title: self.$t("Your changes have been saved!"),
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    onClose: () => {
                                        self.body_loader_active = true;
                                        self.processLoadQueue();
                                        $('#modal-editTemplate').modal("hide");
                                    }
                                });
                            } else {
                                Vue.swal.fire({
                                    position: 'top-end',
                                    title: self.page.post_error_msg,
                                    icon: 'error',
                                    showConfirmButton: false,
                                    timer: 10000,
                                    timerProgressBar: true
                                });
                            }
                        }
                    });
            },
            processLoadQueue: function () {
                var self = this;

                if (self.page.has_server_error) {
                    self.$Progress.finish();
                    self.page.is_ready = true;
                    setTimeout(function() {
                        self.body_loader_active = false;
                    }, 500);
                    return;
                }

                if (!self.page.is_authorized) {
                    self.$Progress.finish();
                    self.page.is_ready = true;
                    setTimeout(function() {
                        self.body_loader_active = false;
                    }, 500);
                    return;
                }

                if (!self.page.is_variables_loaded 
                    && !self.page.is_parameter_list_loaded 
                    && !self.page.is_querylist_loaded 
                    && !self.page.is_data_loaded) {
                    self.$Progress.start();
                }
                
                if (!self.page.is_variables_loaded) {
                    self.loadPageVariables();
                } else {
                    if (!self.page.is_parameter_list_loaded) {
                        self.load_parameter_list();
                    }

                    if (!self.page.is_variable_option_list_loaded) {
                        self.load_variable_option_list();
                    }

                    if (!self.page.is_result_option_list_loaded) {
                        self.load_result_option_list();
                    }

                    if (!self.page.is_querylist_loaded) {
                        self.load_querylist();
                    }

                    if (!self.page.is_database_type_options_loaded) {
                        self.load_database_type_options();
                    }

                    if (!self.page.is_databaselist_loaded) {
                        self.load_databaselist();
                    }

                    if (!self.page.is_data_loaded) {
                        self.loadTemplateData(function(){
                            setTimeout(function() {
                                AdminLTEHelper.initializePermissions(self.page.variables, false);

                                $("#QueryForm_database_id").on("change",function(e){
                                    self.renderDatabaseButton(e.target.value);
                                });

                                self.$Progress.finish();
                                self.page.is_ready = true;
                                self.body_loader_active = false;
                            }, 500);
                        });
                    }

                    $("#ParameterForm_type").on("change", function () {
                        self.doParameterTypeChange(this.value);
                    });
                }
            },
            doParameterTypeChange: function(type) {
                document.getElementById("inputSelectionOptions").style.display = "none";

                if ("selection" == type) {
                    document.getElementById("inputSelectionOptions").style.display = "block";
                }
            },
            loadPageVariables: function () {
                var self = this;

                if (self.page.is_variables_loading) {
                    return;
                }

                self.page.is_variables_loading = true;
                self.page.is_variables_loaded = true;
                axios.get(AdminLTEHelper.getAPIURL("adminlte/get_page_variables/proje"))
                    .then(({ data }) => {
                        self.page.is_variables_loaded = true;
                        self.page.is_variables_loading = false;
                        self.page.variables = data;
                    }).catch(({ data }) => {
                        self.page.is_variables_loaded = true;
                        self.page.is_variables_loading = false;
                        self.$Progress.fail();
                        self.page.has_server_error = true;
                        self.processLoadQueue();
                    }).finally(function() {
                        /* let authorize = {};
                        authorize = AdminLTEHelper.hasUserProtabAuthorized(self.page.variables, 'view_proje_uretim_islemi');
                        self.page.is_authorized = authorize.status;
                        self.page.unauthorized_type = authorize.type; */
                        self.processLoadQueue();
                    });

                    self.processLoadQueue();
            },
            load_variable_option_list: function () {
                var self = this;

                if (self.page.is_variable_option_list_loading) {
                    return;
                }

                self.page.is_variable_option_list_loading = true;
                
                axios.get(AdminLTEHelper.getAPIURL("adminlteadvied/get_variable_option_list"))
                    .then(({ data }) => {
                        self.page.is_variable_option_list_loaded = true;
                        self.page.is_variable_option_list_loading = false;
                        self.variable_option_list = data.list;
                        self.initializeVariableListOptions();
                        self.processLoadQueue();
                    }).catch(({ data }) => {
                        self.page.is_variable_option_list_loaded = true;
                        self.page.is_variable_option_list_loading = false;
                        self.$Progress.fail();
                        self.processLoadQueue();
                    });
            },
            initializeVariableListOptions: function() {
                var self = this;

                var VariableList = self.variable_option_list;
                var variableLength = VariableList.length;
                var Variable = null;
                var options = [];
                var option = null;

                for (var i = 0; i < variableLength; i++) {
                    Variable = VariableList[i];
                    
                    option = {};
                    option["id"] = Variable["id"];
                    option["index"] = i;
                    option["text"] = Variable["text"];

                    options.push(option);
                }

                self.action_variable_list_options =self.variable_option_list;
                self.createLookupListFromOptions(self.variable_option_list, "id");
            },
            createLookupListFromOptions: function(options, keyProperty) {
                var optionCount = options.length;
                var option = null;
                var lookupList = {};

                for (var i = 0; i < optionCount; i++) {
                    option = options[i];

                    if (option[keyProperty] != undefined) {
                        lookupList[option[keyProperty]] = i;
                    }
                }

                this.action_variable_index_by_id = lookupList;
            },
            load_result_option_list: function () {
                var self = this;

                if (self.page.is_result_option_list_loading) {
                    return;
                }

                self.page.is_result_option_list_loading = true;
                
                axios.get(AdminLTEHelper.getAPIURL("adminlteadvied/get_result_option_list"))
                    .then(({ data }) => {
                        self.page.is_result_option_list_loaded = true;
                        self.page.is_result_option_list_loading = false;
                        self.result_option_list = data.list;
                        self.processLoadQueue();
                    }).catch(({ data }) => {
                        self.page.is_result_option_list_loaded = true;
                        self.page.is_result_option_list_loading = false;
                        self.$Progress.fail();
                        self.processLoadQueue();
                    });
            },
            load_parameter_list: function () {
                var self = this;

                if (self.page.is_parameter_list_loading) {
                    return;
                }

                self.page.is_parameter_list_loading = true;
                
                axios.get(AdminLTEHelper.getAPIURL("adminlteadvied/get_parameterlist/" + self.id))
                    .then(({ data }) => {
                        self.page.is_parameter_list_loaded = true;
                        self.page.is_parameter_list_loading = false;
                        self.parameter_list = data.list;
                        self.processLoadQueue();
                    }).catch(({ data }) => {
                        self.page.is_parameter_list_loaded = true;
                        self.page.is_parameter_list_loading = false;
                        self.$Progress.fail();
                        self.processLoadQueue();
                    });
            },
            loadTemplateData: function (callback) {
                var self = this;

                axios.get(AdminLTEHelper.getAPIURL("adminlteadvied/get_template/" + self.id))
                    .then(({ data }) => {
                        self.data = data;
                        self.TemplateForm.id = data.template.id;
                        self.TemplateForm.enabled = data.template.enabled;
                        self.TemplateForm.title = data.template.title;
                        self.TemplateForm.description = data.template.description;
                        self.TemplateForm.type = data.template.type;
                    }).catch(({ data }) => {
                        self.$Progress.fail();
                    }).finally(function() {
                        callback();
                    });
            },
            deleteObject: function(id) {
                var self = this;
                Vue.swal.fire({
                    title: self.$t("Bu kayıt silinecektir."),
                    text: self.$t("Do you confirm?"),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: self.$t("Continue"),
                    cancelButtonText: self.$t("Cancel")
                }).then((result) => {
                    if (result.isConfirmed) {
                        self.formDelete.selected_ids.push(id);
                        self.submitTemplateDeleteForm();
                    }
                });
            },
            submitTemplateDeleteForm: function () {
                var self = this;
                self.$Progress.start();
                self.formDelete.post(AdminLTEHelper.getAPIURL("adminlteadvied/delete_template"))
                    .then(({ data }) => {
                        self.$Progress.finish();
                        self.delete_form.has_error = data.has_error;
                        self.delete_form.error_msg = data.error_msg;
                    }).catch(({ data }) => {
                        self.$Progress.fail();
                    }).finally(function(){
                        if (!self.delete_form.has_error) {
                            Vue.swal.fire({
                                position: 'top-end',
                                title: self.$t("Bu kayıt silinmiştir."),
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                onClose: () => {
                                    self.$router.push('/' + self.main_folder + '/adminlteadvied_export');
                                }                            
                            }); 
                        } else {
                            Vue.swal.fire({
                                position: 'top-end',
                                title: self.delete_form.error_msg,
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 10000,
                                timerProgressBar: true
                            });
                        }
                    });
            },
            showTemplateEdit: function () {
                $('#modal-editTemplate').modal();
            },
            showParameterEdit: function (id) {
                this.ParameterForm.id = 0;
                this.ParameterForm.template_id = this.TemplateForm.id;
                this.ParameterForm.enabled = true;
                this.ParameterForm.__order = "0";
                this.ParameterForm.title = "";
                this.ParameterForm.name = "";
                this.ParameterForm.type = "";
                this.ParameterForm.option_titles = "";
                this.ParameterForm.option_values = "";
                this.ParameterForm.default = "";

                if (0 != id) {
                    var object = this.getParameterById(id);

                    this.ParameterForm.id = object["id"];
                    this.ParameterForm.template_id = object["template_id"];
                    this.ParameterForm.enabled = object["enabled"];
                    this.ParameterForm.__order = object["__order"];
                    this.ParameterForm.title = object["title"];
                    this.ParameterForm.name = object["name"];
                    this.ParameterForm.type = object["type"];

                    $("#ParameterForm_type").val(object["type"]);
                    $("#ParameterForm_type").trigger("change");

                    this.ParameterForm.option_titles = object["option_titles"];
                    this.ParameterForm.option_values = object["option_values"];
                    this.ParameterForm.default = object["default"];
                }

                $('#divParameterEditDialog').modal();
            },
            getParameterById: function(id) {
                var object = null;
                this.parameter_list.forEach(element => {
                    if (id == element.id) {
                        object = element;
                    } 
                });

                return object;
            },
            saveParameter: function () {
                var self = this;

                self.$Progress.start();
                self.ParameterForm.post(AdminLTEHelper.getAPIURL("adminlteadvied/post_parameter"))
                    .then(({ data }) => {
                        self.$Progress.finish();
                        self.page.has_post_error = data.has_error;
                        self.page.has_server_error = false;
                    }).catch(({ data }) => {
                        self.$Progress.fail();
                        let errors = (self.ParameterForm.errors.errors);
                        if (undefined !== errors.error) {
                            self.page.has_server_error = true;
                        } else {
                            self.page.has_post_error = true;
                            self.page.post_error_msg = self.$t("Your changes could not be saved. Please check your details and try again.");
                        }
                    }).finally(function() {
                        if (!self.page.has_server_error) {
                            if (!self.page.has_post_error) {
                                $("#divParameterEditDialog").modal("hide");
                                Vue.swal.fire({
                                    position: 'top-end',
                                    title: self.$t("Your changes have been saved!"),
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    onClose: () => {
                                        self.load_parameter_list();
                                    }
                                });
                            } else {
                                Vue.swal.fire({
                                    position: 'top-end',
                                    title: self.page.post_error_msg,
                                    icon: 'error',
                                    showConfirmButton: false,
                                    timer: 10000,
                                    timerProgressBar: true
                                });
                            }
                        }
                    });
            },
            deleteParameter: function(id) {
                var self = this;
                Vue.swal.fire({
                    title: self.$t("Bu kayıt silinecektir."),
                    text: self.$t("Do you confirm?"),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: self.$t("Continue"),
                    cancelButtonText: self.$t("Cancel")
                }).then((result) => {
                    if (result.isConfirmed) {
                        self.formParameterDelete.selected_ids.push(id);
                        self.submitDeleteParameterForm();
                    }
                });
            },
            submitDeleteParameterForm: function () {
                var self = this;
                self.$Progress.start();
                self.formParameterDelete.post(AdminLTEHelper.getAPIURL("adminlteadvied/delete_parameter"))
                    .then(({ data }) => {
                        self.$Progress.finish();
                        self.delete_form.has_error = data.has_error;
                        self.delete_form.error_msg = data.error_msg;
                    }).catch(({ data }) => {
                        self.$Progress.fail();
                    }).finally(function(){
                        if (!self.delete_form.has_error) {
                            Vue.swal.fire({
                                position: 'top-end',
                                title: self.$t("Bu kayıt silinmiştir."),
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                onClose: () => {
                                    self.load_parameter_list();
                                }                            
                            }); 
                        } else {
                            Vue.swal.fire({
                                position: 'top-end',
                                title: self.delete_form.error_msg,
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 10000,
                                timerProgressBar: true
                            });
                        }
                    });
            },
            load_querylist: function () {
                var self = this;

                if (self.page.is_querylist_loading) {
                    return;
                }

                self.page.is_querylist_loading = true;
                
                axios.get(AdminLTEHelper.getAPIURL("adminlteadvied/get_querylist/" + self.id))
                    .then(({ data }) => {
                        self.page.is_querylist_loaded = true;
                        self.page.is_querylist_loading = false;
                        self.querylist = data.list;
                        self.processLoadQueue();
                    }).catch(({ data }) => {
                        self.page.is_querylist_loaded = true;
                        self.page.is_querylist_loading = false;
                        self.$Progress.fail();
                        self.processLoadQueue();
                    });
            },
            load_databaselist: function () {
                if (this.page.is_databaselist_loading) {
                    return;
                }

                this.page.is_databaselist_loading = true;
                
                axios.get(AdminLTEHelper.getAPIURL("adminlteadvied/get_database_option_list"))
                    .then(({ data }) => {
                        this.page.is_databaselist_loaded = true;
                        this.page.is_databaselist_loading = false;
                        this.databaselist = data.list;
                        this.processLoadQueue();
                    }).catch(({ data }) => {
                        this.page.is_databaselist_loaded = true;
                        this.page.is_databaselist_loading = false;
                        this.$Progress.fail();
                        this.processLoadQueue();
                    });
            },
            showQueryEdit: function (id) {
                this.cleanQueryEditForm();

                if (0 == id) {
                    this.initializeJSQueryBuilder(document.getElementById("processQueryConditionBuilderContainer"), null);
                } else {
                    this.fillQueryEditForm(id);
                }

                $('#divQueryEditDialog').modal();
            },
            cleanQueryEditForm: function() {
                this.QueryForm.id = 0;
                this.QueryForm.template_id = this.TemplateForm.id;
                this.QueryForm.database_id = 0;
                this.QueryForm.enabled = true;
                this.QueryForm.__order = "0";
                this.QueryForm.query = "";
                this.QueryForm.condition_json = "";
            },
            fillQueryEditForm: function(id) {
                var object = this.getQueryById(id);

                this.QueryForm.id = object["id"];
                this.QueryForm.template_id = object["template_id"];
                this.QueryForm.database_id = object["database_id"];
                this.QueryForm.enabled = object["enabled"];
                this.QueryForm.__order = object["__order"];
                this.QueryForm.query = object["query"];
                this.QueryForm.condition_json = object["condition"];

                this.initializeJSQueryBuilder(document.getElementById("processQueryConditionBuilderContainer"), JSON.parse(object["condition"]));
            },
            getQueryById: function(id) {
                var object = null;
                this.querylist.forEach(element => {
                    if (id == element.id) {
                        object = element;
                    } 
                });

                return object;
            },
            saveQuery: function () {
                var self = this;

                self.QueryForm.condition_json = JSON.stringify($("#processQueryConditionBuilderContainer").queryBuilder("getRules", { allow_invalid: true }));

                self.$Progress.start();
                self.QueryForm.post(AdminLTEHelper.getAPIURL("adminlteadvied/post_query"))
                    .then(({ data }) => {
                        self.$Progress.finish();
                        self.page.has_post_error = data.has_error;
                        self.page.has_server_error = false;
                    }).catch(({ data }) => {
                        self.$Progress.fail();
                        let errors = (self.QueryForm.errors.errors);
                        if (undefined !== errors.error) {
                            self.page.has_server_error = true;
                        } else {
                            self.page.has_post_error = true;
                            self.page.post_error_msg = self.$t("Your changes could not be saved. Please check your details and try again.");
                        }
                    }).finally(function() {
                        if (!self.page.has_server_error) {
                            if (!self.page.has_post_error) {
                                $("#divQueryEditDialog").modal("hide");
                                Vue.swal.fire({
                                    position: 'top-end',
                                    title: self.$t("Your changes have been saved!"),
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    onClose: () => {
                                        self.load_querylist();
                                    }
                                });
                            } else {
                                Vue.swal.fire({
                                    position: 'top-end',
                                    title: self.page.post_error_msg,
                                    icon: 'error',
                                    showConfirmButton: false,
                                    timer: 10000,
                                    timerProgressBar: true
                                });
                            }
                        }
                    });
            },
            deleteQuery: function(id) {
                var self = this;
                Vue.swal.fire({
                    title: self.$t("Bu kayıt silinecektir."),
                    text: self.$t("Do you confirm?"),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: self.$t("Continue"),
                    cancelButtonText: self.$t("Cancel")
                }).then((result) => {
                    if (result.isConfirmed) {
                        self.formQueryDelete.selected_ids.push(id);
                        self.submitDeleteQueryForm();
                    }
                });
            },
            submitDeleteQueryForm: function () {
                var self = this;
                self.$Progress.start();
                self.formQueryDelete.post(AdminLTEHelper.getAPIURL("adminlteadvied/delete_query"))
                    .then(({ data }) => {
                        self.$Progress.finish();
                        self.delete_form.has_error = data.has_error;
                        self.delete_form.error_msg = data.error_msg;
                    }).catch(({ data }) => {
                        self.$Progress.fail();
                    }).finally(function(){
                        if (!self.delete_form.has_error) {
                            Vue.swal.fire({
                                position: 'top-end',
                                title: self.$t("Bu kayıt silinmiştir."),
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                onClose: () => {
                                    self.load_querylist();
                                }                            
                            }); 
                        } else {
                            Vue.swal.fire({
                                position: 'top-end',
                                title: self.delete_form.error_msg,
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 10000,
                                timerProgressBar: true
                            });
                        }
                    });
            },
            // Helpers
            initializeJSQueryBuilder: function(container, condition) {
                var self = this;
                var options = self.action_variable_list_options;

                var filters = [];
                var variableCount = options.length;
                var operators = [
                    'equal',
                    'not_equal',
                    'in',
                    'not_in',
                    'less',
                    'less_or_equal',
                    'greater',
                    'greater_or_equal',
                    'begins_with',
                    'not_begins_with',
                    'contains',
                    'not_contains',
                    'ends_with',
                    'not_ends_with',
                    'is_empty',
                    'is_not_empty',
                    'is_null',
                    'is_not_null',
                    'is_integer',
                    'is_not_integer',
                    'is_numeric',
                    'is_not_numeric',
                    'matching_regex',
                    'not_matching_regex'
                ];

                for (var i = 0; i < variableCount; i++) {
                    filters.push({
                        "id": options[i]["id"],
                        "label": options[i]["text"],
                        "type": "string",
                        "operators": operators,
                        "input": self.inputJSQueryBuilder,
                        "valueSetter": self.setJSQueryBuilderInputValue,
                        "valueGetter": self.getJSQueryBuilderInputValue,
                        "input_event": ""
                    });
                }

                if ($(container).queryBuilder != undefined) {
                    $(container).queryBuilder("destroy");
                    container.innerHTML = "";
                }

                if (condition != null) {
                    if (0 == condition.rules.length) {
                        condition = null;
                    } else if (null == condition.rules[0].field) {
                        condition = null;
                    }
                }

                $(container).queryBuilder({
                    plugins: [],
                    validation: {
                        allow_empty_value: true
                    },
                    filters: filters,
                    rules: condition
                });

                $(container).on("change", function () {
                    self.changeJSQueryBuilderContainer(this);
                });
            },
            inputJSQueryBuilder: function (rule, name) {
                var self = this;
                var options = self.action_variable_list_options;

                var templateHeaderHTML = document
                        .getElementById(
                        "action-operation-condition-rule-template-header")
                        .innerHTML;
                var templateFooterHTML = document
                        .getElementById(
                        "action-operation-condition-rule-template-footer")
                        .innerHTML;
                var variableOptionsHTML = "";

                templateHeaderHTML = templateHeaderHTML.replace(/%id%/gi, name);
                templateFooterHTML = templateFooterHTML.replace(/%id%/gi, name);

                var variableCount = options.length;

                for (var i = 0; i < variableCount; i++) {
                    variableOptionsHTML += "<option value=\""
                            + options[i]["id"]
                            + "\">"
                            + options[i]["text"]
                            + "</option>";
                }

                return (templateHeaderHTML
                        + variableOptionsHTML
                        + templateFooterHTML);
            },
            setJSQueryBuilderInputValue: function (rule, value) {
                var self = this;
                var name = rule.id + "_value_0";
                var type = 1;

                if ("" == value) {
                    $("#" + name + "_type").val(1);
                    $("#" + name + "_constant").val(value);
                } else {
                    type = value[0];
                    value = value.substr(2);

                    $("#" + name + "_type").val(type);

                    if (1 == type) {
                        $("#" + name + "_constant").val(value);
                    } else {
                        $("#" + name + "_variable").val(value);
                    }
                }

                var targetElement = document.getElementById(name + "_type");
                if (targetElement != undefined) {
                    self.changeConditionRuleType(targetElement);
                }
            },
            getJSQueryBuilderInputValue: function (rule) {
                var name = rule.id + "_value_0";
                var type = $("#" + name + "_type").val();
                var value = "";

                if (1 == type) {
                    value = ("1;" + $("#" + name + "_constant").val());
                } else {
                    value = ("2;" + $("#" + name + "_variable").val());
                }
                return value;
            },
            changeJSQueryBuilderContainer: function (sender) {
                var self = this;
                $(".action-operation-condition-rule-type", sender).off("change").on("change", function () {
                    self.changeConditionRuleType(this);
                });
            },
            changeConditionRuleType: function (sender) {
                var type = $(sender).val();
                var name = sender.getAttribute("data-rule-name");
                var inputElement = document.getElementById(name + "_constant");
                var selectElement = document.getElementById(name + "_variable");

                $(inputElement).addClass("d-none");
                $(selectElement).addClass("d-none");

                if (type == 1) {
                    $(inputElement).removeClass("d-none");
                } else {
                    $(selectElement).removeClass("d-none");
                }
            },
            generateGUID: function(prefix) {

                var now = new Date();
                var token0 = String(now.getUTCFullYear())
                        + String((now.getUTCMonth() + 1))
                        + String(now.getUTCDate())
                        + String(now.getHours())
                        + String(now.getMinutes())
                        + String(now.getSeconds());
                var token1 = 'xxxx'.replace(/[xy]/g, function(c) {
                    var r = Math.random()*16|0,v=c=='x'?r:r&0x3|0x8;return v.toString(16);
                });
                var token2 = 'xxxx'.replace(/[xy]/g, function(c) {
                    var r = Math.random()*16|0,v=c=='x'?r:r&0x3|0x8;return v.toString(16);
                });  
                
                return prefix + token0 + token1 + token2;
            },
        },
        
        mounted() {
            this.id = this.$route.params.id;
            this.TemplateForm.id = this.id;
            this.main_folder = AdminLTEHelper.getMainFolder();
            this.body_loader_active = true;
            AdminLTEHelper.loadExternalFiles(this.page.external_files, this.processLoadQueue());
        }
    }
</script>