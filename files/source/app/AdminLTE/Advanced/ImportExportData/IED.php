<?php

namespace App\AdminLTE\Advanced\ImportExportData;
use App\AdminLTE\Advanced\ImportExportData\Template;
use App\AdminLTE\Advanced\ImportExportData\Database;
use App\AdminLTE\Advanced\ImportExportData\Lookup;
use App\AdminLTE\Advanced\ImportExportData\Action;
use App\AdminLTE\Advanced\ImportExportData\Validation;
use App\AdminLTE\Advanced\ImportExportData\Query;
use App\AdminLTE\Advanced\ImportExportData\Parameter;
use Illuminate\Support\Facades\Storage;

class IED
{	
	public $excel_columns = [
		'column_a', 'column_b', 'column_c', 'column_d', 'column_e', 'column_f',
		'column_g', 'column_h', 'column_i', 'column_j', 'column_k', 'column_l',
		'column_m', 'column_n', 'column_o', 'column_p', 'column_q', 'column_r',
		'column_s', 'column_t', 'column_u', 'column_v', 'column_w', 'column_x',
		'column_y', 'column_z', 
		'column_aa', 'column_ab', 'column_ac', 'column_ad', 
		'column_ae', 'column_af', 'column_ag', 'column_ah', 'column_ai', 'column_aj', 
		'column_ak', 'column_al', 'column_am', 'column_an', 'column_ao', 'column_ap', 
		'column_aq', 'column_ar', 'column_as', 'column_at', 'column_au', 'column_av', 
		'column_aw', 'column_ax', 'column_ay', 'column_az'
	];

	public function __construct()
	{

	}

	public function createActionFunctionFile($object)
	{
		$functionCodeHeader = '<' . '?' . 'php'
				. "\n"
				. 'function action' . $object->id . '(&$variables) {'
				. "\n";

		$functionCodeBody = '';
		$functionCodeFooter = '';
		$functionCodeFooter = $functionCodeFooter . "\n" . '}';


		$history = [];
		$functionCodeBody = $this->generateActionConditionCode($object->condition, $object->operation, $history);

		// Initialize Used Variables
		if (!isset($history['used_variables']))
		{
			$history['used_variables'] = [];
		}

		$keys = array_keys($history['used_variables']);
		$keyCount = count($keys);

		for ($i = 0; $i < $keyCount; $i++)
		{
			$functionCodeHeader .= "\n\t"
					. 'if (!isset('
					. '$'
					. 'variables[\''
					. $keys[$i]
					. '\'])) {'
					. "\n\t\t"
					. '$'
					. 'variables[\''
					. $keys[$i]
					. '\'] = null;'
					. "\n\t"
					. '}'
					. "\n";
		}

		$functionFilePath = ('/adv/ied/action/'
				. $object->id
				. '.php');

		Storage::disk('local')->put($functionFilePath,
				($functionCodeHeader
				. $functionCodeBody
				. $functionCodeFooter));
	}

	private function generateActionConditionCode($conditionJSON, $operationJSON, &$history)
	{
		$operationHeaderCode = '';
		$operationBodyCode = '';
		$operationFooterCode = '';

		$conditions = json_decode($conditionJSON, true);

		if (isset($conditions['condition']))
		{
			$operationHeaderCode = $operationHeaderCode . "\n\t" . 'if ';
			$operationHeaderCode = $operationHeaderCode . $this->generateConditionCode(
					$conditions['rules'],
					$history,
					$conditions['condition']);
			$operationHeaderCode = $operationHeaderCode . ' {' . "\n";
			$operationFooterCode = $operationFooterCode . "\n\t" . '}';
		}

		$operations = json_decode($operationJSON, true);
		$operationCount = count($operations);
		$operation = null;

		for ($i = 0; $i < $operationCount; $i++)
		{
			$operation = $operations[$i];

			if ($operation['enabled'] != true)
			{
				continue;
			}

			$operationBodyCode .= $this->generateOperationCode($operation, $history);
		}

		return ($operationHeaderCode . $operationBodyCode . $operationFooterCode);
	}

