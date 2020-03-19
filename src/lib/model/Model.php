<?php
declare(strict_types=1);
namespace PangzLab\Lib\Model;

use PangzLab\Lib\Exception\ModelException;

class Model
{
    public function __construct(array $params)
    {
        $propertyList = get_class_vars(get_class($this));
        foreach($propertyList as $currentProperty) {
            $this->$currentProperty = $params[$currentProperty] ?? null;
        }
    }

    public function __call($name, $args)
    {
        $allowedOperation = [ 'get' ];
        $operation        = strtolower(substr($name, 0, 3));
        $property         = lcfirst(substr($name, 2));

        if(!in_array($operation, $allowedOperation)) {
            throw new ModelException("Operation [$operation] is not allowed!");
        }

        if(!property_exists($this, $property)) {
            throw new ModelException("Property [$property] not found in class [".__CLASS__."]!");
        }

        return $this->$property;
    }
}