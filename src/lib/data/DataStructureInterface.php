<?php
declare(strict_types=1);
namespace PangzLab\Lib\Data;
use PangzLab\Lib\Data\DatabaseParameter as DbParam;

interface DataStructureInterface
{
    public function getDataType();
    public function getSize();
    public function createData(DbParam $param);
    public function getData(DbParam $param);
    public function updateData(DbParam $param);
    public function deleteData(DbParam $param);
}