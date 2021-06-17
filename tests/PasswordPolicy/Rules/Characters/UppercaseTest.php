<?php

declare(strict_types=1);

namespace Tests\PasswordPolicy\Rules\Characters;

use CodePros\PasswordPolicy\Rules\Characters\Uppercase;
use PHPUnit\Framework\TestCase;

class UppercaseTest extends TestCase
{
    /**
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Uppercase::getNumChars
     */
    public function testGetNumChars()
    {
        $rule = new Uppercase();
        $this->assertEquals(4, $rule->getNumChars('SDF130C[]*[^#$`{'));
        $this->assertEquals(0, $rule->getNumChars('asdfgh'));
    }
}
