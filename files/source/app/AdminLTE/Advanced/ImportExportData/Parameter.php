<?php

namespace App\AdminLTE\Advanced\ImportExportData;

use Illuminate\Database\Eloquent\Model;

use App\AdminLTE\AdminLTE;

class Parameter extends Model
{
	/* {{@snippet:begin_properties}} */

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'adminlteadviedparametertable';

	protected $fillable = [
		'enabled',
		'__order',
		'template_id',
		'title',
		'name',
		'type',
		'option_titles',
		'option_values',
		'default'
	];

	public static $property_list = [
		[
			'name' => 'id',
			'type' => 'integer',
			'belongs_to' => 'Parameter',
			'display_property' => 'id',
			'title' => 'Id'
		],

		[
			'name' => 'deleted',
			'type' => 'checkbox',
			'belongs_to' => 'Parameter',
			'display_property' => 'deleted',
			'title' => 'Deleted'
		],

		[
			'name' => 'created_at',
			'type' => 'date',
			'belongs_to' => 'Parameter',
			'display_property' => 'created_at',
			'title' => 'Created At'
		],

		[
			'name' => 'updated_at',
			'type' => 'date',
			'belongs_to' => 'Parameter',
			'display_property' => 'updated_at',
			'title' => 'Updated at'
		],
        [
            'name' => 'enabled',
            'type' => 'checkbox',
            'belongs_to' => 'Parameter',
            'display_property' => 'enabled',
            'title' => 'Enabled'
        ],
        [
            'name' => '__order',
            'type' => 'integer',
            'belongs_to' => 'Parameter',
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
            'belongs_to' => 'Parameter',
            'display_property' => 'title',
            'title' => 'Title'
        ],
        [
            'name' => 'name',
            'type' => 'text',
            'belongs_to' => 'Parameter',
            'display_property' => 'name',
            'title' => 'Name'
        ],
        [
            'name' => 'type',
            'type' => 'text',
            'belongs_to' => 'Parameter',
            'display_property' => 'type',
            'title' => 'Type'
        ],
        [
            'name' => 'option_titles',
            'type' => 'text',
            'belongs_to' => 'Parameter',
            'display_property' => 'option_titles',
            'title' => 'Option Titles'
        ],
        [
            'name' => 'option_values',
            'type' => 'text',
            'belongs_to' => 'Parameter',
            'display_property' => 'option_values',
            'title' => 'Option Values'
        ],
        [
            'name' => 'default',
            'type' => 'text',
            'belongs_to' => 'Parameter',
            'display_property' => 'default',
            'title' => 'Default'
        ]
	];

	/* {{@snippet:end_properties}} */

    static function getTableName() {
		return 'adminlteadviedparametertable';
	}

	public function scopeDefaultQuery($query, $search_text, $sort_variable, $sort_direction) {
		$objectAdminLTE = new AdminLTE();
		$query = $objectAdminLTE->getQuery($query, 'Parameter', $this::$property_list, $search_text, $sort_variable, $sort_direction);
		return $query;
	}

	public function template_id()
	{
		return $this->belongsTo(Template::class, 'template_id');
	}


	/* {{@snippet:end_methods}} */
}

/* {{@snippet:end_class}} */