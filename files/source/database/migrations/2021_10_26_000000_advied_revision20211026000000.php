<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\AdminLTE\AdminLTE;

/* {{@snippet:begin_class}} */

class ADVIEDRevision20211026000000 extends Migration
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

        /* {{@snippet:begin_adminlteadviedlookuptable_migration}} */        
        if (!Schema::hasTable('adminlteadviedlookuptable')) {
            Schema::create('adminlteadviedlookuptable', function (Blueprint $table) {
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

            DB::table('adminlteadviedlookuptable')->insert(
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

            DB::table('adminlteadviedlookuptable')->insert(
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

            DB::table('adminlteadviedlookuptable')->insert(
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

            DB::table('adminlteadviedlookuptable')->insert(
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

            DB::table('adminlteadviedlookuptable')->insert(
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

            DB::table('adminlteadviedlookuptable')->insert(
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

            DB::table('adminlteadviedlookuptable')->insert(
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

            DB::table('adminlteadviedlookuptable')->insert(
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

            DB::table('adminlteadviedlookuptable')->insert(
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

            DB::table('adminlteadviedlookuptable')->insert(
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

            DB::table('adminlteadviedlookuptable')->insert(
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

            DB::table('adminlteadviedlookuptable')->insert(
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
            Schema::table('adminlteadviedlookuptable', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('adminlteadviedlookuptable');
                //Schema::disableForeignKeyConstraints();
                if (Schema::hasColumn('adminlteadviedlookuptable', 'enabled')) {                    
                    if (in_array('adminlteadviedlookuptable_enabled_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedlookuptable_enabled_foreign');
                        $table->dropIndex('adminlteadviedlookuptable_enabled_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedlookuptable', '__order')) {                    
                    if (in_array('adminlteadviedlookuptable___order_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedlookuptable___order_foreign');
                        $table->dropIndex('adminlteadviedlookuptable___order_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedlookuptable', 'group')) {                    
                    if (in_array('adminlteadviedlookuptable_group_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedlookuptable_group_foreign');
                        $table->dropIndex('adminlteadviedlookuptable_group_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedlookuptable', 'title')) {                    
                    if (in_array('adminlteadviedlookuptable_title_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedlookuptable_title_foreign');
                        $table->dropIndex('adminlteadviedlookuptable_title_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedlookuptable', 'value1')) {                    
                    if (in_array('adminlteadviedlookuptable_value1_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedlookuptable_value1_foreign');
                        $table->dropIndex('adminlteadviedlookuptable_value1_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedlookuptable', 'value2')) {                    
                    if (in_array('adminlteadviedlookuptable_value2_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedlookuptable_value2_foreign');
                        $table->dropIndex('adminlteadviedlookuptable_value2_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedlookuptable', 'value3')) {                    
                    if (in_array('adminlteadviedlookuptable_value3_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedlookuptable_value3_foreign');
                        $table->dropIndex('adminlteadviedlookuptable_value3_foreign');
                    }
                }
                //Schema::enableForeignKeyConstraints();
            });

            Schema::table('adminlteadviedlookuptable', function (Blueprint $table) {
                if (Schema::hasColumn('adminlteadviedlookuptable', 'enabled')) { 
                    $table->smallInteger('enabled')->default(0)->change();
                } else {
                    $table->smallInteger('enabled')->default(0);
                }
                if (Schema::hasColumn('adminlteadviedlookuptable', '__order')) { 
                    $table->bigInteger('__order')->default(0)->change();
                } else {
                    $table->bigInteger('__order')->default(0);
                }
                if (Schema::hasColumn('adminlteadviedlookuptable', 'group')) { 
                    $table->string('group')->nullable()->change();
                } else {
                    $table->string('group')->nullable();
                }
                if (Schema::hasColumn('adminlteadviedlookuptable', 'title')) { 
                    $table->string('title')->nullable()->change();
                } else {
                    $table->string('title')->nullable();
                }
                if (Schema::hasColumn('adminlteadviedlookuptable', 'value1')) { 
                    $table->string('value1')->nullable()->change();
                } else {
                    $table->string('value1')->nullable();
                }
                if (Schema::hasColumn('adminlteadviedlookuptable', 'value2')) { 
                    $table->string('value2')->nullable()->change();
                } else {
                    $table->string('value2')->nullable();
                }
                if (Schema::hasColumn('adminlteadviedlookuptable', 'value3')) { 
                    $table->string('value3')->nullable()->change();
                } else {
                    $table->string('value3')->nullable();
                }
            });
            
        } // if (!Schema::hasTable('adminlteadviedlookuptable')) {

        /* {{@snippet:end_adminlteadviedlookuptable_migration}} */

        /* {{@snippet:begin_adminlteadvieddatabasetable_migration}} */        
        if (!Schema::hasTable('adminlteadvieddatabasetable')) {
            Schema::create('adminlteadvieddatabasetable', function (Blueprint $table) {
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
            Schema::table('adminlteadvieddatabasetable', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('adminlteadvieddatabasetable');
                //Schema::disableForeignKeyConstraints();
                if (Schema::hasColumn('adminlteadvieddatabasetable', 'enabled')) {                    
                    if (in_array('adminlteadvieddatabasetable_enabled_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadvieddatabasetable_enabled_foreign');
                        $table->dropIndex('adminlteadvieddatabasetable_enabled_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadvieddatabasetable', 'title')) {                    
                    if (in_array('adminlteadvieddatabasetable_title_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadvieddatabasetable_title_foreign');
                        $table->dropIndex('adminlteadvieddatabasetable_title_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadvieddatabasetable', 'host')) {                    
                    if (in_array('adminlteadvieddatabasetable_host_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadvieddatabasetable_host_foreign');
                        $table->dropIndex('adminlteadvieddatabasetable_host_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadvieddatabasetable', 'database_name')) {                    
                    if (in_array('adminlteadvieddatabasetable_database_name_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadvieddatabasetable_database_name_foreign');
                        $table->dropIndex('adminlteadvieddatabasetable_database_name_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadvieddatabasetable', 'username')) {                    
                    if (in_array('adminlteadvieddatabasetable_username_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadvieddatabasetable_username_foreign');
                        $table->dropIndex('adminlteadvieddatabasetable_username_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadvieddatabasetable', 'password')) {                    
                    if (in_array('adminlteadvieddatabasetable_password_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadvieddatabasetable_password_foreign');
                        $table->dropIndex('adminlteadvieddatabasetable_password_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadvieddatabasetable', 'port')) {                    
                    if (in_array('adminlteadvieddatabasetable_port_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadvieddatabasetable_port_foreign');
                        $table->dropIndex('adminlteadvieddatabasetable_port_foreign');
                    }
                }
                //Schema::enableForeignKeyConstraints();
            });

            Schema::table('adminlteadvieddatabasetable', function (Blueprint $table) {
                if (Schema::hasColumn('adminlteadvieddatabasetable', 'enabled')) { 
                    $table->smallInteger('enabled')->default(0)->change();
                } else {
                    $table->smallInteger('enabled')->default(0);
                }
                if (Schema::hasColumn('adminlteadvieddatabasetable', 'title')) { 
                    $table->string('title')->nullable()->change();
                } else {
                    $table->string('title')->nullable();
                }
                if (Schema::hasColumn('adminlteadvieddatabasetable', 'host')) { 
                    $table->string('host')->nullable()->change();
                } else {
                    $table->string('host')->nullable();
                }
                if (Schema::hasColumn('adminlteadvieddatabasetable', 'database_name')) { 
                    $table->string('database_name')->nullable()->change();
                } else {
                    $table->string('database_name')->nullable();
                }
                if (Schema::hasColumn('adminlteadvieddatabasetable', 'username')) { 
                    $table->string('username')->nullable()->change();
                } else {
                    $table->string('username')->nullable();
                }
                if (Schema::hasColumn('adminlteadvieddatabasetable', 'password')) { 
                    $table->longText('password')->nullable()->change();
                } else {
                    $table->longText('password')->nullable();
                }
                if (Schema::hasColumn('adminlteadvieddatabasetable', 'port')) { 
                    $table->bigInteger('port')->default(0)->change();
                } else {
                    $table->bigInteger('port')->default(0);
                }
            });
            
        } // if (!Schema::hasTable('adminlteadvieddatabasetable')) {

        /* {{@snippet:end_adminlteadvieddatabasetable_migration}} */

        /* {{@snippet:begin_adminlteadviedtemplatetable_migration}} */        
        if (!Schema::hasTable('adminlteadviedtemplatetable')) {
            Schema::create('adminlteadviedtemplatetable', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->boolean('deleted')->default(0);
                $table->smallInteger('enabled')->default(0);
                $table->smallInteger('type')->default(0);
                $table->string('title')->nullable();
                $table->longText('description')->nullable();
            });
        } else {
            Schema::table('adminlteadviedtemplatetable', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('adminlteadviedtemplatetable');
                //Schema::disableForeignKeyConstraints();
                if (Schema::hasColumn('adminlteadviedtemplatetable', 'enabled')) {                    
                    if (in_array('adminlteadviedtemplatetable_enabled_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedtemplatetable_enabled_foreign');
                        $table->dropIndex('adminlteadviedtemplatetable_enabled_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedtemplatetable', 'type')) {                    
                    if (in_array('adminlteadviedtemplatetable_type_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedtemplatetable_type_foreign');
                        $table->dropIndex('adminlteadviedtemplatetable_type_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedtemplatetable', 'title')) {                    
                    if (in_array('adminlteadviedtemplatetable_title_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedtemplatetable_title_foreign');
                        $table->dropIndex('adminlteadviedtemplatetable_title_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedtemplatetable', 'description')) {                    
                    if (in_array('adminlteadviedtemplatetable_description_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedtemplatetable_description_foreign');
                        $table->dropIndex('adminlteadviedtemplatetable_description_foreign');
                    }
                }
                //Schema::enableForeignKeyConstraints();
            });

            Schema::table('adminlteadviedtemplatetable', function (Blueprint $table) {
                if (Schema::hasColumn('adminlteadviedtemplatetable', 'enabled')) { 
                    $table->smallInteger('enabled')->default(0)->change();
                } else {
                    $table->smallInteger('enabled')->default(0);
                }
                if (Schema::hasColumn('adminlteadviedtemplatetable', 'type')) { 
                    $table->smallInteger('type')->default(0)->change();
                } else {
                    $table->smallInteger('type')->default(0);
                }
                if (Schema::hasColumn('adminlteadviedtemplatetable', 'title')) { 
                    $table->string('title')->nullable()->change();
                } else {
                    $table->string('title')->nullable();
                }
                if (Schema::hasColumn('adminlteadviedtemplatetable', 'description')) { 
                    $table->longText('description')->nullable()->change();
                } else {
                    $table->longText('description')->nullable();
                }
            });
            
        } // if (!Schema::hasTable('adminlteadviedtemplatetable')) {

        /* {{@snippet:end_adminlteadviedtemplatetable_migration}} */

        /* {{@snippet:begin_adminlteadviedquerytable_migration}} */        
        if (!Schema::hasTable('adminlteadviedquerytable')) {
            Schema::create('adminlteadviedquerytable', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();
                $table->boolean('deleted')->default(0);
                $table->smallInteger('enabled')->default(0);
                $table->bigInteger('__order')->default(0);
                $table->longText('condition')->nullable();
                $table->longText('query')->nullable();
            });
        } else {
            Schema::table('adminlteadviedquerytable', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('adminlteadviedquerytable');
                //Schema::disableForeignKeyConstraints();
                if (Schema::hasColumn('adminlteadviedquerytable', 'enabled')) {                    
                    if (in_array('adminlteadviedquerytable_enabled_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedquerytable_enabled_foreign');
                        $table->dropIndex('adminlteadviedquerytable_enabled_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedquerytable', '__order')) {                    
                    if (in_array('adminlteadviedquerytable___order_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedquerytable___order_foreign');
                        $table->dropIndex('adminlteadviedquerytable___order_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedquerytable', 'condition')) {                    
                    if (in_array('adminlteadviedquerytable_condition_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedquerytable_condition_foreign');
                        $table->dropIndex('adminlteadviedquerytable_condition_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedquerytable', 'query')) {                    
                    if (in_array('adminlteadviedquerytable_query_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedquerytable_query_foreign');
                        $table->dropIndex('adminlteadviedquerytable_query_foreign');
                    }
                }
                //Schema::enableForeignKeyConstraints();
            });

            Schema::table('adminlteadviedquerytable', function (Blueprint $table) {
                if (Schema::hasColumn('adminlteadviedquerytable', 'enabled')) { 
                    $table->smallInteger('enabled')->default(0)->change();
                } else {
                    $table->smallInteger('enabled')->default(0);
                }
                if (Schema::hasColumn('adminlteadviedquerytable', '__order')) { 
                    $table->bigInteger('__order')->default(0)->change();
                } else {
                    $table->bigInteger('__order')->default(0);
                }
                if (Schema::hasColumn('adminlteadviedquerytable', 'condition')) { 
                    $table->longText('condition')->nullable()->change();
                } else {
                    $table->longText('condition')->nullable();
                }
                if (Schema::hasColumn('adminlteadviedquerytable', 'query')) { 
                    $table->longText('query')->nullable()->change();
                } else {
                    $table->longText('query')->nullable();
                }
            });
            
        } // if (!Schema::hasTable('adminlteadviedquerytable')) {

        /* {{@snippet:end_adminlteadviedquerytable_migration}} */

        /* {{@snippet:begin_adminlteadviedactiontable_migration}} */        
        if (!Schema::hasTable('adminlteadviedactiontable')) {
            Schema::create('adminlteadviedactiontable', function (Blueprint $table) {
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
            Schema::table('adminlteadviedactiontable', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('adminlteadviedactiontable');
                //Schema::disableForeignKeyConstraints();
                if (Schema::hasColumn('adminlteadviedactiontable', 'enabled')) {                    
                    if (in_array('adminlteadviedactiontable_enabled_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedactiontable_enabled_foreign');
                        $table->dropIndex('adminlteadviedactiontable_enabled_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedactiontable', '__order')) {                    
                    if (in_array('adminlteadviedactiontable___order_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedactiontable___order_foreign');
                        $table->dropIndex('adminlteadviedactiontable___order_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedactiontable', 'title')) {                    
                    if (in_array('adminlteadviedactiontable_title_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedactiontable_title_foreign');
                        $table->dropIndex('adminlteadviedactiontable_title_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedactiontable', 'condition')) {                    
                    if (in_array('adminlteadviedactiontable_condition_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedactiontable_condition_foreign');
                        $table->dropIndex('adminlteadviedactiontable_condition_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedactiontable', 'operation')) {                    
                    if (in_array('adminlteadviedactiontable_operation_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedactiontable_operation_foreign');
                        $table->dropIndex('adminlteadviedactiontable_operation_foreign');
                    }
                }
                //Schema::enableForeignKeyConstraints();
            });

            Schema::table('adminlteadviedactiontable', function (Blueprint $table) {
                if (Schema::hasColumn('adminlteadviedactiontable', 'enabled')) { 
                    $table->smallInteger('enabled')->default(0)->change();
                } else {
                    $table->smallInteger('enabled')->default(0);
                }
                if (Schema::hasColumn('adminlteadviedactiontable', '__order')) { 
                    $table->bigInteger('__order')->default(0)->change();
                } else {
                    $table->bigInteger('__order')->default(0);
                }
                if (Schema::hasColumn('adminlteadviedactiontable', 'title')) { 
                    $table->string('title')->nullable()->change();
                } else {
                    $table->string('title')->nullable();
                }
                if (Schema::hasColumn('adminlteadviedactiontable', 'condition')) { 
                    $table->longText('condition')->nullable()->change();
                } else {
                    $table->longText('condition')->nullable();
                }
                if (Schema::hasColumn('adminlteadviedactiontable', 'operation')) { 
                    $table->longText('operation')->nullable()->change();
                } else {
                    $table->longText('operation')->nullable();
                }
            });
            
        } // if (!Schema::hasTable('adminlteadviedactiontable')) {

        /* {{@snippet:end_adminlteadviedactiontable_migration}} */

        /* {{@snippet:begin_adminlteadviedparametertable_migration}} */        
        if (!Schema::hasTable('adminlteadviedparametertable')) {
            Schema::create('adminlteadviedparametertable', function (Blueprint $table) {
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
            Schema::table('adminlteadviedparametertable', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('adminlteadviedparametertable');
                //Schema::disableForeignKeyConstraints();
                if (Schema::hasColumn('adminlteadviedparametertable', 'enabled')) {                    
                    if (in_array('adminlteadviedparametertable_enabled_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedparametertable_enabled_foreign');
                        $table->dropIndex('adminlteadviedparametertable_enabled_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedparametertable', '__order')) {                    
                    if (in_array('adminlteadviedparametertable___order_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedparametertable___order_foreign');
                        $table->dropIndex('adminlteadviedparametertable___order_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedparametertable', 'title')) {                    
                    if (in_array('adminlteadviedparametertable_title_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedparametertable_title_foreign');
                        $table->dropIndex('adminlteadviedparametertable_title_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedparametertable', 'name')) {                    
                    if (in_array('adminlteadviedparametertable_name_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedparametertable_name_foreign');
                        $table->dropIndex('adminlteadviedparametertable_name_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedparametertable', 'type')) {                    
                    if (in_array('adminlteadviedparametertable_type_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedparametertable_type_foreign');
                        $table->dropIndex('adminlteadviedparametertable_type_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedparametertable', 'option_titles')) {                    
                    if (in_array('adminlteadviedparametertable_option_titles_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedparametertable_option_titles_foreign');
                        $table->dropIndex('adminlteadviedparametertable_option_titles_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedparametertable', 'option_values')) {                    
                    if (in_array('adminlteadviedparametertable_option_values_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedparametertable_option_values_foreign');
                        $table->dropIndex('adminlteadviedparametertable_option_values_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedparametertable', 'default')) {                    
                    if (in_array('adminlteadviedparametertable_default_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedparametertable_default_foreign');
                        $table->dropIndex('adminlteadviedparametertable_default_foreign');
                    }
                }
                //Schema::enableForeignKeyConstraints();
            });

            Schema::table('adminlteadviedparametertable', function (Blueprint $table) {
                if (Schema::hasColumn('adminlteadviedparametertable', 'enabled')) { 
                    $table->smallInteger('enabled')->default(0)->change();
                } else {
                    $table->smallInteger('enabled')->default(0);
                }
                if (Schema::hasColumn('adminlteadviedparametertable', '__order')) { 
                    $table->bigInteger('__order')->default(0)->change();
                } else {
                    $table->bigInteger('__order')->default(0);
                }
                if (Schema::hasColumn('adminlteadviedparametertable', 'title')) { 
                    $table->string('title')->nullable()->change();
                } else {
                    $table->string('title')->nullable();
                }
                if (Schema::hasColumn('adminlteadviedparametertable', 'name')) { 
                    $table->string('name')->nullable()->change();
                } else {
                    $table->string('name')->nullable();
                }
                if (Schema::hasColumn('adminlteadviedparametertable', 'type')) { 
                    $table->string('type')->nullable()->change();
                } else {
                    $table->string('type')->nullable();
                }
                if (Schema::hasColumn('adminlteadviedparametertable', 'option_titles')) { 
                    $table->longText('option_titles')->nullable()->change();
                } else {
                    $table->longText('option_titles')->nullable();
                }
                if (Schema::hasColumn('adminlteadviedparametertable', 'option_values')) { 
                    $table->longText('option_values')->nullable()->change();
                } else {
                    $table->longText('option_values')->nullable();
                }
                if (Schema::hasColumn('adminlteadviedparametertable', 'default')) { 
                    $table->longText('default')->nullable()->change();
                } else {
                    $table->longText('default')->nullable();
                }
            });
            
        } // if (!Schema::hasTable('adminlteadviedparametertable')) {

        /* {{@snippet:end_adminlteadviedparametertable_migration}} */

        /* {{@snippet:begin_adminlteadviedvalidationtable_migration}} */        
        if (!Schema::hasTable('adminlteadviedvalidationtable')) {
            Schema::create('adminlteadviedvalidationtable', function (Blueprint $table) {
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
            Schema::table('adminlteadviedvalidationtable', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('adminlteadviedvalidationtable');
                //Schema::disableForeignKeyConstraints();
                if (Schema::hasColumn('adminlteadviedvalidationtable', 'enabled')) {                    
                    if (in_array('adminlteadviedvalidationtable_enabled_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedvalidationtable_enabled_foreign');
                        $table->dropIndex('adminlteadviedvalidationtable_enabled_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedvalidationtable', '__order')) {                    
                    if (in_array('adminlteadviedvalidationtable___order_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedvalidationtable___order_foreign');
                        $table->dropIndex('adminlteadviedvalidationtable___order_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedvalidationtable', 'title')) {                    
                    if (in_array('adminlteadviedvalidationtable_title_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedvalidationtable_title_foreign');
                        $table->dropIndex('adminlteadviedvalidationtable_title_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedvalidationtable', 'condition')) {                    
                    if (in_array('adminlteadviedvalidationtable_condition_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedvalidationtable_condition_foreign');
                        $table->dropIndex('adminlteadviedvalidationtable_condition_foreign');
                    }
                }
                if (Schema::hasColumn('adminlteadviedvalidationtable', 'message')) {                    
                    if (in_array('adminlteadviedvalidationtable_message_foreign', $foreignKeys)) {
                        $table->dropForeign('adminlteadviedvalidationtable_message_foreign');
                        $table->dropIndex('adminlteadviedvalidationtable_message_foreign');
                    }
                }
                //Schema::enableForeignKeyConstraints();
            });

            Schema::table('adminlteadviedvalidationtable', function (Blueprint $table) {
                if (Schema::hasColumn('adminlteadviedvalidationtable', 'enabled')) { 
                    $table->smallInteger('enabled')->default(0)->change();
                } else {
                    $table->smallInteger('enabled')->default(0);
                }
                if (Schema::hasColumn('adminlteadviedvalidationtable', '__order')) { 
                    $table->bigInteger('__order')->default(0)->change();
                } else {
                    $table->bigInteger('__order')->default(0);
                }
                if (Schema::hasColumn('adminlteadviedvalidationtable', 'title')) { 
                    $table->string('title')->nullable()->change();
                } else {
                    $table->string('title')->nullable();
                }
                if (Schema::hasColumn('adminlteadviedvalidationtable', 'condition')) { 
                    $table->longText('condition')->nullable()->change();
                } else {
                    $table->longText('condition')->nullable();
                }
                if (Schema::hasColumn('adminlteadviedvalidationtable', 'message')) { 
                    $table->longText('message')->nullable()->change();
                } else {
                    $table->longText('message')->nullable();
                }
            });
            
        } // if (!Schema::hasTable('adminlteadviedvalidationtable')) {
        /* {{@snippet:end_adminlteadviedvalidationtable_migration}} */
        
        Schema::table('adminlteadvieddatabasetable', function(Blueprint $table) {
            if (Schema::hasColumn('adminlteadvieddatabasetable', 'database_type')) { 
                $table->unsignedBigInteger('database_type')->nullable()->unsigned()->change();
            } else {
                $table->unsignedBigInteger('database_type')->nullable()->unsigned();
            }

            $foreignKeys = $this->listTableForeignKeys('adminlteadvieddatabasetable');

            if (!in_array('adminlteadvieddatabasetable_database_type_foreign', $foreignKeys)) {
                $table->foreign('database_type')->references('id')->on('adminlteadviedlookuptable'); 
            }     
        });

        Schema::table('adminlteadviedquerytable', function(Blueprint $table) {
            if (Schema::hasColumn('adminlteadviedquerytable', 'template_id')) { 
                $table->unsignedBigInteger('template_id')->nullable()->unsigned()->change();
            } else {
                $table->unsignedBigInteger('template_id')->nullable()->unsigned();
            }

            $foreignKeys = $this->listTableForeignKeys('adminlteadviedquerytable');

            if (!in_array('adminlteadviedquerytable_template_id_foreign', $foreignKeys)) {
                $table->foreign('template_id')->references('id')->on('adminlteadviedtemplatetable'); 
            }     
        });
        Schema::table('adminlteadviedquerytable', function(Blueprint $table) {
            if (Schema::hasColumn('adminlteadviedquerytable', 'database_id')) { 
                $table->unsignedBigInteger('database_id')->nullable()->unsigned()->change();
            } else {
                $table->unsignedBigInteger('database_id')->nullable()->unsigned();
            }

            $foreignKeys = $this->listTableForeignKeys('adminlteadviedquerytable');

            if (!in_array('adminlteadviedquerytable_database_id_foreign', $foreignKeys)) {
                $table->foreign('database_id')->references('id')->on('adminlteadvieddatabasetable'); 
            }     
        });
        Schema::table('adminlteadviedactiontable', function(Blueprint $table) {
            if (Schema::hasColumn('adminlteadviedactiontable', 'template_id')) { 
                $table->unsignedBigInteger('template_id')->nullable()->unsigned()->change();
            } else {
                $table->unsignedBigInteger('template_id')->nullable()->unsigned();
            }

            $foreignKeys = $this->listTableForeignKeys('adminlteadviedactiontable');

            if (!in_array('adminlteadviedactiontable_template_id_foreign', $foreignKeys)) {
                $table->foreign('template_id')->references('id')->on('adminlteadviedtemplatetable'); 
            }     
        });
        Schema::table('adminlteadviedparametertable', function(Blueprint $table) {
            if (Schema::hasColumn('adminlteadviedparametertable', 'template_id')) { 
                $table->unsignedBigInteger('template_id')->nullable()->unsigned()->change();
            } else {
                $table->unsignedBigInteger('template_id')->nullable()->unsigned();
            }

            $foreignKeys = $this->listTableForeignKeys('adminlteadviedparametertable');

            if (!in_array('adminlteadviedparametertable_template_id_foreign', $foreignKeys)) {
                $table->foreign('template_id')->references('id')->on('adminlteadviedtemplatetable'); 
            }     
        });
        Schema::table('adminlteadviedvalidationtable', function(Blueprint $table) {
            if (Schema::hasColumn('adminlteadviedvalidationtable', 'template_id')) { 
                $table->unsignedBigInteger('template_id')->nullable()->unsigned()->change();
            } else {
                $table->unsignedBigInteger('template_id')->nullable()->unsigned();
            }

            $foreignKeys = $this->listTableForeignKeys('adminlteadviedvalidationtable');

            if (!in_array('adminlteadviedvalidationtable_template_id_foreign', $foreignKeys)) {
                $table->foreign('template_id')->references('id')->on('adminlteadviedtemplatetable'); 
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
        Schema::drop('adminlteadviedlookuptable');
  
        Schema::drop('adminlteadvieddatabasetable');
  
        Schema::drop('adminlteadviedtemplatetable');
  
        Schema::drop('adminlteadviedquerytable');
  
        Schema::drop('adminlteadviedactiontable');
  
        Schema::drop('adminlteadviedparametertable');
  
        Schema::drop('adminlteadviedvalidationtable');

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
