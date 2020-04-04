<?php
declare(strict_types=1);
namespace PangzLab\App\Repository\Account;

use PangzLab\App\Repository\AppRepository;
use PangzLab\App\Model\User\SystemUser;

class SystemAccountRepo extends AppRepository
{
    public function add(SystemUser $user)
    {
        $insert  = $this->getDbService()['insert'];
        $binding = [
            ":user_id"  => $user->getUserId(),
            ":username" => $user->getUsername(),
            ":password" => $user->getPassword(),
            ":role"     => $user->getRole(),
            ":status"   => $user->getStatus(),
        ];
        $values = [
            ":user_id",
            ":username",
            ":password",
            ":role",
            ":status",
        ];
        $columns = [
            "user_id",
            "username",
            "password",
            "role",
            "status",
        ];

        return $insert->inTable('dms_system_account')
            ->withValues([$values])
            ->forColumns($columns)
            ->boundBy($binding)
            ->execute();
    }

    public function exist(SystemUser $user)
    {
        $query     = $this->getDbService()['query'];
        $condition = "
            username = :username AND
            password = :password AND
            role = :role
        ";
        $binding = [
            ":username" => $user->getUsername(),
            ":password" => $user->getPassword(),
            ":role"     => $user->getRole(),
        ];

        $result = $query->inTable('dms_system_account')
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

        return $query->inTable('dms_system_account')
            ->where($condition)
            ->boundBy($binding)
            ->withResultClass('PangzLab\App\Model\DAO\Account\SystemAccountDAO')
            ->execute();
    }

    public function deleteById(int $id)
    {
        return $this->getDbService()['delete']
            ->inTable('dms_system_account')
            ->where("id = :id")
            ->boundBy([':id'=> $id])
            ->execute();
    }
}