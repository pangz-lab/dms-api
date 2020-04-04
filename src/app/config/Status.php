<?php
declare(strict_types=1);
namespace PangzLab\App\Config;

class Status
{
    const USER_REGISTRATION = [
        "ACTIVE"           => 1,
        "CONFIRMED"        => 2,
        "FOR_CONFIRMATION" => 3,
        "CANCELLED"        => 9,
    ];

    const ACCOUNT_REGISTRATION = [
        "FOR_CONFIRMATION" => 2,
        "ACTIVE"           => 1,
        "INACTIVE"         => 0,
    ];

    const WALLET_REGISTRATION = [
        "ACTIVE"           => 1,
        "INACTIVE"         => 0,
    ];

    const RECORD_STATE = [
        "ACTIVE"    => 1,
        "INACTIVE"  => 0,
        "CANCELLED" => -1,
        "DELETED"   => -2,
    ];
}