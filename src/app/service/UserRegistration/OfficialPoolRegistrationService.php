<?php
declare(strict_types=1);
namespace PangzLab\App\Service\UserRegistration;

use PangzLab\App\Interfaces\Service\DatabaseTransactionInterface;
use PangzLab\App\Interfaces\Service\RegistrationInterface;
use PangzLab\App\Interfaces\Model\AbstractUser;
use PangzLab\App\Model\User\SystemUser;
use PangzLab\App\Repository\Wallet\CoinWalletRepo;
use PangzLab\App\Repository\User\OfficialPoolUserRepo;
use PangzLab\App\Repository\User\PoolUserRepo;
use PangzLab\App\Repository\Account\SystemAccountRepo;
use PangzLab\App\Service\InputValidation as Check;
use PangzLab\App\Config\Type;
use PangzLab\App\Config\Status;

class OfficialPoolRegistrationService implements RegistrationInterface
{
    private $repos;

    public function __construct(
        DatabaseTransactionInterface $dbTransactionService
    ) {
        $this->repos['coinWallet']    = new CoinWalletRepo($dbTransactionService);
        $this->repos['poolUser']      = new OfficialPoolUserRepo($dbTransactionService);
        $this->repos['tempPoolUser']  = new PoolUserRepo($dbTransactionService);
        $this->repos['systemAccount'] = new SystemAccountRepo($dbTransactionService);
    }

    public function register(AbstractUser $user): ?int
    {
        $walletId = $this->repos['coinWallet']->add(new CoinWallet([
            "address"     => $user->getWalletAddress(),
            "addressType" => Type::WALLET_ADDRESS["T_ADDRESS"],
            "walletType"  => Type::COIN_WALLET["VERUS_COIN"],
            "status"      => Status::WALLET_REGISTRATION["ACTIVE"],
        ]));

        $userId = $this->repos['poolUser']->add(new JoiningUser([
            "publicAddress"=> $user->getPublicAddress(),
            "walletId"     => $walletId,
            "emailAddress" => $user->getEmailAddress(),
            "secretWords"  => $user->getSecretWords(),
            "status"       => Status::USER_REGISTRATION["ACTIVE"],
        ]));

        $this->repos['systemAccount']->add(new SystemUser([
            "userId"   => $userId,
            "username" => $user->getEmailAddress(),
            "password" => $user->getPublicAddress(),
            "role"     => Type::ACCOUNT_ROLE["POOL_USER"],
            "status"   => Status::ACCOUNT_REGISTRATION["FOR_CONFIRMATION"],
        ]));
    }

    public function isAllowed(AbstractUser $user): bool
    {
        if(
            $this->repos['coinWallet']->exist(new CoinWallet([
                "address"     => $user->getWalletAddress(),
                "addressType" => Type::WALLET_ADDRESS["T_ADDRESS"],
                "walletType"  => Type::COIN_WALLET["VERUS_COIN"],
            ])) ||
            $this->repos['poolUser']->exist(new JoiningUser([
                "publicAddress"=> $user->getPublicAddress(),
                "emailAddress" => $user->getEmailAddress(),
            ])) ||
            $this->repos['systemAccount']->exist(new SystemUser([
                "username" => $user->getEmailAddress(),
                "password" => $user->getPublicAddress(),
                "role"     => Type::ACCOUNT_ROLE["POOL_USER"],
            ]))
        ) {
            return false;
        }

        return true;
    }

    public function sendConfirmationEmail(AbstractUser $user)
    {

    }

    public function cancelTemporaryPoolUser(AbstractUser $user)
    {
        return $this->repos['tempPoolUser']->updateStatusById(
            $user->getId(),
            Status::USER_REGISTRATION["CANCELLED"]
        );
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