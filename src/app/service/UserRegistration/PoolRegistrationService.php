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
    private $validationResult = [
        "validValues" => true,
        "newUser" => true,
    ];
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
        if(!$this->hasValidValues($user)) {
            $this->validationResult["validValues"] = false;
            $this->validationResult["newUser"] = false;
            return false;
        }
        if($this->isExisting($user)) {
            $this->validationResult["validValues"] = true;
            $this->validationResult["newUser"] = false;
            return false;
        }

        return true;
    }

    public function isExisting(AbstractUser $user): bool
    {
        return $this->temporaryPoolUser->exist($user);
    }

    public function getValidationResult(): array 
    {
        return $this->validationResult;
    }

    protected function hasValidValues(AbstractUser $user): bool
    {
        return (
            Check::isPublicAddress($user->getPublicAddress()) &&
            Check::isWalletAddress($user->getWalletAddress()) &&
            Check::isBlockChainTransactionId($user->getTransactionId()) &&
            Check::isEmail($user->getEmailAddress()) &&
            Check::isSecretWords($user->getSecretWords()) &&
            Check::isStatus($user->getStatus())
        );
    }
}