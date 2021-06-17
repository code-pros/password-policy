<?php

declare(strict_types=1);

namespace CodePros\PasswordPolicy\Rules\Characters;

/**
 * String has a certain number of lowercase characters
 */
class Lowercase extends Characters
{

    public function getNumChars(string $password): int
    {
        return strlen(preg_replace('/[^a-z]/', '', $password));
    }
}
