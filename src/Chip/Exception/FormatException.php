<?php
/**
 * Created by PhpStorm.
 * User: phithon
 * Date: 2019/1/13
 * Time: 1:48
 */

namespace Chip\Exception;


class FormatException extends \Exception
{
    public static function create(string $error_code = ""): FormatException
    {
        $message = "Code '{$error_code}' format error";
        return new static($message);
    }
}