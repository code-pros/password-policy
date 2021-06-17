<?php

declare(strict_types=1);

namespace Tests\PasswordPolicy\Rules\Characters;

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
}
