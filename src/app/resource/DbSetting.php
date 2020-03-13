<?php
declare(strict_types=1);
namespace PangzLab\App\Resource;

use PangzLab\Lib\Resource\AbstractResource;

class DbSetting extends AbstractResource
{
    public static function getMysql()
    {
       return self::getFile("/db_setting/mysql.json");
    }
    
    protected static function getFileBasePath(): string
    {
        return dirname(__FILE__, 2).self::DS.".res";
    }
}