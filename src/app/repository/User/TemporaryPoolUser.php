<?php
declare(strict_types=1);
namespace PangzLab\App\Repository\User;

use PangzLab\App\Repository\AppRepository;
use PangzLab\App\Model\User\JoiningUser;

class TemporaryPoolUser extends AppRepository
{
    public function add(JoiningUser $user)
    {
        $insert = $this->getDbService()['insert'];
        $secretWords = $user->getSecretWords();
        $binding = [
            ":public_address" => $user->getPublicAddress(),
            ":wallet_address" => $user->getWalletAddress(),
            ":email" => $user->getEmailAddress(),
            ":secret1" => $secretWords[0],
            ":secret2" => $secretWords[1],
            ":secret3" => $secretWords[2],
            ":status" => $user->getStatus()
        ];
        $values = [
            ":public_address",
            ":wallet_address",
            ":email",
            ":secret1",
            ":secret2",
            ":secret3",
            ":status"
        ];
        $columns = [
            "public_address",
            "wallet_address",
            "email",
            "secret_word1",
            "secret_word2",
            "secret_word3",
            "status",
        ];
        return $insert->inTable('dmstemp_user')
            ->withValues([$values])
            ->forColumns($columns)
            ->boundBy($binding)
            ->execute();
    }

    public function exist(JoiningUser $user)
    {
        $query = $this->getDbService()['query'];
        $condition = "
            email = :email AND
            public_address = :public_address AND
            wallet_address = :wallet_address
        ";
        $binding = [
            ":email"          => $user->getEmailAddress(),
            ":public_address" => $user->getPublicAddress(),
            ":wallet_address" => $user->getWalletAddress()
        ];

        $result = $query->inTable('dmstemp_user')
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

        return $query->inTable('dmstemp_user')
            ->where($condition)
            ->boundBy($binding)
            ->withResultClass('PangzLab\App\Model\DAO\User\UserDAO')
            ->execute();
    }

    public function deleteById(int $id)
    {
        $delete = $this->getDbService()['delete'];
        return $delete->inTable('dmstemp_user')->where("id = :id")->boundBy([':id'=> $id])->execute();
    }
}