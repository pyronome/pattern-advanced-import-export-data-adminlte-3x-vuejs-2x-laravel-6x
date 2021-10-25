<?php

namespace App\Http\Controllers\AdminLTE\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\AdminLTE\AdminLTE;
use App\AdminLTE\AdminLTEModelOption;
use App\AdminLTE\Advanced\ImportExportData\Template;
use App\AdminLTE\Advanced\ImportExportData\Database;
use App\AdminLTE\Advanced\ImportExportData\Lookup;
use App\AdminLTE\Advanced\ImportExportData\Action;
use App\AdminLTE\Advanced\ImportExportData\Validation;
use App\AdminLTE\Advanced\ImportExportData\Query;
use App\AdminLTE\Advanced\ImportExportData\Parameter;
use App\AdminLTE\Advanced\ImportExportData\IED;
use Illuminate\Database\Connectors\MySqlConnector;
use Illuminate\Support\Facades\DB;
use PDO;

class AdvancedImportExportDataController extends Controller
{
    public function get_template(Request $request)
    {
        $parameters = $request->route()->parameters();

        $id = isset($parameters['id'])
                ? intval($parameters['id'])
                : 0;

        $data = [];

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');

        if ($advied_admin) {
            $object = Template::where('id', $id)->first();

            $data['advied_admin'] = $advied_admin;
            $data['id'] = $object->id;
            $data['deleted'] = $object->deleted;
            $data['created_at'] = $object->created_at;
            $data['updated_at'] = $object->updated_at;
            $data['enabled'] = $object->enabled;
            $data['title'] = $object->title;
            $data['description'] = $object->description;
            $data['type'] = $object->type;
        }

        return ['template' => $data];
    }

    public function get_template_list(Request $request)
    {
        $parameters = $request->route()->parameters();

        $type = isset($parameters['type'])
                ? intval($parameters['type'])
                : 0;

        $objectList = Template::where('type', $type)
            ->orderBy('title', 'asc')
            ->get();

        $index = 0;

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');
        
        foreach ($objectList as $object)
        {
            if (1 == $object->deleted) {
                continue;
            }

            $list[$index] = array();
            $list[$index]['advied_admin'] = $advied_admin;
            $list[$index]['id'] = $object->id;
            $list[$index]['deleted'] = $object->deleted;
            $list[$index]['created_at'] = $object->created_at;
            $list[$index]['updated_at'] = $object->updated_at;
            $list[$index]['enabled'] = $object->enabled;
            $list[$index]['title'] = $object->title;
            $list[$index]['description'] = $object->description;
            $list[$index]['type'] = $object->type;

            $index++;
        } // foreach ($objectList as $object)

        return $list;
    }

    public function get_template_option_list(Request $request) 
    {    
        $parameters = $request->route()->parameters();

        $type = isset($parameters['type'])
                ? intval($parameters['type'])
                : 0;

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');

        $objectList = Template::where('type', $type)
            ->orderBy('title', 'asc')
            ->get();

        $list = [];
        $index = 0;
        
        foreach ($objectList as $object)
        {
            if (1 == $object->deleted) {
                continue;
            }

            if (!$advied_admin) {
                if (0 == $object->enabled) {
                    continue;
                }
            }

            $list[$index]['id'] = $object->id;
            $list[$index]['text'] = $object->title;
            $list[$index]['description'] = $object->description;

            $index++;
        } // foreach ($objectList as $object)

        return [
            'list' => $list
        ];
    }

    public function post_template(Request $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');
        
        $id = intval($request->input('id'));

        if ($id > 0) {
            if (!$advied_admin) {
                $has_error = true;
                $error_msg = __('You can not update this object. Contact your system administrator for more information.');
            } else {
                $objectTemplate = Template::find($id);
            }
        } else {
            if (!$advied_admin) {
                $has_error = true;
                $error_msg = __('You can not create any object. Contact your system administrator for more information.');
            } else {
                $objectTemplate = new Template();
            }
        } // if ($id > 0) {

        if ($has_error) {
            $return_data['id'] = $id;
            $return_data['has_error'] = $has_error;
            $return_data['error_msg'] = $error_msg;

            return $return_data;
        }
        
        $objectTemplate->deleted = 0;
        
        $objectTemplate->enabled = ('' != $request->input('enabled'))
                ? intval($request->input('enabled'))
                : 0;
                
        $objectTemplate->title = $request->input('title');
        $objectTemplate->description = $request->input('description');

        $objectTemplate->type = ('' != $request->input('type'))
                ? intval($request->input('type'))
                : 0;
                

        $objectTemplate->save();
        
        $return_data['id'] = $objectTemplate->id;
        $return_data['has_error'] = false;
        $return_data['error_msg'] = '';

        return $return_data;
    }

