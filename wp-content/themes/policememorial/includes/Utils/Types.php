<?php

namespace AwesomeCoder\Lumi\Utils;

class Types
{
    public static function getType($var): string
    {
        return is_object($var) ? get_class($var) : gettype($var);
    }
}
