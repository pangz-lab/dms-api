<?php
declare(strict_types=1);
namespace PangzLab\Lib\Data;

class DatabaseParameter
{
    private $parameterList = [];

    public function __construct(array $param)
    {
        $this->parameterList = $param;
    }

    public function __get(string $name)
    {
        if(isset($this->parameterList[$name])) {
            return $this->parameterList[$name];
        }
        throw new TypeError("Unknown Database parameter");
    }

    public function __set(string $name, $v)
    {
        throw new LogicException("Database parameter update not allowed");
    }
}