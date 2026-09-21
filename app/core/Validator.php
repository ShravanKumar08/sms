<?php

class Validator
{
    public static function required(string $value): bool
    {
        return trim((string) $value) !== '';
    }

    public static function email(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function minLength(string $value, int $length): bool
    {
        return mb_strlen(trim($value)) >= $length;
    }

    public static function confirm(string $value, string $confirmation): bool
    {
        return $value === $confirmation;
    }

    public static function sanitize(string $value): string
    {
        return trim(strip_tags($value));
    }
}
