<?php
declare(strict_types=1);
namespace PangzLab\Lib\Data;

interface DataStructureInterface
{
    public function getDataType();
    public function getSize();
    public function createData(array $param);
    public function getData(array $param);
    public function updateData(array $param);
    public function deleteData(array $param);
}