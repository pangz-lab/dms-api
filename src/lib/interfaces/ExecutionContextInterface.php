<?php
declare(strict_types=1);
namespace PangzLab\Lib\Interfaces;

interface ExecutionContextInterface
{
    public static function app(): array;
    public static function methodGet(): array;
    public static function methodPost(): array;
    public static function methodPut(): array;
    public static function methodDelete(): array;
    public static function methodHead(): array;
    public static function methodPatch(): array;
    public static function methodOptions(): array;
}