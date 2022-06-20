<template>
    <div class="content-wrapper">
        <server-error v-if="page.has_server_error" ></server-error>
        <permission-error v-else-if="!page.authorization.status" :authorization="page.authorization"></permission-error>
        <div v-else>
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="home">{{ $t('Home') }}</a></li>
                        </ol>
                    </div>
                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <form id="ExportForm"
                        class=""
                        @submit.prevent="submitExportForm"
                        @keydown="ExportForm.onKeydown($event)">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="mb-0">{{  $t('Bulk Export') }}</h4>
                                        <div class="sbp-item sbp-hide" advied-permission-token="advied_admin">
                                            <button v-show="!template_editable" type="button"
                                                @click="showTemplateEdit"
                                                class="btn btn-primary btn-sm text-white float-right"
                                                style="position: absolute;right:1.25rem;top:0.75rem;">
                                                <i class="fas fa-plus"></i>&nbsp;{{ $t('Add Template') }}
                                            </button>
                                            <router-link v-show="template_editable"
                                                tag="a"
                                                class="btn btn-warning btn-sm text-white float-right"
                                                :to="templateURL"
                                                style="position: absolute;right:1.25rem;top:0.75rem;">
                                                <i class="fas fa-pencil-alt"></i>&nbsp;{{ $t('Edit Template') }}
                                            </router-link>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="ExportForm_template_id" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">
                                                {{  $t('Please Choose Bulk Export Template') }}
                                            </label>
                                            <div class="col-lg-8 col-md-7 col-sm-12">
                                                <select2-element class="select2-element"
                                                    data-placeholder=""
                                                    id="ExportForm_template_id"
                                                    name="ExportForm_template_id"
                                                    :options="templatelist"
                                                    v-model="ExportForm.template_id">
                                                    <option></option>
                                                </select2-element>
                                                <input type="hidden" :class="{ 'is-invalid': ExportForm.errors.has('template_id') }">
                                                <has-error :form="ExportForm" field="template_id"></has-error>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-12 text-muted" id="template-description-container" style="display:none;margin-top:20px;">
                                            </div>
                                        </div>

                                        <div class="form-group row" id="export-container" style="display:none;">
                                            <div class="col-lg-12">
                                                <div id="formExportInputs" style="display:none;">
                                                </div>

                                                <div id="exportButtonContainer" class="pt-20" style="display:none;">
                                                    <button type="button" 
                                                        id="saveExportForm" 
                                                        @click="submitExportForm"
                                                        class="btn btn-default buttonSave float-right">
                                                        Print/Export...
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
                                <input type="hidden" v-model="TemplateForm.type" id="type" name="type">
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
                                <button
                                    @click="saveTemplate"
                                    :disabled="TemplateForm.busy"
                                    type="button"
                                    class="btn btn-success btn-md btn-card-default btn-on-card float-right">
                                    {{ $t('Create') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary float-left" data-dismiss="modal" style="margin-right:10px;">{{ $t('Close') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="controller" value="export">

        <script id="shorttextTemplate" type="text/html">
            <div class="form-example-int form-horizental mb-20">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="formExport-__NAME__"><strong>__TITLE__</strong></label>
                        </div>
                        <div class="col-lg-12">
                            <div class="nk-int-st">
                                <input type="text"
                                    id="formExport-__NAME__"
                                    name="formExport-__NAME__"
                                    class="form-control export-parameter"
                                    value="__VALUE__"
                                    data-parameter="__NAME__">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </script>

        <script id="numberTemplate" type="text/html">
            <div class="form-example-int form-horizental mb-20">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="formExport-__NAME__"><strong>__TITLE__</strong></label>
                        </div>
                        <div class="col-lg-12">
                            <div class="nk-int-st">
                                <input type="text"
                                    id="formExport-__NAME__"
                                    name="formExport-__NAME__"
                                    class="form-control export-parameter"
                                    value="__VALUE__"
                                    data-parameter="__NAME__">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </script>

        <script id="selectionTemplate" type="text/html">
            <div class="form-example-int form-horizental mb-20">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="formExport-__NAME__"><strong>__TITLE__</strong></label>
                        </div>
                        <div class="col-lg-12">
                            <select id="formExport-__NAME__"
                                    name="formExport-__NAME__"
                                    class="form-control export-parameter"
                                    data-parameter="__NAME__">
                                <option value="">Please Select</option>
                                __OPTIONS__
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </script>
        <script id="optionTemplate" type="text/html">
            <option value="__option_value__" __selected__>__option_title__</option>
        </script>
    </div>
</template>

<script>

export default {
    data() {
        return {
            main_folder: '',
            templateURL: "",
            template_editable: false,
            TemplateForm: new Form({
                'debug_mode': false,
                'id': 0,
                'enabled': false,
                'title': '',
                'description': '',
                'type': 1
            }),
			ExportForm: new Form({
                'debug_mode': false,
                'id': 0,
                'template_id': 0,
                'parameters': ""
            }),
            templatelist: [],
            template_parameter_list: [],
            page: {
                is_ready: false,
                has_server_error: false,
                variables: [],
                authorization: {
                    status: true,
                    type: "",
                    msg: ""
                },
                is_variables_loading: false,
                is_variables_loaded: false,
                has_post_error: false,
                post_error_msg: '',
                is_ready: false,
                is_templatelist_loading: false,
                is_templatelist_loaded: false,
            }
        };
    },
    methods: {
        showTemplateEdit: function () {
            this.TemplateForm.id = 0;
            this.TemplateForm.enabled = 0;
            this.TemplateForm.title = "";
            this.TemplateForm.description = "";
            $('#modal-editTemplate').modal();
        },
        saveTemplate: function () {
            var self = this;
            self.$Progress.start();
            self.TemplateForm.post(WisiloHelper.getAPIURL("wisiloadvied/post_template"))
                .then(({ data }) => {
                self.$Progress.finish();
                self.TemplateForm.id = data.id;
                self.page.has_post_error = data.has_error;
                self.page.post_error_msg = data.error_msg;
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
                                    $('#modal-editTemplate').modal("hide");
                                    self.$router.push('/' + self.main_folder + '/wisiloadvied_exporttemplate/' + self.TemplateForm.id);
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
                return;
            }

            if (!self.page.authorization.status) {
                self.$Progress.finish();
                self.page.is_ready = true;
                return;
            }

            if (!self.page.is_variables_loaded && !self.page.is_templatelist_loaded) {
                self.$Progress.start();
            }
            
            if (!self.page.is_variables_loaded) {
                self.loadPageVariables();
            } else {
                if (!self.page.is_templatelist_loaded) {
                    self.load_templatelist();
                }

                $("#ExportForm_template_id").on("change",function(e){
                    self.doTemplateChange(e.target.value);
                });

                self.$Progress.finish();
                self.page.is_ready = true;
            }
        },
        loadPageVariables: function () {
            var self = this;

            if (self.page.is_variables_loading) {
                return;
            }

            self.page.is_variables_loading = true;

            axios.get(WisiloHelper.getAPIURL("wisilo/get_page_variables/wisiloadvied_export"))
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
                    WisiloHelper.initializePermissions(self.page.variables, false);
                    self.page.authorization = WisiloHelper.hasUserADVIEDAuthorized(self.page.variables, "export");
                    self.processLoadQueue();
                });
        },
        load_parameters: function (template_id) {
            var self = this;
            axios.get(WisiloHelper.getAPIURL("wisiloadvied/get_parameterlist/" + template_id))
                .then(({ data }) => {
                    self.template_parameter_list = data.list;
                }).catch(({ data }) => {
                    self.$Progress.fail();
                }).finally(function() {
                    self.renderExportForm();
                });
        },
        load_templatelist: function () {
            if (this.page.is_templatelist_loading) {
                return;
            }

            this.page.is_templatelist_loading = true;
            
            axios.get(WisiloHelper.getAPIURL("wisiloadvied/get_template_option_list/1"))
                .then(({ data }) => {
                    this.page.is_templatelist_loaded = true;
                    this.page.is_templatelist_loading = false;
                    this.templatelist = data.list;
                    this.processLoadQueue();
                }).catch(({ data }) => {
                    this.page.is_templatelist_loaded = true;
                    this.page.is_templatelist_loading = false;
                    this.$Progress.fail();
                    this.processLoadQueue();
                });
        },
        submitExportForm: function () {
            var self = this;

            self.ExportForm.parameters = self.collectExportParameters();

            self.$Progress.start();
            self.ExportForm.post(WisiloHelper.getAPIURL("wisiloadvied/post_export_form"))
                .then(({ data }) => {
                    self.$Progress.finish();
                    self.page.has_post_error = data.has_error;
                    self.page.post_error_msg = data.error_msg;
                    self.page.has_server_error = false;
                }).catch(({ data }) => {
                    self.$Progress.fail();
                    let errors = (self.ExportForm.errors.errors);
                    if (undefined !== errors.error) {
                        self.page.has_server_error = true;
                    } else {
                        self.page.has_post_error = true;
                        self.page.post_error_msg = self.$t("Please fill in the required fields.");
                    }
                }).finally(function() {
                    if (!self.page.has_server_error) {
                        if (!self.page.has_post_error) {
                            Vue.swal.fire({
                                position: 'top-end',
                                title: self.$t("Your file has been exported!"),
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                onClose: () => {
                                    self.$router.push('/' + self.main_folder + '/wisiloadvied_exportpage/' + self.ExportForm.template_id);
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
        doTemplateChange: function(template_id) {
            if ("" == template_id) {
                return;
            }

            this.template_editable = true;
            this.templateURL = '/' + this.main_folder + '/wisiloadvied_exporttemplate/' + template_id;

            document.getElementById("formExportInputs").style.display = "none";
            this.load_parameters(template_id);
            this.showTemplateDescription(template_id);
            document.getElementById("exportButtonContainer").style.display = "block";
        },
        showTemplateDescription: function(template_id) {
            if ("" == template_id || 0 == template_id) {
                document.getElementById("template-description-container").style.display = "none";
                document.getElementById("export-container").style.display = "none";
                return false;
            }

            var object = this.getTemplateById(template_id);

            document.getElementById("template-description-container").innerHTML = object["description"];
            document.getElementById("template-description-container").style.display = "block";
            document.getElementById("export-container").style.display = "block";
            return true;
        },
        getTemplateById: function(id) {
            var object = null;
            this.templatelist.forEach(element => {
                if (id == element.id) {
                    object = element;
                } 
            });

            return object;
        },
        collectExportParameters: function() {
            var parameters = {};
            
            var inputs = $(".export-parameter", document.getElementById("formExportInputs"));
            var inputCount = inputs.length;

            for (var i = 0; i < inputCount; i++) {
                parameters[inputs[i].getAttribute("data-parameter")] = inputs[i].value;
            }

            return parameters;
        },
        renderExportForm: function() {
            var self = this;

            var ParameterList = self.template_parameter_list;
            var ParameterCount = ParameterList.length;

            if (0 == ParameterCount) {
                document.getElementById("formExportInputs").style.display = "none";
                return;
            }

            var inputsHTML = "";

            ParameterList.forEach(Parameter => {
                inputsHTML = inputsHTML + self.getParameterInputHTML(Parameter);
            });

            document.getElementById("formExportInputs").innerHTML = inputsHTML;
            document.getElementById("formExportInputs").style.display = "block";
        },
        getParameterInputHTML: function(Parameter) {
            if ("shorttext" == Parameter["type"]) {
                return this.getShorttextInputHTML(Parameter);
            } else if ("number" == Parameter["type"]) {
                return this.getNumberInputHTML(Parameter);
            } else if ("selection" == Parameter["type"]) {
                return this.getSelectionInputHTML(Parameter);
            }

            return "";
        },
        getShorttextInputHTML: function(Parameter) {
            var templateHTML = document.getElementById("shorttextTemplate").innerHTML;
            return templateHTML.replace(/__NAME__/g, Parameter["name"])
                .replace(/__TITLE__/g, Parameter["title"])
                .replace(/__VALUE__/g, Parameter["default"]);
        },
        getNumberInputHTML: function(Parameter) {
            var templateHTML = document.getElementById("numberTemplate").innerHTML;
            return templateHTML.replace(/__NAME__/g, Parameter["name"])
                .replace(/__TITLE__/g, Parameter["title"])
                .replace(/__VALUE__/g, Parameter["default"]);
        },
        getSelectionInputHTML: function(Parameter) {
            var templateHTML = document.getElementById("selectionTemplate").innerHTML;
            return templateHTML.replace(/__NAME__/g, Parameter["name"])
                .replace(/__TITLE__/g, Parameter["title"])
                .replace(/__VALUE__/g, Parameter["default"])
                .replace(/__OPTIONS__/g, this.getSelectionOptionsHTML(Parameter));
        },
        getSelectionOptionsHTML: function(Parameter) {
            var optionsHTML = "";
            var optionHTML = "";
            var templateHTML = document.getElementById("optionTemplate").innerHTML;
        
            var defaultValue = Parameter["default"];
            var selected = "";
            var optionTitles = String(Parameter["option_titles"]).split(/\n/g);
            var optionValues = String(Parameter["option_values"]).split(/\n/g);
            var optionCount = optionTitles.length;

            for (var i = 0; i < optionCount; i++) {
                selected = "";
                if (optionValues[i] == defaultValue) {
                    selected = "selected";
                }

                optionHTML = templateHTML.replace(/__option_title__/g, optionTitles[i])
                    .replace(/__option_value__/g, optionValues[i])
                    .replace(/__selected__/g, selected);

                optionsHTML += optionHTML;
            }

            return optionsHTML;
        }
    },
    mounted() {
        this.main_folder = WisiloHelper.getMainFolder();
        this.body_loader_active = true;
        this.processLoadQueue();
    }
}
</script>