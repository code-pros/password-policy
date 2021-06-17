<?php

declare(strict_types=1);

namespace CodePros\PasswordPolicy\Rules\Characters;

class Length extends Characters
{
    public const DESCRIPTION_TYPE = 'character';

    /**
     * @inheritDoc
     */
    public function getNumChars(string $password): int
    {
        return strlen($password);
    }
}
