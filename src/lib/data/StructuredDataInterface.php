<?php
declare(strict_types=1);
namespace PangzLab\Lib\Data;

interface StructuredDataInterface extends DataStructureInterface
{
    public function establishConnection();
}