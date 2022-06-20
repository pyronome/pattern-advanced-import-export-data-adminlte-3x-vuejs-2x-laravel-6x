<?php

namespace App\Wisilo\Advanced\ImportExportData;

use Illuminate\Database\Eloquent\Model;

use App\Wisilo\Wisilo;

class Template extends Model
{
	/* {{@snippet:begin_properties}} */

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'wisiloadviedtemplatetable';

	protected $fillable = [
		'enabled',
		'title',
		'description',
		'type'
	];

	public static $property_list = [
		[
			'name' => 'id',
			'type' => 'integer',
			'belongs_to' => 'Template',
			'display_property' => 'id',
			'title' => 'Id'
		],

		[
			'name' => 'deleted',
			'type' => 'checkbox',
			'belongs_to' => 'Template',
			'display_property' => 'deleted',
			'title' => 'Deleted'
		],

		[
			'name' => 'created_at',
			'type' => 'date',
			'belongs_to' => 'Template',
			'display_property' => 'created_at',
			'title' => 'Created At'
		],

		[
			'name' => 'updated_at',
			'type' => 'date',
			'belongs_to' => 'Template',
			'display_property' => 'updated_at',
			'title' => 'Updated at'
		],
        [
            'name' => 'enabled',
            'type' => 'checkbox',
            'belongs_to' => 'Template',
            'display_property' => 'enabled',
            'title' => 'Enabled'
        ],
        [
            'name' => 'title',
            'type' => 'text',
            'belongs_to' => 'Template',
            'display_property' => 'title',
            'title' => 'Title'
        ],
        [
            'name' => 'description',
            'type' => 'text',
            'belongs_to' => 'Template',
            'display_property' => 'description',
            'title' => 'Description'
        ],
        [
            'name' => 'type',
            'type' => 'checkbox',
            'belongs_to' => 'Template',
            'display_property' => 'type',
            'title' => 'Type'
        ]
	];

	/* {{@snippet:end_properties}} */

	static function getTableName() {
		return 'wisiloadviedtemplatetable';
	}

	public function scopeDefaultQuery($query, $search_text, $sort_variable, $sort_direction) {
		$objectWisilo = new Wisilo();
		$query = $objectWisilo->getQuery($query, 'Template', $this::$property_list, $search_text, $sort_variable, $sort_direction);
		return $query;
	}


	public function Query_template_id()
	{
		return $this->hasMany(Query::class);
	}

	public function Action_template_id()
	{
		return $this->hasMany(Action::class);
	}

	public function Parameter_template_id()
	{
		return $this->hasMany(Parameter::class);
	}

	/* {{@snippet:end_methods}} */
}

/* {{@snippet:end_class}} */