    public function delete_template(Request $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');

        if (!$advied_admin) {
            $return_data['id'] = 1;
            $return_data['has_error'] = true;
            $return_data['error_msg'] = __('You can not delete this object. Contact your system administrator for more information.');

            return $return_data;
        }

        $selected_ids = $request->input('selected_ids');
        $objects = Template::where('deleted', false)
                ->whereIn('id', $selected_ids)
                ->get();

        foreach ($objects as $object)
        {
            $object->deleted = 1;
            $object->save();                
        } // foreach ($objects as $object)

        return $return_data;
    }

    public function get_database_list(Request $request)
    {
        $parameters = $request->route()->parameters();

        $objectList = Database::where('deleted', false)
            ->orderBy('title', 'asc')
            ->get();

        $index = 0;

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');
        
        foreach ($objectList as $object)
        {
            $list[$index] = array();
            $list[$index]['advied_admin'] = $advied_admin;            
            $list[$index]['id'] = $object->id;
            $list[$index]['deleted'] = $object->deleted;
            $list[$index]['created_at'] = $object->created_at;
            $list[$index]['updated_at'] = $object->updated_at;
            $list[$index]['enabled'] = $object->enabled;
            $list[$index]['title'] = $object->title;
            $list[$index]['database_type'] = $object->database_type;
            $list[$index]['host'] = $object->host;
            $list[$index]['database_name'] = $object->database_name;
            $list[$index]['username'] = $object->username;
            $list[$index]['password'] = $object->password;
            $list[$index]['port'] = $object->port;
            $index++;
        }

        return $list;
    }
    
    public function post_database(Request $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');
        
        $id = intval($request->input('id'));

        if ($id > 0) {
            if (!$advied_admin) {
                $has_error = true;
                $error_msg = __('You can not update this object. Contact your system administrator for more information.');
            } else {
                $objectDatabase = Database::find($id);
            }
        } else {
            if (!$advied_admin) {
                $has_error = true;
                $error_msg = __('You can not create any object. Contact your system administrator for more information.');
            } else {
                $objectDatabase = new Database();
            }
        } // if ($id > 0) {

        if ($has_error) {
            $return_data['id'] = $id;
            $return_data['has_error'] = $has_error;
            $return_data['error_msg'] = $error_msg;

            return $return_data;
        }
        
        $objectDatabase->deleted = 0;
        
        $objectDatabase->enabled = ('' != $request->input('enabled'))
                ? intval($request->input('enabled'))
                : 0;
                
        $objectDatabase->title = $request->input('title');

        $objectDatabase->database_type = ('' != $request->input('database_type'))
                ? intval($request->input('database_type'))
                : 0;

        $objectDatabase->host = $request->input('host');
        $objectDatabase->database_name = $request->input('database_name');
        $objectDatabase->username = $request->input('username');
        $objectDatabase->password = $request->input('password');

        $objectDatabase->port = ('' != $request->input('port'))
                ? intval($request->input('port'))
                : 0;
                


        $connectionData = $this->getPDOConnection($objectDatabase);

        if ($connectionData['has_error']) {
            $return_data['id'] = $id;
            $return_data['has_error'] = true;
            $return_data['error_msg'] = $connectionData['error_msg'];

            return $return_data;
        }

        $objectDatabase->save();
        
        $return_data['id'] = $objectDatabase->id;
        $return_data['has_error'] = false;
        $return_data['error_msg'] = '';

        return $return_data;
    }

    public function getPDOConnection($objDatabase) 
    {
        $result = [];
        $result['connection'] = null;
        $result['has_error'] = false;
        $result['error_msg'] = '';
    
        $Lookup = Lookup::where('id', $objDatabase->database_type)->where('deleted', 0)->first();
        
        $port = $Lookup->value3;
        if (intval($objDatabase->port) > 0) {
            $port = intval($objDatabase->port);
        }
    
        $connectionText = $Lookup->value2;
        $connectionText = str_replace('{{HOST}}', $objDatabase->host, $connectionText);
        $connectionText = str_replace('{{PORT}}', $port, $connectionText);
        $connectionText = str_replace('{{DB_NAME}}', $objDatabase->database_name, $connectionText);
    
        try {
            $result['connection'] = new PDO($connectionText, $objDatabase->username, $objDatabase->password);
        } catch (\PDOException $e) {
            $result['connection'] = null;
            $result['has_error'] = true;
            $result['error_msg'] = $e->getMessage();
        }
    
        return $result;
    }

