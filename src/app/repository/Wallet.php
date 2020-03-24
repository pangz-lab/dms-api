<?php
declare(strict_types=1);
namespace PangzLab\App\Repository\Wallet;

use PangzLab\App\Repository\AppRepository;
use PangzLab\App\Model\Wallet\UserWallet;

class Wallet extends AppRepository
{
    public function add(UserWallet $wallet)
    {
        $insert = $this->getDbService()['insert'];
        $binding = [
            ":address"         => $wallet->getAddress(),
            ":address_type"    => $wallet->getAddressType(),
            ":opening_balance" => $wallet->getOpeningBalance(),
            ":wallet_type"     => $wallet->getWalletType(),
            ":status"          => $wallet->getStatus(),
        ];
        $values = [
            ":address",
            ":address_type",
            ":opening_balance",
            ":wallet_type",
            ":status",
        ];
        $columns = [
            "address",
            "address_type",
            "opening_balance",
            "wallet_type",
            "status",
        ];

        return $insert->inTable('dms_wallet')
            ->withValues([$values])
            ->forColumns($columns)
            ->boundBy($binding)
            ->execute();
    }

    public function exist(UserWallet $wallet)
    {
        $query = $this->getDbService()['query'];
        $condition = "
            address = :address AND
            address_type = :address_type AND
            wallet_type = :wallet_type
        ";
        $binding = [
            ":address"      => $wallet->getAddress(),
            ":address_type" => $wallet->getAddressType(),
            ":wallet_type"  => $wallet->getWalletType()
        ];

        $result = $query->inTable('dms_wallet')
            ->where($condition)
            ->boundBy($binding)
            ->execute();

        return (count($result) > 0);
    }

    public function getById(int $id)
    {
        $query     = $this->getDbService()['query'];
        $condition = "id = :id";
        $binding   = [":id" => $id];

        return $query->inTable('dms_wallet')
            ->where($condition)
            ->boundBy($binding)
            ->withResultClass('PangzLab\App\Model\DAO\Wallet\WalletDAO')
            ->execute();
    }

    public function deleteById(int $id)
    {
        $delete = $this->getDbService()['delete'];
        return $delete->inTable('dms_wallet')->where("id = :id")->boundBy([':id'=> $id])->execute();
    }
}