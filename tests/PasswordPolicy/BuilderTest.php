<?php

declare(strict_types=1);

namespace Tests\PasswordPolicy;

use CodePros\PasswordPolicy\Builder;
use CodePros\PasswordPolicy\Rules\Characters\Uppercase;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class BuilderTest extends TestCase
{
    /**
     * @var Uppercase
     */
    private $passingRule;

    /**
     * @var Uppercase
     */
    private $failingRule;

    public function setUp(): void
    {
        parent::setUp();
        $this->passingRule = $this->createMock(Uppercase::class);
        $this->passingRule->method('matches')->willReturn(true);
        $this->failingRule = $this->createMock(Uppercase::class);
        $this->failingRule->method('matches')->willReturn(false);
    }

    /**
     * @covers \CodePros\PasswordPolicy\Builder::__construct
     * @covers \CodePros\PasswordPolicy\Builder::addMustNotRule
     * @covers \CodePros\PasswordPolicy\Builder::addMustRule
     * @covers \CodePros\PasswordPolicy\Builder::build
     */
    public function testAddRules(): void
    {
        $builder = new Builder();
        $policy = $builder->addMustRule($this->passingRule)
            ->addMustNotRule($this->failingRule)
            ->build();

        $this->assertEquals([$this->passingRule], $policy->mustRules);
        $this->assertEquals([$this->failingRule], $policy->mustNotRules);
    }

    /**
     * @depends testAddRules
     * @covers  \CodePros\PasswordPolicy\Builder::mustPassPolicy
     * @covers  \CodePros\PasswordPolicy\Builder::create
     */
    public function testMustPassPolicy(): void
    {
        $builder = new Builder();
        $policy = $builder->addMustRule($this->passingRule)
            ->addMustNotRule($this->failingRule)
            ->build();

        $parentPolicy = Builder::create()->mustPassPolicy($policy)->build();

        $this->assertEquals([$policy], $parentPolicy->childPolicies);
    }

    /**
     * @covers \CodePros\PasswordPolicy\Builder::pctRulesMustPass
     */
    public function testPctRulesMustPassInvalidPct(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Builder::create()->pctRulesMustPass(9001);
    }

    /**
     * @covers \CodePros\PasswordPolicy\Builder::pctRulesMustPass
     */
    public function testPctRulesMustPassValid(): void
    {
        $policy = Builder::create()
            ->pctRulesMustPass(56)
            ->addMustNotRule($this->passingRule)
            ->build();
        $this->assertEquals(56, $policy->pctOfRulesNecessaryToPass);
    }

    /**
     * @covers \CodePros\PasswordPolicy\Builder::build
     */
    public function testBuildNoRules(): void
    {
        $this->expectException(RuntimeException::class);
        Builder::create()->build();
    }
}
