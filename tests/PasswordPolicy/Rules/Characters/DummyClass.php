<?php

namespace Tests\PasswordPolicy\Rules\Characters;

use CodePros\PasswordPolicy\Rules\Characters\Characters;

/**
 * To test concrete methods of base class
 */
class DummyClass extends Characters
{

    /**
     * @inheritDoc
     */
    public function getNumChars(string $password): int
    {
        return strlen($password);
    }
}