	private function generateConditionCode($rules, &$history, $condition = 'AND')
	{
		$ruleCount = count($rules);
		$rule = null;
		$andOr = ' && ';

		if ($condition[0] == 'A')
		{
			$andOr = ' && ';
		} else {
			$andOr = ' || ';
		}

		$code = '(';

		for ($i = 0; $i < $ruleCount; $i++)
		{
			if ($i > 0)
			{
				$code .= $andOr;
			}

			$rule = $rules[$i];

			if (isset($rule['rules']))
			{
				$code .= $this->generateConditionCode(
						$rule['rules'],
						$history,
						$rule['condition']);
			} else {
				$code .= $this->generateConditionRuleCode(
						$rule,
						$history);
			}
		}

		$code .= ')';

		if ($code == '()')
		{
			$code = '(1)';
		}

		return $code;
	}

	private function generateConditionRuleCode($rule, &$history)
	{
		$code = '';

		if (!isset($rule['field']))
		{
			return $code;
		}
		
		$history['used_variables'][$rule['field']] = 1;

		$code = '(';
		
		switch ($rule['operator'])
		{
			case 'equal':

				$code .= '$' . 'variables[\''
						. $rule['field']
						. '\']'
						. ' == '
						. $this->generateConditionRuleValueCode(
						$rule['value'],
						$history);

			break;
			case 'not_equal':

				$code .= '$' . 'variables[\''
						. $rule['field']
						. '\']'
						. ' != '
						. $this->generateConditionRuleValueCode(
						$rule['value'],
						$history);

			break;
			case 'contains':
			case 'in':

				$code .= 'strpos('
						. $this->generateConditionRuleValueCode(
						$rule['value'],
						$history)
						. ',$' . 'variables[\''
						. $rule['field']
						. '\']) !== false';

			break;
			case 'not_in':
			case 'not_contains':

				$code .= 'strpos('
						. $this->generateConditionRuleValueCode(
						$rule['value'],
						$history)
						. ',$' . 'variables[\''
						. $rule['field']
						. '\']) === false';

			break;
			case 'less':

				$code .= 'floatval($' . 'variables[\''
						. $rule['field']
						. '\']'
						. ') < floatval('
						. $this->generateConditionRuleValueCode(
						$rule['value'],
						$history)
						. ')';

			break;
			case 'less_or_equal':

				$code .= 'floatval($' . 'variables[\''
						. $rule['field']
						. '\']'
						. ') <= floatval('
						. $this->generateConditionRuleValueCode(
						$rule['value'],
						$history)
						. ')';

			break;
			case 'greater':

				$code .= 'floatval($' . 'variables[\''
						. $rule['field']
						. '\']'
						. ') > floatval('
						. $this->generateConditionRuleValueCode(
						$rule['value'],
						$history)
						. ')';

			break;
			case 'greater_or_equal':

				$code .= 'floatval($' . 'variables[\''
						. $rule['field']
						. '\']'
						. ') >= floatval('
						. $this->generateConditionRuleValueCode(
						$rule['value'],
						$history)
						. ')';

			break;
			case 'begins_with':

				$code .= 'strpos('
						. $this->generateConditionRuleValueCode(
						$rule['value'],
						$history)
						. ',$' . 'variables[\''
						. $rule['field']
						. '\']) === 0';

			break;
			case 'not_begins_with':

				$code .= 'strpos('
						. $this->generateConditionRuleValueCode(
						$rule['value'],
						$history)
						. ',$' . 'variables[\''
						. $rule['field']
						. '\']) !== 0';

			break;
			case 'ends_with':

				$code .= ('(strlen('
						. $this->generateConditionRuleValueCode(
						$rule['value'],
						$history)
						. ') - strlen('
						. '$'
						. 'variables[\''
						. $rule['field']
						. '\']))'
						. ' == strrpos('
						. $this->generateConditionRuleValueCode(
						$rule['value'],
						$history)
						. ','
						. '$'
						. 'variables[\''
						. $rule['field']
						. '\']'
						. ')');

			break;
			case 'not_ends_with':

				$code .= ('(strlen('
						. $this->generateConditionRuleValueCode(
						$rule['value'],
						$history)
						. ') - strlen('
						. '$'
						. 'variables[\''
						. $rule['field']
						. '\']))'
						. ' != strrpos('
						. $this->generateConditionRuleValueCode(
						$rule['value'],
						$history)
						. ','
						. '$'
						. 'variables[\''
						. $rule['field']
						. '\']'
						. ')');

			break;
			case 'is_empty':

				$code .= '$' . 'variables[\''
						. $rule['field']
						. '\']'
						. ' == \'\'';

			break;
			case 'is_not_empty':

				$code .= '$' . 'variables[\''
						. $rule['field']
						. '\']'
						. ' != \'\'';

			break;
			case 'is_null':

				$code .= '$' . 'variables[\''
						. $rule['field']
						. '\']'
						. ' == null';

			break;
			case 'is_not_null':

				$code .= '$' . 'variables[\''
						. $rule['field']
						. '\']'
						. ' != null';

			break;
			case 'is_integer':

				$code .= 'is_int('
						. '$' . 'variables[\''
						. $rule['field']
						. '\']'
						. ')';

			break;
			case 'is_not_integer':

				$code .= '!is_int('
						. '$' . 'variables[\''
						. $rule['field']
						. '\']'
						. ')';

			break;
			case 'is_numeric':

				$code .= 'is_numeric('
						. '$' . 'variables[\''
						. $rule['field']
						. '\']'
						. ')';

			break;
			case 'is_not_numeric':

				$code .= '!is_numeric('
						. '$' . 'variables[\''
						. $rule['field']
						. '\']'
						. ')';

			break;
			case 'matching_regex':

				$code .= 'preg_match('
						. $this->generateConditionRuleValueCode($rule['value'], $history)
						. ', '
						. '$' . 'variables[\''
						. $rule['field']
						. '\']'
						. ')';

			break;
			case 'not_matching_regex':

				$code .= '!preg_match('
						. $this->generateConditionRuleValueCode($rule['value'], $history)
						. ', '
						. '$' . 'variables[\''
						. $rule['field']
						. '\']'
						. ')';

			break;
		}

		$code .= ')';
		return $code;
	}