    public function delete_database(Request $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');

        if (!$advied_admin) {
            $return_data['id'] = 1;
            $return_data['has_error'] = true;
            $return_data['error_msg'] = __('You can not delete this object. Contact your system administrator for more information.');

            return $return_data;
        }

        $selected_ids = $request->input('selected_ids');
        $objects = Database::where('deleted', false)
                ->whereIn('id', $selected_ids)
                ->get();

        foreach ($objects as $object)
        {
            $object->deleted = 1;
            $object->save();                
        } // foreach ($objects as $object)

        return $return_data;
    }

    public function get_databasetype_list(Request $request) 
    {    
        $objectList = Lookup::where('group', 'database_type')
            ->orderBy('__order', 'asc')
            ->get();
            
        $list = [];
        $index = 0;
        
        foreach ($objectList as $object)
        {
            if (1 == $object->deleted) {
                continue;
            }

            if (0 == $object->enabled) {
                continue;
            }

            $list[$index]['id'] = $object->id;
            $list[$index]['text'] = $object->title;

            $index++;
        } // foreach ($objectList as $object)
        
        return [
            'list' => $list
        ];
    }

    public function get_database_option_list(Request $request) 
    {    
        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');

        $objectList = Database::where('deleted', 0)
            ->orderBy('title', 'asc')
            ->get();

        $list = [];
        $index = 0;
        
        foreach ($objectList as $object)
        {
            if (!$advied_admin) {
                if (0 == $object->enabled) {
                    continue;
                }
            }

            $list[$index]['id'] = $object->id;
            $list[$index]['text'] = $object->title;
            $list[$index]['deleted'] = $object->deleted;
            $list[$index]['created_at'] = $object->created_at;
            $list[$index]['updated_at'] = $object->updated_at;
            $list[$index]['enabled'] = $object->enabled;
            $list[$index]['title'] = $object->title;
            $list[$index]['database_type'] = $object->database_type;
            $list[$index]['host'] = $object->host;
            $list[$index]['database_name'] = $object->database_name;
            $list[$index]['username'] = $object->username;
            $list[$index]['password'] = $object->password;
            $list[$index]['port'] = $object->port;

            $index++;
        } // foreach ($objectList as $object)

        return [
            'list' => $list
        ];
    }

    public function get_actionlist(Request $request)
    {
        $parameters = $request->route()->parameters();

        $template_id = isset($parameters['template_id'])
                ? intval($parameters['template_id'])
                : 0;

        $objectList = Action::where('template_id', $template_id)
            ->orderBy('__order', 'asc')
            ->get();

        $list = [];
        $index = 0;

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');
        
        foreach ($objectList as $object)
        {
            if (1 == $object->deleted) {
                continue;
            }

            $list[$index] = array();
            $list[$index]['advied_admin'] = $advied_admin;            
            $list[$index]['id'] = $object->id;
            $list[$index]['deleted'] = $object->deleted;
            $list[$index]['created_at'] = $object->created_at;
            $list[$index]['updated_at'] = $object->updated_at;
            $list[$index]['enabled'] = $object->enabled;
            $list[$index]['__order'] = $object->__order;
            $list[$index]['template_id'] = $object->template_id;
            $list[$index]['title'] = $object->title;
            $list[$index]['condition'] = $object->condition;
            $list[$index]['operation'] = $object->operation;

            $index++;
        } // foreach ($objectList as $object)

        return [
            'list' => $list
        ];
    }

