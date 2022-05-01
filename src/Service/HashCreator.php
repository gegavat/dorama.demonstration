<?php

namespace App\Service;


class HashCreator
{
    public const ALLOWED_CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public const HASH_LENGTH = 16;

    public static function genRandomStr($withTime = true)
    {
        $charactersLength = strlen(self::ALLOWED_CHARACTERS);
        $randomString = '';
        for ($i = 0; $i < self::HASH_LENGTH; $i++) {
            $randomString .= self::ALLOWED_CHARACTERS[rand(0, $charactersLength - 1)];
        }
        return $withTime ? $randomString . '_' . time() : $randomString;
    }
}