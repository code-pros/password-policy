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
}
