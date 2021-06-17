<?php

declare(strict_types=1);

namespace Tests\PasswordPolicy\Rules\Characters;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CharactersTest extends TestCase
{
    /**
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Characters::__construct
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Characters::matches
     */
    public function testMatchesBothSpecified()
    {
        $rule = new DummyClass(3, 5);

        $this->assertFalse($rule->matches('abcdef'));
        $this->assertTrue($rule->matches('abcde'));
        $this->assertTrue($rule->matches('abc'));
        $this->assertFalse($rule->matches('ab'));
    }

    /**
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Characters::__construct
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Characters::matches
     */
    public function testMatchesMinOnly()
    {
        $rule = new DummyClass(3);

        $this->assertTrue($rule->matches('abcdef'));
        $this->assertTrue($rule->matches('abc'));
        $this->assertFalse($rule->matches('ab'));
    }

    /**
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Characters::__construct
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Characters::matches
     */
    public function testMatchesMaxOnly()
    {
        $rule = new DummyClass(null, 5);

        $this->assertFalse($rule->matches('abcdef'));
        $this->assertTrue($rule->matches('abcde'));
        $this->assertTrue($rule->matches('ab'));
    }

    /**
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Characters::__construct
     */
    public function testConstructNoParametersProvided()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('You must specify either a min or a max number of characters.');
        $rule = new DummyClass();
    }

    /**
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Characters::__construct
     */
    public function testConstructMinLessThanZero()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Min number of characters must be positive.');
        $rule = new DummyClass(-49);
    }

    /**
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Characters::__construct
     */
    public function testConstructMaxLessThanZero()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Max number of characters must be positive.');
        $rule = new DummyClass(null, -95);
    }

    /**
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Characters::__construct
     */
    public function testConstructMaxLessThanMin()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Min number of characters must be less than or equal Max.');
        $rule = new DummyClass(10, 5);
    }

    /**
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Characters::getDescription
     */
    public function testGetDescription()
    {
        // min only
        $ruleMinOnly = new DummyClass(1);
        $this->assertEquals('have at least 1 Any character.', $ruleMinOnly->getDescription());

        // min only
        $ruleMinOnlyPlural = new DummyClass(2);
        $this->assertEquals('have at least 2 Any characters.', $ruleMinOnlyPlural->getDescription());

        // max only
        $ruleMaxOnly = new DummyClass(null, 5);
        $this->assertEquals('have at most 5 Any characters.', $ruleMaxOnly->getDescription());

        // both
        $ruleBoth = new DummyClass(1, 5);
        $this->assertEquals('have 1 to 5 Any characters.', $ruleBoth->getDescription());
    }
}
