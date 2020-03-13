<?php
declare(strict_types=1);
namespace PangzLab\App\Repository;

use DI\Container;
use PangzLab\Lib\Repository\Repository;

use PangzLab\App\Resource\DbSetting;
use PangzLab\App\Service\MySqlDbService;

class DatabaseRepository extends Repository
{
    public function getMysql(string $configName = 'dms_api')
    {
        $setting = DbSetting::getMysql();
        $setting = (object) $setting->{$configName};
        return new MySqlDbService([
            'database'  => $setting->database,
            'host'      => $setting->host,
            'username'  => $setting->username,
            'password'  => $setting->password,
        ]); 
    }
}