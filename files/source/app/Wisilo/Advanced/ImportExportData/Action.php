<?php

namespace App\Wisilo\Advanced\ImportExportData;

use Illuminate\Database\Eloquent\Model;

use App\Wisilo\Wisilo;

class Action extends Model
{
	/* {{@snippet:begin_properties}} */

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'wisiloadviedactiontable';

	protected $fillable = [
		'enabled',
		'__order',
		'template_id',
		'title',
		'condition',
		'operation'
	];

	public static $property_list = [
		[
			'name' => 'id',
			'type' => 'integer',
			'belongs_to' => 'Action',
			'display_property' => 'id',
			'title' => 'Id'
		],

		[
			'name' => 'deleted',
			'type' => 'checkbox',
			'belongs_to' => 'Action',
			'display_property' => 'deleted',
			'title' => 'Deleted'
		],

		[
			'name' => 'created_at',
			'type' => 'date',
			'belongs_to' => 'Action',
			'display_property' => 'created_at',
			'title' => 'Created At'
		],

		[
			'name' => 'updated_at',
			'type' => 'date',
			'belongs_to' => 'Action',
			'display_property' => 'updated_at',
			'title' => 'Updated at'
		],
        [
            'name' => 'enabled',
            'type' => 'checkbox',
            'belongs_to' => 'Action',
            'display_property' => 'enabled',
            'title' => 'Enabled'
        ],
        [
            'name' => '__order',
            'type' => 'integer',
            'belongs_to' => 'Action',
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
            'name' => 'title',
            'type' => 'text',
            'belongs_to' => 'Action',
            'display_property' => 'title',
            'title' => 'Title'
        ],
        [
            'name' => 'condition',
            'type' => 'text',
            'belongs_to' => 'Action',
            'display_property' => 'condition',
            'title' => 'Condition'
        ],
        [
            'name' => 'operation',
            'type' => 'text',
            'belongs_to' => 'Action',
            'display_property' => 'operation',
            'title' => 'Operation'
        ]
	];

	/* {{@snippet:end_properties}} */
	
	static function getTableName() {
		return 'wisiloadviedactiontable';
	}

	public function scopeDefaultQuery($query, $search_text, $sort_variable, $sort_direction) {
		$objectWisilo = new Wisilo();
		$query = $objectWisilo->getQuery($query, 'Action', $this::$property_list, $search_text, $sort_variable, $sort_direction);
		return $query;
	}

	public function template_id()
	{
		return $this->belongsTo(Template::class, 'template_id');
	}


	/* {{@snippet:end_methods}} */
}

/* {{@snippet:end_class}} */