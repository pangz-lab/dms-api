<?php
declare(strict_types=1);
namespace PangzLab\App\Model\Wallet;

use PangzLab\Lib\Model\Model;

class UserWallet extends Model
{
    /**
    * 1. This provides a default constructor for assigning values
    *    to the model properties.
    * 2. You can still override it's definition by creating a custom getter method
    * 3. All properties is provided by automatic getter so creating
    *    a getter for each property is unncessary. You can access it like
    *    $yourInstance->getId();
    */
    protected $id;
    protected $address;
    protected $addressType;
    protected $walletType;
    protected $status;
}