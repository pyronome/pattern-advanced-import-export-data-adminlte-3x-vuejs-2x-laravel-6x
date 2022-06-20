<?php

namespace App\Wisilo\Advanced\ImportExportData;

use Illuminate\Database\Eloquent\Model;

use App\Wisilo\Wisilo;

class Lookup extends Model
{
	/* {{@snippet:begin_properties}} */

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'wisiloadviedlookuptable';

	protected $fillable = [
		'enabled',
		'__order',
		'group',
		'title',
		'value1',
		'value2',
		'value3'
	];

	public static $property_list = [
		[
			'name' => 'id',
			'type' => 'integer',
			'belongs_to' => 'Lookup',
			'display_property' => 'id',
			'title' => 'Id'
		],

		[
			'name' => 'deleted',
			'type' => 'checkbox',
			'belongs_to' => 'Lookup',
			'display_property' => 'deleted',
			'title' => 'Deleted'
		],

		[
			'name' => 'created_at',
			'type' => 'date',
			'belongs_to' => 'Lookup',
			'display_property' => 'created_at',
			'title' => 'Created At'
		],

		[
			'name' => 'updated_at',
			'type' => 'date',
			'belongs_to' => 'Lookup',
			'display_property' => 'updated_at',
			'title' => 'Updated at'
		],
        [
            'name' => 'enabled',
            'type' => 'checkbox',
            'belongs_to' => 'Lookup',
            'display_property' => 'enabled',
            'title' => 'Enabled'
        ],
        [
            'name' => '__order',
            'type' => 'integer',
            'belongs_to' => 'Lookup',
            'display_property' => '__order',
            'title' => 'Order'
        ],
        [
            'name' => 'group',
            'type' => 'text',
            'belongs_to' => 'Lookup',
            'display_property' => 'group',
            'title' => 'Group'
        ],
        [
            'name' => 'title',
            'type' => 'text',
            'belongs_to' => 'Lookup',
            'display_property' => 'title',
            'title' => 'Title'
        ],
        [
            'name' => 'value1',
            'type' => 'text',
            'belongs_to' => 'Lookup',
            'display_property' => 'value1',
            'title' => 'Value 1'
        ],
        [
            'name' => 'value2',
            'type' => 'text',
            'belongs_to' => 'Lookup',
            'display_property' => 'value2',
            'title' => 'Value 2'
        ],
        [
            'name' => 'value3',
            'type' => 'text',
            'belongs_to' => 'Lookup',
            'display_property' => 'value3',
            'title' => 'Value 3'
        ]
	];

	/* {{@snippet:end_properties}} */

	static function getTableName() {
		return 'wisiloadviedlookuptable';
	}

	public function scopeDefaultQuery($query, $search_text, $sort_variable, $sort_direction) {
		$objectWisilo = new Wisilo();
		$query = $objectWisilo->getQuery($query, 'Lookup', $this::$property_list, $search_text, $sort_variable, $sort_direction);
		return $query;
	}


	public function Database_database_type()
	{
		return $this->hasMany(Database::class);
	}

	/* {{@snippet:end_methods}} */
}

/* {{@snippet:end_class}} */