	private function generateConditionRuleValueCode($value, &$history)
	{
		$code = '';
		if ('' == $value)
		{
			return 'null';
		}

		$valueType = intval($value[0]);
		$value = substr($value, 2);

		if (2 == $valueType)
		{
			$history['used_variables'][$value] = 1;
			$code = '$variables[\''
					. $value
					. '\']';
		} else {
			$code = ('\'' . $value . '\'');
		}

		return $code;
	}

	private function generateOperationCode($operation, &$history)
	{
		$function_name = 'generate' . strtoupper($operation['function_id']) . 'FunctionCode';

		$code = '';

		if (method_exists($this, $function_name))
		{
			$code = $this->$function_name($operation, $history);

			if (isset($operation['result']) && ($operation['result'] != ''))
			{
				$code = $code . "\n\t\t" . $this->generateConditionRuleValueCode(('2;' . $operation['result']), $history)
					. '='
					. '$' . 'tempResult;' . "\n";
			}

			return $code;
		} else {
			return '';
		}
	}

	private function generateADDITIONFunctionCode($operation, &$history)
	{
		if (!isset($operation['parameters']))
		{
			return '';
		}

		if (!isset($operation['result']))
		{
			return '';
		}

		if (count($operation['parameters']) != 2)
		{
			return '';
		}

		$code = "\n\t\t" . '$' . 'tempResult=null;';
		$code = $code . "\n\t\t" . '$' . 'tempResult=floatval('
				. $this->generateFunctionParameterValueCode(
				$operation['parameters'][0],
				$history)
				. ');';
		$code = $code . "\n\t\t" . '$' . 'tempResult+=floatval('
				. $this->generateFunctionParameterValueCode(
				$operation['parameters'][1],
				$history)
				. ');'
				. "\n";
		
		return $code;
	}

	private function generateSUBTRACTIONFunctionCode($operation, &$history)
	{
		if (!isset($operation['parameters']))
		{
			return '';
		}

		if (!isset($operation['result']))
		{
			return '';
		}

		if (count($operation['parameters']) != 2)
		{
			return '';
		}

		$code = "\n\t\t" . '$' . 'tempResult=null;';
		$code = $code . "\n\t\t" . '$' . 'tempResult=floatval('
				. $this->generateFunctionParameterValueCode(
				$operation['parameters'][0],
				$history)
				. ');';
		$code = $code . "\n\t\t" . '$' . 'tempResult-=floatval('
				. $this->generateFunctionParameterValueCode(
				$operation['parameters'][1],
				$history)
				. ');'
				. "\n";
		
		return $code;
	}

