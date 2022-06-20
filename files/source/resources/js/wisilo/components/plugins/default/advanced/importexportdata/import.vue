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
                    <form id="ImportForm"
                        class=""
                        @submit.prevent="submitForm"
                        @keydown="ImportForm.onKeydown($event)">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="mb-0">{{  $t('Bulk Import') }}</h4>
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
                                            <label for="ImportForm_template_id" class="detail-label col-form-label col-lg-4 col-md-5 col-sm-12">
                                                {{  $t('Please Choose Bulk Import Template') }}
                                            </label>
                                            <div class="col-lg-8 col-md-7 col-sm-12">
                                                <select2-element class="select2-element"
                                                    data-placeholder=""
                                                    id="ImportForm_template_id"
                                                    name="ImportForm_template_id"
                                                    :options="templatelist"
                                                    v-model="ImportForm.template_id">
                                                    <option></option>
                                                </select2-element>
                                                <input type="hidden" :class="{ 'is-invalid': ImportForm.errors.has('template_id') }">
                                                <has-error :form="ImportForm" field="template_id"></has-error>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-lg-12 text-muted" id="template-description-container" style="display:none;margin-top:20px;">
                                            </div>
                                        </div>

                                        <div class="form-group row" id="import-container" style="display:none;">
                                            <pre style="margin-top: 10px;">
                                                <div id="drop">Drop an excel (.xls) file here</div>
                                                
                                                <div>... or click here to select an excel (.xls) file
                                                    <input type="file" class="form-control" id="importFile" :accept="SheetJSFT" @change="_change" />
                                                </div> 

                                                <input type="checkbox" class="d-none" name="useworker" checked>
                                                <input type="checkbox" class="d-none" name="userabs" checked>
                                            </pre>
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
                    <div class="modalfooter justify-content-between show_by_permission_must_update">
                        <div class="row">
                            <div class="col-md-12">
                                <button
                                    @click="saveTemplate"
                                    menu-permission-token="wisiloadvied_"
                                    advied-permission-token="create_import_template"
                                    :disabled="TemplateForm.busy"
                                    type="button"
                                    class="sbp-item sbp-hide btn btn-success btn-md btn-card-default btn-on-card float-right">
                                    {{ $t('Create') }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary float-left" data-dismiss="modal" style="margin-right:10px;">{{ $t('Close') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="controller" value="import">
    </div>
</template>

<script>

const make_cols = refstr => Array(XLSX.utils.decode_range(refstr).e.c + 1).fill(0).map((x,i) => ({name:XLSX.utils.encode_col(i), key:i}));
const _SheetJSFT = [
	"xlsx", "xlsb", "xlsm", "xls", "xml", "csv", "txt", "ods", "fods", "uos", "sylk", "dif", "dbf", "prn", "qpw", "123", "wb*", "wq*", "html", "htm"
].map(function(x) { return "." + x; }).join(",");

export default {
    data() {
        return {
            data: ["SheetJS".split(""), "1234567".split("")],
			cols: [
				{name:"A", key:0},
				{name:"B", key:1},
				{name:"C", key:2},
				{name:"D", key:3},
				{name:"E", key:4},
				{name:"F", key:5},
				{name:"G", key:6},
			],
			SheetJSFT: _SheetJSFT,

            main_folder: '',
            templateURL: "",
            template_editable: false,
            TemplateForm: new Form({
                'debug_mode': false,
                'id': 0,
                'enabled': false,
                'title': '',
                'description': '',
                'type': 0
            }),
			ImportForm: new Form({
                'debug_mode': false,
                'id': 0,
                'template_id': 0,
                'import_data': ""
            }),
            templatelist: [],
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
                external_files: [
                    ("/js/wisilo/xlsx/xlsx.full.min.js"),
                ],
            }
        };
    },
    methods: {
        _suppress(evt) { evt.stopPropagation(); evt.preventDefault(); },
		_drop(evt) {
			evt.stopPropagation(); evt.preventDefault();
			const files = evt.dataTransfer.files;
			if(files && files[0]) this._file(files[0]);
		},
		_change(evt) {
			const files = evt.target.files;
			if(files && files[0]) {
                this._file(files[0]);
            }
		},
		_export(evt) {
			/* convert state to workbook */
			const ws = XLSX.utils.aoa_to_sheet(this.data);
			const wb = XLSX.utils.book_new();
			XLSX.utils.book_append_sheet(wb, ws, "SheetJS");
			/* generate file and send to client */
			XLSX.writeFile(wb, "sheetjs.xlsx");
		},
		_file(file) {
			/* Boilerplate to set up FileReader */
			const reader = new FileReader();
			reader.onload = (e) => {
				/* Parse data */
				const ab = e.target.result;
				const wb = XLSX.read(new Uint8Array(ab), {type:'array'});
				/* Get first worksheet */
				const wsname = wb.SheetNames[0];
				const ws = wb.Sheets[wsname];
				/* Convert array of arrays */
				const data = XLSX.utils.sheet_to_json(ws, {header:1});
				/* Update state */
				this.data = data;
				this.cols = make_cols(ws['!ref']);

                this.submitForm();
			};
			reader.readAsArrayBuffer(file);
		},
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
                                    self.$router.push('/' + self.main_folder + '/wisiloadvied_importtemplate/' + self.TemplateForm.id);
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

                $("#ImportForm_template_id").on("change",function(e){
                    self.showTemplateDescription(e.target.value);
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

            axios.get(WisiloHelper.getAPIURL("wisilo/get_page_variables/wisiloadvied_import"))
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
                    self.page.authorization = WisiloHelper.hasUserADVIEDAuthorized(self.page.variables, "import");
                    self.processLoadQueue();
                });
        },
        load_templatelist: function () {
            if (this.page.is_templatelist_loading) {
                return;
            }

            this.page.is_templatelist_loading = true;
            
            axios.get(WisiloHelper.getAPIURL("wisiloadvied/get_template_option_list/0"))
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
        submitForm: function () {
            var self = this;

            self.ImportForm.import_data = self.data;

            self.$Progress.start();
            self.ImportForm.post(WisiloHelper.getAPIURL("wisiloadvied/post_import_form"))
                .then(({ data }) => {
                    self.$Progress.finish();
                    self.id = data.id;
                    self.page.has_post_error = data.has_error;
                    self.page.post_error_msg = data.error_msg;
                    self.page.has_server_error = false;
                }).catch(({ data }) => {
                    self.$Progress.fail();
                    let errors = (self.ImportForm.errors.errors);
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
                                title: self.$t("Your file has been imported!"),
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                onClose: () => {
                                    self.$router.push('/' + self.main_folder + '/wisiloadvied_import');
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
        showTemplateDescription: function(template_id) {
            if ("" == template_id || 0 == template_id) {
                document.getElementById("template-description-container").style.display = "none";
                document.getElementById("import-container").style.display = "none";
                return false;
            }

            this.template_editable = true;
            this.templateURL = '/' + this.main_folder + '/wisiloadvied_importtemplate/' + template_id;

            var object = this.getTemplateById(template_id);

            document.getElementById("template-description-container").innerHTML = object["description"];
            document.getElementById("template-description-container").style.display = "block";
            document.getElementById("import-container").style.display = "block";
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
    },
    mounted() {
        this.main_folder = WisiloHelper.getMainFolder();
        this.body_loader_active = true;
        WisiloHelper.loadExternalFiles(this.page.external_files, this.processLoadQueue());
    }
}
</script>