<?php

declare(strict_types=1);

namespace Tests\PasswordPolicy;

use CodePros\PasswordPolicy\PasswordPolicy;
use CodePros\PasswordPolicy\Rules\Characters\Uppercase;
use PHPUnit\Framework\TestCase;

class PasswordPolicyTest extends TestCase
{
    /**
     * @covers \CodePros\PasswordPolicy\PasswordPolicy::validate
     */
    public function testValidateWithMustRules()
    {
        $passingRule = $this->createMock(Uppercase::class);
        $passingRule->method('matches')->willReturn(true);

        $policy = new PasswordPolicy();
        $policy->mustRules[] = $passingRule;
        $policy->mustRules[] = $passingRule;
        $policy->mustRules[] = $passingRule;

        $this->assertTrue($policy->validate('any password'));
    }

    /**
     * @covers \CodePros\PasswordPolicy\PasswordPolicy::validate
     */
    public function testValidateWithMustNotRules()
    {
        $failingRule = $this->createMock(Uppercase::class);
        $failingRule->method('matches')->willReturn(false);

        $policy = new PasswordPolicy();
        $policy->mustNotRules[] = $failingRule;
        $policy->mustNotRules[] = $failingRule;
        $policy->mustNotRules[] = $failingRule;

        $this->assertTrue($policy->validate('any password'));
    }

    /**
     * @covers \CodePros\PasswordPolicy\PasswordPolicy::validate
     */
    public function testValidateWithChildPolicy()
    {
        $passingRule = $this->createMock(Uppercase::class);
        $passingRule->method('matches')->willReturn(true);

        $childPolicy = new PasswordPolicy();
        $childPolicy->mustRules[] = $passingRule;

        $policy = new PasswordPolicy();
        $policy->mustRules[] = $passingRule;
        $policy->childPolicies[] = $childPolicy;

        $this->assertTrue($policy->validate('any password'));
    }

    /**
     * @covers \CodePros\PasswordPolicy\PasswordPolicy::validate
     */
    public function testValidatePercentages()
    {
        $passingRule = $this->createMock(Uppercase::class);
        $passingRule->method('matches')->willReturn(true);
        $failingRule = $this->createMock(Uppercase::class);
        $failingRule->method('matches')->willReturn(false);

        $policy = new PasswordPolicy();
        $policy->mustRules[] = $passingRule;
        $policy->mustRules[] = $passingRule;
        $policy->mustRules[] = $passingRule;
        $policy->mustRules[] = $failingRule;

        // should pass with 2/3 rules passing
        $policy->pctOfRulesNecessaryToPass = 66;
        $this->assertTrue($policy->validate('any password'));

        // should fail with 80% rules passing
        $policy->pctOfRulesNecessaryToPass = 80;
        $this->assertFalse($policy->validate('any password'));
    }
}