	private function generateMULTIPLICATIONFunctionCode($operation, &$history)
	{
		if (!isset($operation['parameters']))
		{
			return '';
		}

		if (!isset($operation['result']))
		{
			return '';
		}

		if (count($operation['parameters']) != 2)
		{
			return '';
		}

		$code = "\n\t\t" . '$' . 'tempResult=null;';
		$code = $code . "\n\t\t" . '$' . 'tempResult=floatval('
				. $this->generateFunctionParameterValueCode(
				$operation['parameters'][0],
				$history)
				. ');';
		$code = $code . "\n\t\t" . '$' . 'tempResult*=floatval('
				. $this->generateFunctionParameterValueCode(
				$operation['parameters'][1],
				$history)
				. ');'
				. "\n";
		
		return $code;
	}

	private function generateDIVISIONFunctionCode($operation, &$history)
	{
		if (!isset($operation['parameters']))
		{
			return '';
		}

		if (!isset($operation['result']))
		{
			return '';
		}

		if (count($operation['parameters']) != 2)
		{
			return '';
		}

		$code = "\n\t\t" . '$' . 'tempResult=null;';
		$code = $code . "\n\t\t" . '$' . 'tempResult=floatval('
				. $this->generateFunctionParameterValueCode(
				$operation['parameters'][0],
				$history)
				. ');';
		$code = $code . "\n\t\t" . '$' . 'tempResult='
				. '$'
				. 'tempResult/floatval('
				. $this->generateFunctionParameterValueCode(
				$operation['parameters'][1],
				$history)
				. ');'
				. "\n";
		
		return $code;
	}

	private function generateFunctionParameterValueCode($parameter, &$history)
	{
		$code = '';
		if ('cv' == $parameter['type'])
		{
			if ('c' == $parameter['default_type'])
			{
				$code = $this->generateConditionRuleValueCode(
						'1;'
						. $parameter['value'],
						$history);
			} else {
				$code = $this->generateConditionRuleValueCode(
						'2;'
						. $parameter['value'],
						$history);
			}
		}

		return $code;
	}

	public function createValidationConditionFunctionFile($object)
	{
		$functionCodeHeader = '<' . '?' . 'php'
				. "\n"
				. 'function vc' . $object->id . '($variables) {'
				. "\n";

		$functionCodeBody = '';
		$functionCodeFooter = "\n\n\t" . 'return false;';
		$functionCodeFooter = $functionCodeFooter . "\n" . '}';


		$history = [];
		$functionCodeBody = $this->generateValidationConditionCode($object->condition, $history);

		// Initialize Used Variables
		if (!isset($history['used_variables']))
		{
			$history['used_variables'] = [];
		}

		$keys = array_keys($history['used_variables']);
		$keyCount = count($keys);

		for ($i = 0; $i < $keyCount; $i++)
		{
			$functionCodeHeader .= "\n\t"
					. 'if (!isset('
					. '$'
					. 'variables[\''
					. $keys[$i]
					. '\'])) {'
					. "\n\t\t"
					. '$'
					. 'variables[\''
					. $keys[$i]
					. '\'] = null;'
					. "\n\t"
					. '}'
					. "\n";
		}

		$functionFilePath = ('/adv/ied/validation/condition/'
				. $object->id
				. '.php');

		Storage::disk('local')->put($functionFilePath,
				($functionCodeHeader
				. $functionCodeBody
				. $functionCodeFooter));
	}

	private function generateValidationConditionCode($conditionJSON, &$history)
	{
		$operationHeaderCode = '';
		$operationFooterCode = '';

		$conditions = json_decode($conditionJSON, true);

		if (isset($conditions['condition']))
		{
			$operationHeaderCode = $operationHeaderCode . "\n\t" . 'if ';
			$operationHeaderCode = $operationHeaderCode . $this->generateConditionCode(
					$conditions['rules'],
					$history,
					$conditions['condition']);
			$operationHeaderCode = $operationHeaderCode . ' {' . "\n";
			$operationFooterCode = $operationFooterCode . "\n\t" . '}';
		}

		$operationBodyCode = "\t\t" . 'return true;';


		return ($operationHeaderCode . $operationBodyCode . $operationFooterCode);
	}

