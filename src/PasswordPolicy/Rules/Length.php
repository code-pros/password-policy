<?php

declare(strict_types=1);

namespace CodePros\PasswordPolicy\Rules;

/**
 * String is a certain length
 */
class Length implements RulesInterface
{

    /**
     * Minimum length
     * @var int|null
     */
    protected $minLength;

    /**
     * Maximum length
     * @var int|null
     */
    protected $maxLength;

    /**
     * Constructor
     * @param int|null $minLength Minimum length of password or Null if you don't want to constrain
     * @param int|null $maxLength Maximum length of password or Null if you don't want to constrain
     */
    public function __construct(int $minLength = null, int $maxLength = null)
    {
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    /**
     * Is password within range of length?
     * @param string $password
     * @return bool
     */
    public function matches(string $password): bool
    {
        if (isset($this->minLength) && strlen($password) < $this->minLength) {
            return false;
        }
        if (isset($this->maxLength) && strlen($password) > $this->maxLength) {
            return false;
        }
        return true;
    }
}
