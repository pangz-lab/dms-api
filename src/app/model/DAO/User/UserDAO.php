<?php
declare(strict_types=1);
namespace PangzLab\App\Model\DAO\User;

use PangzLab\App\Model\DAO\DataObjectModel;

class UserDAO extends DataObjectModel
{
    protected $id;
    protected $public_address;
    protected $wallet_id;
    protected $wallet_address;
    protected $email;
    protected $secret_word1;
    protected $secret_word2;
    protected $secret_word3;
    protected $status;
    protected $created_by;
    protected $created_date;
    protected $updated_by;
    protected $updated_date;
}