	public function createQueryConditionFunctionFile($object)
	{
		$functionCodeHeader = '<' . '?' . 'php'
				. "\n"
				. 'function qc' . $object->id . '($variables) {'
				. "\n";

		$functionCodeBody = '';
		$functionCodeFooter = "\n\n\t" . 'return false;';
		$functionCodeFooter = $functionCodeFooter . "\n" . '}';


		$history = [];
		$functionCodeBody = $this->generateQueryConditionCode($object->condition, $history);

		// Initialize Used Variables
		if (!isset($history['used_variables']))
		{
			$history['used_variables'] = [];
		}

		$keys = array_keys($history['used_variables']);
		$keyCount = count($keys);

		for ($i = 0; $i < $keyCount; $i++)
		{
			$functionCodeHeader .= "\n\t"
					. 'if (!isset('
					. '$'
					. 'variables[\''
					. $keys[$i]
					. '\'])) {'
					. "\n\t\t"
					. '$'
					. 'variables[\''
					. $keys[$i]
					. '\'] = null;'
					. "\n\t"
					. '}'
					. "\n";
		}

		$functionFilePath = ('/adv/ied/query/condition/'
				. $object->id
				. '.php');

		Storage::disk('local')->put($functionFilePath,
				($functionCodeHeader
				. $functionCodeBody
				. $functionCodeFooter));
	}

	private function generateQueryConditionCode($conditionJSON, &$history)
	{
		$operationHeaderCode = '';
		$operationFooterCode = '';

		$conditions = json_decode($conditionJSON, true);

		if (isset($conditions['condition']))
		{
			$operationHeaderCode = $operationHeaderCode . "\n\t" . 'if ';
			$operationHeaderCode = $operationHeaderCode . $this->generateConditionCode(
					$conditions['rules'],
					$history,
					$conditions['condition']);
			$operationHeaderCode = $operationHeaderCode . ' {' . "\n";
			$operationFooterCode = $operationFooterCode . "\n\t" . '}';
		}

		$operationBodyCode = "\t\t" . 'return true;';


		return ($operationHeaderCode . $operationBodyCode . $operationFooterCode);
	}

	public function getVariablesArray($template_id, $arrData) {
		$variables = [];

		// Excell Columns
		$columnCount = count($arrData[0]);

		for ($i=0; $i < $columnCount; $i++) { 
			$variables[$this->excel_columns[$i]] = '';
		}

		// Template Variables
		for ($i=1; $i < 33; $i++) { 
			$variables['temp_' . $i] = '';
		}

		return $variables;
	}

	public function getExcelRowsData($template_id, $arrData, $variables) {
		$excelRowsData = [];
		$excelRowsData[0]['line'] = 1;
		$excelRowsData[0]['is_line_valid'] = false;
		$excelRowsData[0]['variables'] = [];
		$excelRowsData[0]['has_error'] = false;
		$excelRowsData[0]['errors'] = [];

		$dataLength = count($arrData);

		for ($i=1; $i < $dataLength; $i++) { 
			$arrRowData = $arrData[$i];

			if (0 == count($arrRowData)) {
				// pass empty line
				$excelRowsData[$i]['line'] = ($i+1);
				$excelRowsData[$i]['is_line_valid'] = false;
				$excelRowsData[$i]['variables'] = [];
				$excelRowsData[$i]['has_error'] = false;
				$excelRowsData[$i]['errors'] = [];
				continue;
			}

			$temp_variables = $variables;

			$columnCount = count($arrRowData);
			for ($j=0; $j < $columnCount; $j++) {
				$rowVal = isset($arrRowData[$j]) ? trim($arrRowData[$j]) : '';
				$temp_variables[$this->excel_columns[$j]] = $this->getRowRealValue($rowVal);
			}

			$this->calculate_temp_variables($template_id, $temp_variables);

			$excelRowsData[$i]['line'] = ($i+1);
			$excelRowsData[$i]['is_line_valid'] = true;
			$excelRowsData[$i]['variables'] = $temp_variables;
			$excelRowsData[$i]['has_error'] = false;
			$excelRowsData[$i]['errors'] = [];
		}

		return $excelRowsData;
	}

	private function calculate_temp_variables($template_id, &$temp_variables) {
		$ActionList = Action::where('template_id', $template_id)
            ->orderBy('__order', 'asc')
            ->get();

		foreach ($ActionList as $Action) {
			if (1 == $Action->deleted || 0 == $Action->enabled) {
				continue;
			}

			$function_name = 'action' . $Action->id;

			require_once(storage_path('app/adv/ied/action/'
				. $Action->id
				. '.php'));
				
			$function_name($temp_variables);
		} // foreach
	}

