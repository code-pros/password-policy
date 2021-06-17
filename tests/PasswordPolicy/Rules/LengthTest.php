<?php

declare(strict_types=1);

namespace Tests\PasswordPolicy\Rules;

use CodePros\PasswordPolicy\Rules\Length;
use PHPUnit\Framework\TestCase;

class LengthTest extends TestCase
{

    /**
     * @covers \CodePros\PasswordPolicy\Rules\Length::matches
     * @covers \CodePros\PasswordPolicy\Rules\Length::__construct
     */
    public function testMatchesBothSpecified()
    {
        $rule = new Length(3, 5);

        $this->assertFalse($rule->matches('123456'));
        $this->assertTrue($rule->matches('12345'));
        $this->assertTrue($rule->matches('123'));
        $this->assertFalse($rule->matches('12'));
    }

    /**
     * @covers \CodePros\PasswordPolicy\Rules\Length::matches
     * @covers \CodePros\PasswordPolicy\Rules\Length::__construct
     */
    public function testMatchesMinOnly()
    {
        $rule = new Length(3);

        $this->assertTrue($rule->matches('123456'));
        $this->assertTrue($rule->matches('123'));
        $this->assertFalse($rule->matches('12'));
    }

    /**
     * @covers \CodePros\PasswordPolicy\Rules\Length::matches
     * @covers \CodePros\PasswordPolicy\Rules\Length::__construct
     */
    public function testMatchesMaxOnly()
    {
        $rule = new Length(null, 5);

        $this->assertFalse($rule->matches('123456'));
        $this->assertTrue($rule->matches('12345'));
        $this->assertTrue($rule->matches('12'));
    }
}
