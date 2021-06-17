<?php

declare(strict_types=1);

namespace CodePros\PasswordPolicy\Rules;

/**
 * Password is a minimum Levenshtein distance from another string
 *
 * Useful for when the user is resetting their password, and you want to make sure it's reasonably different.
 */
class Levenshtein implements RulesInterface
{

    /**
     * String to compare to
     * @var string
     */
    protected $string;

    /**
     * Minimum distance of difference
     * @var int
     */
    protected $minDistance;

    /**
     * Description of the string we're comparing the new password to
     * @var string
     */
    private $stringDesc;

    /**
     * Constructor
     * @param string $comparisonString String to compare the distance
     * @param int $minDistance
     * @param string $comparisonStringDescription Description for what the comparison string is.
     */
    public function __construct(
        string $comparisonString,
        int $minDistance,
        string $comparisonStringDescription = 'your previous password'
    ) {
        $this->string = $comparisonString;
        $this->minDistance = $minDistance;
        $this->stringDesc = $comparisonStringDescription;
    }

    /**
     * Is password within range of length?
     * @param string $password
     * @return bool
     */
    public function matches(string $password): bool
    {
        return levenshtein($password, $this->string) >= $this->minDistance;
    }

    public function getDescription(): string
    {
        return 'be more different from ' . $this->stringDesc . '.';
    }
}
