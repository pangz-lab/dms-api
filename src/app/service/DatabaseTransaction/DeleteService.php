<?php
declare(strict_types=1);
namespace PangzLab\App\Service\DatabaseTransaction;

use PangzLab\App\Service\DatabaseTransaction\TransactionMap;

class DeleteService extends TransactionMap
{
    public function execute()
    {
        $binding = $this->binding;
        $params  = [
            "_table"     => $this->table,
            "_condition" => $this->condition ?? ""
        ];

        return $this->dbInstance->deleteData($params, $binding);
    }
}