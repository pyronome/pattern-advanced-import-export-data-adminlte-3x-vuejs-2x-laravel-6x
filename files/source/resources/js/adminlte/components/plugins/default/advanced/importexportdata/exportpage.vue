<template>
    <div class="content-wrapper cw-print">
        <server-error v-if="page.has_server_error" ></server-error>
        <permission-error v-else-if="!page.is_authorized" :type="page.unauthorized_type"></permission-error>
        <div v-else>
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                    <div class="col-sm-6">
                        <!-- <h1>{{ $t('Gecikme Süresi Ayarları') }}</h1> -->
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="home">{{ $t('Home') }}</a></li>
                        </ol>
                    </div>
                    </div>
                </div>
            </section>
            <section class="content sectionContent">
                <div class="container-fluid">
                    <div class="divButtonPrintPage">
                        <button type="button" id="buttonPrintPage" class="custom-export-buttons" @click="windowPrint" style="display:none;">
                            <i class="fa fa-print"></i>&nbsp;Print
                        </button>

                        <button type="button" id="buttonExport" class="custom-export-buttons" @click="_export" style="display:none;">
                            <i class="fa fa-export"></i>&nbsp;Export
                        </button>

                    </div>

                    <div class="row">
                        <div class="col-lg-12" style="margin-bottom:20px;">
                            <h3 id="template-title"></h3>
                            <!-- <h3 id="templateDescription"></h3> -->
                            <ul id="parameterList"></ul>
                        </div>
                        <div class="col-lg-12">
                            <div id="export_no_results">
                                <p id="exportError">No results found.</p>
                            </div>
                            <div class="table-responsive">
                                <table id="ExportTable"  class="table table-striped table-bordered table-hover table-sm">
                                    <thead id="ExportTableHeader" data-fixed-available="1">
                                    </thead>
                                    <tbody id="ExportTableBody" class="tbodyList line-height-35">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <input type="hidden" id="controller" value="exportpage">
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
			id: 0,
            export_data: null,
            table_data: [],
            page: {
                is_ready: false,
                has_server_error: false,
                variables: [],
                is_authorized: true,
                unauthorized_type: '',
                is_variables_loading: false,
                is_variables_loaded: false,
                has_post_error: false,
                post_error_msg: '',
                is_ready: false,
                is_export_data_loading: false,
                is_export_data_loaded: false,
                external_files: [
                    ("/js/adminlte/xlsx/xlsx.full.min.js"),
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
			const ws = XLSX.utils.aoa_to_sheet(this.table_data);
			const wb = XLSX.utils.book_new();
			XLSX.utils.book_append_sheet(wb, ws, "SheetJS");
			/* generate file and send to client */
			XLSX.writeFile(wb, "export.xlsx");
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

        processLoadQueue: function () {
            var self = this;
            if (self.page.has_server_error) {
                self.$Progress.finish();
                self.page.is_ready = true;
                return;
            }

            if (!self.page.is_authorized) {
                self.$Progress.finish();
                self.page.is_ready = true;
                return;
            }

            if (!self.page.is_variables_loaded && !self.page.is_export_data_loaded) {
                self.$Progress.start();
            }
            
            if (!self.page.is_variables_loaded) {
                self.loadPageVariables();
            } else {
                if (!self.page.is_export_data_loaded) {
                    self.load_export_data();
                }

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

            axios.get(AdminLTEHelper.getAPIURL("adminlte/get_page_variables/adminlteadvied_export"))
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
                    AdminLTEHelper.initializePermissions(self.page.variables, false);
                    self.processLoadQueue();
                });
        },
        load_export_data: function () {
            var self = this;
            if (self.page.is_export_data_loading) {
                return;
            }

            self.page.is_export_data_loading = true;
            
            axios.get(AdminLTEHelper.getAPIURL("adminlteadvied/get_export_table/" + self.id))
                .then(({ data }) => {
                    self.page.is_export_data_loaded = true;
                    self.page.is_export_data_loading = false;
                    self.export_data = data.data;
                    self.processLoadQueue();
                }).catch(({ data }) => {
                    self.page.is_export_data_loaded = true;
                    self.page.is_export_data_loading = false;
                    self.$Progress.fail();
                    self.processLoadQueue();
                }).finally(function() {
                    self.renderExportPage();
                });
        },
        renderExportPage: function() {
            if (null === this.export_data) {
                document.getElementById("export_no_results").style.display = "block";
                return;
            }

            var ExportData = this.export_data;

            document.getElementById("template-title").innerHTML = ExportData["title"];

            /* document.getElementById("templateDescription").innerHTML = ExportData["description"]; */

            this.renderParameters(ExportData["parameters"]);

            if (1 == ExportData["has_error"]) {
                document.getElementById("exportError").innerHTML = ExportData["error_msg"];
                document.getElementById("export_no_results").style.display = "block";
                return;
            }

            this.renderTable(ExportData["titles"], ExportData["values"]);
            document.getElementById("buttonPrintPage").style.display = "block";
            document.getElementById("buttonExport").style.display = "block";
        },
        renderParameters: function(parameters) {
            /* var parametersHTML = "";
            var parameterHTML = "";
            var objParameters = JSON.parse(parameters);

            Object.keys(objParameters).forEach(key => {
            parameterHTML = "<li><b>" + key + " : </b>" + objParameters[key] + "</li>";
            parametersHTML += parameterHTML;
            }) */

            document.getElementById("parameterList").innerHTML = parameters;
        },
        renderTable: function(titles, values) {
            this.renderTableHeader(titles);
            this.renderTableBody(values);

            /* $("#ExportTable").DataTable({
                "ordering"  : false,
                "paging"    : false,
                "searching" : false,
                "info" : false,
                dom: "Bfrtip",
                buttons: [
                    {
                        extend: 'colvis',
                        text: 'Columns'
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'copyHtml5',
                        //text: 'Kopyala',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        text: 'Remove',
                        action: function ( e, dt, node, config ) {
                            var container = $(node).parent().parent().parent().parent().remove();
                        }
                    }
                ]
            }); */
        },
        renderTableHeader: function(titles) {
            var headerHTML = "<tr>";

            var titleList = titles.split(",");
            this.table_data.push(titleList);
            titleList.forEach(element => {
                headerHTML = headerHTML + "<th>" + element + "</th>";
            })

            headerHTML += "</tr>";

            document.getElementById("ExportTableHeader").innerHTML = headerHTML;
        },
        renderTableBody: function(values) {
            var self = this;
            var rowsHTML = "";
            var rowHTML = "";

            var rowData = [];
            var rowList = JSON.parse(values);
            
            rowList.forEach(row => {
                rowData = [];
                rowHTML = "<tr>";
                Object.keys(row).forEach(key => {
                    rowHTML = rowHTML + "<td>" + row[key] + "</td>";
                    rowData.push(row[key]);
                })

                rowHTML += "</tr>";
                rowsHTML += rowHTML;

                self.table_data.push(rowData);
            })

            document.getElementById("ExportTableBody").innerHTML = rowsHTML;
        },
        windowPrint: function() {
            window.print();
        }
    },
    mounted() {
        this.id = this.$route.params.id;
        this.main_folder = AdminLTEHelper.getMainFolder();
        this.body_loader_active = true;
        AdminLTEHelper.loadExternalFiles(this.page.external_files, this.processLoadQueue());
    }
}
</script>