	private function getRowRealValue($rowVal) {
		if (!is_numeric($rowVal)) {
			return $rowVal;
		}

		$floatVal = floatval($rowVal);
		$intVal = intval($rowVal);

		if ($floatVal == $intVal) {
			return $intVal;
		}

		return $floatVal;
	}

	public function validateVariables($template_id, $excelRowsData) {
		$validations = [];

		$ValidationList = Validation::where('template_id', $template_id)
            ->orderBy('__order', 'asc')
            ->get();

		$index = 0;

		foreach ($ValidationList as $Validation) {
			if (1 == $Validation->deleted || 0 == $Validation->enabled) {
				continue;
			}

			$function_name = 'vc' . $Validation->id;

			require_once(storage_path('app/adv/ied/validation/condition/'
				. $Validation->id
				. '.php'));

			$validations[$index]['function_name'] = $function_name;
			$validations[$index]['error_msg'] = $Validation->message;
			$index++;
		} // foreach

		foreach ($excelRowsData as $index => $data) {
			if ($data['is_line_valid']) {
				$temp_variables = $data['variables'];
				$has_error = false;
				$error_messages = [];
				$em_index = 0;

				foreach ($validations as $validation) {
					if ($validation['function_name']($temp_variables)) {
						$has_error = true;
						$error_messages[$em_index]['line'] = $data['line'];
						$error_messages[$em_index]['msg'] = $validation['error_msg'];
						$em_index++;
					}
				}

				$excelRowsData[$index]['has_error'] = $has_error;
				$excelRowsData[$index]['errors'] = $error_messages;
			}
		}

		return $excelRowsData;
	}

	public function executeImportQueries($template_id, $excelRowsData) {
		$queryDataList = [];

		$QueryList = Query::where('template_id', $template_id)
            ->orderBy('__order', 'asc')
            ->get();

		$index = 0;

		foreach ($QueryList as $Query) {
			if (1 == $Query->deleted || 0 == $Query->enabled) {
				continue;
			}

			$function_name = 'qc' . $Query->id;

			$queryDataList[$index]['database_id'] = $Query->database_id;
			$queryDataList[$index]['condition_file_path'] = '';
			$queryDataList[$index]['condition_function_name'] = '';
			$queryDataList[$index]['condition_file_path'] = ('app/adv/ied/query/condition/' . $Query->id . '.php');
			$queryDataList[$index]['condition_function_name'] = $function_name;
			$queryDataList[$index]['query'] = $Query->query;
		
			$index++;
		} // foreach

		return $this->__executeImportQueries($excelRowsData, $queryDataList);
	}

	private function __executeImportQueries($excelRowsData, $queryDataList)  {
		$result = [
			'has_error' => false,
			'error_msg' => ''
		];

		foreach ($excelRowsData as $data) {
			if (!$result['has_error'] && $data['is_line_valid']) {
				$variables = $data['variables']; 
				foreach ($queryDataList as $query_data) {
					require_once(storage_path($query_data['condition_file_path']));

					if (!$result['has_error'] && $query_data['condition_function_name']($variables)) {
						$result = $this->__executeImportQuery($variables, $query_data);
					}
				}
			}
		}

		return $result;
	}

	private function __executeImportQuery($variables, $query_data) {
		$result = [
			'has_error' => false,
			'error_msg' => ''
		];

		$Database = Database::find($query_data['database_id']);

		$connectionData = $this->getPDOConnection($Database);
		$connection = $connectionData['connection'];

		$SQL = $query_data['query'];

		foreach ($variables as $variable => $value) {
			if (null === $value) {
				$value = '';
			}

			$value = addslashes($value);

			$SQL = str_replace(('{{' . $variable . '}}'), $value, $SQL);
		}

        try {
            $objPDO = $connection->prepare($SQL); // bind parameters döngüyle yapılınca patlıyor..
            $objPDO->execute();

			if (0 != $objPDO->errorCode()) {
				$result['has_error'] = true;

				$errors = $objPDO->errorInfo();
				$result['error_msg'] = '<b>Query</b> : ' . $SQL . '<br>'
					. '<b>Error</b> : ' . $errors[2];
			}

        } catch (\PDOException $e) {
			$result['has_error'] = true;
			$result['error_msg'] = $e->getMessage();
        }

		return $result;
	}

