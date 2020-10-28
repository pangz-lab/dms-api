<?php
declare(strict_types=1);
namespace PangzLab\App\Service;

class InputValidation
{
    //@TODO limit character types like for wallet only [a-zA-Z0-9]
    const PUBLIC_ADDRESS_LENGTH            = [ "min" => 34, "max" => 40 ];
    const WALLET_ADDRESS_LENGTH            = [ "min" => 34, "max" => 40 ];
    const SECRET_WORD_LENGTH               = [ "min" => 5,  "max" => 15 ];
    const BLOCKCHAIN_TRANSACTION_ID_LENGTH = [ "min" => 64,  "max" => 70 ];
    const SECRET_WORD_COUNT_ALLOWED        = 3;
    
    public static function isEmail(?string $value): bool
    {
        $value = $value ?? "";
        return (filter_var($value, FILTER_VALIDATE_EMAIL) !== FALSE);
    }

    public static function isPublicAddress(?string $value): bool
    {
        $value  = $value ?? "";
        $length = strlen(trim($value));
        
        return (
            $length >= self::PUBLIC_ADDRESS_LENGTH["min"] &&
            $length <= self::PUBLIC_ADDRESS_LENGTH["max"]
        );
    }

    public static function isWalletAddress(?string $value): bool
    {
        $value  = $value ?? "";
        $length = strlen(trim($value));
        return (
            $length >= self::WALLET_ADDRESS_LENGTH["min"] &&
            $length <= self::WALLET_ADDRESS_LENGTH["max"]
        );
    }

    public static function isStatus(?int $value): bool
    {
        $value = $value ?? "";
        return (\is_numeric($value));
    }

    public static function isSecretWord(?string $value): bool
    {
        $value  = $value ?? "";
        $length = strlen(trim($value));
        return (
            $length >= self::SECRET_WORD_LENGTH["min"] &&
            $length <= self::SECRET_WORD_LENGTH["max"]
        );
    }

    public static function isBlockChainTransactionId(?string $value): bool
    {
        $value = $value ?? "";
        $length = strlen(trim($value));
        return (
            $length >= self::BLOCKCHAIN_TRANSACTION_ID_LENGTH["min"] &&
            $length <= self::BLOCKCHAIN_TRANSACTION_ID_LENGTH["max"]
        );
    }

    public static function isSecretWords(?array $words): bool
    {
        $words = $words ?? [];
        if(count(array_unique($words)) != self::SECRET_WORD_COUNT_ALLOWED) {
            return false;
        }

        foreach($words as $currentWord) {
            if(!static::isSecretWord($currentWord)) {
                return false;
            }
        }

        return true;
    }
}