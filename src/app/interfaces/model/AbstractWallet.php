<?php
declare(strict_types=1);
namespace PangzLab\App\Interfaces\Model;

use PangzLab\Lib\Model\Model;

abstract class AbstractWallet extends Model
{
    abstract public function getInfo();
    protected function prepareInfo()
    {
        $info         = [];
        $propertyList = get_class_vars(get_class($this));
        foreach($propertyList as $currentProperty => $value) {
            $info[$currentProperty] = $params[$currentProperty] ?? null;
        }
        return $info;
    }
}