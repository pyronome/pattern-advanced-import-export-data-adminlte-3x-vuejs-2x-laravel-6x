<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Wisilo\Wisilo;

/* {{@snippet:begin_class}} */

class ADVIEDRevision20211028000000 extends Migration
{

    /* {{@snippet:begin_properties}} */

    /* {{@snippet:end_properties}} */

    /* {{@snippet:begin_methods}} */

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* {{@snippet:begin_up_method}} */

        /* {{@snippet:begin_wisiloadviedlookuptable_migration}} */        
        if (!Schema::hasTable('wisiloadviedlookuptable')) {
            Schema::create('wisiloadviedlookuptable', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->boolean('deleted')->default(0);
                $table->smallInteger('enabled')->default(0);
                $table->bigInteger('__order')->default(0);
                $table->string('group')->nullable();
                $table->string('title')->nullable();
                $table->string('value1')->nullable();
                $table->string('value2')->nullable();
                $table->string('value3')->nullable();
            });

            DB::table('wisiloadviedlookuptable')->insert(
                array(
                    'id' => 1,
                    'deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'enabled' => 1,
                    '__order' => 1,
                    'group' => 'database_type',
                    'title' => 'Oracle',
                    'value1' => 'oci',
                    'value2' => '',
                    'value3' => ''
                )
            );

            DB::table('wisiloadviedlookuptable')->insert(
                array(
                    'id' => 2,
                    'deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'enabled' => 1,
                    '__order' => 2,
                    'group' => 'database_type',
                    'title' => 'Microsoft SQL Server',
                    'value1' => 'dblib',
                    'value2' => '',
                    'value3' => ''
                )
            );

            DB::table('wisiloadviedlookuptable')->insert(
                array(
                    'id' => 3,
                    'deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'enabled' => 1,
                    '__order' => 3,
                    'group' => 'database_type',
                    'title' => 'MySQL',
                    'value1' => 'mysql',
                    'value2' => 'mysql:host={{HOST}}:{{PORT}};dbname={{DB_NAME}};charset=utf8',
                    'value3' => ''
                )
            );

            DB::table('wisiloadviedlookuptable')->insert(
                array(
                    'id' => 4,
                    'deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'enabled' => 1,
                    '__order' => 4,
                    'group' => 'database_type',
                    'title' => 'Microsoft SQL Server / SQL Azure',
                    'value1' => 'sqlsrv',
                    'value2' => 'sqlsrv:server={{HOST}},{{PORT}};database={{DB_NAME}};',
                    'value3' => ''
                )
            );

            DB::table('wisiloadviedlookuptable')->insert(
                array(
                    'id' => 5,
                    'deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'enabled' => 1,
                    '__order' => 5,
                    'group' => 'database_type',
                    'title' => 'PostgreSQL',
                    'value1' => 'pgsql',
                    'value2' => '',
                    'value3' => ''
                )
            );

            DB::table('wisiloadviedlookuptable')->insert(
                array(
                    'id' => 6,
                    'deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'enabled' => 1,
                    '__order' => 6,
                    'group' => 'database_type',
                    'title' => 'SQLite',
                    'value1' => 'sqlite',
                    'value2' => '',
                    'value3' => ''
                )
            );

            DB::table('wisiloadviedlookuptable')->insert(
                array(
                    'id' => 7,
                    'deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'enabled' => 1,
                    '__order' => 7,
                    'group' => 'database_type',
                    'title' => 'IBM',
                    'value1' => 'ibm',
                    'value2' => '',
                    'value3' => ''
                )
            );

            DB::table('wisiloadviedlookuptable')->insert(
                array(
                    'id' => 8,
                    'deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'enabled' => 1,
                    '__order' => 8,
                    'group' => 'database_type',
                    'title' => 'Cubrid',
                    'value1' => 'cubrid',
                    'value2' => '',
                    'value3' => ''
                )
            );

            DB::table('wisiloadviedlookuptable')->insert(
                array(
                    'id' => 9,
                    'deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'enabled' => 1,
                    '__order' => 9,
                    'group' => 'database_type',
                    'title' => 'Firebird',
                    'value1' => 'firebird',
                    'value2' => '',
                    'value3' => ''
                )
            );

