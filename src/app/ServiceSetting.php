<?php
declare(strict_types=1);
namespace PangzLab\App;

use PangzLab\Lib\Interfaces\ExecutionContextInterface;

class ServiceSetting implements ExecutionContextInterface
{
    public static function app(): array
    {
        return [
            'DatabaseService'
        ];
    }
    public static function methodGet(): array { return [];}
    public static function methodPost(): array
    {
        return [
            'PostService',
        ];
    }
    
    public static function methodPut(): array { return [];}
    public static function methodDelete(): array { return [];}
    public static function methodHead(): array { return [];}
    public static function methodPatch(): array { return [];}
    public static function methodOptions(): array { return [];}
}