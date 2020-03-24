<?php
declare(strict_types=1);
namespace PangzLab\App\Model\User;

use PangzLab\App\Config\Status;
use PangzLab\App\Model\User\GenericUser as User;

class JoiningUser extends User
{
    protected $publicAddress = "";
    protected $walletId      = "";
    protected $walletAddress = "";
    protected $emailAddress  = "";
    protected $secretWords   = [];
    protected $status        = Status::USER_REGISTRATION["FOR_CONFIRMATION"];
}