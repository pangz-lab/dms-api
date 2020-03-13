<?php
declare(strict_types=1);
namespace PangzLab\App\Repository;

use DI\Container;
use PangzLab\Lib\Repository\Repository;

class Transaction extends Repository
{
    public function getSummary()
    {
        $params = [
            "_table" => "dms_wallet"
        ];
        return $this->container->get('DatabaseService')
            ->getInstance("mysql")
            ->getData($params, 'PangzLab\App\Model\TestTxSummary');
    }
}