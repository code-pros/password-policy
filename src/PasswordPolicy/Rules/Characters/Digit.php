<?php

declare(strict_types=1);

namespace CodePros\PasswordPolicy\Rules\Characters;

/**
 * String has a certain number of digits
 */
class Digit extends Characters
{

    public const DESCRIPTION_TYPE = 'Digit';

    public function getNumChars(string $password): int
    {
        return strlen(preg_replace('/[^\d]/', '', $password));
    }
}
