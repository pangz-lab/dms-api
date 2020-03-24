<?php
declare(strict_types=1);
namespace PangzLab\App\Repository;

use PangzLab\App\Interfaces\Service\DatabaseTransactionInterface;

class AppRepository
{
    private $dbTransactionService;
    private $dbService = [];
    
    public function __construct(
        DatabaseTransactionInterface $dbTransactionService
    ) {
        $this->dbTransactionService = $dbTransactionService;
        $this->dbService['insert']  = $dbTransactionService->insert();
        $this->dbService['query']   = $dbTransactionService->query();
        $this->dbService['delete']  = $dbTransactionService->delete();
        $this->dbService['update']  = $dbTransactionService->update();
    }

    public function getDbService()
    {
        return $this->dbService;
    }

    public function getDbTransactionService()
    {
        return $this->dbTransactionService;
    }
}