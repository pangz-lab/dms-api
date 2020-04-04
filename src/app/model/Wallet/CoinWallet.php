<?php
declare(strict_types=1);
namespace PangzLab\App\Model\Wallet;

use PangzLab\App\Model\Wallet\GenericWallet;
use PangzLab\App\Interfaces\Model\AbstractWallet;

class CoinWallet extends AbstractWallet
{
    protected $id;
    protected $address;
    protected $addressType;
    protected $walletType;
    protected $status;

    public function getInfo()
    {
        return $this->prepareInfo();
    }
}