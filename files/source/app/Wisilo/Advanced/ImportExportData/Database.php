<?php

namespace App\Wisilo\Advanced\ImportExportData;

use Illuminate\Database\Eloquent\Model;

use App\Wisilo\Wisilo;

class Database extends Model
{
	/* {{@snippet:begin_properties}} */

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'wisiloadvieddatabasetable';

	protected $fillable = [
		'enabled',
		'title',
		'database_type',
		'host',
		'database_name',
		'username',
		'password',
		'port'
	];

	public static $property_list = [
		[
			'name' => 'id',
			'type' => 'integer',
			'belongs_to' => 'Database',
			'display_property' => 'id',
			'title' => 'Id'
		],

		[
			'name' => 'deleted',
			'type' => 'checkbox',
			'belongs_to' => 'Database',
			'display_property' => 'deleted',
			'title' => 'Deleted'
		],

		[
			'name' => 'created_at',
			'type' => 'date',
			'belongs_to' => 'Database',
			'display_property' => 'created_at',
			'title' => 'Created At'
		],

		[
			'name' => 'updated_at',
			'type' => 'date',
			'belongs_to' => 'Database',
			'display_property' => 'updated_at',
			'title' => 'Updated at'
		],
        [
            'name' => 'enabled',
            'type' => 'checkbox',
            'belongs_to' => 'Database',
            'display_property' => 'enabled',
            'title' => 'Enabled'
        ],
        [
            'name' => 'title',
            'type' => 'text',
            'belongs_to' => 'Database',
            'display_property' => 'title',
            'title' => 'Title'
        ],
        [
            'name' => 'database_type',
            'type' => 'class_selection_single',
            'belongs_to' => 'Lookup',
            'display_property' => 'title',
            'title' => 'Database Type'

        ],
        [
            'name' => 'host',
            'type' => 'text',
            'belongs_to' => 'Database',
            'display_property' => 'host',
            'title' => 'Host'
        ],
        [
            'name' => 'database_name',
            'type' => 'text',
            'belongs_to' => 'Database',
            'display_property' => 'database_name',
            'title' => 'Database Name'
        ],
        [
            'name' => 'username',
            'type' => 'text',
            'belongs_to' => 'Database',
            'display_property' => 'username',
            'title' => 'Username'
        ],
        [
            'name' => 'password',
            'type' => 'text',
            'belongs_to' => 'Database',
            'display_property' => 'password',
            'title' => 'Password'
        ],
        [
            'name' => 'port',
            'type' => 'integer',
            'belongs_to' => 'Database',
            'display_property' => 'port',
            'title' => 'Port'
        ]
	];

	/* {{@snippet:end_properties}} */

	static function getTableName() {
		return 'wisiloadvieddatabasetable';
	}

	public function scopeDefaultQuery($query, $search_text, $sort_variable, $sort_direction) {
		$objectWisilo = new Wisilo();
		$query = $objectWisilo->getQuery($query, 'Database', $this::$property_list, $search_text, $sort_variable, $sort_direction);
		return $query;
	}

	public function database_type()
	{
		return $this->belongsTo(Lookup::class, 'database_type');
	}

	public function Query_database_id()
	{
		return $this->hasMany(Query::class);
	}

	/* {{@snippet:end_methods}} */
}

/* {{@snippet:end_class}} */