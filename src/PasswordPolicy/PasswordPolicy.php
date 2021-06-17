<?php

declare(strict_types=1);

namespace CodePros\PasswordPolicy;

class PasswordPolicy
{

    /**
     * Rules that must be true
     * @var Rules\RulesInterface[]
     */
    public $mustRules = [];

    /**
     * Rules that must be false
     * @var Rules\RulesInterface[]
     */
    public $mustNotRules = [];

    /**
     * Nested policies that must validate
     * @var PasswordPolicy[]
     */
    public $childPolicies = [];

    /**
     * Percentage of rules necessary to pass
     * Defaults to 100(%).  Useful for if you want 3 out of 4 rules to be valid
     * to accept the password
     * @var int
     */
    public $pctOfRulesNecessaryToPass = 100;

    /**
     * Validates a password matches this policy
     */
    public function validate(string $password): bool
    {
        $numTests = count($this->mustRules) + count($this->mustNotRules) + count($this->childPolicies);

        $passes = 0;

        // must match
        foreach ($this->mustRules as $rule) {
            if ($rule->matches($password)) {
                $passes++;
            }
        }
        unset($rule);

        // must not match
        foreach ($this->mustNotRules as $rule) {
            if (!$rule->matches($password)) {
                $passes++;
            }
        }
        unset($rule);

        // child policies
        foreach ($this->childPolicies as $policy) {
            if ($policy->validate($password)) {
                $passes++;
            }
        }
        unset($policy);

        return round($passes / $numTests * 100) >= $this->pctOfRulesNecessaryToPass;
    }
}
