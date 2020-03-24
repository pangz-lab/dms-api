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
        $ope          = "";

        foreach($propertyList as $property => $value) {
            if($property == 'getterMethods') {break;}
            $ope = $this->convertToGetter($property);
            $this->getterMethods[$ope] = $property;
        }
    }

    public function __call($name, $args)
    {
        if(!isset($this->getterMethods[$name])) {
            var_dump($this->getterMethods);
            throw new ModelException("Operation [$name] is not allowed!");
        }
        $prop = $this->getterMethods[$name];
        return $this->$prop;
    }

    private function convertToGetter(string $prop)
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