<?php
declare(strict_types=1);
namespace PangzLab\App\Service;

class InputValidation
{
    const PUBLIC_ADDRESS_LENGTH = 50;
    const WALLET_ADDRESS_LENGTH = 34;
    const SECRET_WORD_LENGTH    = 5;
    const SECRET_WORD_COUNT_ALLOWED = 3;

    public static function isEmail(?string $value): bool
    {
        $value = $value ?? "";
        return (filter_var($value, FILTER_VALIDATE_EMAIL) !== FALSE);
    }

    public static function isPublicAddress(?string $value): bool
    {
        $value = $value ?? "";
        return (strlen(trim($value)) == self::PUBLIC_ADDRESS_LENGTH);
    }

    public static function isWalletAddress(?string $value): bool
    {
        $value = $value ?? "";
        return (strlen(trim($value)) == self::WALLET_ADDRESS_LENGTH);
    }

    public static function isStatus(?int $value): bool
    {
        $value = $value ?? "";
        return (\is_numeric($value));
    }

    public static function isSecretWord(?string $value): bool
    {
        $value = $value ?? "";
        return (strlen(trim($value)) >= self::SECRET_WORD_LENGTH);
    }

    public static function isSecretWords(?array $words): bool
    {
        $words = $words ?? [];
        if(count(array_unique($words)) < self::SECRET_WORD_COUNT_ALLOWED) {
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