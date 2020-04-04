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
        $insParam = [
            "_table" => "dmstemp_user",
            "_columns" => [
                "public_address",
                "wallet_id",
                "email",
                "secret_word1",
                "secret_word2",
                "secret_word3",
            ],
            "_columnValues" => [
                [
                    "'pb1_fdfasdfka;djfkajsdkfljasd'",
                    "12443",
                    "'wallet1@gmail.com'",
                    "'secret11'",
                    "'secret21'",
                    "'secret31'",
                ],
                [
                    "'pb2_fdfasdfka;djfkajsdkfljasd'",
                    "23323",
                    "'wallet2@gmail.com'",
                    "'secret12'",
                    "'secret22'",
                    "'secret32'",
                ]
            ]
        ];
        // $db = $this->container->get('DatabaseService')->getInstance("mysql");
        // $db->createData($insParam);
        return $db->getData($params, null, 'PangzLab\App\Model\TestTxSummary');
    }
}