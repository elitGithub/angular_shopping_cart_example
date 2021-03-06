<?php


namespace App\Helpers;


use ReallySimpleJWT\Token;

class JWTHelper
{
    public static ?string $appSecret;

    public static function initSecret(): ?string
    {
        if (isset(static::$appSecret)) {
            return static::$appSecret;
        }

        static::$appSecret = $_ENV['SECRET_KEY'];
        return static::$appSecret;
    }

    public static function parseToken($token): array
    {
        $token = str_replace('Bearer ', '', $token);
        return Token::parser($token, static::initSecret())->parse()->getPayload();
    }

    public static function validate($token): bool
    {
        return Token::validate($token, static::initSecret()) && Token::validateExpiration($token, static::initSecret());
    }
}