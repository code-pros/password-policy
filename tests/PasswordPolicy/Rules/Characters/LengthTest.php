<?php

declare(strict_types=1);

namespace Tests\PasswordPolicy\Rules\Characters;

use CodePros\PasswordPolicy\Rules\Characters\Length;
use PHPUnit\Framework\TestCase;

class LengthTest extends TestCase
{
    /**
     * @uses   \CodePros\PasswordPolicy\Rules\Characters\Characters
     * @covers \CodePros\PasswordPolicy\Rules\Characters\Length::getNumChars
     */
    public function testGetNumChars()
    {
        $rule = new Length(1);
        $this->assertEquals(16, $rule->getNumChars('SDF130C[]*[^#$`{'));
        $this->assertEquals(17, $rule->getNumChars('SDF1a30c[]xc[av`{'));
        $this->assertEquals(6, $rule->getNumChars('asdfgh'));
    }
}
