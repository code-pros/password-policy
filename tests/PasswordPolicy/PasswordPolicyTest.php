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
     * @covers \CodePros\PasswordPolicy\PasswordPolicy::getDetailedStatus
     */
    public function testValidateWithChildPolicy()
    {
        $passingRule = $this->createMock(Uppercase::class);
        $passingRule->method('matches')->willReturn(true);
        $passingRule->method('getDescription')->willReturn('have at least one Uppercase character');

        $childPolicy = new PasswordPolicy();
        $childPolicy->mustRules[] = $passingRule;

        $policy = new PasswordPolicy();
        $policy->mustRules[] = $passingRule;
        $policy->childPolicies[] = $childPolicy;

        $this->assertTrue($policy->validate('any password'));

        $expectedMessages = [
            [
                'message' => 'Password must have at least one Uppercase character',
                'passed' => true,
            ],
            [
                'message' => 'Password must have at least one Uppercase character',
                'passed' => true,
            ],
        ];
        $this->assertEquals($expectedMessages, $policy->getDetailedStatus());
    }

    /**
     * @covers \CodePros\PasswordPolicy\PasswordPolicy::validate
     * @covers \CodePros\PasswordPolicy\PasswordPolicy::getDetailedStatus
     */
    public function testValidatePercentages()
    {
        $passingRule = $this->createMock(Uppercase::class);
        $passingRule->method('matches')->willReturn(true);
        $passingRule->method('getDescription')->willReturn('have at least one Uppercase character');
        $failingRule = $this->createMock(Uppercase::class);
        $failingRule->method('matches')->willReturn(false);
        $failingRule->method('getDescription')->willReturn('have at least one Lowercase character');

        $policy = new PasswordPolicy();
        $policy->mustRules[] = $passingRule;
        $policy->mustRules[] = $passingRule;
        $policy->mustRules[] = $passingRule;
        $policy->mustRules[] = $failingRule;

        // should pass with 2/3 rules passing
        $policy->pctOfRulesNecessaryToPass = 66;
        $this->assertTrue($policy->validate('any password'));

        $expectedMessages = [
            [
                'message' => 'Password must follow 3/4 of the following rules.',
            ],
            [
                'message' => 'Password must have at least one Uppercase character',
                'passed' => true,
            ],
            [
                'message' => 'Password must have at least one Uppercase character',
                'passed' => true,
            ],
            [
                'message' => 'Password must have at least one Uppercase character',
                'passed' => true,
            ],
            [
                'message' => 'Password must have at least one Lowercase character',
                'passed' => false,
            ],
        ];
        $this->assertEquals($expectedMessages, $policy->getDetailedStatus());

        // should fail with 80% rules passing
        $policy->pctOfRulesNecessaryToPass = 80;
        $this->assertFalse($policy->validate('any password'));

        $expectedMessages2 = [
            [
                'message' => 'Password must have at least one Uppercase character',
                'passed' => true,
            ],
            [
                'message' => 'Password must have at least one Uppercase character',
                'passed' => true,
            ],
            [
                'message' => 'Password must have at least one Uppercase character',
                'passed' => true,
            ],
            [
                'message' => 'Password must have at least one Lowercase character',
                'passed' => false,
            ],
        ];

        $this->assertEquals($expectedMessages2, $policy->getDetailedStatus());
    }
}
