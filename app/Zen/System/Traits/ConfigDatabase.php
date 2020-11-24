<?php
/**
 * Created by PhpStorm.
 * User: prakashpokhrel
 * Date: 20/12/2017
 * Time: 17.00
 */

namespace App\Zen\System\Traits;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait ConfigDatabase
{
    public function assignDataBase($tenant)
    {
        DB ::purge('tenant');
        $config = config('database.connections.tenant');
        $config['database'] = $tenant -> database;
        config() -> set('database.connections.tenant', $config);
        config() -> set('database.default', 'tenant');
        Schema ::connection('tenant') -> getConnection() -> reconnect();
    }

    public function getDefaultDatabaseData()
    {
        $default['database'] = config("database.connections.tenant.database");
        return (object)$default;
    }

    public function assignSystemDataBase()
    {
        $config = config('database.connections.system');
        $config['database'] = 'system';
        config() -> set('database.connections.system', $config);
        config() -> set('database.default', 'system');
        Schema ::connection('system') -> getConnection() -> reconnect();
    }
}