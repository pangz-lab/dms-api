<?php
declare(strict_types=1);
namespace PangzLab\App\Service;

use PangzLab\Lib\Data\DatabaseParameter as DbParam;

class DatabaseService
{
    protected $dbRepo;
    protected $dbInstance;

    public function __construct()
    {
        $this->dbRepo = new MySqlDbService(
            new DbParam([
            'database'  => 'dudezmobi_staking',
            'host'      => 'localhost',
            'username'  => 'root',
            'password'  => '',
        ]));
        $this->dbInstance = $this->instantiateDbRepo();
    }

    public function getInstance()
    {
        return $this->dbInstance;
    }

    public function getRecords($params = [])
    {
        $param = array_merge(
            MySqlDbService::$parameterFormat,
            $params
        );
        return $this->dbInstance->getData(new DbParam($param));
    }

    private function instantiateDbRepo()
    {
        return $this->dbRepo->establishConnection();
    }
}