<?php
declare(strict_types=1);
namespace PangzLab\App\Service\DatabaseTransaction;

use PangzLab\App\Service\DatabaseTransaction\TransactionMap;

class InsertService extends TransactionMap
{
    public function execute()
    {
        $binding = $this->binding;
        $params  = [
            "_table"        => $this->table,
            "_columns"      => $this->columns,
            "_columnValues" => $this->values,
            "_condition"    => $this->condition
        ];

        return $this->dbInstance->createData($params, $binding);
    }
}