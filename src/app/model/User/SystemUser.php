<?php
declare(strict_types=1);
namespace PangzLab\App\Model\User;

use PangzLab\App\Interfaces\Model\AbstractUser as User;

class SystemUser extends User
{
    protected $id;
    protected $userId;
    protected $username;
    protected $password;
    protected $role;
    protected $status;
    
    public function getInfo() { return $this->prepareInfo(); }
}