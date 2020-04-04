<?php
declare(strict_types=1);
namespace PangzLab\App\Model\DAO\Wallet;

use PangzLab\App\Model\DAO\DataObjectModel;

class WalletDAO extends DataObjectModel
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
    protected $address_type;
    protected $opening_balance;
    protected $wallet_type;
    protected $status;
    protected $created_by;
    protected $created_date;
    protected $updated_by;
    protected $updated_date;
}