    public function get_variable_option_list(Request $request)
    {
        $columns = [
            'id',
            'text'
        ];
    
        $list = array();
    
        $excelColumns = [
            ['id' => 'column_a', 'text' => 'Column A'],
            ['id' => 'column_b', 'text' => 'Column B'],
            ['id' => 'column_c', 'text' => 'Column C'],
            ['id' => 'column_d', 'text' => 'Column D'],
            ['id' => 'column_e', 'text' => 'Column E'],
            ['id' => 'column_f', 'text' => 'Column F'],
            ['id' => 'column_g', 'text' => 'Column G'],
            ['id' => 'column_h', 'text' => 'Column H'],
            ['id' => 'column_i', 'text' => 'Column I'],
            ['id' => 'column_j', 'text' => 'Column J'],
            ['id' => 'column_k', 'text' => 'Column K'],
            ['id' => 'column_l', 'text' => 'Column L'],
            ['id' => 'column_m', 'text' => 'Column M'],
            ['id' => 'column_n', 'text' => 'Column N'],
            ['id' => 'column_o', 'text' => 'Column O'],
            ['id' => 'column_p', 'text' => 'Column P'],
            ['id' => 'column_q', 'text' => 'Column Q'],
            ['id' => 'column_r', 'text' => 'Column R'],
            ['id' => 'column_s', 'text' => 'Column S'],
            ['id' => 'column_t', 'text' => 'Column T'],
            ['id' => 'column_u', 'text' => 'Column U'],
            ['id' => 'column_v', 'text' => 'Column V'],
            ['id' => 'column_w', 'text' => 'Column W'],
            ['id' => 'column_x', 'text' => 'Column X'],
            ['id' => 'column_y', 'text' => 'Column Y'],
            ['id' => 'column_z', 'text' => 'Column Z'],
            ['id' => 'column_aa', 'text' => 'Column AA'],
            ['id' => 'column_ab', 'text' => 'Column AB'],
            ['id' => 'column_ac', 'text' => 'Column AC'],
            ['id' => 'column_ad', 'text' => 'Column AD'],
            ['id' => 'column_ae', 'text' => 'Column AE'],
            ['id' => 'column_af', 'text' => 'Column AF'],
            ['id' => 'column_ag', 'text' => 'Column AG'],
            ['id' => 'column_ah', 'text' => 'Column AH'],
            ['id' => 'column_ai', 'text' => 'Column AI'],
            ['id' => 'column_aj', 'text' => 'Column AJ'],
            ['id' => 'column_ak', 'text' => 'Column AK'],
            ['id' => 'column_al', 'text' => 'Column AL'],
            ['id' => 'column_am', 'text' => 'Column AM'],
            ['id' => 'column_an', 'text' => 'Column AN'],
            ['id' => 'column_ao', 'text' => 'Column AO'],
            ['id' => 'column_ap', 'text' => 'Column AP'],
            ['id' => 'column_aq', 'text' => 'Column AQ'],
            ['id' => 'column_ar', 'text' => 'Column AR'],
            ['id' => 'column_as', 'text' => 'Column AS'],
            ['id' => 'column_at', 'text' => 'Column AT'],
            ['id' => 'column_au', 'text' => 'Column AU'],
            ['id' => 'column_av', 'text' => 'Column AV'],
            ['id' => 'column_aw', 'text' => 'Column AW'],
            ['id' => 'column_ax', 'text' => 'Column AX'],
            ['id' => 'column_ay', 'text' => 'Column AY'],
            ['id' => 'column_az', 'text' => 'Column AZ']
        ];
    
        $tempColumns = [];
        
        for ($i=1; $i < 33; $i++) { 
            $tempColumns[$i]['id'] = 'temp_' . $i;
            $tempColumns[$i]['text'] = 'Temp Variable ' . $i;
        }
    
        $list = array_merge($excelColumns, $tempColumns);

        return [
            'list' => $list
        ];
    }

    public function get_result_option_list(Request $request)
    {
        $columns = [
            'id',
            'text'
        ];
    
        $list = array();
    
        $tempColumns = [];
    
        for ($i=0; $i < 33; $i++) { 
            $tempColumns[$i]['id'] = 'temp_' . ($i + 1);
            $tempColumns[$i]['text'] = 'Temp Variable ' . ($i + 1);
        }
    
        $list = $tempColumns;

        return [
            'list' => $list
        ];
    }

