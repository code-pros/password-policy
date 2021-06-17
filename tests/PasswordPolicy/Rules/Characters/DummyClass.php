<?php

declare(strict_types=1);

namespace Tests\PasswordPolicy\Rules\Characters;

use CodePros\PasswordPolicy\Rules\Characters\Characters;

/**
 * To test concrete methods of base class
 */
class DummyClass extends Characters
{
    public const DESCRIPTION_TYPE = 'Any character';

    /**
     * @inheritDoc
     */
    public function getNumChars(string $password): int
    {
        return strlen($password);
    }
}
