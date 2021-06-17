<?php

declare(strict_types=1);

namespace Tests\PasswordPolicy\Rules;

use CodePros\PasswordPolicy\Rules\ConsecutiveCharacters;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ConsecutiveCharactersTest extends TestCase
{

    /**
     * @covers \CodePros\PasswordPolicy\Rules\ConsecutiveCharacters::__construct
     */
    public function testConstructNotEnoughCharacters()
    {
        $this->expectException(InvalidArgumentException::class);
        new ConsecutiveCharacters(1);
    }

    /**
     * @covers \CodePros\PasswordPolicy\Rules\ConsecutiveCharacters::__construct
     * @covers \CodePros\PasswordPolicy\Rules\ConsecutiveCharacters::matches
     */
    public function testMatches()
    {
        $rule = new ConsecutiveCharacters(3);

        $this->assertTrue($rule->matches('asdfffdva'));
        $this->assertFalse($rule->matches('chilly'));
    }

    /**
     * @covers \CodePros\PasswordPolicy\Rules\ConsecutiveCharacters::getDescription
     */
    public function testGetDescription()
    {
        $rule = new ConsecutiveCharacters(2);

        $this->assertEquals('have more than 2 of the same characters in a row.', $rule->getDescription());
    }
}
