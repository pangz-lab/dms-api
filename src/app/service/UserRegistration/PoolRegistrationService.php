<?php
declare(strict_types=1);
namespace PangzLab\App\Service\UserRegistration;

use PangzLab\App\Interfaces\Service\DatabaseTransactionInterface;
use PangzLab\App\Interfaces\Service\RegistrationInterface;
use PangzLab\App\Model\User\GenericUser;
use PangzLab\App\Service\InputValidation as Check;
use PangzLab\App\Repository\User\TemporaryPoolUser;

class PoolRegistrationService implements RegistrationInterface
{
    public function __construct(
        DatabaseTransactionInterface $dbTransactionService
    ) {
        $this->temporaryPoolUser    = new TemporaryPoolUser($dbTransactionService);
    }

    public function register(GenericUser $user): ?int
    {
        return $this->temporaryPoolUser->add($user);
    }

    public function isAllowed(GenericUser $user): bool
    {
        if(!$this->hasValidValues($user)) { return false; }
        if($this->isExisting($user)) { return false; }

        return true;
    }

    public function isExisting(GenericUser $user): bool
    {
        return $this->temporaryPoolUser->exist($user);
    }

    protected function hasValidValues(GenericUser $user)
    {
        return (
            Check::isPublicAddress($user->getPublicAddress()) &&
            Check::isWalletAddress($user->getWalletAddress()) &&
            Check::isEmail($user->getEmailAddress()) &&
            Check::isSecretWords($user->getSecretWords()) &&
            Check::isStatus($user->getStatus())
        );
    }
}