            DB::table('wisiloadviedlookuptable')->insert(
                array(
                    'id' => 10,
                    'deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'enabled' => 1,
                    '__order' => 10,
                    'group' => 'database_type',
                    'title' => 'Informix',
                    'value1' => 'informix',
                    'value2' => '',
                    'value3' => ''
                )
            );

            DB::table('wisiloadviedlookuptable')->insert(
                array(
                    'id' => 11,
                    'deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'enabled' => 1,
                    '__order' => 11,
                    'group' => 'database_type',
                    'title' => 'ODBC',
                    'value1' => 'odbc',
                    'value2' => '',
                    'value3' => ''
                )
            );

            DB::table('wisiloadviedlookuptable')->insert(
                array(
                    'id' => 12,
                    'deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'enabled' => 1,
                    '__order' => 12,
                    'group' => 'database_type',
                    'title' => '4D',
                    'value1' => '4D',
                    'value2' => '',
                    'value3' => ''
                )
            );
        } else {
            Schema::table('wisiloadviedlookuptable', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('wisiloadviedlookuptable');
                //Schema::disableForeignKeyConstraints();
                if (Schema::hasColumn('wisiloadviedlookuptable', 'enabled')) {                    
                    if (in_array('wisiloadviedlookuptable_enabled_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedlookuptable_enabled_foreign');
                        $table->dropIndex('wisiloadviedlookuptable_enabled_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedlookuptable', '__order')) {                    
                    if (in_array('wisiloadviedlookuptable___order_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedlookuptable___order_foreign');
                        $table->dropIndex('wisiloadviedlookuptable___order_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedlookuptable', 'group')) {                    
                    if (in_array('wisiloadviedlookuptable_group_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedlookuptable_group_foreign');
                        $table->dropIndex('wisiloadviedlookuptable_group_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedlookuptable', 'title')) {                    
                    if (in_array('wisiloadviedlookuptable_title_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedlookuptable_title_foreign');
                        $table->dropIndex('wisiloadviedlookuptable_title_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedlookuptable', 'value1')) {                    
                    if (in_array('wisiloadviedlookuptable_value1_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedlookuptable_value1_foreign');
                        $table->dropIndex('wisiloadviedlookuptable_value1_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedlookuptable', 'value2')) {                    
                    if (in_array('wisiloadviedlookuptable_value2_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedlookuptable_value2_foreign');
                        $table->dropIndex('wisiloadviedlookuptable_value2_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedlookuptable', 'value3')) {                    
                    if (in_array('wisiloadviedlookuptable_value3_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedlookuptable_value3_foreign');
                        $table->dropIndex('wisiloadviedlookuptable_value3_foreign');
                    }
                }
                //Schema::enableForeignKeyConstraints();
            });

            Schema::table('wisiloadviedlookuptable', function (Blueprint $table) {
                if (Schema::hasColumn('wisiloadviedlookuptable', 'enabled')) { 
                    $table->smallInteger('enabled')->default(0)->change();
                } else {
                    $table->smallInteger('enabled')->default(0);
                }
                if (Schema::hasColumn('wisiloadviedlookuptable', '__order')) { 
                    $table->bigInteger('__order')->default(0)->change();
                } else {
                    $table->bigInteger('__order')->default(0);
                }
                if (Schema::hasColumn('wisiloadviedlookuptable', 'group')) { 
                    $table->string('group')->nullable()->change();
                } else {
                    $table->string('group')->nullable();
                }
                if (Schema::hasColumn('wisiloadviedlookuptable', 'title')) { 
                    $table->string('title')->nullable()->change();
                } else {
                    $table->string('title')->nullable();
                }
                if (Schema::hasColumn('wisiloadviedlookuptable', 'value1')) { 
                    $table->string('value1')->nullable()->change();
                } else {
                    $table->string('value1')->nullable();
                }
                if (Schema::hasColumn('wisiloadviedlookuptable', 'value2')) { 
                    $table->string('value2')->nullable()->change();
                } else {
                    $table->string('value2')->nullable();
                }
                if (Schema::hasColumn('wisiloadviedlookuptable', 'value3')) { 
                    $table->string('value3')->nullable()->change();
                } else {
                    $table->string('value3')->nullable();
                }
            });
            
        } // if (!Schema::hasTable('wisiloadviedlookuptable')) {

        /* {{@snippet:end_wisiloadviedlookuptable_migration}} */

        /* {{@snippet:begin_wisiloadvieddatabasetable_migration}} */        
        if (!Schema::hasTable('wisiloadvieddatabasetable')) {
            Schema::create('wisiloadvieddatabasetable', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->boolean('deleted')->default(0);
                $table->smallInteger('enabled')->default(0);
                $table->string('title')->nullable();
                $table->string('host')->nullable();
                $table->string('database_name')->nullable();
                $table->string('username')->nullable();
                $table->longText('password')->nullable();
                $table->bigInteger('port')->default(0);
            });
        } else {
            Schema::table('wisiloadvieddatabasetable', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('wisiloadvieddatabasetable');
                //Schema::disableForeignKeyConstraints();
                if (Schema::hasColumn('wisiloadvieddatabasetable', 'enabled')) {                    
                    if (in_array('wisiloadvieddatabasetable_enabled_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadvieddatabasetable_enabled_foreign');
                        $table->dropIndex('wisiloadvieddatabasetable_enabled_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadvieddatabasetable', 'title')) {                    
                    if (in_array('wisiloadvieddatabasetable_title_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadvieddatabasetable_title_foreign');
                        $table->dropIndex('wisiloadvieddatabasetable_title_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadvieddatabasetable', 'host')) {                    
                    if (in_array('wisiloadvieddatabasetable_host_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadvieddatabasetable_host_foreign');
                        $table->dropIndex('wisiloadvieddatabasetable_host_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadvieddatabasetable', 'database_name')) {                    
                    if (in_array('wisiloadvieddatabasetable_database_name_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadvieddatabasetable_database_name_foreign');
                        $table->dropIndex('wisiloadvieddatabasetable_database_name_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadvieddatabasetable', 'username')) {                    
                    if (in_array('wisiloadvieddatabasetable_username_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadvieddatabasetable_username_foreign');
                        $table->dropIndex('wisiloadvieddatabasetable_username_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadvieddatabasetable', 'password')) {                    
                    if (in_array('wisiloadvieddatabasetable_password_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadvieddatabasetable_password_foreign');
                        $table->dropIndex('wisiloadvieddatabasetable_password_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadvieddatabasetable', 'port')) {                    
                    if (in_array('wisiloadvieddatabasetable_port_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadvieddatabasetable_port_foreign');
                        $table->dropIndex('wisiloadvieddatabasetable_port_foreign');
                    }
                }
                //Schema::enableForeignKeyConstraints();
            });

            Schema::table('wisiloadvieddatabasetable', function (Blueprint $table) {
                if (Schema::hasColumn('wisiloadvieddatabasetable', 'enabled')) { 
                    $table->smallInteger('enabled')->default(0)->change();
                } else {
                    $table->smallInteger('enabled')->default(0);
                }
                if (Schema::hasColumn('wisiloadvieddatabasetable', 'title')) { 
                    $table->string('title')->nullable()->change();
                } else {
                    $table->string('title')->nullable();
                }
                if (Schema::hasColumn('wisiloadvieddatabasetable', 'host')) { 
                    $table->string('host')->nullable()->change();
                } else {
                    $table->string('host')->nullable();
                }
                if (Schema::hasColumn('wisiloadvieddatabasetable', 'database_name')) { 
                    $table->string('database_name')->nullable()->change();
                } else {
                    $table->string('database_name')->nullable();
                }
                if (Schema::hasColumn('wisiloadvieddatabasetable', 'username')) { 
                    $table->string('username')->nullable()->change();
                } else {
                    $table->string('username')->nullable();
                }
                if (Schema::hasColumn('wisiloadvieddatabasetable', 'password')) { 
                    $table->longText('password')->nullable()->change();
                } else {
                    $table->longText('password')->nullable();
                }
                if (Schema::hasColumn('wisiloadvieddatabasetable', 'port')) { 
                    $table->bigInteger('port')->default(0)->change();
                } else {
                    $table->bigInteger('port')->default(0);
                }
            });
            
        } // if (!Schema::hasTable('wisiloadvieddatabasetable')) {

        /* {{@snippet:end_wisiloadvieddatabasetable_migration}} */

        /* {{@snippet:begin_wisiloadviedtemplatetable_migration}} */        
        if (!Schema::hasTable('wisiloadviedtemplatetable')) {
            Schema::create('wisiloadviedtemplatetable', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->boolean('deleted')->default(0);
                $table->smallInteger('enabled')->default(0);
                $table->smallInteger('type')->default(0);
                $table->string('title')->nullable();
                $table->longText('description')->nullable();
            });
        } else {
            Schema::table('wisiloadviedtemplatetable', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('wisiloadviedtemplatetable');
                //Schema::disableForeignKeyConstraints();
                if (Schema::hasColumn('wisiloadviedtemplatetable', 'enabled')) {                    
                    if (in_array('wisiloadviedtemplatetable_enabled_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedtemplatetable_enabled_foreign');
                        $table->dropIndex('wisiloadviedtemplatetable_enabled_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedtemplatetable', 'type')) {                    
                    if (in_array('wisiloadviedtemplatetable_type_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedtemplatetable_type_foreign');
                        $table->dropIndex('wisiloadviedtemplatetable_type_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedtemplatetable', 'title')) {                    
                    if (in_array('wisiloadviedtemplatetable_title_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedtemplatetable_title_foreign');
                        $table->dropIndex('wisiloadviedtemplatetable_title_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedtemplatetable', 'description')) {                    
                    if (in_array('wisiloadviedtemplatetable_description_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedtemplatetable_description_foreign');
                        $table->dropIndex('wisiloadviedtemplatetable_description_foreign');
                    }
                }
                //Schema::enableForeignKeyConstraints();
            });

            Schema::table('wisiloadviedtemplatetable', function (Blueprint $table) {
                if (Schema::hasColumn('wisiloadviedtemplatetable', 'enabled')) { 
                    $table->smallInteger('enabled')->default(0)->change();
                } else {
                    $table->smallInteger('enabled')->default(0);
                }
                if (Schema::hasColumn('wisiloadviedtemplatetable', 'type')) { 
                    $table->smallInteger('type')->default(0)->change();
                } else {
                    $table->smallInteger('type')->default(0);
                }
                if (Schema::hasColumn('wisiloadviedtemplatetable', 'title')) { 
                    $table->string('title')->nullable()->change();
                } else {
                    $table->string('title')->nullable();
                }
                if (Schema::hasColumn('wisiloadviedtemplatetable', 'description')) { 
                    $table->longText('description')->nullable()->change();
                } else {
                    $table->longText('description')->nullable();
                }
            });
            
        } // if (!Schema::hasTable('wisiloadviedtemplatetable')) {

        /* {{@snippet:end_wisiloadviedtemplatetable_migration}} */

        /* {{@snippet:begin_wisiloadviedquerytable_migration}} */        
        if (!Schema::hasTable('wisiloadviedquerytable')) {
            Schema::create('wisiloadviedquerytable', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->boolean('deleted')->default(0);
                $table->smallInteger('enabled')->default(0);
                $table->bigInteger('__order')->default(0);
                $table->longText('condition')->nullable();
                $table->longText('query')->nullable();
            });
        } else {
            Schema::table('wisiloadviedquerytable', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('wisiloadviedquerytable');
                //Schema::disableForeignKeyConstraints();
                if (Schema::hasColumn('wisiloadviedquerytable', 'enabled')) {                    
                    if (in_array('wisiloadviedquerytable_enabled_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedquerytable_enabled_foreign');
                        $table->dropIndex('wisiloadviedquerytable_enabled_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedquerytable', '__order')) {                    
                    if (in_array('wisiloadviedquerytable___order_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedquerytable___order_foreign');
                        $table->dropIndex('wisiloadviedquerytable___order_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedquerytable', 'condition')) {                    
                    if (in_array('wisiloadviedquerytable_condition_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedquerytable_condition_foreign');
                        $table->dropIndex('wisiloadviedquerytable_condition_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedquerytable', 'query')) {                    
                    if (in_array('wisiloadviedquerytable_query_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedquerytable_query_foreign');
                        $table->dropIndex('wisiloadviedquerytable_query_foreign');
                    }
                }
                //Schema::enableForeignKeyConstraints();
            });

            Schema::table('wisiloadviedquerytable', function (Blueprint $table) {
                if (Schema::hasColumn('wisiloadviedquerytable', 'enabled')) { 
                    $table->smallInteger('enabled')->default(0)->change();
                } else {
                    $table->smallInteger('enabled')->default(0);
                }
                if (Schema::hasColumn('wisiloadviedquerytable', '__order')) { 
                    $table->bigInteger('__order')->default(0)->change();
                } else {
                    $table->bigInteger('__order')->default(0);
                }
                if (Schema::hasColumn('wisiloadviedquerytable', 'condition')) { 
                    $table->longText('condition')->nullable()->change();
                } else {
                    $table->longText('condition')->nullable();
                }
                if (Schema::hasColumn('wisiloadviedquerytable', 'query')) { 
                    $table->longText('query')->nullable()->change();
                } else {
                    $table->longText('query')->nullable();
                }
            });
            
        } // if (!Schema::hasTable('wisiloadviedquerytable')) {

        /* {{@snippet:end_wisiloadviedquerytable_migration}} */

        /* {{@snippet:begin_wisiloadviedactiontable_migration}} */        
        if (!Schema::hasTable('wisiloadviedactiontable')) {
            Schema::create('wisiloadviedactiontable', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->boolean('deleted')->default(0);
                $table->smallInteger('enabled')->default(0);
                $table->bigInteger('__order')->default(0);
                $table->string('title')->nullable();
                $table->longText('condition')->nullable();
                $table->longText('operation')->nullable();
            });
        } else {
            Schema::table('wisiloadviedactiontable', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('wisiloadviedactiontable');
                //Schema::disableForeignKeyConstraints();
                if (Schema::hasColumn('wisiloadviedactiontable', 'enabled')) {                    
                    if (in_array('wisiloadviedactiontable_enabled_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedactiontable_enabled_foreign');
                        $table->dropIndex('wisiloadviedactiontable_enabled_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedactiontable', '__order')) {                    
                    if (in_array('wisiloadviedactiontable___order_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedactiontable___order_foreign');
                        $table->dropIndex('wisiloadviedactiontable___order_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedactiontable', 'title')) {                    
                    if (in_array('wisiloadviedactiontable_title_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedactiontable_title_foreign');
                        $table->dropIndex('wisiloadviedactiontable_title_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedactiontable', 'condition')) {                    
                    if (in_array('wisiloadviedactiontable_condition_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedactiontable_condition_foreign');
                        $table->dropIndex('wisiloadviedactiontable_condition_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedactiontable', 'operation')) {                    
                    if (in_array('wisiloadviedactiontable_operation_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedactiontable_operation_foreign');
                        $table->dropIndex('wisiloadviedactiontable_operation_foreign');
                    }
                }
                //Schema::enableForeignKeyConstraints();
            });

            Schema::table('wisiloadviedactiontable', function (Blueprint $table) {
                if (Schema::hasColumn('wisiloadviedactiontable', 'enabled')) { 
                    $table->smallInteger('enabled')->default(0)->change();
                } else {
                    $table->smallInteger('enabled')->default(0);
                }
                if (Schema::hasColumn('wisiloadviedactiontable', '__order')) { 
                    $table->bigInteger('__order')->default(0)->change();
                } else {
                    $table->bigInteger('__order')->default(0);
                }
                if (Schema::hasColumn('wisiloadviedactiontable', 'title')) { 
                    $table->string('title')->nullable()->change();
                } else {
                    $table->string('title')->nullable();
                }
                if (Schema::hasColumn('wisiloadviedactiontable', 'condition')) { 
                    $table->longText('condition')->nullable()->change();
                } else {
                    $table->longText('condition')->nullable();
                }
                if (Schema::hasColumn('wisiloadviedactiontable', 'operation')) { 
                    $table->longText('operation')->nullable()->change();
                } else {
                    $table->longText('operation')->nullable();
                }
            });
            
        } // if (!Schema::hasTable('wisiloadviedactiontable')) {

        /* {{@snippet:end_wisiloadviedactiontable_migration}} */

        /* {{@snippet:begin_wisiloadviedparametertable_migration}} */        
        if (!Schema::hasTable('wisiloadviedparametertable')) {
            Schema::create('wisiloadviedparametertable', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->boolean('deleted')->default(0);
                $table->smallInteger('enabled')->default(0);
                $table->bigInteger('__order')->default(0);
                $table->string('title')->nullable();
                $table->string('name')->nullable();
                $table->string('type')->nullable();
                $table->longText('option_titles')->nullable();
                $table->longText('option_values')->nullable();
                $table->longText('default')->nullable();
            });
        } else {
            Schema::table('wisiloadviedparametertable', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('wisiloadviedparametertable');
                //Schema::disableForeignKeyConstraints();
                if (Schema::hasColumn('wisiloadviedparametertable', 'enabled')) {                    
                    if (in_array('wisiloadviedparametertable_enabled_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedparametertable_enabled_foreign');
                        $table->dropIndex('wisiloadviedparametertable_enabled_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedparametertable', '__order')) {                    
                    if (in_array('wisiloadviedparametertable___order_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedparametertable___order_foreign');
                        $table->dropIndex('wisiloadviedparametertable___order_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedparametertable', 'title')) {                    
                    if (in_array('wisiloadviedparametertable_title_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedparametertable_title_foreign');
                        $table->dropIndex('wisiloadviedparametertable_title_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedparametertable', 'name')) {                    
                    if (in_array('wisiloadviedparametertable_name_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedparametertable_name_foreign');
                        $table->dropIndex('wisiloadviedparametertable_name_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedparametertable', 'type')) {                    
                    if (in_array('wisiloadviedparametertable_type_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedparametertable_type_foreign');
                        $table->dropIndex('wisiloadviedparametertable_type_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedparametertable', 'option_titles')) {                    
                    if (in_array('wisiloadviedparametertable_option_titles_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedparametertable_option_titles_foreign');
                        $table->dropIndex('wisiloadviedparametertable_option_titles_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedparametertable', 'option_values')) {                    
                    if (in_array('wisiloadviedparametertable_option_values_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedparametertable_option_values_foreign');
                        $table->dropIndex('wisiloadviedparametertable_option_values_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedparametertable', 'default')) {                    
                    if (in_array('wisiloadviedparametertable_default_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedparametertable_default_foreign');
                        $table->dropIndex('wisiloadviedparametertable_default_foreign');
                    }
                }
                //Schema::enableForeignKeyConstraints();
            });

            Schema::table('wisiloadviedparametertable', function (Blueprint $table) {
                if (Schema::hasColumn('wisiloadviedparametertable', 'enabled')) { 
                    $table->smallInteger('enabled')->default(0)->change();
                } else {
                    $table->smallInteger('enabled')->default(0);
                }
                if (Schema::hasColumn('wisiloadviedparametertable', '__order')) { 
                    $table->bigInteger('__order')->default(0)->change();
                } else {
                    $table->bigInteger('__order')->default(0);
                }
                if (Schema::hasColumn('wisiloadviedparametertable', 'title')) { 
                    $table->string('title')->nullable()->change();
                } else {
                    $table->string('title')->nullable();
                }
                if (Schema::hasColumn('wisiloadviedparametertable', 'name')) { 
                    $table->string('name')->nullable()->change();
                } else {
                    $table->string('name')->nullable();
                }
                if (Schema::hasColumn('wisiloadviedparametertable', 'type')) { 
                    $table->string('type')->nullable()->change();
                } else {
                    $table->string('type')->nullable();
                }
                if (Schema::hasColumn('wisiloadviedparametertable', 'option_titles')) { 
                    $table->longText('option_titles')->nullable()->change();
                } else {
                    $table->longText('option_titles')->nullable();
                }
                if (Schema::hasColumn('wisiloadviedparametertable', 'option_values')) { 
                    $table->longText('option_values')->nullable()->change();
                } else {
                    $table->longText('option_values')->nullable();
                }
                if (Schema::hasColumn('wisiloadviedparametertable', 'default')) { 
                    $table->longText('default')->nullable()->change();
                } else {
                    $table->longText('default')->nullable();
                }
            });
            
        } // if (!Schema::hasTable('wisiloadviedparametertable')) {

        /* {{@snippet:end_wisiloadviedparametertable_migration}} */

        /* {{@snippet:begin_wisiloadviedvalidationtable_migration}} */        
        if (!Schema::hasTable('wisiloadviedvalidationtable')) {
            Schema::create('wisiloadviedvalidationtable', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->boolean('deleted')->default(0);
                $table->smallInteger('enabled')->default(0);
                $table->bigInteger('__order')->default(0);
                $table->string('title')->nullable();
                $table->longText('condition')->nullable();
                $table->longText('message')->nullable();
            });
        } else {
            Schema::table('wisiloadviedvalidationtable', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('wisiloadviedvalidationtable');
                //Schema::disableForeignKeyConstraints();
                if (Schema::hasColumn('wisiloadviedvalidationtable', 'enabled')) {                    
                    if (in_array('wisiloadviedvalidationtable_enabled_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedvalidationtable_enabled_foreign');
                        $table->dropIndex('wisiloadviedvalidationtable_enabled_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedvalidationtable', '__order')) {                    
                    if (in_array('wisiloadviedvalidationtable___order_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedvalidationtable___order_foreign');
                        $table->dropIndex('wisiloadviedvalidationtable___order_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedvalidationtable', 'title')) {                    
                    if (in_array('wisiloadviedvalidationtable_title_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedvalidationtable_title_foreign');
                        $table->dropIndex('wisiloadviedvalidationtable_title_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedvalidationtable', 'condition')) {                    
                    if (in_array('wisiloadviedvalidationtable_condition_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedvalidationtable_condition_foreign');
                        $table->dropIndex('wisiloadviedvalidationtable_condition_foreign');
                    }
                }
                if (Schema::hasColumn('wisiloadviedvalidationtable', 'message')) {                    
                    if (in_array('wisiloadviedvalidationtable_message_foreign', $foreignKeys)) {
                        $table->dropForeign('wisiloadviedvalidationtable_message_foreign');
                        $table->dropIndex('wisiloadviedvalidationtable_message_foreign');
                    }
                }
                //Schema::enableForeignKeyConstraints();
            });

            Schema::table('wisiloadviedvalidationtable', function (Blueprint $table) {
                if (Schema::hasColumn('wisiloadviedvalidationtable', 'enabled')) { 
                    $table->smallInteger('enabled')->default(0)->change();
                } else {
                    $table->smallInteger('enabled')->default(0);
                }
                if (Schema::hasColumn('wisiloadviedvalidationtable', '__order')) { 
                    $table->bigInteger('__order')->default(0)->change();
                } else {
                    $table->bigInteger('__order')->default(0);
                }
                if (Schema::hasColumn('wisiloadviedvalidationtable', 'title')) { 
                    $table->string('title')->nullable()->change();
                } else {
                    $table->string('title')->nullable();
                }
                if (Schema::hasColumn('wisiloadviedvalidationtable', 'condition')) { 
                    $table->longText('condition')->nullable()->change();
                } else {
                    $table->longText('condition')->nullable();
                }
                if (Schema::hasColumn('wisiloadviedvalidationtable', 'message')) { 
                    $table->longText('message')->nullable()->change();
                } else {
                    $table->longText('message')->nullable();
                }
            });
            
        } // if (!Schema::hasTable('wisiloadviedvalidationtable')) {
        /* {{@snippet:end_wisiloadviedvalidationtable_migration}} */
        
        Schema::table('wisiloadvieddatabasetable', function(Blueprint $table) {
            if (Schema::hasColumn('wisiloadvieddatabasetable', 'database_type')) { 
                $table->unsignedBigInteger('database_type')->nullable()->unsigned()->change();
            } else {
                $table->unsignedBigInteger('database_type')->nullable()->unsigned();
            }

            $foreignKeys = $this->listTableForeignKeys('wisiloadvieddatabasetable');

            if (!in_array('wisiloadvieddatabasetable_database_type_foreign', $foreignKeys)) {
                $table->foreign('database_type')->references('id')->on('wisiloadviedlookuptable'); 
            }     
        });

        Schema::table('wisiloadviedquerytable', function(Blueprint $table) {
            if (Schema::hasColumn('wisiloadviedquerytable', 'template_id')) { 
                $table->unsignedBigInteger('template_id')->nullable()->unsigned()->change();
            } else {
                $table->unsignedBigInteger('template_id')->nullable()->unsigned();
            }

            $foreignKeys = $this->listTableForeignKeys('wisiloadviedquerytable');

            if (!in_array('wisiloadviedquerytable_template_id_foreign', $foreignKeys)) {
                $table->foreign('template_id')->references('id')->on('wisiloadviedtemplatetable'); 
            }     
        });
        Schema::table('wisiloadviedquerytable', function(Blueprint $table) {
            if (Schema::hasColumn('wisiloadviedquerytable', 'database_id')) { 
                $table->unsignedBigInteger('database_id')->nullable()->unsigned()->change();
            } else {
                $table->unsignedBigInteger('database_id')->nullable()->unsigned();
            }

            $foreignKeys = $this->listTableForeignKeys('wisiloadviedquerytable');

            if (!in_array('wisiloadviedquerytable_database_id_foreign', $foreignKeys)) {
                $table->foreign('database_id')->references('id')->on('wisiloadvieddatabasetable'); 
            }     
        });
        Schema::table('wisiloadviedactiontable', function(Blueprint $table) {
            if (Schema::hasColumn('wisiloadviedactiontable', 'template_id')) { 
                $table->unsignedBigInteger('template_id')->nullable()->unsigned()->change();
            } else {
                $table->unsignedBigInteger('template_id')->nullable()->unsigned();
            }

            $foreignKeys = $this->listTableForeignKeys('wisiloadviedactiontable');

            if (!in_array('wisiloadviedactiontable_template_id_foreign', $foreignKeys)) {
                $table->foreign('template_id')->references('id')->on('wisiloadviedtemplatetable'); 
            }     
        });
        Schema::table('wisiloadviedparametertable', function(Blueprint $table) {
            if (Schema::hasColumn('wisiloadviedparametertable', 'template_id')) { 
                $table->unsignedBigInteger('template_id')->nullable()->unsigned()->change();
            } else {
                $table->unsignedBigInteger('template_id')->nullable()->unsigned();
            }

            $foreignKeys = $this->listTableForeignKeys('wisiloadviedparametertable');

            if (!in_array('wisiloadviedparametertable_template_id_foreign', $foreignKeys)) {
                $table->foreign('template_id')->references('id')->on('wisiloadviedtemplatetable'); 
            }     
        });
        Schema::table('wisiloadviedvalidationtable', function(Blueprint $table) {
            if (Schema::hasColumn('wisiloadviedvalidationtable', 'template_id')) { 
                $table->unsignedBigInteger('template_id')->nullable()->unsigned()->change();
            } else {
                $table->unsignedBigInteger('template_id')->nullable()->unsigned();
            }

            $foreignKeys = $this->listTableForeignKeys('wisiloadviedvalidationtable');

            if (!in_array('wisiloadviedvalidationtable_template_id_foreign', $foreignKeys)) {
                $table->foreign('template_id')->references('id')->on('wisiloadviedtemplatetable'); 
            }     
        });

        /* {{@snippet:end_up_method}} */
    }

    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        /* {{@snippet:begin_down_method}} */
        /*
        Schema::drop('wisiloadviedlookuptable');
  
        Schema::drop('wisiloadvieddatabasetable');
  
        Schema::drop('wisiloadviedtemplatetable');
  
        Schema::drop('wisiloadviedquerytable');
  
        Schema::drop('wisiloadviedactiontable');
  
        Schema::drop('wisiloadviedparametertable');
  
        Schema::drop('wisiloadviedvalidationtable');

        */
		/* {{@snippet:end_down_method}} */

    }

    public function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(function($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }

    /* {{@snippet:end_methods}} */
}

/* {{@snippet:end_class}} */
