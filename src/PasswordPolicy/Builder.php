<?php

declare(strict_types=1);

namespace CodePros\PasswordPolicy;

use InvalidArgumentException;
use RuntimeException;

class Builder
{

    /**
     * @var PasswordPolicy
     */
    protected $policy;

    public function __construct()
    {
        $this->policy = new PasswordPolicy();
    }

    public static function create(): Builder
    {
        return new static();
    }

    /**
     * Adds a rule that must pass
     */
    public function addMustRule(Rules\RulesInterface $rule): self
    {
        $this->policy->mustRules[] = $rule;
        return $this;
    }

    /**
     * Adds a rule that must pass
     */
    public function addMustNotRule(Rules\RulesInterface $rule): self
    {
        $this->policy->mustNotRules[] = $rule;
        return $this;
    }

    /**
     * Adds a nested policy to pass
     * Useful if you want a percentage of a set of rules, but guarantee others
     */
    public function mustPassPolicy(PasswordPolicy $policy): self
    {
        $this->policy->childPolicies[] = $policy;
        return $this;
    }

    /**
     * Set a different percentage of rules necessary to pass for the policy
     * to pass.
     * Policy must pass 100% of rules specified by default.
     */
    public function pctRulesMustPass(int $pctOfRulesNecessaryToPass): self
    {
        if ($pctOfRulesNecessaryToPass < 0 || $pctOfRulesNecessaryToPass > 100) {
            throw new InvalidArgumentException('You must specify a valid percentage of rules to pass.');
        }

        $this->policy->pctOfRulesNecessaryToPass = $pctOfRulesNecessaryToPass;
        return $this;
    }

    public function build(): PasswordPolicy
    {
        $numTests = count($this->policy->mustRules)
            + count($this->policy->mustNotRules)
            + count($this->policy->childPolicies);

        if ($numTests === 0) {
            throw new RuntimeException('You must specify at least one rule.');
        }

        return $this->policy;
    }
}
