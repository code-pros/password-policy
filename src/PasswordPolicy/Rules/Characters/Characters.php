<?php

namespace CodePros\PasswordPolicy\Rules\Characters;

use CodePros\PasswordPolicy\Rules\RulesInterface;
use InvalidArgumentException;

/**
 * Parent class for similar class-of-characters rules
 */
abstract class Characters implements RulesInterface
{

    /**
     * Minimum number
     * @var int|null
     */
    protected $min;

    /**
     * Maximum number
     * @var int|null
     */
    protected $max;

    /**
     * Constructor
     * @param int|null $min Minimum number of characters (or null for no constraint)
     * @param int|null $max Maximum number of characters (or null for no constraint)
     */
    public function __construct(int $min = null, int $max = null)
    {
        if (!isset($min) && !isset($max)) {
            throw new InvalidArgumentException('You must specify either a min or a max number of characters.');
        }
        if (isset($min) && $min < 0) {
            throw new InvalidArgumentException('Min number of characters must be positive.');
        }
        if (isset($max) && $max < 0) {
            throw new InvalidArgumentException('Max number of characters must be positive.');
        }
        if (isset($min) && isset($max) && $min > $max) {
            throw new InvalidArgumentException('Min number of characters must be less than or equal Max.');
        }

        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Does password have a certain number of characters?
     * @param string $password
     * @return bool
     */
    public function matches(string $password): bool
    {
        $numChars = $this->getNumChars($password);
        if (isset($this->min) && $numChars < $this->min) {
            return false;
        }
        if (isset($this->max) && $numChars > $this->max) {
            return false;
        }
        return true;
    }

    /**
     * Get the number of characters in this certain set
     */
    abstract public function getNumChars(string $password): int;
}
