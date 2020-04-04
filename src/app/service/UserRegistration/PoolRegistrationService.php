<?php
declare(strict_types=1);
namespace PangzLab\App\Service\UserRegistration;

use PangzLab\App\Interfaces\Service\DatabaseTransactionInterface;
use PangzLab\App\Interfaces\Service\RegistrationInterface;
use PangzLab\App\Interfaces\Model\AbstractUser;
use PangzLab\App\Service\InputValidation as Check;
use PangzLab\App\Repository\User\PoolUserRepo;

class PoolRegistrationService implements RegistrationInterface
{
    private $temporaryPoolUser;
    public function __construct(
        DatabaseTransactionInterface $dbTransactionService
    ) {
        $this->temporaryPoolUser = new PoolUserRepo($dbTransactionService);
    }

    public function register(AbstractUser $user): ?int
    {
        return $this->temporaryPoolUser->add($user);
    }

    public function isAllowed(AbstractUser $user): bool
    {
        if(!$this->hasValidValues($user)) { return false; }
        if($this->isExisting($user)) { return false; }

        return true;
    }

    public function isExisting(AbstractUser $user): bool
    {
        return $this->temporaryPoolUser->exist($user);
    }

    protected function hasValidValues(AbstractUser $user)
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