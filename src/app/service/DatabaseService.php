<?php
declare(strict_types=1);
namespace PangzLab\App\Service;

use PangzLab\App\Repository\DatabaseRepository;
class DatabaseService
{
    private $repo;
    private $dbCollection;
    private $instances;

    public function __construct()
    {   
        $this->repo = new DatabaseRepository();
        $this->dbCollection['mysql'] = $this->repo->getMysql();
    }

    public function getInstance(string $dbName)
    {
        if(!isset($this->dbCollection[$dbName])) {
            throw new \InvalidArgumentException(
                " Database instance does not exist! [$dbName]"
            );
        }

        if(!isset($this->instances[$dbName])) {
            $this->instances[$dbName] = $this->dbCollection[$dbName]->establishConnection();
        }

        return $this->instances[$dbName];
    }
}