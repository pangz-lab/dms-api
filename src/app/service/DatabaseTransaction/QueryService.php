<?php
declare(strict_types=1);
namespace PangzLab\App\Service\DatabaseTransaction;

use PangzLab\App\Service\DatabaseTransaction\TransactionMap;

class QueryService extends TransactionMap
{
    private $resultClass;

    public function withResultClass(string $resultClass)
    {
        $this->resultClass = $resultClass;
        return $this;
    }

    public function execute()
    {
        $binding  = $this->binding;
        $rowClass = $this->resultClass;
        $params  = [
            "_table"        => $this->table,
            "_columns"      => $this->columns ?? [],
            "_condition"    => $this->condition ?? ""
        ];

        return $this->dbInstance->getData($params, $binding, $rowClass);
    }
}