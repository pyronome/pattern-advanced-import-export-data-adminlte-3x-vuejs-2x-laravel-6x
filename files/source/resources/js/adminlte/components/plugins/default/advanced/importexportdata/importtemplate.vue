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
                            <li class="breadcrumb-item"><router-link :to="'/' + main_folder + '/adminlteadvied_import'">{{ $t("Import") }}</router-link></li>
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
                                    <h4 class="mb-0">{{  $t('Variables & Actions') }}</h4>
                                    <button type="button"
                                        @click="showActionEdit(0)"
                                        class="btn btn-primary btn-sm text-white float-right"
                                        style="position: absolute;right:1.25rem;top:0.75rem;">
                                        <i class="fas fa-plus"></i>&nbsp;{{ $t('Add') }}
                                    </button>
                                </div>
                                <div class="card-body" v-show="actionlist.length > 0">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th><span>{{ $t('Title') }}</span></th>
                                                    <th style="width:100px;text-align:center;"><span>{{ $t('Enabled') }}</span></th>
                                                    <th class="text-center th-btn-1">
                                                        <span></span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodyActionRecordList">
                                                <tr v-for="row in actionlist" :key="row.id">
                                                    <td v-html="row.title">
                                                    </td>
                                                    <td class="text-center">
                                                        <span :class="'text-success spanIcon spanIconEnabled' + row.enabled">
                                                            <i class="far fa-check-circle"></i>
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            @click="showActionEdit(row.id)"
                                                            class="btn iconic-btn">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                        <button type="button"
                                                            @click="deleteAction(row.id)"
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
                                    <h4 class="mb-0">{{  $t('Validation Rules') }}</h4>
                                    <button type="button"
                                        @click="showValidationEdit(0)"
                                        class="btn btn-primary btn-sm text-white float-right"
                                        style="position: absolute;right:1.25rem;top:0.75rem;">
                                        <i class="fas fa-plus"></i>&nbsp;{{ $t('Add') }}
                                    </button>
                                </div>
                                <div class="card-body" v-show="validationlist.length > 0">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover table-sm">
                                            <thead>
                                                <tr>
                                                    <th><span>{{ $t('Message') }}</span></th>
                                                    <th style="width:100px;text-align:center;"><span>{{ $t('Enabled') }}</span></th>
                                                    <th class="text-center th-btn-1">
                                                        <span></span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbodyValidationRecordList">
                                                <tr v-for="row in validationlist" :key="row.id">
                                                    <td v-html="row.message">
                                                    </td>
                                                    <td class="text-center">
                                                        <span :class="'text-success spanIcon spanIconEnabled' + row.enabled">
                                                            <i class="far fa-check-circle"></i>
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button"
                                                            @click="showValidationEdit(row.id)"
                                                            class="btn iconic-btn">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </button>
                                                        <button type="button"
                                                            @click="deleteValidation(row.id)"
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
                        <h4 class="modal-title">{{ $t('Import Template') }}</h4>
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

        <div id="divActionEditDialog" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $t('Action') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="ActionForm" @submit.prevent="saveAction" @keydown="ActionForm.onKeydown($event)">
                            <input type="hidden"
                                id="ActionForm_id"
                                name="ActionForm_id"
                                class=""
                                v-model="ActionForm.id"/>
                            <input type="hidden"
                                id="ActionForm_template_id"
                                name="ActionForm_template_id"
                                class=""
                                v-model="ActionForm.template_id"/>

                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="col-lg-12">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox"
                                                id="ActionForm_enabled"
                                                name="ActionForm_enabled"
                                                class=""
                                                v-model="ActionForm.enabled"/>
                                            <label for="ActionForm_enabled" class="detail-label">
                                                {{ $t('Enabled') }}  
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="ActionForm___order" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Order') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text"
                                            v-model="ActionForm.__order"
                                            class="form-control "
                                            id="ActionForm___order"
                                            name="ActionForm___order"
                                            :class="{ 'is-invalid': ActionForm.errors.has('__order') }">
                                        <has-error :form="ActionForm" field="__order"></has-error>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="ActionForm_title" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Title') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text"
                                            v-model="ActionForm.title"
                                            class="form-control "
                                            id="ActionForm_title"
                                            name="ActionForm_title"
                                            :class="{ 'is-invalid': ActionForm.errors.has('title') }">
                                        <has-error :form="ActionForm" field="title"></has-error>
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
                                            <div class="jsquerybuilder-container" id="processActionConditionBuilderContainer"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-xs-12">
                                    <div class="card card-outline card-primary shadow-sm">
                                        <div class="card-header">
                                            <h3 class="card-title">{{ $t('Operations') }}</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body p-2">
                                            <div class="col-lg-12 col-md-12 col-xs-12 text-right p-0 mb-2">
                                                <button type="button"
                                                        @click="clickAddOperationButton"
                                                        class="btn btn-primary btn-sm text-white">
                                                    <i class="fas fa-plus"></i>&nbsp;{{ $t('Add Operation') }}
                                                </button>
                                            </div>
                                            <div v-show="!show_action_operations" class="form-group col-lg-12 col-md-12 col-xs-12">
                                                <h5 class="text-center text-muted"><i class="fas fa-battery-empty"></i></h5>
                                                <h6 class="text-center text-muted">{{ $t('No items found!') }}</h6>
                                            </div>
                                            <div v-show="show_action_operations" class="col-lg-12 col-md-12 col-xs-12 p-0">
                                                <ul id="action-operation-list-container" class="checkbox-item-list sortable-item-list action-operation-list ui-sortable">
                                                    <li v-for="(item, index) in operations" :key="item.id" :data-item-id="item.id" class="list-item">
                                                        <div class="sortable-handle">
                                                            <span class="handle ui-sortable-handle">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </span>
                                                        </div>
                                                        <div class="main-text">
                                                            <a class="list-item-main-link" :id="'actionOperationLink' + index" href="JavaScript:void(0);" @click="clickEditActionOperationButton(index)" v-html="getActionOperationTitleHTML(index)"></a>
                                                        </div>
                                                        <div class="tools">
                                                            <button type="button" @click="clickActionOperationDeleteButton(index)" class="btn text-danger btn-block btn-sm"><i class="fas fa-times"></i></button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modalfooter justify-content-between show_by_permission_must_update">
                        <div class="row">
                            <div class="col-md-12">
                                <button @click="saveAction"
                                    :disabled="ActionForm.busy"
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

        <div id="divValidationEditDialog" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $t('Validation Rule') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="ValidationForm" @submit.prevent="saveValidation" @keydown="ValidationForm.onKeydown($event)">
                            <input type="hidden"
                                id="ValidationForm_id"
                                name="ValidationForm_id"
                                class=""
                                v-model="ValidationForm.id"/>
                            <input type="hidden"
                                id="ValidationForm_template_id"
                                name="ValidationForm_template_id"
                                class=""
                                v-model="ValidationForm.template_id"/>

                            <div class="row">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <div class="col-lg-12">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox"
                                                id="ValidationForm_enabled"
                                                name="ValidationForm_enabled"
                                                class=""
                                                v-model="ValidationForm.enabled"/>
                                            <label for="ValidationForm_enabled" class="detail-label">
                                                {{ $t('Enabled') }}  
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="ValidationForm___order" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Order') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text"
                                            v-model="ValidationForm.__order"
                                            class="form-control "
                                            id="ValidationForm___order"
                                            name="ValidationForm___order"
                                            :class="{ 'is-invalid': ValidationForm.errors.has('__order') }">
                                        <has-error :form="ValidationForm" field="__order"></has-error>
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
                                            <div class="jsquerybuilder-container" id="processValidationConditionBuilderContainer"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                    <label for="message" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">{{ $t('Message') }}  <span class="required">*</span></label>
                                    <div class="col-lg-12">
                                        <textarea rows="5"
                                            v-model="ValidationForm.message"
                                            id="ValidationForm_message"
                                            name="ValidationForm_message"
                                            class="form-control"
                                            :class="{ 'is-invalid': ValidationForm.errors.has('message') }"></textarea>
                                        <has-error :form="ValidationForm" field="message"></has-error>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modalfooter justify-content-between show_by_permission_must_update">
                        <div class="row">
                            <div class="col-md-12">
                                <button @click="saveValidation"
                                    :disabled="ValidationForm.busy"
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

        <div class="modal fade" id="modal-addEditOperation" tabindex="-1" role="dialog" data-operation-id="">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $t('Value') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="min-height:100px;">
                        <div class="row mt-20">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label for="AddEditOperationForm_function"><strong>Function</strong></label>
                                <select id="AddEditOperationForm_function"
                                        name="AddEditOperationForm_function"
                                        class="form-control htmldb-select">
                                    <option value="">Please Select</option>
                                    <option value="addition">Addition</option>
                                    <option value="division">Division</option>
                                    <option value="multiplication">Multiplication</option>
                                    <option value="subtraction">Subtraction</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div id="function-description-container" class="d-none">
                                    <div class="callout">
                                        <p id="function-description"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="AddEditOperationForm_parameter_container" class="parameter_container row mb-20 d-none">

                        </div>

                        <div id="AddEditOperationForm_result_container" class="result_container row d-none">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label for="AddEditOperationForm_result" class="detail-label">Result</label>
                                <select2-element class="select2-element"
                                    data-placeholder=""
                                    id="AddEditOperationForm_result"
                                    name="AddEditOperationForm_result"
                                    :options="action_variable_list_options">
                                </select2-element>
                            </div>
                        </div>

                        <script type="text/html" id="AddEditOperationForm_parameter_template_container">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <label for="AddEditOperationForm_f_%id%_p_%index%" class="detail-label">%title%</label>
                                <button id="AddEditOperationForm_f_%id%_p_%index%"
                                        type="button"
                                        data-parameter-title="%title%"
                                        data-parameter-index="%index%"
                                        data-parameter-id="%id%"
                                        data-parameter-type="%type%"
                                        data-parameter-default-type="%defaulttype%"
                                        data-parameter-required="%required%"
                                        data-parameter-default="%default%"
                                        data-parameter-value="%value%"
                                        data-parameter-display-text=""
                                        class="btn btn-default btn-block button-parameter text-left button_f_%id%_p_%index% parameter_type_%type%">%displaytext%</button>
                                <span id="AddEditOperationForm_f_%id%_p_%index%_error" class="error invalid-feedback"></span>
                            </div>
                        </script>
                    </div>
                    <div class="modalfooter justify-content-between show_by_permission_must_update">
                        <div class="row pt-20">
                            <div class="col-md-12">
                                <button type="button"
                                    id="button-addEditOperationSave"
                                    name="button-addEditOperationSave"
                                    @click="clickSaveOperationButton"
                                    class="btn btn-success float-right">
                                    {{ $t('Save') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary float-left" data-dismiss="modal" style="margin-right:10px;">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-functionParameterEdit" role="dialog" data-parameter-type="" data-parameter-id="" data-parameter-index="">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 id="header-functionParameterEdit" class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="body-functionParameterEdit" class="modal-body" style="min-height:100px;">
                        <div class="row parameter-input parameter-input-type-cv">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="icheck-primary d-inline">
                                    <input type="radio"
                                        id="AddEditFunctionParameterForm_constant_variable_radio0"
                                        name="AddEditFunctionParameterForm_constant_variable_radio"
                                        class=""
                                        @click="clickFunctionParameterConstantVariableRadio"
                                        value="1" />
                                    <label for="AddEditFunctionParameterForm_constant_variable_radio0" class="detail-label">
                                        {{ $t('Constant Value') }}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="icheck-primary d-inline">
                                    <input type="radio"
                                        id="AddEditFunctionParameterForm_constant_variable_radio1"
                                        name="AddEditFunctionParameterForm_constant_variable_radio"
                                        class=""
                                        @click="clickFunctionParameterConstantVariableRadio"
                                        value="2" />
                                    <label for="AddEditFunctionParameterForm_constant_variable_radio1" class="detail-label">
                                        {{ $t('Variable') }}
                                    </label>
                                </div>
                            </div>

                            <div class="form-group col-lg-12 col-md-12 col-sm-12 function-parameter-cv-input function-parameter-cv-input1 d-none">
                                <label for="AddEditFunctionParameterForm_cv_input1" class="detail-label">Constant Value</label>
                                <input type="text"
                                    class="form-control " 
                                    id="AddEditFunctionParameterForm_cv_input1"
                                    name="AddEditFunctionParameterForm_cv_input1">
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 function-parameter-cv-input function-parameter-cv-input2 d-none">
                                <label for="AddEditFunctionParameterForm_cv_input2" class="detail-label">Variable</label>
                                <select2-element class="select2-element"
                                    data-placeholder=""
                                    id="AddEditFunctionParameterForm_cv_input2"
                                    name="AddEditFunctionParameterForm_cv_input2"
                                    :options="action_variable_list_options">
                                </select2-element>
                            </div>
                        </div>
                    </div>
                    <div class="modalfooter justify-content-between show_by_permission_must_update">
                        <div class="row pt-20">
                            <div class="col-md-12">
                                <button type="button"
                                    id="button-functionParameterSave"
                                    name="button-functionParameterSave"
                                    @click="clickSaveFunctionParameterButton"
                                    class="btn btn-success float-right">
                                    {{ $t('Save') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary float-left" data-dismiss="modal" style="margin-right:10px;">Close</button>
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
                                <button @click="saveQuery"
                                    :disabled="QueryForm.busy"
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
                                <button @click="saveDatabase"
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
                ActionForm: new Form({
                    'debug_mode': false,
                    'id': 0,
                    'template_id': 0,
                    'enabled': false,
                    'title': '',
                    'condition_json': '',
                    'operation_json': '',
                    '__order': ''
                }),
                formActionDelete: new Form({
                    'selected_ids': []
                }),
                actionlist: [],
                variable_option_list: [],
                result_option_list: [],
                ValidationForm: new Form({
                    'debug_mode': false,
                    'id': 0,
                    'template_id': 0,
                    'enabled': false,
                    'message': '',
                    'condition_json': '',
                    '__order': ''
                }),
                formValidationDelete: new Form({
                    'selected_ids': []
                }),
                validationlist: [],
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
                    is_actionlist_loading: false,
                    is_actionlist_loaded: false,
                    is_validationlist_loading: false,
                    is_validationlist_loaded: false,
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
                show_action_operations: false,
                action_function_index_by_id: [],
                action_variable_list_options: [],
                action_variable_index_by_id: [],
                operations: [],
                operation_index_by_id: [],
                OperationFunctions: [
                    {
                        "id": "addition",
                        "enabled": true,
                        "title": "Addition",
                        "description": "Number 1 + Number 2<br>This function adds Number 1 and Number 2 and returns the result.",
                        "parameters": [
                            {
                                "title": "Number 1",
                                "type": "cv", // c: Constant, cv: ConstantOrVariable, l: List
                                "default_type": "c",
                                "required": true,
                                "default": null
                            },
                            {
                                "title": "Number 2",
                                "type": "cv", // c: Constant, cv: ConstantOrVariable, l: List
                                "default_type": "",
                                "required": true,
                                "default": null
                            }
                        ],
                        "has_result_parameter": true
                    },
                    {
                        "id": "division",
                        "enabled": true,
                        "title": "Division",
                        "description": "Number 1 / Number 2<br>This function divides Number 1 by Number 2 and returns the result.",
                        "parameters": [
                            {
                                "title": "Number 1",
                                "type": "cv", // c: Constant, cv: ConstantOrVariable, l: List
                                "default_type": "",
                                "required": true,
                                "default": null
                            },
                            {
                                "title": "Number 2",
                                "type": "cv", // c: Constant, cv: ConstantOrVariable, l: List
                                "default_type": "",
                                "required": true,
                                "default": null
                            }
                        ],
                        "has_result_parameter": true
                    },
                    {
                        "id": "multiplication",
                        "enabled": true,
                        "title": "Multiplication",
                        "description": "Number 1 * Number 2<br>This function multiplies Number 1 by Number 2 and returns the result.",
                        "parameters": [
                            {
                                "title": "Number 1",
                                "type": "cv", // c: Constant, cv: ConstantOrVariable, l: List
                                "default_type": "",
                                "required": true,
                                "default": null
                            },
                            {
                                "title": "Number 2",
                                "type": "cv", // c: Constant, cv: ConstantOrVariable, l: List
                                "default_type": "",
                                "required": true,
                                "default": null
                            }
                        ],
                        "has_result_parameter": true
                    },
                    {
                        "id": "subtraction",
                        "enabled": true,
                        "title": "Subtraction",
                        "description": "Number 1 - Number 2<br>This function substracts Number 2 from Number 1 and returns the result.",
                        "parameters": [
                            {
                                "title": "Number 1",
                                "type": "cv", // c: Constant, cv: ConstantOrVariable, l: List
                                "default_type": "",
                                "required": true,
                                "default": null
                            },
                            {
                                "title": "Number 2",
                                "type": "cv", // c: Constant, cv: ConstantOrVariable, l: List
                                "default_type": "",
                                "required": true,
                                "default": null
                            }
                        ],
                        "has_result_parameter": true
                    }
                ]
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
                    && !self.page.is_actionlist_loaded 
                    && !self.page.is_validationlist_loaded 
                    && !self.page.is_querylist_loaded 
                    && !self.page.is_data_loaded) {
                    self.$Progress.start();
                }
                
                if (!self.page.is_variables_loaded) {
                    self.loadPageVariables();
                } else {
                    if (!self.page.is_actionlist_loaded) {
                        self.load_actionlist();
                    }

                    if (!self.page.is_validationlist_loaded) {
                        self.load_validationlist();
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
                        let authorize = {};
                        authorize = AdminLTEHelper.hasUserADVIEDAuthorized(self.page.variables, 'advied_admin');
                        self.page.is_authorized = authorize.status;
                        self.page.unauthorized_type = authorize.type;
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
                        self.initializeFunctionList();
                        self.processLoadQueue();
                    }).catch(({ data }) => {
                        self.page.is_variable_option_list_loaded = true;
                        self.page.is_variable_option_list_loading = false;
                        self.$Progress.fail();
                        self.processLoadQueue();
                    });
            },
            initializeFunctionList: function() {
                var self = this;
                var processActionFunctionCount = self.OperationFunctions.length;
                var processActionFunction = null;
                var options = [];

                for (var i = 0; i < processActionFunctionCount; i++) {
                    processActionFunction = self.OperationFunctions[i];
                    self.action_function_index_by_id[processActionFunction.id] = i;
                }

                self.initializeVariableListOptions();

                $("#AddEditOperationForm_function").off("change").on("change", function () {
                    self.changeAddEditOperationFormFunction(this);
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
            changeAddEditOperationFormFunction: function (sender) {
                var self = this;
                var selectionId = $(sender).val();

                if (selectionId == 0) {
                    document.getElementById("AddEditOperationForm_parameter_container").innerHTML = "";
                    $("#AddEditOperationForm_parameter_container").addClass("d-none");
                    $("#AddEditOperationForm_result_container").addClass("d-none");
                    $("#AddEditOperationForm_result_container").addClass("disabled");
                    $("#function-description-container").addClass("d-none");
                    return;
                }

                var fIndex = this.action_function_index_by_id[selectionId];
                var fObject = this.OperationFunctions[fIndex];

                if (!fObject) {
                    return;
                }

                var fParameterCount = fObject.parameters.length;
                var fParameter = null;
                var fParameterTemplate = document
                        .getElementById("AddEditOperationForm_parameter_template_container")
                        .innerHTML;
                var fParameterHTML = "";
                var fParameterContainerHTML = "";

                for (var i = 0; i < fParameterCount; i++) {
                    fParameter = fObject.parameters[i];
                    fParameterHTML = fParameterTemplate;
                    fParameterHTML = fParameterHTML.replace(/%id%/gi, selectionId);
                    fParameterHTML = fParameterHTML.replace(/%index%/gi, i);
                    fParameterHTML = fParameterHTML.replace(/%title%/gi, this.$t(fParameter.title));
                    fParameterHTML = fParameterHTML.replace(/%type%/gi, fParameter.type);
                    fParameterHTML = fParameterHTML.replace(/%defaulttype%/gi, fParameter.default_type);
                    fParameterHTML = fParameterHTML.replace(/%required%/gi, fParameter.required);
                    fParameterHTML = fParameterHTML.replace(/%default%/gi, fParameter.default);

                    if (fParameter.default != null) {
                        fParameterHTML = fParameterHTML.replace(
                                /%value%/gi,
                                fParameter.default);
                        fParameterHTML = fParameterHTML.replace(
                                /%displaytext%/gi,
                                fParameter.default);
                    } else {
                        fParameterHTML = fParameterHTML.replace(
                                /%displaytext%/gi,
                                this.$t("(Not Specified)"));
                        fParameterHTML = fParameterHTML.replace(
                                /%value%/gi, "");
                    }

                    fParameterContainerHTML += fParameterHTML;
                }

                var container = document.getElementById("AddEditOperationForm_parameter_container");
                container.innerHTML = fParameterContainerHTML;
                
                if ("" == fParameterContainerHTML) {
                    $("#AddEditOperationForm_parameter_container").addClass("d-none");
                } else {
                    $("#AddEditOperationForm_parameter_container").removeClass("d-none");
                }

                $("#function-description").html(this.$t(fObject.description));
                $("#function-description-container").removeClass("d-none");

                if (fObject.has_result_parameter == true) {
                    $("#AddEditOperationForm_result_container").removeClass("d-none");
                    $("#AddEditOperationForm_result_container").removeClass("disabled");
                } else {
                    $("#AddEditOperationForm_result_container").addClass("d-none");
                    $("#AddEditOperationForm_result_container").addClass("disabled");
                }

                $("button.button-parameter", container).off("click").on("click", function () {
                    self.clickButtonParameter(this);
                });
            },
            clickButtonParameter: function (sender) {
                this.setParameterEditModalDefaults(sender);
                $("#modal-functionParameterEdit").modal();
            },
            setParameterEditModalDefaults: function (sender) {
                var self = this;
                var modalContainer = document.getElementById("modal-functionParameterEdit");
                var modalBody = document.getElementById("body-functionParameterEdit");
                var title = sender.getAttribute("data-parameter-title");
                var type = sender.getAttribute("data-parameter-type");
                var defaultType = sender.getAttribute("data-parameter-default-type");
                var id = sender.getAttribute("data-parameter-id");
                var index = sender.getAttribute("data-parameter-index");
                var value = sender.getAttribute("data-parameter-value");

                modalContainer.setAttribute("data-parameter-type", type);
                modalContainer.setAttribute("data-parameter-id", id);
                modalContainer.setAttribute("data-parameter-index", index);

                document.getElementById("header-functionParameterEdit").innerHTML = title;

                $(".parameter-input", modalBody).addClass("d-none");
                $((".parameter-input-type-" + type), modalBody).removeClass("d-none");

                if (value == "") {
                    if ("cv" == type) {
                        $("#AddEditFunctionParameterForm_cv_input1").val("");
                        $('#AddEditFunctionParameterForm_cv_input2').val(
                                $('#AddEditFunctionParameterForm_cv_input2 option:first-child')
                                .val()).trigger('change');
                        $("#AddEditFunctionParameterForm_constant_variable_radio0").prop("checked", true);
                        this.updateFunctionParameterConstantVariableInputs();
                    }
                } else {
                    if ("c" == defaultType) {
                        $("#AddEditFunctionParameterForm_constant_variable_radio0").prop("checked", true);
                        this.updateFunctionParameterConstantVariableInputs();
                        $("#AddEditFunctionParameterForm_cv_input1").val(value);
                    } else if ("v" == defaultType) {
                        $("#AddEditFunctionParameterForm_constant_variable_radio1").prop("checked", true);
                        this.updateFunctionParameterConstantVariableInputs();
                        $("#AddEditFunctionParameterForm_cv_input2").val(value);
                        $("#AddEditFunctionParameterForm_cv_input2").trigger("change");
                    } else if ("l" == type) {
                        $("#AddEditFunctionParameterForm_alarm_list_input").val(value);
                        $("#AddEditFunctionParameterForm_alarm_list_input").trigger("change");
                    }
                }
            },
            clickFunctionParameterConstantVariableRadio: function () {
                this.updateFunctionParameterConstantVariableInputs();
            },
            updateFunctionParameterConstantVariableInputs: function () {
                var modalBody = document.getElementById("body-functionParameterEdit");
                var value = 0;
                if (document.getElementById(
                        "AddEditFunctionParameterForm_constant_variable_radio0").checked) {
                    value = 1;
                } else if (document.getElementById(
                        "AddEditFunctionParameterForm_constant_variable_radio1").checked) {
                    value = 2;
                }

                $(".function-parameter-cv-input", modalBody).addClass("d-none");
                $((".function-parameter-cv-input" + value), modalBody).removeClass("d-none");
            },
            clickSaveFunctionParameterButton: function () {
                var modalContainer = document.getElementById("modal-functionParameterEdit");
                var type = modalContainer.getAttribute("data-parameter-type");
                var id = modalContainer.getAttribute("data-parameter-id");
                var index = modalContainer.getAttribute("data-parameter-index");
                var value = "";
                var displayText = "";
                var targetParameter = document.getElementById(
                        "AddEditOperationForm_f_"
                        + id
                        + "_p_"
                        + index);
                var defaultType = "";

                switch (type) {
                    case "l":
                        value = $("#AddEditFunctionParameterForm_alarm_list_input").val();
                    break;
                    case "cv":
                        if (document.getElementById(
                                "AddEditFunctionParameterForm_constant_variable_radio0").checked) {
                            defaultType = "c";
                            value = $("#AddEditFunctionParameterForm_cv_input1").val();
                        } else if (document.getElementById(
                                "AddEditFunctionParameterForm_constant_variable_radio1").checked) {
                            defaultType = "v";
                            value = $("#AddEditFunctionParameterForm_cv_input2").val();
                        }
                    break;
                    case "o":
                        value = $("#AddEditFunctionParameterForm_opc_server_list").val()
                                + ";"
                                + $("#AddEditFunctionParameterForm_opc_leaf").val();
                    break;
                }

                displayText = this.getFunctionParameterDisplayText(
                        type,
                        defaultType,
                        value);

                $(targetParameter).removeClass("btn-danger");
                $(targetParameter).removeClass("is-invalid");
                $(targetParameter).addClass("btn-default");

                targetParameter.setAttribute("data-parameter-default-type", defaultType);
                targetParameter.setAttribute("data-parameter-value", value);
                targetParameter.setAttribute("data-parameter-display-text", displayText);
                targetParameter.innerHTML = displayText;

                $(modalContainer).modal("hide");
            },
            getFunctionParameterDisplayText: function (type, defaultType, value) {
                if ((null == value) || ("" == value)) {
                    return this.$t("(Not Specified)");
                }

                var displayText = "";
                var index = 0;

                switch (type) {
                    case "l":
                        index = this.action_alarm_index_by_id[value];
                        if (index != undefined) {
                            displayText = this.action_alarm_list_options[index].text;
                        }
                    break;
                    case "cv":
                        if ("c" == defaultType) {
                            displayText = "&quot;" + value + "&quot;";
                        } else {
                            index = this.action_variable_index_by_id[value];
                            if (index != undefined) {
                                displayText = this.action_variable_list_options[index].text;
                            }
                        }
                    break;
                    case "o":
                        displayText = value;
                        displayText = displayText.replace(";", "/");
                        displayText = "OPC:" + displayText;
                    break;
                }

                return displayText;
            },
            generateOperationId: function (prefix) {
                var now = new Date();
                var token0 = String(now.getTime());
                var token1 = String(Math.floor(100 + Math.random() * 900));
                
                if (!prefix) {
                    prefix = "OP";
                }

                return prefix + token0 + token1;
            },
            clickActionOperationDeleteButton: function (index) {
                if (this.operations[index]) {
                    this.operations.splice(index, 1);
                    this.refreshActionOperationList();
                }
            },
            clickEditActionOperationButton: function (index) {
                this.setAddEditOperationModal(this.operations[index]);
                this.showAddEditOperationModal();
            },
            clickAddOperationButton: function () {
                this.setAddEditOperationModal(null);
                this.showAddEditOperationModal();
            },
            showAddEditOperationModal: function () {
                $('#modal-addEditOperation').modal();
            },
            setAddEditOperationModal: function (operation) {
                if (operation == undefined) {
                    operation = null;
                }

                if (operation == null) {
                    $('#AddEditOperationForm_function').val(
                            $('#AddEditOperationForm_function option:first-child')
                            .val()).trigger('change');

                    $("#modal-addEditOperation").attr(
                            "data-operation-id",
                            this.generateOperationId());
                    return true;
                }

                var functionObject = this.OperationFunctions[
                        this.action_function_index_by_id[
                        operation.function_id]];

                $('#AddEditOperationForm_function').val(operation.function_id);
                $('#AddEditOperationForm_function').trigger("change");

                if (functionObject.has_result_parameter) {
                    $("#AddEditOperationForm_result").val(operation.result);
                    $("#AddEditOperationForm_result").trigger("change");
                }

                var parameterCount = functionObject.parameters.length;
                var parameterButton = null;
                var operationParameter = null;
                var parameterDisplayText = "";

                for (var i = 0; i < parameterCount; i++) {
                    operationParameter = operation.parameters[i];
                    parameterButton = document.getElementById(
                            "AddEditOperationForm_f_"
                            + operation.function_id
                            + "_p_"
                            + i);

                    if (parameterButton == undefined) {
                        continue;
                    }

                    parameterDisplayText = this.getFunctionParameterDisplayText(
                            operationParameter.type,
                            operationParameter.default_type,
                            operationParameter.value);

                    parameterButton.setAttribute("data-parameter-default-type", operationParameter.default_type);
                    parameterButton.setAttribute("data-parameter-value", operationParameter.value);
                    parameterButton.setAttribute("data-parameter-display-text", parameterDisplayText);
                    parameterButton.innerHTML = parameterDisplayText;
                }

                $("#modal-addEditOperation").attr(
                        "data-operation-id", operation.id);
            },
            clickSaveOperationButton: function () {
                var operationObject = {};
                var functionId = $("#AddEditOperationForm_function").val();

                if ("" == functionId) {
                    $("#modal-addEditOperation").modal("hide");
                    return false;
                }

                var parameterButtons = $("#AddEditOperationForm_parameter_container .button-parameter");
                var parameterButtonCount = parameterButtons.length;
                var parameterButton = null;
                var parameterButtonRequired = false;
                var parameterButtonValue = "";
                var parameterButtonType = "";
                var parameterButtonDefaultType = "";
                var hasErrors = false;

                operationObject.id = $("#modal-addEditOperation").attr("data-operation-id");
                operationObject.function_id = functionId;
                operationObject.parameters = [];
                operationObject.enabled = true;

                for (var i = 0; i < parameterButtonCount; i++) {
                    parameterButton = parameterButtons[i];
                    parameterButtonRequired = ("true" == parameterButton.getAttribute("data-parameter-required"));
                    parameterButtonValue = parameterButton.getAttribute("data-parameter-value");
                    parameterButtonType = parameterButton.getAttribute("data-parameter-type");
                    parameterButtonDefaultType = parameterButton.getAttribute("data-parameter-default-type");

                    if (true == parameterButtonRequired) {
                        if (("" == parameterButtonValue)
                                || (null == parameterButtonValue)) {
                            $(parameterButton).addClass("btn-danger");
                            $(parameterButton).removeClass("btn-default");
                            $(parameterButton).addClass("is-invalid");
                            $("#" + parameterButton.getAttribute("id")
                                    + "_error").html(
                                    this.$t("Please specify a value for this parameter."));
                            hasErrors = true;
                        }
                    }

                    operationObject.parameters.push({
                        "type": parameterButtonType,
                        "default_type": parameterButtonDefaultType,
                        "value": parameterButtonValue
                    });
                }

                if ($("#AddEditOperationForm_result_container").hasClass("disabled")) {
                    operationObject.result = "";
                } else {
                    operationObject.result = $("#AddEditOperationForm_result").val();
                }

                if (!hasErrors) {
                    this.updateOperation(operationObject);
                    $("#modal-addEditOperation").modal("hide");
                }
            },
            updateOperation: function (operation) {
                if (this.operation_index_by_id[operation.id] == undefined) {
                    // New Operation
                    this.operations.push(operation);
                } else {
                    // this.operations[this.operation_index_by_id[operation.id]] = operation;
                    this.$set(this.operations,
                            this.operation_index_by_id[operation.id],
                            operation);
                }

                this.refreshActionOperationList();
            },
            refreshActionOperationList: function () {
                if (0 == this.operations.length) {
                    this.show_action_operations = false;
                } else {
                    this.show_action_operations = true;
                    $("#action-operation-list-container").sortable({
                        placeholder: "ui-sortable-placeholder"
                    });

                    var operationCount = this.operations.length;
                    this.operation_index_by_id = [];
                    var operation = null;

                    for (var i = 0; i < operationCount; i++) {
                        operation = this.operations[i];
                        this.operation_index_by_id[operation.id] = i;
                    }
                }
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
            load_actionlist: function () {
                var self = this;

                if (self.page.is_actionlist_loading) {
                    return;
                }

                self.page.is_actionlist_loading = true;
                
                axios.get(AdminLTEHelper.getAPIURL("adminlteadvied/get_actionlist/" + self.id))
                    .then(({ data }) => {
                        self.page.is_actionlist_loaded = true;
                        self.page.is_actionlist_loading = false;
                        self.actionlist = data.list;
                        self.processLoadQueue();
                    }).catch(({ data }) => {
                        self.page.is_actionlist_loaded = true;
                        self.page.is_actionlist_loading = false;
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
                                    self.$router.push('/' + self.main_folder + '/adminlteadvied_import');
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
            showActionEdit: function (id) {
                this.cleanActionEditForm();

                if (0 == id) {
                    this.initializeJSQueryBuilder(document.getElementById("processActionConditionBuilderContainer"), null);
                } else {
                    this.fillActionEditForm(id);
                }

                $('#divActionEditDialog').modal();
            },
            cleanActionEditForm: function() {
                this.ActionForm.id = 0;
                this.ActionForm.template_id = this.TemplateForm.id;
                this.ActionForm.enabled = true;
                this.ActionForm.__order = "0";
                this.ActionForm.title = "";
                this.ActionForm.condition_json = "";
                this.ActionForm.operation_json = "";

                this.operations = [];
                this.refreshActionOperationList();

                $("#btn-delete-Action").hide();
            },
            fillActionEditForm: function(id) {
                var object = this.getActionById(id);

                this.ActionForm.id = object["id"];
                this.ActionForm.template_id = object["template_id"];
                this.ActionForm.enabled = object["enabled"];
                this.ActionForm.__order = object["__order"];
                this.ActionForm.title = object["title"];
                this.ActionForm.condition_json = object["condition"];
                this.ActionForm.operation_json = object["operation"];

                this.initializeJSQueryBuilder(document.getElementById("processActionConditionBuilderContainer"), JSON.parse(object["condition"]));

                this.operations = JSON.parse(object["operation"]);
                this.refreshActionOperationList();

                $("#btn-delete-Action").show();
            },
            getActionOperationTitleHTML: function (index) {
                var operationObject = this.operations[index];
                var functionObject = this.OperationFunctions[this.action_function_index_by_id[operationObject.function_id]];
                var variableObject = null;
                var listItemHTML = document.getElementById("action-operation-list-item-template").innerHTML;
                var titleHTML = functionObject.title;
                var resultHTML = "";
                var functionParameterCount = 0;
                var functionParameterObject = null;
                var parameterObject = null;
                var parametersHTML = "";

                if (functionObject.has_result_parameter) {
                    resultHTML = "<strong>";

                    if (this.action_variable_index_by_id[operationObject.result] != undefined) {
                        variableObject = this.action_variable_list_options[this.action_variable_index_by_id[operationObject.result]];
                        resultHTML += variableObject.text;
                    }

                    resultHTML += ":</strong>&nbsp;";
                }

                functionParameterCount = functionObject.parameters.length;

                for (var i = 0; i < functionParameterCount; i++) {
                    if (parametersHTML != "") {
                        parametersHTML += ",&nbsp;";
                    }

                    functionParameterObject = functionObject.parameters[i];
                    parameterObject = operationObject.parameters[i];

                    parametersHTML += "<strong>"
                            + functionParameterObject.title
                            + ":</strong>&nbsp;";
                    parametersHTML += this.getFunctionParameterDisplayText(
                            functionParameterObject.type,
                            parameterObject.default_type,
                            parameterObject.value);
                    
                }

                if (parametersHTML != "") {
                    parametersHTML = "(" + parametersHTML + ")";
                }

                listItemHTML = listItemHTML.replace(/%title%/gi, titleHTML);
                listItemHTML = listItemHTML.replace(/%result%/gi, resultHTML);
                listItemHTML = listItemHTML.replace(/%parameters%/gi, parametersHTML);

                return listItemHTML;
            },
            getFunctionParameterDisplayText: function (type, defaultType, value) {
                if ((null == value) || ("" == value)) {
                    return "(Not Specified)";
                }

                var displayText = "";
                var index = 0;

                if ("c" == defaultType) {
                    displayText = "&quot;" + value + "&quot;";
                } else {
                    index = this.action_variable_index_by_id[value];
                    if (index != undefined) {
                        displayText = this.action_variable_list_options[index].text;
                    }
                }

                return displayText;
            },
            getSortedOperations: function() {
                var elements = $("#action-operation-list-container > li");
                var elementCount = elements.length;
                var element = null;
                var sortedOperations = [];
                var operationId = "";

                for (var i = 0; i < elementCount; i++) {
                    element = elements[i];
                    operationId = element.getAttribute("data-item-id");
                    sortedOperations.push(
                            this.operations[
                            this.operation_index_by_id[
                            operationId]]);
                }

                return sortedOperations;
            },
            getActionById: function(id) {
                var object = null;
                this.actionlist.forEach(element => {
                    if (id == element.id) {
                        object = element;
                    } 
                });

                return object;
            },
            saveAction: function () {
                var self = this;

                this.collectActionFormValues();

                self.$Progress.start();
                self.ActionForm.post(AdminLTEHelper.getAPIURL("adminlteadvied/post_action"))
                    .then(({ data }) => {
                        self.$Progress.finish();
                        self.page.has_post_error = data.has_error;
                        self.page.has_server_error = false;
                    }).catch(({ data }) => {
                        self.$Progress.fail();
                        let errors = (self.ActionForm.errors.errors);
                        if (undefined !== errors.error) {
                            self.page.has_server_error = true;
                        } else {
                            self.page.has_post_error = true;
                            self.page.post_error_msg = self.$t("Your changes could not be saved. Please check your details and try again.");
                        }
                    }).finally(function() {
                        if (!self.page.has_server_error) {
                            if (!self.page.has_post_error) {
                                $("#divActionEditDialog").modal("hide");
                                Vue.swal.fire({
                                    position: 'top-end',
                                    title: self.$t("Your changes have been saved!"),
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    onClose: () => {
                                        self.load_actionlist();
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
            deleteAction: function(id) {
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
                        self.formActionDelete.selected_ids.push(id);
                        self.submitDeleteActionForm();
                    }
                });
            },
            submitDeleteActionForm: function () {
                var self = this;
                self.$Progress.start();
                self.formActionDelete.post(AdminLTEHelper.getAPIURL("adminlteadvied/delete_action"))
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
                                    self.load_actionlist();
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
            collectActionFormValues: function () {
                this.ActionForm.condition_json
                        = JSON.stringify($("#processActionConditionBuilderContainer")
                        .queryBuilder("getRules",
                        { allow_invalid: true }));

                this.ActionForm.operation_json
                        = JSON.stringify(this.getSortedOperations());
            },
            load_validationlist: function () {
                var self = this;

                if (self.page.is_validationlist_loading) {
                    return;
                }

                self.page.is_validationlist_loading = true;
                
                axios.get(AdminLTEHelper.getAPIURL("adminlteadvied/get_validationlist/" + self.id))
                    .then(({ data }) => {
                        self.page.is_validationlist_loaded = true;
                        self.page.is_validationlist_loading = false;
                        self.validationlist = data.list;
                        self.processLoadQueue();
                    }).catch(({ data }) => {
                        self.page.is_validationlist_loaded = true;
                        self.page.is_validationlist_loading = false;
                        self.$Progress.fail();
                        self.processLoadQueue();
                    });
            },
            showValidationEdit: function (id) {
                this.cleanValidationEditForm();

                if (0 == id) {
                    this.initializeJSQueryBuilder(document.getElementById("processValidationConditionBuilderContainer"), null);
                } else {
                    this.fillValidationEditForm(id);
                }

                $('#divValidationEditDialog').modal();
            },
            cleanValidationEditForm: function() {
                this.ValidationForm.id = 0;
                this.ValidationForm.template_id = this.TemplateForm.id;
                this.ValidationForm.enabled = true;
                this.ValidationForm.__order = "0";
                this.ValidationForm.message = "";
                this.ValidationForm.condition_json = "";

                $("#btn-delete-Validation").hide();
            },
            fillValidationEditForm: function(id) {
                var object = this.getValidationById(id);

                this.ValidationForm.id = object["id"];
                this.ValidationForm.template_id = object["template_id"];
                this.ValidationForm.enabled = object["enabled"];
                this.ValidationForm.__order = object["__order"];
                this.ValidationForm.message = object["message"];
                this.ValidationForm.condition_json = object["condition"];

                this.initializeJSQueryBuilder(document.getElementById("processValidationConditionBuilderContainer"), JSON.parse(object["condition"]));

                $("#btn-delete-Validation").show();
            },
            getValidationById: function(id) {
                var object = null;
                this.validationlist.forEach(element => {
                    if (id == element.id) {
                        object = element;
                    } 
                });

                return object;
            },
            saveValidation: function () {
                var self = this;

                this.collectValidationFormValues();

                self.$Progress.start();
                self.ValidationForm.post(AdminLTEHelper.getAPIURL("adminlteadvied/post_validation"))
                    .then(({ data }) => {
                        self.$Progress.finish();
                        self.page.has_post_error = data.has_error;
                        self.page.has_server_error = false;
                    }).catch(({ data }) => {
                        self.$Progress.fail();
                        let errors = (self.ValidationForm.errors.errors);
                        if (undefined !== errors.error) {
                            self.page.has_server_error = true;
                        } else {
                            self.page.has_post_error = true;
                            self.page.post_error_msg = self.$t("Your changes could not be saved. Please check your details and try again.");
                        }
                    }).finally(function() {
                        if (!self.page.has_server_error) {
                            if (!self.page.has_post_error) {
                                $("#divValidationEditDialog").modal("hide");
                                Vue.swal.fire({
                                    position: 'top-end',
                                    title: self.$t("Your changes have been saved!"),
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    onClose: () => {
                                        self.load_validationlist();
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
            deleteValidation: function(id) {
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
                        self.formValidationDelete.selected_ids.push(id);
                        self.submitDeleteValidationForm();
                    }
                });
            },
            submitDeleteValidationForm: function () {
                var self = this;
                self.$Progress.start();
                self.formValidationDelete.post(AdminLTEHelper.getAPIURL("adminlteadvied/delete_validation"))
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
                                    self.load_validationlist();
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
            collectValidationFormValues: function () {
                this.ValidationForm.condition_json
                        = JSON.stringify($("#processValidationConditionBuilderContainer")
                        .queryBuilder("getRules",
                        { allow_invalid: true }));
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