<?php
declare(strict_types=1);
namespace PangzLab\Lib\Routing;

interface RouteMethodCollectionInterface
{
    public static function get(): array;
    public static function post(): array;
    public static function put(): array;
    public static function delete(): array;
    public static function head(): array;
    public static function patch(): array;
    public static function options(): array;
    public static function any(): array;
}