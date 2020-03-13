<?php
declare(strict_types=1);
namespace PangzLab\App\Repository;
use PangzLab\Lib\Repository\Repository;

namespace PangzLab\App\Service\MySqlDbService;

use DI\Container;

class User extends Repository
{
    public function getDetail()
    {
        $params = [
            "_table" => "dms_wallet"
        ];
        return $this->container->get('DatabaseService')->getInstance("mysql")->getData($params);
    }
}