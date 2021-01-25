<?php
namespace Framework\Database;

use Illuminate\Database\Capsule\Manager as Capsule;


class Database
{
    public function __construct() {

        $db = new Capsule();
        
        $db->addConnection([
            'driver'    => db_config('driver'),
            'host'      => db_config('host_name'),
            'database'  => db_config('db_name'),
            'username'  => db_config('db_user'),
            'password'  => db_config('db_password'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
        $db->setAsGlobal();
        $db->bootEloquent();
    }
}