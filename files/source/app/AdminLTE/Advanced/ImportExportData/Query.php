<?php

namespace App\AdminLTE\Advanced\ImportExportData;

use Illuminate\Database\Eloquent\Model;

use App\AdminLTE\AdminLTE;

class Query extends Model
{
	/* {{@snippet:begin_properties}} */

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'adminlteadviedquerytable';

	protected $fillable = [
		'enabled',
		'__order',
		'template_id',
		'database_id',
		'condition',
		'query'
	];

	public static $property_list = [
		[
			'name' => 'id',
			'type' => 'integer',
			'belongs_to' => 'Query',
			'display_property' => 'id',
			'title' => 'Id'
		],

		[
			'name' => 'deleted',
			'type' => 'checkbox',
			'belongs_to' => 'Query',
			'display_property' => 'deleted',
			'title' => 'Deleted'
		],

		[
			'name' => 'created_at',
			'type' => 'date',
			'belongs_to' => 'Query',
			'display_property' => 'created_at',
			'title' => 'Created At'
		],

		[
			'name' => 'updated_at',
			'type' => 'date',
			'belongs_to' => 'Query',
			'display_property' => 'updated_at',
			'title' => 'Updated at'
		],
        [
            'name' => 'enabled',
            'type' => 'checkbox',
            'belongs_to' => 'Query',
            'display_property' => 'enabled',
            'title' => 'Enabled'
        ],
        [
            'name' => '__order',
            'type' => 'integer',
            'belongs_to' => 'Query',
            'display_property' => '__order',
            'title' => 'Order'
        ],
        [
            'name' => 'template_id',
            'type' => 'class_selection_single',
            'belongs_to' => 'Template',
            'display_property' => 'title',
            'title' => 'Template'

        ],
        [
            'name' => 'database_id',
            'type' => 'class_selection_single',
            'belongs_to' => 'Database',
            'display_property' => 'title',
            'title' => 'Database'

        ],
        [
            'name' => 'condition',
            'type' => 'text',
            'belongs_to' => 'Query',
            'display_property' => 'condition',
            'title' => 'Condition'
        ],
        [
            'name' => 'query',
            'type' => 'text',
            'belongs_to' => 'Query',
            'display_property' => 'query',
            'title' => 'Query'
        ]
	];

	/* {{@snippet:end_properties}} */
	
	static function getTableName() {
		return 'adminlteadviedquerytable';
	}

	public function scopeDefaultQuery($query, $search_text, $sort_variable, $sort_direction) {
		$objectAdminLTE = new AdminLTE();
		$query = $objectAdminLTE->getQuery($query, 'Query', $this::$property_list, $search_text, $sort_variable, $sort_direction);
		return $query;
	}

	public function template_id()
	{
		return $this->belongsTo(Template::class, 'template_id');
	}

	public function database_id()
	{
		return $this->belongsTo(Database::class, 'database_id');
	}


	/* {{@snippet:end_methods}} */
}

/* {{@snippet:end_class}} */