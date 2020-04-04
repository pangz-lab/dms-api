<?php
declare(strict_types=1);
namespace PangzLab\App\Interfaces\Service;

use PangzLab\App\Interfaces\Model\AbstractUser;

interface RegistrationInterface
{
    public function register(AbstractUser $user): ?int;
    public function isAllowed(AbstractUser $user): bool;
}