<?php

declare(strict_types=1);

namespace Tests\PasswordPolicy\Rules\Characters;

use CodePros\PasswordPolicy\Rules\Characters\Special;
use PHPUnit\Framework\TestCase;

class SpecialTest extends TestCase
{
    /**
     * @uses   \CodePros\PasswordPolicy\Rules\Characters\Characters
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Special::getNumChars
     */
    public function testGetNumChars()
    {
        $rule = new Special(1);
        $this->assertEquals(12, $rule->getNumChars("SDF130C[]*[^#$`{\*/c"));
        $this->assertEquals(0, $rule->getNumChars('asdfgh'));
    }
}
