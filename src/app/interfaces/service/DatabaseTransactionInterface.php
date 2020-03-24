<?php
declare(strict_types=1);
namespace PangzLab\App\Interfaces\Service;

interface DatabaseTransactionInterface
{
    //@Todo set specifc return type php 7.4 covariance and contravariance
    public function insert();
    public function query();
    public function update();
    public function delete();
    public function getDbInstance();
    public function getDbService();
}