    public function post_action(Request $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');

        $id = intval($request->input('id'));

        if ($id > 0) {
            if (!$advied_admin) {
                $has_error = true;
                $error_msg = __('You can not update this object. Contact your system administrator for more information.');
            } else {
                $objectAction = Action::find($id);
            }
        } else {
            if (!$advied_admin) {
                $has_error = true;
                $error_msg = __('You can not create any object. Contact your system administrator for more information.');
            } else {
                $objectAction = new Action();
            }
        } // if ($id > 0) {

        if ($has_error) {
            $return_data['id'] = $id;
            $return_data['has_error'] = $has_error;
            $return_data['error_msg'] = $error_msg;

            return $return_data;
        }
        
        $objectAction->deleted = 0;
        $objectAction->enabled = ('' != $request->input('enabled'))
                ? intval($request->input('enabled'))
                : 0;
        if (!empty($request->input('template_id'))) {
		    $objectAction->template_id = intval($request->input('template_id'));
        }
        $objectAction->__order = ('' != $request->input('__order'))
                ? intval($request->input('__order'))
                : 0;
        $objectAction->title = $request->input('title');
        $objectAction->condition = $request->input('condition_json');
        $objectAction->operation = $request->input('operation_json');

		$objectAction->save();

        $IED = new IED;
        $IED->createActionFunctionFile($objectAction);

        $return_data['id'] = $objectAction->id;
        $return_data['has_error'] = false;
        $return_data['error_msg'] = '';

        return $return_data;
    }

    public function delete_action(Request $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');

        if (!$advied_admin) {
            $return_data['id'] = 1;
            $return_data['has_error'] = true;
            $return_data['error_msg'] = __('You can not delete this object. Contact your system administrator for more information.');

            return $return_data;
        }

        $selected_ids = $request->input('selected_ids');
        $objects = Action::where('deleted', false)
                ->whereIn('id', $selected_ids)
                ->get();

        foreach ($objects as $object)
        {
            $object->deleted = 1;
            $object->save();                
        } // foreach ($objects as $object)

        return $return_data;
    }

    public function get_validationlist(Request $request)
    {
        $parameters = $request->route()->parameters();

        $template_id = isset($parameters['template_id'])
                ? intval($parameters['template_id'])
                : 0;

        $objectList = Validation::where('template_id', $template_id)
            ->orderBy('__order', 'asc')
            ->get();

        $list = [];
        $index = 0;

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');
        
        foreach ($objectList as $object)
        {
            if (1 == $object->deleted) {
                continue;
            }

            $list[$index] = array();
            $list[$index]['advied_admin'] = $advied_admin;            
            $list[$index]['id'] = $object->id;
            $list[$index]['deleted'] = $object->deleted;
            $list[$index]['created_at'] = $object->created_at;
            $list[$index]['updated_at'] = $object->updated_at;
            $list[$index]['enabled'] = $object->enabled;
            $list[$index]['__order'] = $object->__order;
            $list[$index]['template_id'] = $object->template_id;
            $list[$index]['condition'] = $object->condition;
            $list[$index]['message'] = $object->message;

            $index++;
        } // foreach ($objectList as $object)

        return [
            'list' => $list
        ];
    }

    public function post_validation(Request $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');
        
        $id = intval($request->input('id'));

        if ($id > 0) {
            if (!$advied_admin) {
                $has_error = true;
                $error_msg = __('You can not update this object. Contact your system administrator for more information.');
            } else {
                $objectValidation = Validation::find($id);
            }
        } else {
            if (!$advied_admin) {
                $has_error = true;
                $error_msg = __('You can not create any object. Contact your system administrator for more information.');
            } else {
                $objectValidation = new Validation();
            }
        } // if ($id > 0) {

        if ($has_error) {
            $return_data['id'] = $id;
            $return_data['has_error'] = $has_error;
            $return_data['error_msg'] = $error_msg;

            return $return_data;
        }
        
        $objectValidation->deleted = 0;
        $objectValidation->enabled = ('' != $request->input('enabled'))
                ? intval($request->input('enabled'))
                : 0;
        if (!empty($request->input('template_id'))) {
		    $objectValidation->template_id = intval($request->input('template_id'));
        }
        $objectValidation->__order = ('' != $request->input('__order'))
                ? intval($request->input('__order'))
                : 0;
        $objectValidation->message = $request->input('message');
        $objectValidation->condition = $request->input('condition_json');

		$objectValidation->save();

        $IED = new IED;
        $IED->createValidationConditionFunctionFile($objectValidation);

        $return_data['id'] = $objectValidation->id;
        $return_data['has_error'] = false;
        $return_data['error_msg'] = '';

        return $return_data;
    }

    public function delete_validation(Request $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');

        if (!$advied_admin) {
            $return_data['id'] = 1;
            $return_data['has_error'] = true;
            $return_data['error_msg'] = __('You can not delete this object. Contact your system administrator for more information.');

            return $return_data;
        }

        $selected_ids = $request->input('selected_ids');
        $objects = Validation::where('deleted', false)
                ->whereIn('id', $selected_ids)
                ->get();

        foreach ($objects as $object)
        {
            $object->deleted = 1;
            $object->save();                
        } // foreach ($objects as $object)

        return $return_data;
    }

