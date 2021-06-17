<?php

declare(strict_types=1);

namespace CodePros\PasswordPolicy\Rules;

use InvalidArgumentException;

/**
 * String has a certain number of consecutive characters in it
 */
class ConsecutiveCharacters implements RulesInterface
{
    /**
     * Number of consecutive characters to test against
     * @var int
     */
    protected $numConsecutiveCharacters;

    /**
     * Constructor
     * @param int $numConsecutiveCharacters Number of consecutive characters (specify at least 2)
     * @throws InvalidArgumentException if you specify an invalid number of consecutive characters
     */
    public function __construct(int $numConsecutiveCharacters)
    {
        if ($numConsecutiveCharacters < 2) {
            throw new InvalidArgumentException('You must specify at least 2 consecutive characters');
        }

        $this->numConsecutiveCharacters = $numConsecutiveCharacters;
    }

    /**
     * Does password have a certain number of consecutive characters?
     * @param string $password
     * @return bool
     */
    public function matches(string $password): bool
    {
        return (bool)preg_match('/(.)\1{2}/', $password);
    }

    public function getDescription(): string
    {
        return 'have ' . $this->numConsecutiveCharacters . ' or more of the same characters in a row.';
    }
}
