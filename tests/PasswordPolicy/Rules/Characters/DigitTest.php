<?php

declare(strict_types=1);

namespace Tests\PasswordPolicy\Rules\Characters;

use CodePros\PasswordPolicy\Rules\Characters\Digit;
use PHPUnit\Framework\TestCase;

class DigitTest extends TestCase
{
    /**
     * @uses   \CodePros\PasswordPolicy\Rules\Characters\Characters
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Digit::getNumChars
     */
    public function testGetNumChars()
    {
        $rule = new Digit(1);
        $this->assertEquals(3, $rule->getNumChars('SDF130C[]*[^#$`{'));
        $this->assertEquals(0, $rule->getNumChars('asdfgh'));
    }
}
