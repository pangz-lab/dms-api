<?php
declare(strict_types=1);
namespace PangzLab\App\Model\DAO;

use PangzLab\Lib\Model\Model;

class DataObjectModel extends Model
{
    protected $getterMethods = [];
    public function __construct()
    {
        $propertyList = get_class_vars(get_class($this));

        foreach($propertyList as $property => $value) {
            if($property == 'getterMethods') {break;}

            $this->getterMethods[$this->createGetter($property)] = $property;
        }
    }

    public function __call($name, $args)
    {
        if(!isset($this->getterMethods[$name])) {
            throw new ModelException("Operation [$name] is not allowed in class ".__CLASS__."!");
        }

        return $this->{$this->getterMethods[$name]};
    }

    private function createGetter(string $prop)
    {
        $component = explode("_", $prop);
        if(count($component) > 1) {
            return "get".implode("", array_map(
                function($v){
                    return ucfirst($v);
                },
                $component
            ));
        }

        return "get".ucfirst($prop);
    }
}