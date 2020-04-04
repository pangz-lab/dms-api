<?php
declare(strict_types=1);
namespace PangzLab\App\Config;

class Type
{
    const WALLET_ADDRESS = [
        "T_ADDRESS" => 'T',
        "Z_ADDRESS" => 'Z',
    ];

    const COIN_WALLET = [
        "VERUS_COIN" => 'vrsc',
    ];

    const ACCOUNT_ROLE = [
        "ADMIN"     => 0,
        "POOL_USER" => 9,
    ];
}