<?php
declare(strict_types=1);
namespace PangzLab\App\Service\UserRegistration;

use PangzLab\App\Interfaces\Service\RegistrationInterface;

class OfficialPoolRegistrationService implements RegistrationInterface
{
    private $dbTransactionService;
    private $dbService = [];
    
    public function __construct(
        DatabaseTransactionInterface $dbTransactionService
    ) {
        $this->dbTransactionService = $dbTransactionService;
        $this->dbService['insert']  = $dbTransactionService->insert();
        $this->dbService['query']   = $dbTransactionService->query();
    }
    
    public function register(GenericUser $user): ?int
    {
        $insert = $this->dbService['insert'];
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

    public function isAllowed(GenericUser $user): bool
    {
        if(!$this->hasValidValues($user)) { return false; }
        if($this->isExisting($user)) { return false; }

        return true;
    }

    public function isExisting(GenericUser $user): bool
    {
        $query = $this->dbService['query'];
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
}