<?php
declare(strict_types=1);
namespace PangzLab\Lib\Resource;

abstract class AbstractResource
{
    const DS = "/";

    public static function getFile(string $source, bool $decodeToObject = true)
    {
        $s   = static::DS;
        $src = static::getFileBasePath().$s.$source;
        if(!\file_exists($src)) {
            throw new \InvalidArgumentException("Source file does not exist! [$src]");
        }
        
        if($decodeToObject) {
            return json_decode(\file_get_contents($src));
        }

        return \file_get_contents($src); 
    }

    abstract protected static function getFileBasePath(): string;
}