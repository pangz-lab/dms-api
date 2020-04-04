<?php
declare(strict_types=1);
namespace PangzLab\App\Service\DatabaseTransaction;

use PangzLab\Lib\Data\StructuredDataInterface;
use PangzLab\App\Interfaces\Service\DatabaseTransactionInterface;
use PangzLab\App\Interfaces\Service\DatabaseInterface;
use PangzLab\App\Service\DatabaseTransaction\InsertService;
use PangzLab\App\Service\DatabaseTransaction\QueryService;
use PangzLab\App\Service\DatabaseTransaction\UpdateService;
use PangzLab\App\Service\DatabaseTransaction\DeleteService;

//@Todo Add return value for methods, php 7.4
class DatabaseTransactionService implements DatabaseTransactionInterface
{
    private $dbService;
    private $dbInstance;

    public function __construct(
        DatabaseInterface $db,
        ?StructuredDataInterface $dbInstance = null
    ) {
        $this->dbService  = $db;
        $this->dbInstance = $dbInstance ?? $db->getInstance("mysql");
    }

    public function insert()
    {
        return new InsertService($this->dbInstance);
    }

    public function query()
    {
        return new QueryService($this->dbInstance);
    }

    public function update()
    {
        return new UpdateService($this->dbInstance);
    }

    public function delete()
    {
        return new DeleteService($this->dbInstance);
    }

    public function getDbInstance()
    {
        return $this->dbInstance;
    }

    public function setDbInstance(string $dbName)
    {
        $this->dbInstance = $this->dbService->getInstance($dbName);
        return $this;
    }

    public function getDbService()
    {
        return $this->dbService;
    }
}