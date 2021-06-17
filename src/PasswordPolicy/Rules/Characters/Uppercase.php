<?php

declare(strict_types=1);

namespace CodePros\PasswordPolicy\Rules\Characters;

/**
 * String has a certain number of uppercase characters
 */
class Uppercase extends Characters
{

    public const DESCRIPTION_TYPE = 'Uppercase character';

    public function getNumChars(string $password): int
    {
        return strlen(preg_replace('/[^A-Z]/', '', $password));
    }
}
