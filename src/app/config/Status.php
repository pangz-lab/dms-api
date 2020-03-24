<?php
declare(strict_types=1);
namespace PangzLab\App\Config;

class Status
{
    const USER_REGISTRATION = [
        "FOR_CONFIRMATION"  => 1,
        "CONFIRMED"         => 0,
        "CANCELLED"         => -1,
    ];

    const RECORD_STATE = [
        "ACTIVE"    => 1,
        "INACTIVE"  => 0,
        "CANCELLED" => -1,
        "DELETED"   => -2,
    ];
}