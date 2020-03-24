<?php
declare(strict_types=1);
namespace PangzLab\App\Interfaces\Service;

use PangzLab\App\Model\User\GenericUser;

interface RegistrationInterface
{
    public function register(GenericUser $user): ?int;
    public function isAllowed(GenericUser $user): bool;
    public function isExisting(GenericUser $user): bool;
}