    public function get_querylist(Request $request)
    {
        $parameters = $request->route()->parameters();

        $template_id = isset($parameters['template_id'])
                ? intval($parameters['template_id'])
                : 0;

        $objectList = Query::where('template_id', $template_id)
            ->orderBy('__order', 'asc')
            ->get();

        $list = [];
        $index = 0;

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');
        
        foreach ($objectList as $object)
        {
            if (1 == $object->deleted) {
                continue;
            }

            $list[$index] = array();
            $list[$index]['advied_admin'] = $advied_admin;            
            $list[$index]['id'] = $object->id;
            $list[$index]['deleted'] = $object->deleted;
            $list[$index]['created_at'] = $object->created_at;
            $list[$index]['updated_at'] = $object->updated_at;
            $list[$index]['enabled'] = $object->enabled;
            $list[$index]['__order'] = $object->__order;
            $list[$index]['template_id'] = $object->template_id;
            $list[$index]['database_id'] = $object->database_id;
            $list[$index]['condition'] = $object->condition;
            $list[$index]['query'] = $object->query;

            $index++;
        } // foreach ($objectList as $object)

        return [
            'list' => $list
        ];
    }
    
    public function post_query(Request $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');
        
        $id = intval($request->input('id'));

        if ($id > 0) {
            if (!$advied_admin) {
                $has_error = true;
                $error_msg = __('You can not update this object. Contact your system administrator for more information.');
            } else {
                $objectQuery = Query::find($id);
            }
        } else {
            if (!$advied_admin) {
                $has_error = true;
                $error_msg = __('You can not create any object. Contact your system administrator for more information.');
            } else {
                $objectQuery = new Query();
            }
        } // if ($id > 0) {

        if ($has_error) {
            $return_data['id'] = $id;
            $return_data['has_error'] = $has_error;
            $return_data['error_msg'] = $error_msg;

            return $return_data;
        }
        
        $objectQuery->deleted = 0;
        $objectQuery->enabled = ('' != $request->input('enabled'))
                ? intval($request->input('enabled'))
                : 0;
        if (!empty($request->input('template_id'))) {
		    $objectQuery->template_id = intval($request->input('template_id'));
        }
        if (!empty($request->input('database_id'))) {
		    $objectQuery->database_id = intval($request->input('database_id'));
        }
        $objectQuery->__order = ('' != $request->input('__order'))
                ? intval($request->input('__order'))
                : 0;
        $objectQuery->query = $request->input('query');
        $objectQuery->condition = $request->input('condition_json');

		$objectQuery->save();

        $IED = new IED;
        $IED->createQueryConditionFunctionFile($objectQuery);

        $return_data['id'] = $objectQuery->id;
        $return_data['has_error'] = false;
        $return_data['error_msg'] = '';

        return $return_data;
    }

    public function delete_query(Request $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');

        if (!$advied_admin) {
            $return_data['id'] = 1;
            $return_data['has_error'] = true;
            $return_data['error_msg'] = __('You can not delete this object. Contact your system administrator for more information.');

            return $return_data;
        }

        $selected_ids = $request->input('selected_ids');
        $objects = Query::where('deleted', false)
                ->whereIn('id', $selected_ids)
                ->get();

        foreach ($objects as $object)
        {
            $object->deleted = 1;
            $object->save();                
        } // foreach ($objects as $object)

        return $return_data;
    }

    public function get_import_form(Request $request)
    {
        $list = [];

        $list[0]['id'] = 1;
        $list[0]['template_id'] = 0;
        $list[0]['import_data'] = '';

        return [
            'list' => $list
        ];
    }
    
