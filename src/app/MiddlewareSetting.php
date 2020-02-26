<?php
namespace PangzLab\App;

use PangzLab\Lib\Interfaces\ExecutionContextInterface;

class MiddlewareSetting implements ExecutionContextInterface
{
    public static function app(): array
    {
        return [
            'SessionChecker',
            'Parser',
            'SessionChecker',
            'Parser',
        ];
    }

    public static function methodGet(): array 
    {
        return [
            'GetParser'
        ];
    }

    public static function methodPost(): array
    {
        return [
            'PostParser'
        ];
    }

    public static function methodPut(): array
    {
        return [
            'PutParser'
        ];
    }

    public static function methodDelete(): array
    { 
        return [
            'DeleteParser'
        ];
    }

    public static function methodHead(): array
    { 
        return [
            'HeadParser'
        ];
    }

    public static function methodPatch(): array
    { 
        return [
            'PatchParser'
        ];
    }

    public static function methodOptions(): array
    { 
        return [
            'OptionsParser'
        ];
    }
}