<?php
namespace App\Enum;

class UserTypeEnum
{
    public const CAR = 1;
    public const PASSPORT = 2;

    public static function getAll(): array
    {
        return [
            self::CAR,
            self::PASSPORT,
        ];
    }
    
    public static function exist(int $type): bool
    {
        return in_array($type, self::getAll());
    }
}
