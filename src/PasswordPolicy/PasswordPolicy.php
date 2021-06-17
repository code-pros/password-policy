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
     * Status of last validation run
     * @var array
     */
    protected $detailedStatus = [];

    /**
     * Validates a password matches this policy
     */
    public function validate(string $password): bool
    {
        // reset the status
        $this->detailedStatus = [];

        $numTotalRules = count($this->mustRules) + count($this->mustNotRules) + count($this->childPolicies);

        $passes = 0;

        $numRulesNeededToPass = ceil(($this->pctOfRulesNecessaryToPass / 100) * $numTotalRules);

        if ($numRulesNeededToPass < $numTotalRules) {
            $this->detailedStatus[] = [
                'message' => 'Password must follow '
                    . $numRulesNeededToPass . '/' . $numTotalRules . ' of the following rules.',
            ];
        }

        // must match
        foreach ($this->mustRules as $rule) {
            $passesThisRule = false;

            if ($rule->matches($password)) {
                $passes++;
                $passesThisRule = true;
            }

            $this->detailedStatus[] = [
                'message' => 'Password must ' . $rule->getDescription(),
                'passed' => $passesThisRule,
            ];
        }
        unset($rule);

        // must not match
        foreach ($this->mustNotRules as $rule) {
            $passesThisRule = false;

            if (!$rule->matches($password)) {
                $passes++;
                $passesThisRule = true;
            }

            $this->detailedStatus[] = [
                'message' => 'Password must not ' . $rule->getDescription(),
                'passed' => $passesThisRule,
            ];
        }
        unset($rule);

        // child policies
        foreach ($this->childPolicies as $policy) {
            if ($policy->validate($password)) {
                $passes++;
            }
        }
        unset($policy);

        return round($passes / $numTotalRules * 100) >= $this->pctOfRulesNecessaryToPass;
    }

    /**
     * Gets human-readable descriptions of the rules and whether or not the last password
     * passed each rule.  Run this after validate().
     * @return array
     */
    public function getDetailedStatus(): array
    {
        $data = $this->detailedStatus;

        foreach ($this->childPolicies as $childPolicy) {
            $data = array_merge($data, $childPolicy->detailedStatus);
        }
        unset($childPolicy);

        return $data;
    }
}
