<?php

declare(strict_types=1);

namespace Tests\PasswordPolicy\Rules\Characters;

use CodePros\PasswordPolicy\Rules\Characters\Lowercase;
use PHPUnit\Framework\TestCase;

class LowercaseTest extends TestCase
{
    /**
     * @uses   \CodePros\PasswordPolicy\Rules\Characters\Characters
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Lowercase::getNumChars
     */
    public function testGetNumChars()
    {
        $rule = new Lowercase();
        $this->assertEquals(0, $rule->getNumChars('SDF130C[]*[^#$`{'));
        $this->assertEquals(6, $rule->getNumChars('SDF1a30c[]xc[av`{'));
        $this->assertEquals(6, $rule->getNumChars('asdfgh'));
    }
}