	public function executeExportQueries($Template, $parameters) {
		$queryDataList = [];

		$QueryList = Query::where('template_id', $Template->id)
            ->orderBy('__order', 'asc')
            ->get();

		$index = 0;

		foreach ($QueryList as $Query) {
			if (1 == $Query->deleted || 0 == $Query->enabled) {
				continue;
			}

            $function_name = 'qc' . $Query->id;

			$queryDataList[$index]['database_id'] = $Query->database_id;
			$queryDataList[$index]['condition_file_path'] = '';
			$queryDataList[$index]['condition_function_name'] = '';
			$queryDataList[$index]['condition_file_path'] = ('app/adv/ied/query/condition/' . $Query->id . '.php');
			$queryDataList[$index]['condition_function_name'] = $function_name;
			$queryDataList[$index]['query'] = $Query->query;
		
			$index++;
		} // foreach
		
		return $this->__executeExportQueries($Template, $parameters, $queryDataList);
	}

	private function __executeExportQueries($Template, $parameters, $queryDataList)  {
		$result = [
			'has_error' => false,
			'error_msg' => ''
		];

        foreach ($queryDataList as $query_data) {
            require_once(storage_path($query_data['condition_file_path']));

            if (!$result['has_error'] && $query_data['condition_function_name']($parameters)) {
                $result = $this->__executeExportQuery($Template, $parameters, $query_data);
            }
        }

		return $result;
	}

	private function __executeExportQuery($Template, $parameters, $query_data) {
		$result = [
			'has_error' => false,
			'error_msg' => '',
			'data' => []
		];

        $Database = Database::find($query_data['database_id']);

		$connectionData = $this->getPDOConnection($Database);
		$connection = $connectionData['connection'];

		$SQL = htmlspecialchars_decode($query_data['query']);

		foreach ($parameters as $parameter => $value) {
			if (null === $value) {
				$value = $this->getParameterDefaultValue($Template, $parameter);
			}

			$SQL = str_replace(('{{' . $parameter . '}}'), $value, $SQL);
		}

        try {            
            $objPDO = $connection->prepare($SQL); // bind parameters döngüyle yapılınca patlıyor..
            $objPDO->execute();

			if (0 != $objPDO->errorCode()) {
				$result['has_error'] = true;

				$errors = $objPDO->errorInfo();
				$result['error_msg'] = '<b>Query</b> : ' . $SQL . '<br>'
					. '<b>Error</b> : ' . $errors[2];
			} else {
				$result_data = [];

				$data = $objPDO->fetchAll();

				foreach($data as $index => $row) {
					$result_data[$index] = array();

					foreach ($row as $key => $value) {
						if (!is_int($key)) {
							$result_data[$index][$key] = $value;
						}
					}
				}

				$result['data'] = $result_data;
			}

        } catch (\PDOException $e) {
			$result['has_error'] = true;
			$result['error_msg'] = $e->getMessage();
        }

		return $result;
	}

	private function getParameterDefaultValue($Template, $parameter) {
		$defaultValue = '';

		$ParameterList = Parameter::where('name', $parameter)
            ->orderBy('__order', 'asc')
            ->get();

		foreach ($ParameterList as $Parameter) {
            if ($Template->id == $Parameter->template_id) {
                $defaultValue = $Parameter->default;
            }
		} // foreach ($ParameterList as $Parameter) {

		return $defaultValue;
	}
	
	public function getPDOConnection($objDatabase) {
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
            $result['connection'] = new \PDO($connectionText, $objDatabase->username, $objDatabase->password);
        } catch (\PDOException $e) {
            $result['connection'] = null;
            $result['has_error'] = true;
            $result['error_msg'] = $e->getMessage();
        }
    
        return $result;
    }
	###########################
	###########################
	###########################
	###########################
	###########################
	###########################
	###########################
	######################################################
	###########################
	###########################
	######################################################
	###########################
	###########################
	######################################################
	###########################
	###########################
	######################################################
	###########################
	###########################
	######################################################
	###########################
	###########################
	######################################################
	###########################
	###########################
	######################################################
	###########################
	###########################
	######################################################
	###########################
	###########################
	######################################################
	###########################
	###########################
	###########################

	

	

	

	

	
}

/* {{@snippet:end_class}} */