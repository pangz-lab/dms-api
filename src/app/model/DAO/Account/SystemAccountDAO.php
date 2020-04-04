<?php
declare(strict_types=1);
namespace PangzLab\App\Model\DAO\Account;

use PangzLab\App\Model\DAO\DataObjectModel;

class SystemAccountDAO extends DataObjectModel
{
    protected $id;
    protected $user_id;
    protected $username;
    protected $password;
    protected $role;
    protected $status;
    protected $created_by;
    protected $created_date;
    protected $updated_by;
    protected $updated_date;
}