    public function post_import_form(Request $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $id = intval($request->input('id'));
        $template_id = intval($request->input('template_id'));
        $import_data = ($request->input('import_data'));

        $dataLength = count($import_data);

        if ($dataLength < 2) {
            $has_error = true;
            $error_msg = ('The excel file uploaded is empty.');
        }

        $objTemplate = Template::find($template_id);

        $IED = new IED;
        $variables = $IED->getVariablesArray($template_id, $import_data);

        $excelRowsData = $IED->getExcelRowsData($template_id, $import_data, $variables);

        $excelRowsData = $IED->validateVariables($template_id, $excelRowsData);

        foreach ($excelRowsData as $index => $data) {
            if ($data['has_error']) {
                foreach($data['errors'] as $error) {
                    $has_error = true;

                    if ($error_msg != '') {
                        $error_msg .= '<br>';
                    } // if ($error_msg != '') {

                    $error_msg .= ('<b>Row ' . $error['line'] . ': </b>' . $error['msg']);
                }
            }
        }

        if ($has_error) {
            $return_data['id'] = $id;
            $return_data['has_error'] = $has_error;
            $return_data['error_msg'] = $error_msg;

            return $return_data;
        }

        $result = $IED->executeImportQueries($template_id, $excelRowsData);

        if ($result['has_error']) {
            $has_error = true;

            if ($error_msg != '') {
                $error_msg .= '<br>';
            } // if ($error_msg != '') {

            $error_msg .= $result['error_msg'];

            return false;
        }

        if ($has_error) {
            $return_data['id'] = $id;
            $return_data['has_error'] = $has_error;
            $return_data['error_msg'] = $error_msg;

            return $return_data;
        }
        
        /* $controller->messageCount = 1;
        $controller->lastMessage = ('The file has been uploaded successfully using the template &quot;'
                . $objTemplate->title
                . '&quot; ('
                . date('d.m.Y H:i:s')
                . ').'); */

        // Custom functions
        /* includeLibrary('makeDBMaintenance');
        makeDBMaintenance();

        includeLibrary('emptyCacheFolder');
        emptyCacheFolder(); */

        $return_data['id'] = 1;
        $return_data['has_error'] = false;
        $return_data['error_msg'] = '';

        return $return_data;
    }

    public function get_parameterlist(Request $request)
    {
        $parameters = $request->route()->parameters();

        $template_id = isset($parameters['template_id'])
                ? intval($parameters['template_id'])
                : 0;

        $objectList = Parameter::where('template_id', $template_id)
            ->orderBy('__order', 'asc')
            ->get();

        $types = ['selection' => 'Selection', 'shorttext' => 'Short Text', 'number' => 'Number'];
        $list = [];
        $index = 0;

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');
        
        foreach ($objectList as $object)
        {
            if (1 == $object->deleted) {
                continue;
            }

            $list[$index] = array();
            $list[$index]['advied_admin'] = $advied_admin;            
            $list[$index]['id'] = $object->id;
            $list[$index]['deleted'] = $object->deleted;
            $list[$index]['created_at'] = $object->created_at;
            $list[$index]['updated_at'] = $object->updated_at;
            $list[$index]['enabled'] = $object->enabled;
            $list[$index]['__order'] = $object->__order;
            $list[$index]['template_id'] = $object->template_id;
            $list[$index]['title'] = $object->title;
            $list[$index]['name'] = $object->name;
            $list[$index]['type'] = $object->type;
            $list[$index]['option_titles'] = $object->option_titles;
            $list[$index]['option_values'] = $object->option_values;
            $list[$index]['default'] = $object->default;

            $index++;
        } // foreach ($objectList as $object)

        return [
            'list' => $list
        ];
    }
    
    public function post_parameter(Request $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');
        
        $id = intval($request->input('id'));

        if ($id > 0) {
            if (!$advied_admin) {
                $has_error = true;
                $error_msg = __('You can not update this object. Contact your system administrator for more information.');
            } else {
                $objectParameter = Parameter::find($id);
            }
        } else {
            if (!$advied_admin) {
                $has_error = true;
                $error_msg = __('You can not create any object. Contact your system administrator for more information.');
            } else {
                $objectParameter = new Parameter();
            }
        } // if ($id > 0) {

        if ($has_error) {
            $return_data['id'] = $id;
            $return_data['has_error'] = $has_error;
            $return_data['error_msg'] = $error_msg;

            return $return_data;
        }
        
        $objectParameter->deleted = 0;
        $objectParameter->enabled = ('' != $request->input('enabled'))
                ? intval($request->input('enabled'))
                : 0;
        if (!empty($request->input('template_id'))) {
		    $objectParameter->template_id = intval($request->input('template_id'));
        }
        
        $objectParameter->__order = ('' != $request->input('__order'))
                ? intval($request->input('__order'))
                : 0;

        $objectParameter->title = $request->input('title');
        $objectParameter->name = $request->input('name');
        $objectParameter->type = $request->input('type');
        $objectParameter->option_titles = $request->input('option_titles');
        $objectParameter->option_values = $request->input('option_values');
        $objectParameter->default = $request->input('default');

		$objectParameter->save();

        $return_data['id'] = $objectParameter->id;
        $return_data['has_error'] = false;
        $return_data['error_msg'] = '';

        return $return_data;
    }

    public function delete_parameter(Request $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $objectAdminLTE = new AdminLTE();
        $advied_admin = $objectAdminLTE->isAdviedAdmin('advied_admin');

        if (!$advied_admin) {
            $return_data['id'] = 1;
            $return_data['has_error'] = true;
            $return_data['error_msg'] = __('You can not delete this object. Contact your system administrator for more information.');

            return $return_data;
        }

        $selected_ids = $request->input('selected_ids');
        $objects = Parameter::where('deleted', false)
                ->whereIn('id', $selected_ids)
                ->get();

        foreach ($objects as $object)
        {
            $object->deleted = 1;
            $object->save();                
        } // foreach ($objects as $object)

        return $return_data;
    }

    public function get_export_form(Request $request)
    {
        $list = [];

        $list[0]['id'] = 1;
        $list[0]['template_id'] = 0;
        $list[0]['parameters'] = '';

        return [
            'list' => $list
        ];
    }
    
    public function post_export_form(Request $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $id = intval($request->input('id'));
        $template_id = intval($request->input('template_id'));
        $parameters = ($request->input('parameters'));

        $sessionKey = sha1('exportpage'). '_export_parameters';
        $request->session()->put($sessionKey, $parameters);

        $return_data['id'] = 1;
        $return_data['has_error'] = false;
        $return_data['error_msg'] = '';

        return $return_data;
    }

    public function get_export_table(Request $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $parameters = $request->route()->parameters();

        $template_id = isset($parameters['template_id'])
                ? intval($parameters['template_id'])
                : 0;

        $objTemplate = Template::find($template_id);

        $sessionKey = sha1('exportpage'). '_export_parameters';
        $params = $request->session()->get($sessionKey);

        $IED = new IED;
        $results = $IED->executeExportQueries($objTemplate, $params);

        if ($results['has_error']) {
            $return_data['id'] = $template_id;
            $return_data['has_error'] = $has_error;
            $return_data['error_msg'] = $results['error_msg'];

            return $return_data;
        }

        if (0 == count($results['data'])) {
            $return_data['id'] = $template_id;
            $return_data['has_error'] = true;
            $return_data['error_msg'] = 'No results found.';
            return $return_data;
        }


        $titles = '';
        $values = '';

        if (!$has_error) {
            foreach ($results['data'][0] as $key => $value) {
                if ('' != $titles) {
                    $titles .= ',';
                }

                $titles .= $key;
            }

            
            $values = json_encode($results['data'], (JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS));
        }

        $ParameterList = Parameter::where('template_id', $template_id)
            ->orderBy('__order', 'asc')
            ->get();

        $parametersHTML = '';

        foreach ($ParameterList as $Parameter) {
            if (1 == $Parameter->deleted) {
                continue;
            }
            
            $parameterHTML = '<div class="divParameter" id="divParameter_' . $Parameter->name . '">'
                    . '<span class="spanParameterTitle">' . $Parameter->title . ': </span>';

            if (isset($params[$Parameter->name])) {
                $value = $params[$Parameter->name];
            } else {
                $value = $Parameter->default;
            }

            if ('selection' == $Parameter->type) {
                $option_titles = explode("\n", $Parameter->option_titles);
                $option_values = explode("\n", $Parameter->option_values);

                
                $countValues = count($option_values);
                for ($i=0; $i < $countValues; $i++) { 
                    $option_value = trim($option_values[$i]);
                    if ($value == $option_value) {
                        $value = $option_titles[$i];
                    }
                }
            }

            $parameterHTML = $parameterHTML
                . '<span class="spanParameterValue">' . $value . '<span>'
                . '</div>';

            $parametersHTML .= $parameterHTML;
		} // foreach ($ParameterList as $Parameter) {
        
        $list['id'] = 1;
        $list['title'] = $objTemplate->title;
        $list['description'] = $objTemplate->description;
        $list['parameters'] = $parametersHTML;
        $list['titles'] = $titles;
        $list['values'] = $values;

        return [
            'data' => $list
        ];
    }
}